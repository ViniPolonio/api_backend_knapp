<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'cnpj',
        'phone_number',
        'email',
        'uf',
        'endereco_detail',
        'status',
    ];
    
    public function branches()
    {
        return $this->hasMany(\App\Models\Branch::class);
    }
}
