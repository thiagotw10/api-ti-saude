<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    use HasFactory;

    protected $fillable = ['proc_codigo', 'proc_nome', 'proc_valor', 'espec_id'];

    public function especialidade(){
        return $this->hasOne(Especialidade::class, 'id', 'espec_id');
    }
}
