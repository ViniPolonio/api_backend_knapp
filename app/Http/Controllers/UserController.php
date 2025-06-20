<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            if ($users->isEmpty()) {
                return ResponseHelper::error('Nenhum registro encontrado.', null, 404);
            }
            return ResponseHelper::success($users, 'Usuários recuperados com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar usuários.', $e->getMessage());
        }
    }

    public function show($idUser)
    {
        try {
            $user = $this->userService->getUserDetail($idUser);
            return ResponseHelper::success($user, 'Usuário recuperado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao consultar usuário.', $e->getMessage());
        }
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
            return ResponseHelper::success($user, 'Usuário criado com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao criar usuário.', $e->getMessage());
        }
    }

    public function update(UserUpdateRequest $request, $idUser)
    {
        try {
            $user = $this->userService->updateUser($idUser, $request->validated());
            return ResponseHelper::success($user, 'Usuário atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar usuário.', $e->getMessage());
        }
    }

    public function activeUser($idUser)
    {
        try {
            $result = $this->userService->activateUser($idUser);
            return ResponseHelper::success($result['user'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao ativar usuário.', $e->getMessage());
        }
    }

    public function inactiveUser($idUser)
    {
        try {
            $result = $this->userService->deactivateUser($idUser);
            return ResponseHelper::success($result['user'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao inativar usuário.', $e->getMessage());
        }
    }

    public function destroy($idUser)
    {
        try {
            $result = $this->userService->deleteUser($idUser);
            return ResponseHelper::success($result['user'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao deletar usuário.', $e->getMessage());
        }
    }

    public function getUsers(int $status, int $branchId) 
    {
        try {
            // 0 - PENDENTE APROVAÇÃO | 1 - APROVADO COM VINCULO | 2 - APROVADO SEM VINCULO | 3 - REPROVADO | 4 - INACTIVE = DELETED_AT
            $consultUsers = $this->userService->getUsers($status, $branchId);
            if ($consultUsers->isEmpty()) {
                return response()->json(['staus'  => 1, 'message' => 'Não há usuários aguardando aprovação nesta filial no momento.', 'data' => '',]);
            }
            return ResponseHelper::success($consultUsers, 'Novos usuários recuperados com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Error ao consultar todos os novos usuários.', $e->getMessage());
        }
    }

    public function getUsersByBranch(int $branchId) 
    {
        try {
            $consultAllUsers = $this->userService->getAllUsersByBranchId($branchId);
            if ($consultAllUsers->isEmpty()) {
                return response()->json(['staus'  => 1, 'message' => 'Não foram encontrados usuários vinculados a essa filial.', 'data' => '',]);
            }
            return ResponseHelper::success($consultAllUsers, 'Usuários da filial recuperados com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Error ao consultar todos os usuários dessa filial.', $e->getMessage());

        }
    }
    
    public function estatistics(Request $request)
    {
        try {
            // Total Geral
            $usersPending = User::whereNull('deleted_at')
                ->where('status', 0)
                ->count();

            $usersActive = User::whereNull('deleted_at')
                ->where('status', 1)
                ->count();

            $total = $usersPending + $usersActive;

            // Por Company (sem join, só ID)
            $companies = \DB::table('users')
                ->select('company_id', \DB::raw('COUNT(*) as total'),
                    \DB::raw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as users_pending'),
                    \DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as users_active'))
                ->whereNull('deleted_at')
                ->groupBy('company_id')
                ->get();

            $companiesData = [];
            foreach ($companies as $company) {
                $companiesData[] = [
                    'company_id'    => $company->company_id,
                    'users_pending' => $company->users_pending,
                    'users_active'  => $company->users_active,
                    'total'         => $company->total,
                ];
            }

            // Por Branch (com join para pegar o título)
            $branches = \DB::table('users as u')
                ->join('branches as b', 'u.branch_id', '=', 'b.id')
                ->select('u.branch_id', 'b.name as branch_name',
                    \DB::raw('COUNT(*) as total'),
                    \DB::raw('SUM(CASE WHEN u.status = 0 THEN 1 ELSE 0 END) as users_pending'),
                    \DB::raw('SUM(CASE WHEN u.status = 1 THEN 1 ELSE 0 END) as users_active'))
                ->whereNull('u.deleted_at')
                ->groupBy('u.branch_id', 'b.name')
                ->get();

            $branchesData = [];
            foreach ($branches as $branch) {
                $branchesData[] = [
                    'branch_id'     => $branch->branch_id,
                    'branch_name'   => $branch->branch_name,
                    'users_pending' => $branch->users_pending,
                    'users_active'  => $branch->users_active,
                    'total'         => $branch->total,
                ];
            }

            return response()->json([
                'total' => [
                    'users_pending' => $usersPending,
                    'users_active'  => $usersActive,
                    'total'         => $total,
                ],
                'companies' => $companiesData,
                'branches'  => $branchesData
            ]);

        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao consultar estatísticas dos usuários.', $e->getMessage());
        }
    }
}