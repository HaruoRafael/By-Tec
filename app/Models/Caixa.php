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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
