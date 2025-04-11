<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class BranchCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id'        => 'required|exists:companies,id',
            'name'              => 'required|string|max:255',
            'cnpj'              => 'required|string|size:14|unique:branches,cnpj',
            'phone_number'      => 'required|string|max:15',
            'email'             => 'required|email|unique:branches,email',
            'uf'                => 'required|string|size:2',
            'endereco_detail'   => 'required|string|max:255',
            'status'            => 'nullable|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required'       => 'O campo empresa é obrigatório.',
            'company_id.exists'         => 'A empresa informada não foi encontrada.',
            'name.required'             => 'O nome da filial é obrigatório.',
            'cnpj.required'             => 'O CNPJ é obrigatório.',
            'cnpj.size'                 => 'O CNPJ deve conter exatamente 14 caracteres.',
            'cnpj.unique'               => 'Este CNPJ já está cadastrado.',
            'phone_number.required'     => 'O número de telefone é obrigatório.',
            'email.required'            => 'O e-mail é obrigatório.',
            'email.email'               => 'Informe um e-mail válido.',
            'email.unique'              => 'Este e-mail já está cadastrado.',
            'uf.required'               => 'A UF é obrigatória.',
            'uf.size'                   => 'A UF deve conter exatamente 2 caracteres.',
            'endereco_detail.required'  => 'O endereço é obrigatório.',
            'status.in'                 => 'O status deve ser 0 (inativo) ou 1 (ativo).',
        ];
    }
}
