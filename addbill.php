<?php

use App\Model\CashFlow;
use App\Model\Users;
use App\Model\Company;
use App\Model\Bill;
use App\Model\TransactionCategory;
use App\Model\CompanyCategory;
use App\View;

require 'vendor/autoload.php';

$date = "2023/12/04";
$amount = 50000;
$admin_fee = 0;
$total_amount = 0;
$phone_num = "08123456789";
$company_id = 1;
$cashflow_id = 2;
$transaction_category_id = 1;
$company_category_id = 1;

$bill = new Bill();

$cash_flow = new CashFlow();
$user = new Users();
$company = new Company();
$transaction_category = new TransactionCategory();
$company_category = new CompanyCategory();


$user->details($phone_num);
$transaction_category->details($transaction_category_id);
$cash_flow->setUser($user);
$cash_flow->setTransactionCategory($transaction_category);
$cash_flow->details($cashflow_id);

$company_category->details($company_category_id);
$company->setCompanyCategory($company_category);
$company->details($company_id);


$bill->setAmount(50000);
$bill->setBillingDate($date);
$bill->setUser($user);
$bill->setAdminFee($admin_fee);
$bill->setTotalAmount($total_amount);
$bill->setCompany($company);
$bill->setUser($user);
$bill->setCashflow($cash_flow);

View::json($bill->addBill());