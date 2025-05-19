<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Departament\DepartamentCreateRequest;
use App\Http\Requests\Departament\DepartamentUpdateRequest;
use App\Services\DepartamentService;

class DepartamentController extends Controller
{
    protected $departamentService;
    
    public function __construct(DepartamentService $departamentService)
    {
        $this->departamentService = $departamentService;
    }
    
    public function index()
    {
        try {
            $departaments = $this->departamentService->getAllDepartaments();
            if ($departaments->isEmpty()) {
                return ResponseHelper::error('Nenhum registro encontrado.', null, 404);
            }
            return ResponseHelper::success($departaments, 'Departamentos recuperados com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar departamentos.', $e->getMessage());
        }
    }
    
    public function show($idDepartament)
    {
        try {
            $departament = $this->departamentService->getDepartamentDetail($idDepartament);
            return ResponseHelper::success($departament, 'Departamento recuperado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao consultar departamento.', $e->getMessage());
        }
    }
    
    public function store(DepartamentCreateRequest $request)
    {
        try {
            $departament = $this->departamentService->createDepartament($request->validated());
            return ResponseHelper::success($departament, 'Departamento criado com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao criar departamento.', $e->getMessage());
        }
    }
    
    public function update(DepartamentUpdateRequest $request, $idDepartament)
    {
        try {
            $departament = $this->departamentService->updateDepartament($idDepartament, $request->validated());
            return ResponseHelper::success($departament, 'Departamento atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar departamento.', $e->getMessage());
        }
    }
    
    public function destroy($idDepartament)
    {
        try {
            $result = $this->departamentService->deleteDepartament($idDepartament);
            return ResponseHelper::success($result['departament'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao deletar departamento.', $e->getMessage());
        }
    }
}
