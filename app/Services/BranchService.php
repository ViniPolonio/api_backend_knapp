<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Exception;

class BranchService
{
    /**
     * Retorna todas as branches.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllBranches()
    {
        return Branch::with('company')
            ->whereNull('deleted_at')
            ->get();
    }

    /**
     * Retorna o detalhe de uma branch ou lança exceção se não encontrada.
     *
     * @param int $id
     * @return Branch
     * @throws Exception
     */
    public function getBranchDetail(int $id): Branch
    {
        $branch = Branch::with('company')->find($id);
        if (!$branch) {
            throw new Exception('Branch não encontrada.', 404);
        }
        return $branch;
    }

    /**
     * Cria uma nova branch com os dados fornecidos.
     *
     * @param array $data
     * @return Branch
     */
    public function createBranch(array $data): Branch
    {
        return DB::transaction(function () use ($data) {
            return Branch::create([
                'company_id' => $data['company_id'],
                'name'       => $data['name'],
                'cnpj'       => $data['cnpj'],
                'phone_number' => $data['phone_number'],
                'email'      => $data['email'],
                'uf'         => $data['uf'],
                'endereco_detail' => $data['endereco_detail'],
                'status'     => $data['status'],
                'departaments_json' => json_encode($data['departaments_json']),
                'cep' => $data['cep'],
            ]);
        });
    }

    /**
     * Atualiza os dados de uma branch existente.
     *
     * @param int $id
     * @param array $data
     * @return Branch
     */
    public function updateBranch(int $id, array $data): Branch
    {
        return DB::transaction(function () use ($id, $data) {
            $branch = Branch::findOrFail($id);

            $data = array_merge([
                'departaments_json' => $branch->departaments_json,
                'company_id'     => $branch->company_id,
                'name'           => $branch->name,
                'cnpj'           => $branch->cnpj,
                'phone_number'   => $branch->phone_number,
                'email'          => $branch->email,
                'uf'             => $branch->uf,
                'endereco_detail'=> $branch->endereco_detail,
                'status'         => $branch->status,
                'cep'            => $branch->cep,
            ], $data);

            $branch->update([
                'cep'             => $data['cep'],
                'departaments_json' => $data['departaments_json'],
                'company_id'     => $data['company_id'],
                'name'           => $data['name'],
                'cnpj'           => $data['cnpj'],
                'phone_number'   => $data['phone_number'],
                'email'          => $data['email'],
                'uf'             => $data['uf'],
                'endereco_detail'=> $data['endereco_detail'],
                'status'         => $data['status'],
            ]);

            return $branch;
        });
    }


    /**
     * Deleta (soft delete) a branch.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function deleteBranch(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $branch = Branch::findOrFail($id);
            if ($branch->trashed()) {
                throw new Exception('Branch já foi deletada anteriormente.', 400);
            }
            $branch->delete();
            return [
                'branch'  => $branch,
                'message' => 'Branch deletada com sucesso.'
            ];
        });
    }
}
