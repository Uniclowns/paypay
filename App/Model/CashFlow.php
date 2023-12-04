<?php
namespace App\Model;

use App\Model\TransactionCategory;
use App\Model\Users;
use PDO;

class CashFlow extends Model{
    public int $id;
    protected string $date;
    protected float $amount;
    protected float $balance;
    protected float $credit_debit;
    protected Users $user;
    protected TransactionCategory $transaction_category;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setCreditDebit(float $credit_debit): void
    {
        $this->credit_debit = $credit_debit;
    }

    public function getCreditDebit(): float
    {
        return $this->credit_debit;
    }

    public function setUser(Users $user): void
    {
        $this->user = $user;
    }

    public function getUser(): Users
    {
        return $this->user;
    }


    public function setTransactionCategory(TransactionCategory $transaction_category): void
    {
        $this->transaction_category = $transaction_category;
    }

    public function getTransactionCategory(): TransactionCategory
    {
        return $this->transaction_category;
    }

    public function addCashFlow(){
        $stmt = $this->db->prepare("INSERT INTO cashflow (id, date, amount, balance, credit_debit, phone_num, transaction_category_id) VALUES (:id, :date, :amount, :balance, :credit_debit, :phone_num, :transaction_category)");
        $this->generateId();
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':balance', $this->balance);
        $stmt->bindParam(':credit_debit', $this->credit_debit);
        $stmt->bindParam(':phone_num', $this->user->phone_num);
        $stmt->bindParam(':transaction_category', $this->transaction_category->id);
        return $stmt->execute();
    }

    public function details($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM cashflow WHERE id=$id");
        if ($stmt->execute()) {
            $cash_flow = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $cash_flow['id'];
            $this->date = $cash_flow['date'];
            $this->amount = $cash_flow['amount'];
            $this->balance = $cash_flow['balance'];
            $this->credit_debit = $cash_flow['credit_debit'];
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
}