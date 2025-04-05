<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Company;
use App\Models\Branch;

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
}
