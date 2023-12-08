<?php 
namespace App\Model;

use App\Model\Users;
use PDO;

class UserPremium extends Users
{
    public function transfer() : bool
    {
        return $this->cash_flow->paymentBill();
    }

}
