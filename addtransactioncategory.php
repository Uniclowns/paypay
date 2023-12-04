<?php

use App\Model\TransactionCategory;
use App\View;

require 'vendor/autoload.php';

$nama = "QRIS";

$company_category = new TransactionCategory();
$company_category->setName($nama);

View::json($company_category->addCategory());