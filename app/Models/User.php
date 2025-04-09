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

    public function consultAllUsers ()
    {
        try {
            $data = User::whereNull('deleted_at')
                ->with(['company', 'branch'])
                ->get();
            if($data->isEmpty()){
                return response()->json([
                    'message' => 'No records found'
                ], 404);
            }

            return response()->json([
                'message' => 'Users retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function consultDetailUser ($id) 
    {
        try {
            $data = User::where('id', $id)
                ->whereNull('deleted_at')
                ->with(['company', 'branch'])
                ->first();

            if(!$data){
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'message' => 'User retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error in operation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public static function createUser($request)
    {
        return DB::transaction(function () use ($request) {
            return self::create([
                'name' => $request->name,
                'cpf' => $request->cpf,
                'phone_number' => $request->phone_number,
                'is_admin' => $request->is_admin ?? false,

                'company_id' => $request->company_id,
                'branch_id' => $request->branch_id,

                'uf' => $request->uf,
                'endereco_detail' => $request->endereco_detail,
                'email' => $request->email,
                'status' => $request->status ?? 0,
                'email_verified_at' => $request->email_verified_at,

                'password' => Hash::make($request->password),
            ]);
        });
    }

    public static function updateUser($id, $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $user = self::findOrFail($id);

            $user->update([
                'name' => $request->name,
                'cpf' => $request->cpf,
                'phone_number' => $request->phone_number,
                'is_admin' => $request->is_admin ?? false,

                'company_id' => $request->company_id,
                'branch_id' => $request->branch_id,

                'uf' => $request->uf,
                'endereco_detail' => $request->endereco_detail,
                'email' => $request->email,
                'status' => $request->status ?? 0,
                'email_verified_at' => $request->email_verified_at,
            ]);

            return $user;
        });
    }

    public static function activeUser($id)
    {
        return DB::transaction(function () use ($id) {
            $user = self::findOrFail($id);

            if ($user->status === 1) {
                return response()->json([
                    'message' => 'Usuário já está ativo.'
                ], 200);
            }

            if ($user->status !== 0) {
                return response()->json([
                    'message' => 'Usuário não pode ser ativado pois está com status diferente de inativo (0).',
                    'status_atual' => $user->status
                ], 400);
            }

            $user->update(['status' => 1]);

            return response()->json([
                'message' => 'Usuário ativado com sucesso.',
                'user' => $user
            ], 200);
        });
    }

    public static function inactiveUser($id)
    {
        return DB::transaction(function () use ($id) {
            $user = self::findOrFail($id);

            if ($user->status === 0) {
                return response()->json([
                    'message' => 'Usuário já está inativo.'
                ], 200);
            }

            if ($user->status !== 1) {
                return response()->json([
                    'message' => 'Usuário não pode ser inativado pois está com status diferente de ativo (1).',
                    'status_atual' => $user->status
                ], 400);
            }

            $user->update(['status' => 0]);

            return response()->json([
                'message' => 'Usuário inativado com sucesso.',
                'user' => $user
            ], 200);
        });
    }

    public static function deleteUser($id)
    {
        return DB::transaction(function () use ($id) {
            $user = self::findOrFail($id);

            if ($user->trashed()) {
                return response()->json([
                    'message' => 'Usuário já foi deletado anteriormente.'
                ], 200);
            }

            $user->delete();

            return response()->json([
                'message' => 'Usuário deletado com sucesso.',
                'user' => $user
            ], 200);
        });
    }
}