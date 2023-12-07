<?php
namespace App\Model;

use App\Model\Model;
use PDO;

class TransactionCategory extends Model{
    public int $id;
    protected string $name;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function generateId()
    {
        $sql = 'SELECT MAX(id) AS id FROM transaction_category';
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'] + 1;
        } else {
            return 0;
        }
    }

    public function addCategory()
    {
        $stmt = $this->db->prepare("INSERT INTO transaction_category (id, name) VALUES (:id, :name)");
        $this->generateId();
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function editCategory()
    {
        $stmt = $this->db->prepare("UPDATE transaction_category SET name = :name WHERE id = :id");
        $this->generateId();
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function details($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM transaction_category WHERE id=$id");
        if($stmt->execute()) {
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $category['id'];
            $this->name = $category['name'];
        } else {
            $category = null;
        }
    }


}