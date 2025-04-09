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
                'name'       => $data['name'],
                'address'    => $data['address'],
                'company_id' => $data['company_id'],
                // adicione outros campos conforme necessário
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
            $branch->update([
                'name'       => $data['name'],
                'address'    => $data['address'],
                'company_id' => $data['company_id'],
                // adicione outros campos conforme necessário
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
