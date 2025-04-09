<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::consultAllUsers();
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
            $user = User::consultDetailUser($idUser);
            return ResponseHelper::success($user, 'Usuário recuperado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao consultar usuário.', $e->getMessage());
        }
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $user = User::createUser($request);
            return ResponseHelper::success($user, 'Usuário criado com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao criar usuário.', $e->getMessage());
        }
    }

    public function update(UserUpdateRequest $request, $idUser)
    {
        try {
            $user = User::updateUser($idUser, $request);
            return ResponseHelper::success($user, 'Usuário atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar usuário.', $e->getMessage());
        }
    }

    public function activeUser($idUser)
    {
        try {
            $result = User::activeUser($idUser);
            return ResponseHelper::success($result['user'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao ativar usuário.', $e->getMessage());
        }
    }

    public function inactiveUser($idUser)
    {
        try {
            $result = User::inactiveUser($idUser);
            return ResponseHelper::success($result['user'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao inativar usuário.', $e->getMessage());
        }
    }

    public function destroy($idUser)
    {
        try {
            $result = User::deleteUser($idUser);
            return ResponseHelper::success($result['user'], $result['message']);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao deletar usuário.', $e->getMessage());
        }
    }
}
