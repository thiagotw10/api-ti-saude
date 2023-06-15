<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    use HasFactory;
    protected $primaryKey = 'proc_codigo';
    protected $fillable = ['proc_nome', 'proc_valor'];

    public function especialidade(){
        return $this->hasOne(Especialidade::class, 'id', 'espec_id');
    }

    public function procedimento()
    {
        return $this->belongsToMany(Consulta::class, 'cons_procs', 'procedimento_id', 'consulta_id');
    }
}
