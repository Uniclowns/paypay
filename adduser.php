<?php
use App\Model\UserStandard;
use App\View;

require_once 'vendor/autoload.php';

$user = new UserStandard();
$user->setEmail("h1101221020@student.untan.ac.id");
$user->setName("Pheterson Ferry Fernando");
$user->setBalance();
$user->setCategoryUser();
$user->setPhoneNum("08123456789");
$user->setPin("123456");
$user->setProfilPicture();
View::json($user->addUser());