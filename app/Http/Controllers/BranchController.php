<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Branch\BranchCreateRequest;
use App\Http\Requests\Branch\BranchUpdateRequest;
use App\Services\BranchService;

class BranchController extends Controller
{
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index()
    {
        try {
            $branches = $this->branchService->getAllBranches();
            if ($branches->isEmpty()) {
                return ResponseHelper::error('Nenhum registro encontrado.', null, 404);
            }
            return ResponseHelper::success($branches, 'Branches recuperadas com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar branches.', $e->getMessage());
        }
    }

    public function show($idBranch)
    {
        try {
            $branch = $this->branchService->getBranchDetail($idBranch);
            return ResponseHelper::success($branch, 'Branch recuperada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao consultar branch.', $e->getMessage());
        }
    }

    public function store(BranchCreateRequest $request)
    {
        try {
            $branch = $this->branchService->createBranch($request->validated());
            return ResponseHelper::success($branch, 'Branch criada com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao criar branch.', $e->getMessage());
        }
    }

    public function update(BranchUpdateRequest $request, $idBranch)
    {
        try {
            $branch = $this->branchService->updateBranch($idBranch, $request->validated());
            return ResponseHelper::success($branch, 'Branch atualizada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar branch.', $e->getMessage());
        }
    }

    public function destroy($idBranch)
    {
        try {
            $result = $this->branchService->deleteBranch($idBranch);
            return ResponseHelper::success($result['branch'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao deletar branch.', $e->getMessage());
        }
    }
}
