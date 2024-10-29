<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CPF;

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
            'cpf' => ['required', 'string', new CPF, Rule::unique(User::class)->ignore($this->route('user')->id)],
            'rg' => ['nullable', 'string', 'max:12', Rule::unique(User::class)->ignore($this->route('user')->id)],
            'telefone' => ['nullable', 'string', 'max:15'],
            'sexo' => ['nullable', 'string', 'in:Masculino,Feminino,Outro'],
            'data_nascimento' => ['nullable', 'date'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cargo' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->route('user')->id)],
            'status' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->route('user')->id == 1 && $this->has('cargo')) {
                $validator->errors()->add('cargo', 'O usuário com ID 1 não pode alterar o cargo.');
            }
        });
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser um texto válido.',
            'cpf.max' => 'O CPF não pode ter mais que 14 caracteres.',
            'cpf.unique' => 'Este CPF já está em uso.',
            'rg.string' => 'O RG deve ser um texto válido.',
            'rg.max' => 'O RG não pode ter mais que 12 caracteres.',
            'rg.unique' => 'Este RG já está em uso.',
            'telefone.string' => 'O telefone deve ser um texto válido.',
            'telefone.max' => 'O telefone não pode ter mais que 15 caracteres.',
            'sexo.in' => 'O sexo deve ser masculino, feminino ou outro.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'endereco.string' => 'O endereço deve ser um texto válido.',
            'endereco.max' => 'O endereço não pode ter mais que 255 caracteres.',
            'cargo.string' => 'O cargo deve ser um texto válido.',
            'cargo.max' => 'O cargo não pode ter mais que 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.lowercase' => 'O e-mail deve estar em letras minúsculas.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais que 255 caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',
            'status.boolean' => 'O status deve ser verdadeiro ou falso.',
        ];
    }
}
