<?php
namespace App\Model;
header('Content-Type: application/json; charset=utf-8');

use PDO;
use PDOException;

class Model
{
    protected $db;

    public function __construct() {
        require 'config.php';
        try {
            $conn = new PDO("mysql:host=$servername;dbname={$database}", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>
