<?php

namespace App\Model;

use App\Model\CashFlow;
use App\Model\Users;
use App\Model\Company;
use App\Model\TransactionCategory;
use App\Model\CompanyCategory;
use App\View;

use PDO;

class Bill extends Model
{
    public int $id;
    public string $billing_date;
    public int $amount;
    public int $admin_fee;
    public int $total_amount;
    protected CashFlow $cashflow;
    protected Users $user;
    protected Company $company;

    public function setBillingDate(string $billing_date): void
    {
        $this->billing_date = $billing_date;
    }

    public function setUser(Users $user): void
    {
        $this->user = $user;
    }

    public function setAdminFee(): void
    {
        $this->admin_fee = 500;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setTotalAmount($credit): void
    {
        $this->total_amount = $credit + $this->admin_fee;
    }

    public function setCashflow(CashFlow $cashflow): void
    {
        $this->cashflow = $cashflow;
    }

    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function details($id) : void
    {
        $stmt = $this->db->prepare("SELECT * FROM bill WHERE id=$id");
        if ($stmt->execute()) {
            $bill = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->total_amount = $bill['total_amount'];
        } else {
            $bill = null;
        }
    }

    public function view() : array
    {
    $stmt = $this->db->prepare("SELECT 
    `billing_date`,
    `amount`, 
    `admin_fee`,
    `total_amount`, 
    `company`.`company_name`, 
    `user`.`nama`, 
    `user`.`phone_num`,
    `cashflow`.`status`, 
    `transaction_category`.`name` 
    FROM bill 
    LEFT JOIN company ON company.id = bill.company_id
    LEFT JOIN user ON user.phone_num = bill.phone_num
    LEFT JOIN cashflow ON cashflow.id = bill.cashflow_id
    LEFT JOIN transaction_category ON transaction_category.id = cashflow.transaction_category_id");
        if ($stmt->execute()) {
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $temp = null;
        }
        return $temp;
    }
}
