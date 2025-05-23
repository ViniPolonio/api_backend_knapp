<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'departament_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin'          => 'boolean',
        'status'            => 'integer',
    ];

    // Relação com a empresa
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    // Relação com a filial
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    //Relação com o Departamento
    public function departament()
    {
        return $this->belongsTo(\App\Models\Departament::class, 'departament_id');
    }

}
