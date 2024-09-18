<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'valor', 'duracao'];

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
