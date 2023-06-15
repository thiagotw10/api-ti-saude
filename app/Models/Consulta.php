<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    protected $primaryKey = 'cons_codigo';
    protected $fillable = ['cons_codigo', 'cons_med','particular','data','hora', 'cons_pac', 'vinculo_id'];
    protected $hidden = ['cons_med','cons_pac', 'vinculo_id', 'created_at', 'updated_at'];

    public function medico(){
        return $this->hasOne(Medico::class, 'med_codigo', 'cons_med')->with('especialidade');
    }


    public function vinculo(){
        return $this->hasOne(Vinculo::class, 'vinc_codigo', 'vinculo_id')->with('planoSaude');
    }

    public function paciente(){
        return $this->hasOne(Paciente::class, 'pac_codigo', 'cons_pac');
    }

    // Modelo Paciente
    public function procedimento()
    {
        return $this->belongsToMany(Procedimento::class, 'cons_procs', 'consulta_id', 'procedimento_id');
    }

}
