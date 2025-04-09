<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Branch\BranchCreateRequest;
use App\Http\Requests\Branch\BranchUpdateRequest;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        try {
            $branches = Branch::consultAllBranches();
            return ResponseHelper::success($branches);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar Branchs.', $e->getMessage());
        }
    }

    public function show($idBranch)
    {
        try {
            $branch = Branch::consultDetailBranch($idBranch);
            return ResponseHelper::success($branch);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao consultar Branch.', $e->getMessage());
        }
    }

    public function store(BranchCreateRequest $request)
    {
        try {
            $branch = Branch::createBranch($request);
            return ResponseHelper::success($branch, 'Branch criada com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao criar Branch.', $e->getMessage());
        }
    }

    public function update(BranchUpdateRequest $request, $idBranch)
    {
        try {
            $branch = Branch::updateBranch($idBranch, $request);
            return ResponseHelper::success($branch, 'Branch atualizada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar Branch.', $e->getMessage());
        }
    }

    public function destroy($idBranch)
    {
        try {
            return Branch::deleteBranch($idBranch);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao deletar Branch.', $e->getMessage());
        }
    }
}
