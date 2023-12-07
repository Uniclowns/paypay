<?php

use App\Model\TransactionCategory;
use App\View;

require 'vendor/autoload.php';

$nama = "Receive Money";

$company_category = new TransactionCategory();
$company_category->setName($nama);

View::json($company_category->addCategory());