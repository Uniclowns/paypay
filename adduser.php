<?php
use App\Model\Users;
use App\View;

require_once 'vendor/autoload.php';

$user = new Users();
$user->setEmail("h1101221020@student.untan.ac.id");
$user->setName("Pheterson Ferry Fernando");
$user->setBalance(0);
$user->setCategoryUser("standard");
$user->setPhoneNum("08123456789");
$user->setPin("123123");
$user->setProfilPicture("avatar.jpg");
View::json($user->addUser());