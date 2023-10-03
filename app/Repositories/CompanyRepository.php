<?php

namespace App\Repositories;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Support\Facades\Redis;

class CompanyRepository implements CompanyRepositoryInterface
{
    public $companyFromCache;

    public function getAllCompany()
    {
        // $cacheKey  = 'Getall';
        $companies = Company::all();
        // foreach ($companies as $company) {
        //     // Store each company individually using its ID as the key
        //     Redis::set('Company' . $company->id, json_encode($company));
        // }

        return $companies;
    }

    public function getCompanyById($id)
    {
        // return Company::findOrFail($id);
        // $company = Company::findOrFail($id);
        $cache = Redis::get('Company' . $id, );

        if (isset($cache)) {
            $company = json_decode($cache, FALSE);
            $this->companyFromCache = true;
            return $company;
        } else {
            $company = Company::findOrFail($id);
            Redis::set('Company' . $id, $company);
            
            return $company;
        }
    }

    public function deleteCompany($id)
    {

        return Company::destroy($id);

    }
    public function createCompany(array $data)
    {
        $company = Company::create($data);
        Redis::set('Company' . $company->id, json_encode($company));

        return $company;
        // foreach ($companies as $company) {
        //     // Store each company individually using its ID as the key
        //     Redis::set('Company' . $company->id, json_encode($company));
        // }

    }
    public function updateCompany($id, array $data)
    {
        return Company::whereId($id)->update($data);
    }
}

