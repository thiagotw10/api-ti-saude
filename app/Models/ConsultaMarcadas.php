<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaMarcadas extends Model
{
    use HasFactory;

    protected $fillable = ['cons_id', 'pac_id', 'med_id', 'particular', 'nr_contrato', 'proc_id'];

    protected $hidden = ['created_at', 'updated_at', 'cons_id', 'pac_id', 'med_id', 'id'];

    public function consulta()
    {
        return $this->hasOne(Consulta::class, 'id', 'cons_id');
    }

    public function medico()
    {
        return $this->hasOne(Medico::class, 'id', 'med_id');
    }

    public function procedimento()
    {
        return $this->hasOne(Procedimento::class, 'id', 'proc_id');
    }
}
