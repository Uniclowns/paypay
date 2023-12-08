<?php

namespace App\Model;

use App\Model\Model;
use App\Model\CompanyCategory;
use PDO;

class Company extends Model
{
    public int $id;
    protected string $name;
    protected CompanyCategory $company_category;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setCompanyCategory(CompanyCategory $company_category): void
    {
        $this->company_category = $company_category;
    }

    public function addCompany() : bool 
    {
        $this->generateId();
        $stmt = $this->db->prepare("INSERT INTO company(id, company_name, company_category_id) VALUES (:id, :name, :company_category)");
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':company_category', $this->company_category->id);
        return $stmt->execute();
    }

    public function editCompany() : bool
    {
        $stmt = $this->db->prepare("UPDATE company SET company_name = :name, company_category_id = :com_cat_id WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':com_cat_id', $this->company_category->id);
        return $stmt->execute();
    }


    public function details($id) : void
    {
        $stmt = $this->db->prepare("SELECT * FROM company WHERE id=$id");
        if ($stmt->execute()) {
            $company = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $company['id'];
            $this->name = $company['company_name'];
            $this->company_category->id = $company['company_category_id'];
        } else {
            $company = null;
        }
    }

    public function generateId() : void
    {
        $stmt = $this->db->prepare("SELECT MAX(id) AS id FROM company");
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'] + 1;
        } else {
            0;
        }
    }

    public function view() : array
    {
        $stmt = $this->db->prepare("SELECT 
        company.company_name,
        company_category.name
    FROM 
        company 
    LEFT JOIN 
        company_category ON company_category.id = company.company_category_id");

        if ($stmt->execute()) {
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $temp = null;
        }

        return $temp;
    }
}
