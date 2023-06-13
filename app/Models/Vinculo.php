<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    use HasFactory;
    protected $primaryKey = 'vinc_codigo';
    protected $fillable = ['paciente_id', 'plano_saude_id', 'nr_contrato'];
    protected $hidden = ['paciente_id', 'plano_saude_id', 'created_at', 'updated_at'];

    public function planoSaude()
    {
        return $this->hasOne(PlanoSaude::class, 'plano_codigo', 'plano_saude_id');
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'pac_codigo', 'paciente_id');
    }
}
