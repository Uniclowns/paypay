<?php
use App\Model\UserStandard;
use App\View;

require_once 'vendor/autoload.php';

$user = new UserStandard();
$user->setEmail("h1101221036@student.untan.ac.id");
$user->setName("Carsen Wilmer");
$user->setBalance();
$user->setCategoryUser();
$user->setPhoneNum("08121234567");
$user->setPin("123456");
$user->setProfilPicture();
View::json($user->addUser());