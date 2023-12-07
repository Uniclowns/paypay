<?php
use App\Model\Company;
use App\Model\CompanyCategory;
use App\View;

require_once 'vendor/autoload.php';

$user = new Company();
$companyCategory = new CompanyCategory();

$category = 4;
$companyCategory->id = $category;

$user->setId(1);
$user->setName("Bank Indonesia");
$user->setCompanyCategory($companyCategory);
View::json($user->editCompany());