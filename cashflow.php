<?php

use App\Model\CashFlow;
use App\Model\UserStandard;
use App\Model\UserPremium;
use App\Model\Company;
use App\Model\Bill;
use App\Model\TransactionCategory;
use App\Model\CompanyCategory;
use App\View;

require 'vendor/autoload.php';

$phone_num = "08123456789";
$transaction_category_id = "4";
$company_category_id = 1;
$company_id = 1;

$cash_flow = new CashFlow();
$user = new UserPremium();
$transaction_category = new TransactionCategory();
$company_category = new CompanyCategory();
$bill = new Bill();
$company = new Company();

$user->details($phone_num);

$transaction_category->details($transaction_category_id);

$company_category->setId($company_category_id);

$company->setCompanyCategory($company_category);
$company->setId($company_id);

$cash_flow->generateId();
$cash_flow->setCompany($company);
$cash_flow->cashflow = $cash_flow;
$cash_flow->bill = $bill;
$cash_flow->setDate();
$cash_flow->setUser($user);
$cash_flow->setCreDebStat("-1000");
$cash_flow->setTransactionCategory($transaction_category);

if($cash_flow->getStatus() == "Debit"){
    if($user->getCategoryUser() == "Standard" || $user->getCategoryUser() == "Premium")
    {
        View::json($cash_flow->topUp());
    }
}else if($cash_flow->getStatus() == "Credit"){
    if($user->getCategoryUser() == "Standard")
    {
        View::json($user->transfer());
    }else if($user->getCategoryUser() == "Premium")
    {
        $bill->setCashflow($cash_flow);
        $bill->setCompany($company);
        $bill->setUser($user);
        $bill->setCashflow($cash_flow);
        $user->cash_flow = $cash_flow;
        View::json($user->transfer());
    }
}



