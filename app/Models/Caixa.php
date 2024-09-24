<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data_abertura',
        'data_fechamento',
        'saldo_inicial',
        'saldo_final',
        'status',
    ];

    // Relacionamento com o usuário que abriu o caixa
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com transações
    public function transacoes()
    {
        return $this->hasMany(Transacao::class);
    }

    // Relacionamento com vendas
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
