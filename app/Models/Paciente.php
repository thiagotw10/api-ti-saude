<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasApiTokens, HasFactory;
    protected $primaryKey = 'pac_codigo';

    protected $fillable = [
       'pac_codigo', 'pac_nome', 'pac_telefone', 'pac_dataNascimento'
    ];

}
