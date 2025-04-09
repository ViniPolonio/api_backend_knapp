<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Exception;

class CompanyService
{
    /**
     * Retorna todas as companies.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllCompanies()
    {
        return Company::whereNull('deleted_at')->get();
    }
    
    /**
     * Retorna os detalhes de uma company pelo ID,
     * ou lança exceção se não encontrada.
     *
     * @param int $id
     * @return Company
     * @throws Exception
     */
    public function getCompanyDetail(int $id): Company
    {
        $company = Company::find($id);
        if (!$company) {
            throw new Exception('Company não encontrada.', 404);
        }
        return $company;
    }
    
    /**
     * Cria uma nova company com os dados fornecidos.
     *
     * @param array $data
     * @return Company
     */
    public function createCompany(array $data): Company
    {
        return DB::transaction(function () use ($data) {
            return Company::create([
                'name'            => $data['name'],
                'cnpj'            => $data['cnpj'],
                'phone_number'    => $data['phone_number'],
                'email'           => $data['email'],
                'uf'              => $data['uf'],
                'endereco_detail' => $data['endereco_detail'],
                'status'          => $data['status'] ?? 1, // Padrão ativo
            ]);
        });
    }
    
    /**
     * Atualiza uma company existente com os dados fornecidos.
     *
     * @param int   $id
     * @param array $data
     * @return Company
     */
    public function updateCompany(int $id, array $data): Company
    {
        return DB::transaction(function () use ($id, $data) {
            $company = Company::findOrFail($id);
            $company->update([
                'name'            => $data['name'],
                'cnpj'            => $data['cnpj'],
                'phone_number'    => $data['phone_number'],
                'email'           => $data['email'],
                'uf'              => $data['uf'],
                'endereco_detail' => $data['endereco_detail'],
                'status'          => $data['status'] ?? 1,
            ]);
            return $company;
        });
    }
    
    /**
     * Realiza o soft delete de uma company.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function deleteCompany(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $company = Company::findOrFail($id);
            if ($company->trashed()) {
                throw new Exception('Company já foi deletada anteriormente.', 400);
            }
            $company->delete();
            return [
                'company' => $company,
                'message' => 'Company deletada com sucesso.'
            ];
        });
    }
}
