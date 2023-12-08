<?php
use App\Model\Company;
use App\View;

require_once 'vendor/autoload.php';

$company = new Company();
View::json($company->view());