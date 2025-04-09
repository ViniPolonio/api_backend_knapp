<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Company;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'cpf',
        'phone_number',
        'is_admin',
        'company_id',
        'branch_id',
        'uf',
        'endereco_detail',
        'email',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'status' => 'integer',
    ];

    // Relação com a empresa
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relação com a filial
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Retorna todos os usuários (com company e branch)
     *
     * @return \Illuminate\Support\Collection
     */
    public static function consultAllUsers()
    {
        return self::with(['company', 'branch'])
                   ->whereNull('deleted_at')
                   ->get();
    }

    /**
     * Retorna o usuário com os detalhes informados pelo id.
     *
     * @param int $id
     * @return User
     * @throws \Exception
     */
    public static function consultDetailUser($id)
    {
        $user = self::with(['company', 'branch'])->find($id);
        if (!$user) {
            throw new \Exception('Usuário não encontrado.', 404);
        }
        return $user;
    }

    /**
     * Cria um usuário usando os dados validados.
     *
     * @param \Illuminate\Http\Request $request
     * @return User
     */
    public static function createUser($request)
    {
        return DB::transaction(function () use ($request) {
            return self::create([
                'name'              => $request->name,
                'cpf'               => $request->cpf,
                'phone_number'      => $request->phone_number,
                'is_admin'          => $request->is_admin ?? false,
                'company_id'        => $request->company_id,
                'branch_id'         => $request->branch_id,
                'uf'                => $request->uf,
                'endereco_detail'   => $request->endereco_detail,
                'email'             => $request->email,
                'status'            => $request->status ?? 0,
                'email_verified_at' => $request->email_verified_at,
                'password'          => Hash::make($request->password),
            ]);
        });
    }

    /**
     * Atualiza um usuário existente usando os dados validados.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return User
     */
    public static function updateUser($id, $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $user = self::findOrFail($id);
            $user->update([
                'name'              => $request->name,
                'cpf'               => $request->cpf,
                'phone_number'      => $request->phone_number,
                'is_admin'          => $request->is_admin ?? false,
                'company_id'        => $request->company_id,
                'branch_id'         => $request->branch_id,
                'uf'                => $request->uf,
                'endereco_detail'   => $request->endereco_detail,
                'email'             => $request->email,
                'status'            => $request->status ?? 0,
                'email_verified_at' => $request->email_verified_at,
            ]);
            return $user;
        });
    }

    /**
     * Ativa um usuário alterando o status para 1.
     * Se o usuário já estiver ativo ou com status inválido, retorna informativo.
     *
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public static function activeUser($id)
    {
        return DB::transaction(function () use ($id) {
            $user = self::findOrFail($id);

            if ($user->status === 1) {
                return [
                    'user'    => $user,
                    'message' => 'Usuário já está ativo.'
                ];
            }

            if ($user->status !== 0) {
                throw new \Exception('Usuário não pode ser ativado pois está com status diferente de inativo (0).', 400);
            }

            $user->update(['status' => 1]);

            return [
                'user'    => $user,
                'message' => 'Usuário ativado com sucesso.'
            ];
        });
    }

    /**
     * Inativa um usuário alterando o status para 0.
     * Se o usuário já estiver inativo ou com status inválido, retorna informativo.
     *
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public static function inactiveUser($id)
    {
        return DB::transaction(function () use ($id) {
            $user = self::findOrFail($id);

            if ($user->status === 0) {
                return [
                    'user'    => $user,
                    'message' => 'Usuário já está inativo.'
                ];
            }

            if ($user->status !== 1) {
                throw new \Exception('Usuário não pode ser inativado pois está com status diferente de ativo (1).', 400);
            }

            $user->update(['status' => 0]);

            return [
                'user'    => $user,
                'message' => 'Usuário inativado com sucesso.'
            ];
        });
    }

    /**
     * Deleta (soft delete) um usuário.
     * Se o usuário já estiver deletado, lança exceção.
     *
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public static function deleteUser($id)
    {
        return DB::transaction(function () use ($id) {
            $user = self::findOrFail($id);

            if ($user->trashed()) {
                throw new \Exception('Usuário já foi deletado anteriormente.', 400);
            }

            $user->delete();

            return [
                'user'    => $user,
                'message' => 'Usuário deletado com sucesso.'
            ];
        });
    }
}
