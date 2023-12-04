<?php
use App\Model\Users;
use App\View;

require_once 'vendor/autoload.php';

$user = new Users();
$user->setPhoneNum("08123456789");
$user->setPin("123456");
View::json($user->login());