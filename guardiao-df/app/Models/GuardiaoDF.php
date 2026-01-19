<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuardiaoDF extends Model
{
    protected $table = 'guardiao_df';

    protected $fillable = [
        'texto_original', 
        'texto_mascarado', 
        'score_risco', 
        'dados_identificados'
        ];
}
