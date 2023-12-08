<?php
use App\Model\CompanyCategory;
use App\View;

require_once 'vendor/autoload.php';

$category = new CompanyCategory();
View::json($category->view());