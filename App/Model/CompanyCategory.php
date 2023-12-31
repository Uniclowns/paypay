<?php

namespace App\Model;

use App\Model\Model;
use PDO;

class CompanyCategory extends Model
{
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

    public function addCategory() : bool 
    {
        $stmt = $this->db->prepare("INSERT INTO company_category (id, name) VALUES (:id, :name)");
        $this->generateId();
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        return $stmt->execute();
    }

    public function editCategory() : bool
    {
        $stmt = $this->db->prepare("UPDATE company_category SET name = :name WHERE id = :id");
        $this->generateId();
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function generateId() : void
    {
        $sql = 'SELECT MAX(id) AS id FROM company_category';
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'] + 1;
        } else {
             0;
        }
    }

    public function details($id) : void
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

    public function view() : array   
    {
        $stmt = $this->db->prepare("SELECT `name` FROM company_category");
        if ($stmt->execute()) {
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $temp = null;
        }

        return $temp;
    }
}
