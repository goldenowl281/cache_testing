<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CompanyController extends Controller
{

    private CompanyRepositoryInterface $companyRepository;
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        // Cache::put('cachekey', 'this should be cache key', now()->addDay());
        // Cache::put('key', 'Cache 2', now()->addDay());
        // Cache::flush();
        // dd(Cache::get('cachekey'));
        // if (Cache::has('chchekey')) {
        //     dd('cache key found');
        // }
        // dd(Redis::get('Company' . 1));
        $companies = $this->companyRepository->getAllCompany();
        Cache::set('act', 'Taylor');
        if (Cache::has('act')) {
            dd('hello');
        }
        return response()->json($companies);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = [
            'name'    => $request->name,
            'website' => $request->website,
            'email'   => $request->email,
        ];
        $company = $this->companyRepository->createCompany($data);
        return response()->json([
            'success' => true,
            'message' => 'Company Created successfullt',
            'data'    => $company
        ]);
    }

    public function show(string $id)
    {
        $company = $this->companyRepository->getCompanyById($id);

        if ($this->companyRepository->companyFromCache) {
            return response()->json([
                'success' => true,
                'message' => 'from cache',
                'data'    => $company
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'from database',
                'data'    => $company
            ]);
        }
    }

    public function edit(string $id, Request $request)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $data = [
            'name'   => $request->name,
            'website' => $request->website,
            'email'  => $request->email,
        ];
        $company = $this->companyRepository->updateCompany($id, $data);
        return response()->json([
            'success' => true,
            'message' => 'Company Updated successfully',
            'data'    => $company,
        ]);
    }

    public function destroy(string $id)
    {
        $company = $this->companyRepository->deleteCompany($id);
        if ($company) {
            // Company was successfully deleted
            return response()->json([
                'success'  => true,
                'message'  => 'Company deleted successfully',
                'data'     => $company
            ]);
        } else {
            // Company with the given ID does not exist
            return response()->json([
                'success'  => false,
                'message'  => 'Company not found or could not be deleted',
                'data'     => null
            ], 404); // You can choose an appropriate HTTP status code like 404 (Not Found)
        }
    }
}
