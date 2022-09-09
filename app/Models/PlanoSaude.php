<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoSaude extends Model
{
    use HasFactory;

    protected $fillable = ['plano_codigo', 'plano_descricao', 'plano_telefone'];
}
