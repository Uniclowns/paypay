<?php
use App\Model\UserPremium;
use App\View;

require_once 'vendor/autoload.php';

$user = new UserPremium();
View::json($user->view());