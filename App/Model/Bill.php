<?php
namespace App\Model;

use App\Model\Users;
use App\Model\CashFlow;
use App\Model\Company;
use PDO;

class Bill extends Model{
    protected int $id;
    protected string $billing_date;
    protected int $amount;
    protected int $admin_fee;
    protected int $total_amount;
    protected CashFlow $cashflow;
    protected Users $user;
    protected Company $company;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setBillingDate(string $billing_date): void
    {
        $this->billing_date = $billing_date;
    }

    public function getBillingDate(): string
    {
        return $this->billing_date;
    }

    public function setUser(Users $user): void
    {
        $this->user = $user;
    }

    public function getUser(): Users
    {
        return $this->user;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }


    public function setTotalAmount(int $total_amount): void
    {
        $this->total_amount = $total_amount;
    }

    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }

    public function setAdminFee(int $admin_fee): void
    {
        $this->admin_fee = $admin_fee;
    }

    public function getAdminFee(): int
    {
        return $this->admin_fee;
    }

    public function setCashflow(CashFlow $cashflow): void
    {
        $this->cashflow = $cashflow;
    }

    public function getCashflow(): \App\Model\CashFlow
    {
        return $this->cashflow;
    }

    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return \App\Model\Company
     */
    public function getCompany(): \App\Model\Company
    {
        return $this->company;
    }



    public function addBill(){
        $stmt = $this->db->prepare("INSERT INTO bill (id, billing_date, amount, admin_fee, total_amount, company_id, phone_num, cashflow_id) VALUES (:id, :billing_date, :amount, :admin_fee, :total_amount, :company, :phone_num, :cashflow)");
        $this->generateId();
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':billing_date', $this->billing_date);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':admin_fee', $this->admin_fee);
        $stmt->bindParam(':total_amount', $this->total_amount);
        $stmt->bindParam(':company', $this->company->id);
        $stmt->bindParam(':phone_num', $this->user->phone_num);
        $stmt->bindParam(':cashflow', $this->cashflow->id);
        return $stmt->execute();
    }

    public function details($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bill WHERE id=$id");
        if ($stmt->execute()) {
            $bill = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $bill['id'];
            $this->billing_date = $bill['billing_date'];
            $this->amount = $bill['amount'];
            $this->admin_fee = $bill['admin_fee'];
            $this->total_amount = $bill['total_amount'];
            $this->company = $bill['company'];
            $this->user = $bill['phone_num'];
            $this->cashflow = $bill['cashflow_id'];
        } else {
            $bill = null;
        }
    }

    public function generateId()
    {
        $stmt = $this->db->prepare("SELECT MAX(id) AS id FROM bill");
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'] + 1;
        } else {
            return 0;
        }
    }
}