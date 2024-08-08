<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['descricao'];

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
}
