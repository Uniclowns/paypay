<?php
use App\Model\TransactionCategory;
use App\View;

require_once 'vendor/autoload.php';

$transaction_category = new TransactionCategory();

$name = "Perusahaan Tersero";

$transaction_category->setId(4);
$transaction_category->setName($name);
View::json($transaction_category->editCategory());