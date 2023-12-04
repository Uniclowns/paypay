<?php 
namespace App\Model;

use App\Model\Model;
use PDO;

class Users extends Model{
    protected string $email;
    protected string $name;
    protected string $pin;
    protected int $balance = 0;
    public string $phone_num;
    protected string $profil_picture = "avatar.jpg";
    protected string $category_user = "standard";

    public function login(){
        $stmt = $this->db->prepare("SELECT * FROM user WHERE phone_num = :phone_num");
        $stmt->bindParam(':phone_num', $this->phone_num);
        if ($stmt->execute() === true){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($this->pin, $data["pin"])){
                return true;
            }
        } else {
            // Cetak error
            print_r($stmt->errorInfo());
        }
    }

    public function logout(){
        return false;
    }

    public function changePin() : bool
    {
        $stmt = $this->db->prepare("UPDATE user SET pin = :pin WHERE phone_num = :phone_num");
        $stmt->bindParam(':phone_num', $this->phone_num);
        $pass = password_hash($this->pin, PASSWORD_DEFAULT);
        $stmt->bindParam(':pin', $pass);
        return $stmt->execute();
    }

    public function printQR(){
        return false;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPin(string $pin): void
    {
        $this->pin = $pin;
    }

    public function getPin(): string
    {
        return $this->pin;
    }

    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPhoneNum(string $phone_num): void
    {
        if($phone_num >= 628000){
            $this->phone_num = $phone_num;
        }else{
            echo "Nomor hape anda tidak dimulai dengan 628";
        }
    }

    public function getPhoneNum(): string
    {
        return $this->phone_num;
    }

    public function setProfilPicture(string $profil_picture): void
    {
        $this->profil_picture = $profil_picture;
    }

    public function getProfilPicture(): string
    {
        return $this->profil_picture;
    }

    public function setCategoryUser(string $category_user): void
    {
        $this->category_user = $category_user;
    }


    public function getCategoryUser(): string
    {
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

    public function details($id)
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
}