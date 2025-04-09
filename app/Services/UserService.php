<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    /**
     * Retorna todos os usuários com relacionamento com company e branch.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllUsers()
    {
        return User::with(['company', 'branch'])
            ->whereNull('deleted_at')
            ->get();
    }

    /**
     * Retorna o usuário detalhado pelo ID ou lança exceção se não encontrado.
     *
     * @param int $id
     * @return User
     * @throws Exception
     */
    public function getUserDetail(int $id): User
    {
        $user = User::with(['company', 'branch'])->find($id);
        if (!$user) {
            throw new Exception('Usuário não encontrado.', 404);
        }
        return $user;
    }

    /**
     * Cria um novo usuário com os dados fornecidos.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            return User::create([
                'name'              => $data['name'],
                'cpf'               => $data['cpf'],
                'phone_number'      => $data['phone_number'],
                'is_admin'          => $data['is_admin'] ?? false,
                'company_id'        => $data['company_id'],
                'branch_id'         => $data['branch_id'],
                'uf'                => $data['uf'],
                'endereco_detail'   => $data['endereco_detail'],
                'email'             => $data['email'],
                'status'            => $data['status'] ?? 0,
                'email_verified_at' => $data['email_verified_at'] ?? null,
                'password'          => Hash::make($data['password']),
            ]);
        });
    }

    /**
     * Atualiza o usuário com os dados fornecidos.
     *
     * @param int   $id
     * @param array $data
     * @return User
     */
    public function updateUser(int $id, array $data): User
    {
        return DB::transaction(function () use ($id, $data) {
            $user = User::findOrFail($id);
            $user->update([
                'name'              => $data['name'],
                'cpf'               => $data['cpf'],
                'phone_number'      => $data['phone_number'],
                'is_admin'          => $data['is_admin'] ?? false,
                'company_id'        => $data['company_id'],
                'branch_id'         => $data['branch_id'],
                'uf'                => $data['uf'],
                'endereco_detail'   => $data['endereco_detail'],
                'email'             => $data['email'],
                'status'            => $data['status'] ?? 0,
                'email_verified_at' => $data['email_verified_at'] ?? null,
            ]);
            return $user;
        });
    }

    /**
     * Ativa o usuário (altera o status para 1) se estiver inativo.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function activateUser(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            if ($user->status === 1) {
                return [
                    'user'    => $user,
                    'message' => 'Usuário já está ativo.'
                ];
            }
            if ($user->status !== 0) {
                throw new Exception('Usuário não pode ser ativado pois está com status diferente de inativo (0).', 400);
            }
            $user->update(['status' => 1]);
            return [
                'user'    => $user,
                'message' => 'Usuário ativado com sucesso.'
            ];
        });
    }

    /**
     * Inativa o usuário (altera o status para 0) se estiver ativo.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function deactivateUser(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            if ($user->status === 0) {
                return [
                    'user'    => $user,
                    'message' => 'Usuário já está inativo.'
                ];
            }
            if ($user->status !== 1) {
                throw new Exception('Usuário não pode ser inativado pois está com status diferente de ativo (1).', 400);
            }
            $user->update(['status' => 0]);
            return [
                'user'    => $user,
                'message' => 'Usuário inativado com sucesso.'
            ];
        });
    }

    /**
     * Deleta (soft delete) o usuário.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function deleteUser(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            if ($user->trashed()) {
                throw new Exception('Usuário já foi deletado anteriormente.', 400);
            }
            $user->delete();
            return [
                'user'    => $user,
                'message' => 'Usuário deletado com sucesso.'
            ];
        });
    }
}
