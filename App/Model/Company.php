<?php
namespace App\Model;

use App\Model\Model;
use App\Model\CompanyCategory;
use PDO;

class Company extends Model{
    public int $id;
    protected string $name;
    protected CompanyCategory $company_category;

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

    public function setCompanyCategory(CompanyCategory $company_category): void
    {
        $this->company_category = $company_category;
    }

    public function getCompanyCategory(): CompanyCategory
    {
        return $this->company_category;
    }

    public function addCompany(){
        $this->generateId();
        $stmt = $this->db->prepare("INSERT INTO company(id, company_name, company_category_id) VALUES (:id, :name, :company_category)");
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':company_category', $this->company_category->id);
        return $stmt->execute();
    }


    public function details($id)
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

    public function generateId()
    {
        $stmt = $this->db->prepare("SELECT MAX(id) AS id FROM company");
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'] + 1;
        } else {
            return 0;
        }
    }
}