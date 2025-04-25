<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:12', 'unique:users,cpf'],
            'phone_number' => ['required', 'string', 'max:15'],
            'is_admin' => ['boolean'],

            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => ['required', 'exists:branches,id'],

            'uf' => ['required', 'string', 'size:2'],
            'endereco_detail' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'status' => ['nullable', 'integer', 'between:0,127'],
            'email_verified_at' => ['nullable', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode exceder 255 caracteres.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.max' => 'O CPF não pode exceder 12 caracteres.',
            'cpf.unique' => 'Este CPF já está em uso.',

            'phone_number.required' => 'O número de telefone é obrigatório.',
            'phone_number.max' => 'O número de telefone não pode exceder 15 caracteres.',

            'is_admin.boolean' => 'O campo administrador deve ser verdadeiro ou falso.',

            'company_id.required' => 'A empresa é obrigatória.',
            'company_id.exists' => 'A empresa selecionada é inválida.',

            'branch_id.required' => 'A filial é obrigatória.',
            'branch_id.exists' => 'A filial selecionada é inválida.',

            'uf.required' => 'O estado (UF) é obrigatório.',
            'uf.size' => 'O estado (UF) deve conter exatamente 2 caracteres.',

            'endereco_detail.required' => 'O endereço é obrigatório.',
            'endereco_detail.max' => 'O endereço não pode exceder 255 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.max' => 'O e-mail não pode exceder 255 caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',

            'status.integer' => 'O status deve ser um número inteiro.',
            'status.between' => 'O status deve estar entre 0 e 127.',

            'email_verified_at.date' => 'A data de verificação de e-mail deve ser uma data válida.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }
}
