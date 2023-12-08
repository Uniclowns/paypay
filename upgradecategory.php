<?php
use App\Model\UserStandard;
use App\View;

require_once 'vendor/autoload.php';

$user = new UserStandard();
$user->setPhoneNum('08123456789');

View::json($user->upgradeCategory());