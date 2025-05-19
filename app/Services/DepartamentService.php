<?php

namespace App\Services;

use App\Models\Departament;
use Illuminate\Support\Facades\DB;
use Exception;

class DepartamentService
{
    /**
     * Retorna todos os departamentos.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllDepartaments()
    {
        return Departament::whereNull('deleted_at')->get();
    }
    
    /**
     * Retorna os detalhes de um departamento pelo ID,
     * ou lança exceção se não encontrado.
     *
     * @param int $id
     * @return Departament
     * @throws Exception
     */
    public function getDepartamentDetail(int $id): Departament
    {
        $departament = Departament::find($id);
        if (!$departament) {
            throw new Exception('Departamento não encontrado.', 404);
        }
        return $departament;
    }
    
    /**
     * Cria um novo departamento com os dados fornecidos.
     *
     * @param array $data
     * @return Departament
     */
    public function createDepartament(array $data): Departament
    {
        return DB::transaction(function () use ($data) {
            return Departament::create([
                'title'       => $data['title'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'] ?? 1, // Padrão ativo
            ]);
        });
    }
    
    /**
     * Atualiza um departamento existente com os dados fornecidos.
     *
     * @param int   $id
     * @param array $data
     * @return Departament
     */
    public function updateDepartament(int $id, array $data): Departament
    {
        return DB::transaction(function () use ($id, $data) {
            $departament = Departament::findOrFail($id);
            $departament->update([
                'title'       => $data['title'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'] ?? 1,
            ]);
            return $departament;
        });
    }
    
    /**
     * Realiza o soft delete de um departamento.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function deleteDepartament(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $departament = Departament::findOrFail($id);
            if ($departament->trashed()) {
                throw new Exception('Departamento já foi deletado anteriormente.', 400);
            }
            $departament->delete();
            return [
                'departament' => $departament,
                'message' => 'Departamento deletado com sucesso.'
            ];
        });
    }
}
