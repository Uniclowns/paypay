<?php 
namespace App\Model;

use App\Model\Users;
use PDO;

class UserStandard extends Users
{
    public function transfer() : bool
    {
        return false;
    }
}
