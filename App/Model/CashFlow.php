<?php

namespace App\Model;

use App\Model\TransactionCategory;
use App\Model\Users;
use App\Model\Bill;
use App\Model\Company;

use PDO;

date_default_timezone_set("Asia/Jakarta");

class CashFlow extends Model
{
    public int $id;
    protected string $date;
    protected float $credit;
    protected float $debit;
    protected string $status;
    public float $temp;
    protected Users $user;
    public TransactionCategory $transaction_category;
    public Bill $bill;
    protected Company $company;
    public $cashflow;

    public function setDate(): void
    {
        $this->date = date('Y-m-d');
    }

    public function setCreDebStat(string $credit): void
    {
        $string = $credit;
        $characters = str_split($string);

        if ($characters[0] === '-') {
            $this->status = "Credit";
            $this->credit = (int)implode('', array_slice($characters, 1));
            $this->debit = 0;
            $this->user->details($this->user->phone_num);
            $this->temp = $this->user->balance - $this->credit;
        } else if ($characters[0] === '+') {
            $this->status = "Debit";
            $this->debit = (int)implode('', array_slice($characters, 1));
            $this->credit = 0;
            $this->user->details($this->user->phone_num);
            $this->temp = $this->user->balance + $this->debit;
        } else {
            false;
        }
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setUser(Users $user): void
    {
        $this->user = $user;
    }

    public function setTransactionCategory(TransactionCategory $transaction_category): void
    {
        $this->transaction_category = $transaction_category;
    }


    public function setCompany(Company $company)
    {
        $this->company = $company;
    }

    public function details($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM cashflow WHERE id=$id");
        if ($stmt->execute()) {
            $cash_flow = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $cash_flow['id'];
            $this->date = $cash_flow['date'];
            $this->credit = $cash_flow['0'];
            $this->debit = $cash_flow['0'];
            $this->status = $cash_flow['status'];
            $this->user->phone_num = $cash_flow['phone_num'];
            $this->transaction_category->id  = $cash_flow['transaction_category_id'];
        } else {
            $cash_flow = null;
        }
    }

    public function generateId()
    {
        $stmt = $this->db->prepare("SELECT MAX(id) AS id FROM cashflow");
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'] + 1;
        } else {
            return 0;
        }
    }

    public function generateIdBill()
    {
        $stmt = $this->db->prepare("SELECT MAX(id) AS id FROM bill");
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->bill->id = $data['id'] + 1;
        } else {
            return 0;
        }
    }

    public function topUp()
    {
        $stmt = $this->db->prepare("INSERT INTO cashflow (id, date, credit, debit, status, phone_num, transaction_category_id) VALUES (:id, :date, :credit, :debit, :status, :phone_num, :transaction_category)");
        $this->generateId();
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':credit', $this->credit);
        $stmt->bindParam(':debit', $this->debit);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':phone_num', $this->user->phone_num);
        $stmt->bindParam(':transaction_category', $this->transaction_category->id);
        $stmt2 = $this->db->prepare("UPDATE user SET balance = :temp WHERE phone_num = :user");
        if ($stmt->execute()) {
            $stmt2->bindParam(':temp', $this->temp);
            $stmt2->bindParam(':user', $this->user->phone_num);
            return $stmt2->execute();
        }
    }

    public function paymentBill()
    {
        $stmt = $this->db->prepare("INSERT INTO cashflow (id, date, credit, debit, status, phone_num, transaction_category_id) VALUES (:id, :date, :credit, :debit, :status, :phone_num, :transaction_category)");
        $this->generateId();
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':credit', $this->credit);
        $stmt->bindParam(':debit', $this->debit);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':phone_num', $this->user->phone_num);
        $stmt->bindParam(':transaction_category', $this->transaction_category->id);
        $stmt2 = $this->db->prepare("UPDATE user SET balance = :temp WHERE phone_num = :user");
        if ($stmt->execute()) {
            $stmt3 = $this->db->prepare("INSERT INTO bill (id, billing_date, amount, admin_fee, total_amount, company_id, phone_num, cashflow_id) VALUES (:id, :billing_date, :amount, :admin_fee, :total_amount, :company, :phone_num, :cashflow)");
            $this->generateIdBill();
            $stmt3->bindParam(':id', $this->bill->id);
            $stmt3->bindParam(':billing_date', $this->date);
            $stmt3->bindParam(':amount', $this->credit);
            $this->bill->setAdminFee();
            $stmt3->bindParam(':admin_fee', $this->bill->admin_fee);
            $this->bill->setTotalAmount($this->credit);
            $stmt3->bindParam(':total_amount', $this->bill->total_amount);
            $stmt3->bindParam(':company', $this->company->id);
            $stmt3->bindParam(':phone_num', $this->user->phone_num);
            $stmt3->bindParam(':cashflow', $this->id);
            $stmt3->execute();

            $this->bill->details($this->bill->id);
            $this->user->details($this->user->phone_num);

            $temp = $this->user->balance - $this->bill->total_amount;
            
            $stmt2->bindParam(':temp', $temp);
            $stmt2->bindParam(':user', $this->user->phone_num);
            return $stmt2->execute();
        }
    }
}
