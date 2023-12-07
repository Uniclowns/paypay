<?php
use App\Model\Users;
use App\View;

require_once 'vendor/autoload.php';

$user = new Users();
$user->setPhoneNum("08123456789");
$user->setName("Gerd");
$user->setEmail("carsenwilmerganteng123@gmail.com");
$user->setProfilPicture("carsen.jpg");
View::json($user->editProfile());