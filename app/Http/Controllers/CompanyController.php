<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    protected $companyService;
    
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }
    
    public function index()
    {
        try {
            $companies = $this->companyService->getAllCompanies();
            if ($companies->isEmpty()) {
                return ResponseHelper::error('Nenhum registro encontrado.', null, 404);
            }
            return ResponseHelper::success($companies, 'Companies recuperadas com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar companies.', $e->getMessage());
        }
    }
    
    public function show($idCompany)
    {
        try {
            $company = $this->companyService->getCompanyDetail($idCompany);
            return ResponseHelper::success($company, 'Company recuperada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao consultar company.', $e->getMessage());
        }
    }
    
    public function store(CompanyCreateRequest $request)
    {
        try {
            $company = $this->companyService->createCompany($request->validated());
            return ResponseHelper::success($company, 'Company criada com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao criar company.', $e->getMessage());
        }
    }
    
    public function update(CompanyUpdateRequest $request, $idCompany)
    {
        try {
            $company = $this->companyService->updateCompany($idCompany, $request->validated());
            return ResponseHelper::success($company, 'Company atualizada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar company.', $e->getMessage());
        }
    }
    
    public function destroy($idCompany)
    {
        try {
            $result = $this->companyService->deleteCompany($idCompany);
            return ResponseHelper::success($result['company'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao deletar company.', $e->getMessage());
        }
    }
}
