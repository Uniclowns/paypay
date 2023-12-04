<?php

use App\Model\Company;
use App\Model\CompanyCategory;
use App\View;

require 'vendor/autoload.php';

$nama = "Bank Mandiri";
$category = 1;

$company = new Company();
$companyCategory = new CompanyCategory();

$companyCategory->id = $category;

$company->setName($nama);
$company->setCompanyCategory($companyCategory);

View::json($company->addCompany());