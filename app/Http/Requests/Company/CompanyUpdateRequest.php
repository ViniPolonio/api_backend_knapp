<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('idCompany');

        return [
            'name'             => 'required|string|max:255',
            'cnpj'             => [
                'required',
                'string',
                'size:14',
                Rule::unique('companies', 'cnpj')->ignore($companyId),
            ],
            'phone_number'     => 'required|string|max:15',
            'email'            => [
                'required',
                'email',
                Rule::unique('companies', 'email')->ignore($companyId),
            ],
            'uf'               => 'required|string|size:2',
            'endereco_detail'  => 'required|string|max:255',
            'status'           => 'nullable|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'             => 'O nome da empresa é obrigatório.',
            'cnpj.required'             => 'O CNPJ é obrigatório.',
            'cnpj.size'                 => 'O CNPJ deve conter exatamente 14 caracteres.',
            'cnpj.unique'               => 'Este CNPJ já está em uso.',
            'phone_number.required'     => 'O número de telefone é obrigatório.',
            'email.required'            => 'O e-mail é obrigatório.',
            'email.email'               => 'O e-mail deve ser válido.',
            'email.unique'              => 'Este e-mail já está em uso.',
            'uf.required'               => 'A UF é obrigatória.',
            'uf.size'                   => 'A UF deve conter exatamente 2 caracteres.',
            'endereco_detail.required'  => 'O endereço é obrigatório.',
            'status.in'                 => 'O status deve ser 0 (inativo) ou 1 (ativo).',
        ];
    }
}
