<?php

use App\Model\CashFlow;
use App\Model\Users;
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
$user = new Users();
$transaction_category = new TransactionCategory();
$company_category = new CompanyCategory();
$bill = new Bill();
$company = new Company();


$company_category->setId($company_category_id);
$company->setId($company_id);
$company->setCompanyCategory($company_category);

$user->details($phone_num);
$transaction_category->details($transaction_category_id);

$company_category->setId($company_category_id);
$cash_flow->setCompany($company);

$bill->setCashflow($cash_flow);
$cash_flow->cashflow = $cash_flow;
$cash_flow->bill = $bill;
$cash_flow->setDate();
$cash_flow->setUser($user);
$cash_flow->setCreDebStat("-50000");
$cash_flow->setTransactionCategory($transaction_category);

$bill->setCompany($company);
$bill->setUser($user);
$bill->setCashflow($cash_flow);

View::json($cash_flow->addCashFlow());

