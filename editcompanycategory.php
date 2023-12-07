<?php
use App\Model\CompanyCategory;
use App\View;

require_once 'vendor/autoload.php';

$company_category = new CompanyCategory();

$name = "Perusahaan Tersero";

$company_category->setId(4);
$company_category->setName($name);
View::json($company_category->editCategory());