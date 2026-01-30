<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analise extends Model
{
    protected $table = 'analises';

    protected $fillable = [
        'user_id',
        'nome_arquivo',
        'conteudo_original',
        'conteudo_mascarado',
        'score_risco',
        'dados_identificados'
    ];
}
