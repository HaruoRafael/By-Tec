<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'telefone',
        'sexo',
        'data_nascimento',
        'endereco',
        'cargo',
        'email',
        'password',
        'status',  
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'data_nascimento' => 'date',
    ];

    /**
     * Check if the user has a specific cargo.
     *
     * @param string $cargo
     * @return bool
     */
    public function hasCargo($cargo): bool
    {
        return $this->cargo === $cargo;
    }

    /**
     * Relacionamento com os caixas que o usuário abriu.
     */
    public function caixas()
    {
        return $this->hasMany(Caixa::class);
    }

    /**
     * Relacionamento com as vendas feitas pelo usuário.
     */
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
