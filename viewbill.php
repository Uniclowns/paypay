<?php
use App\Model\Bill;
use App\View;

require_once 'vendor/autoload.php';

$bill = new Bill();
View::json($bill->view());