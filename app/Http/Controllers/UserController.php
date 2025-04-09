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
            return ResponseHelper::success($users);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar usuários.', $e->getMessage());
        }
    }

    public function show($idUser)
    {
        try {
            $user = User::consultDetailUser($idUser);
            return ResponseHelper::success($user);
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
            return User::activeUser($idUser);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao ativar usuário.', $e->getMessage());
        }
    }

    public function inactiveUser($idUser)
    {
        try {
            return User::inactiveUser($idUser);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao inativar usuário.', $e->getMessage());
        }
    }

    public function destroy($idUser)
    {
        try {
            return User::deleteUser($idUser);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao deletar usuário.', $e->getMessage());
        }
    }
}
