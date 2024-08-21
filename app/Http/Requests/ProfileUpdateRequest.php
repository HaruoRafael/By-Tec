<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:14', Rule::unique(User::class)->ignore($this->route('user')->id)],
            'rg' => ['nullable', 'string', 'max:12', Rule::unique(User::class)->ignore($this->route('user')->id)],
            'telefone' => ['nullable', 'string', 'max:15'],
            'sexo' => ['nullable', 'string', 'in:masculino,feminino,outro'],
            'data_nascimento' => ['nullable', 'date'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cargo' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->route('user')->id)],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
