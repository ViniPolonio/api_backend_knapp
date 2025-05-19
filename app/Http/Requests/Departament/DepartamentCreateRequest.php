<?php

namespace App\Http\Requests\Departament;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ajuste conforme a regra de autorização do seu app
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:departaments,title',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.unique' => 'Já existe um departamento com este título.',
            'status.required' => 'O status é obrigatório.',
            'status.boolean' => 'O status deve ser verdadeiro ou falso.',
        ];
    }
}
