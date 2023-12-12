<?php
use App\Model\UserPremium;
use App\View;

require_once 'vendor/autoload.php';

$user = new UserPremium();
$user->setPhoneNum("08121234567");
View::json($user->all());