<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'cnpj',
        'phone_number',
        'email',
        'uf',
        'endereco_detail',
        'status',
        'departaments_json',
        'cep',
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }
}
