<?php

namespace App\Model;

use App\Model\Model;
use PDO;

abstract class Users extends Model
{
    public string $phone_num;
    protected string $email;
    protected string $name;
    protected string $pin;
    public int $balance;
    protected string $profil_picture;
    protected string $category_user;

    public CashFlow $cash_flow;

    public function login(): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE phone_num = :phone_num");
        $stmt->bindParam(':phone_num', $this->phone_num);
        if ($stmt->execute() === true) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->pin, $data["pin"])) {
                return true;
            }
        } else {
            // Cetak error
            print_r($stmt->errorInfo());
        }
    }

    public function logout(): bool
    {
        return false;
    }

    public function changePin(): bool
    {
        $stmt = $this->db->prepare("UPDATE user SET pin = :pin WHERE phone_num = :phone_num");
        $stmt->bindParam(':phone_num', $this->phone_num);
        $pass = password_hash($this->pin, PASSWORD_DEFAULT);
        $stmt->bindParam(':pin', $pass);
        return $stmt->execute();
    }

    public function editProfile(): bool
    {
        $stmt = $this->db->prepare("UPDATE user SET email = :email, nama = :nama, profil_picture = :profil_picture WHERE phone_num = :phone_num");
        $stmt->bindParam(':phone_num', $this->phone_num);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nama', $this->name);
        $stmt->bindParam(':profil_picture', $this->profil_picture);
        return $stmt->execute();
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPin(string $pin): void
    {
        $this->pin = $pin;
    }

    public function setBalance(): void
    {
        $this->balance = 0;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPhoneNum(string $phone_num): void
    {
        if ($phone_num >= 628000) {
            $this->phone_num = $phone_num;
        } else {
            echo "Nomor hape anda tidak dimulai dengan 628";
        }
    }

    public function setProfilPicture(): void
    {
        $this->profil_picture = "avatar.jpg";
    }

    public function setCategoryUser(): void
    {
        $this->category_user = "Standard";
    }

    public function getCategoryUser(): string
    {
        $this->details($this->phone_num);
        return $this->category_user;
    }

    public function addUser(): bool
    {
        $stmt = $this->db->prepare("INSERT INTO user (phone_num, email, nama, pin, balance,  profil_picture, category_user) VALUES (:phone_num, :email, :name, :pin, :balance,  :profil_picture, :category_user)");
        $stmt->bindParam(':name', $this->name);
        $pass = password_hash($this->pin, PASSWORD_DEFAULT);
        $stmt->bindParam(':pin', $pass);
        $stmt->bindParam(':balance', $this->balance);
        $stmt->bindParam(':phone_num', $this->phone_num);
        $stmt->bindParam(':profil_picture', $this->profil_picture);
        $stmt->bindParam(':category_user', $this->category_user);
        $stmt->bindParam(':email', $this->email);
        return $stmt->execute();
    }

    public function details($id): void
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE phone_num=$id");
        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->phone_num = $user['phone_num'];
            $this->pin = $user['pin'];
            $this->balance = $user['balance'];
            $this->profil_picture = $user['profil_picture'];
            $this->email = $user['email'];
            $this->category_user = $user['category_user'];
            $this->email = $user['email'];
        } else {
            $user = null;
        }
    }

    public function topUp(): bool
    {
        return $this->cash_flow->topUp();
    }

    public function upgradeCategory(): bool
    {
        $this->details($this->phone_num);
        if ($this->category_user != 'Premium') {
            $stmt = $this->db->prepare("UPDATE user SET category_user = :category_user WHERE phone_num = :phone_num");
            $temp = "Premium";
            $stmt->bindParam(':category_user', $temp);
            $stmt->bindParam(':phone_num', $this->phone_num);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public function view(): array
    {
        $stmt = $this->db->prepare("SELECT `user`.`nama`,
       `user`.`phone_num`,
       `user`.`balance`,
       SUM(`cashflow`.`debit`) AS total_debit,
       SUM(`cashflow`.`credit`) AS total_credit
       FROM `cashflow`
       LEFT JOIN `user` ON `cashflow`.`phone_num` = `user`.`phone_num`
       GROUP BY `user`.`nama`, `user`.`phone_num`, `user`.`balance`;");
        if ($stmt->execute()) {
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $temp = null;
        }
        return $temp;
    }

    public function home(): array
    {
        $stmt = $this->db->prepare("SELECT `nama`, `phone_num`, `balance`, `profil_picture` FROM `paypay`.`user`");
        if ($stmt->execute()) {
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $temp = null;
        }
        return $temp;
    }

    public function all() : array 
    {
         $stmt = $this->db->prepare("SELECT * FROM user");
        if ($stmt->execute()) {
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $temp = null;
        }
        return $temp;
    }

    abstract public function transfer();
}
