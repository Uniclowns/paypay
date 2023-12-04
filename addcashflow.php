<?php

use App\Model\CashFlow;
use App\Model\Users;
use App\Model\TransactionCategory;

use App\View;

require 'vendor/autoload.php';

$date = "2023/12/04";
$amount = 50000;
$balance = 50000;
$credit_debit = 50000;
$phone_num = "08123456789";
$transaction_category_id = "1";


$cash_flow = new CashFlow();
$user = new Users();
$transaction_category = new TransactionCategory();

$user->details($phone_num);
$transaction_category->details($transaction_category_id);

$cash_flow->setDate($date);
$cash_flow->setBalance($balance);
$cash_flow->setAmount($amount);
$cash_flow->setCreditDebit($credit_debit);
$cash_flow->setUser($user);
$cash_flow->setTransactionCategory($transaction_category);

View::json($cash_flow->addCashFlow());