<?php
namespace App\Model;

use App\Model\Model;
use PDO;

class CompanyCategory extends Model{
    public int $id;
    protected string $name;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addCategory(){
        $stmt = $this->db->prepare("INSERT INTO company_category (id, name) VALUES (:id, :name)");
        $this->generateId();
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        return $stmt->execute();
    }

    public function generateId()
    {
        $sql = 'SELECT MAX(id) AS id FROM company_category';
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'] + 1;
        } else {
            return 0;
        }
    }

    public function details($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM company_category WHERE id=$id");
        if ($stmt->execute()) {
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $category['id'];
            $this->name = $category['name'];
        } else {
            $category = null;
        }
    }

}