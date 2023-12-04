<?php

use App\Model\CompanyCategory;
use App\View;

require 'vendor/autoload.php';

$nama = "QRIS";

$company_category = new CompanyCategory();
$company_category->setName($nama);

View::json($company_category->addCategory());