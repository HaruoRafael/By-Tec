<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'cpf', 'rg', 'telefone', 'sexo', 'data_nascimento', 'endereco', 'status_id'
    ];

    protected $dates = ['data_nascimento'];

    public function getIdadeAttribute()
    {
        // Verifica se data_nascimento é uma string e a converte para um objeto Carbon
        if (is_string($this->data_nascimento)) {
            $this->data_nascimento = Carbon::parse($this->data_nascimento);
        }
        // Retorna a idade com base na data de nascimento
        return optional($this->data_nascimento)->age;
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function avaliacoes()
{
    return $this->hasMany(Avaliacao::class);
}
}
