<?php

namespace App\Interfaces;

interface CompanyRepositoryInterface
{
    public function getAllCompany();
    public function getCompanyById($id);
    public function deleteCompany($id);
    public function createCompany( array $data);
    public function updateCompany($id, array $data);
}

?>
