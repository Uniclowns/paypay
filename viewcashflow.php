<?php
use App\Model\CashFlow;
use App\View;

require_once 'vendor/autoload.php';

$cashflow = new CashFlow();
View::json($cashflow->view());