<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = ['cons_codigo','pac_id', 'proc_id','med_id','particula','cons_data','cons_hora'];

    public function medico(){
        return $this->hasOne(Medico::class, 'id', 'med_id');
    }

    public function procedimento(){
        return $this->hasOne(Procedimento::class, 'id', 'proc_id');
    }
}
