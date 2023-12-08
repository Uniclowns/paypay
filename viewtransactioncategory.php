<?php
use App\Model\TransactionCategory;
use App\View;

require_once 'vendor/autoload.php';

$category = new TransactionCategory();
View::json($category->view());