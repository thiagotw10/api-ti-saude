<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    protected $primaryKey = 'med_codigo';

    protected $fillable = ['med_codigo', 'med_nome', 'med_CRM', 'med_espec'];

    protected $hidden = ['created_at', 'updated_at', 'med_espec'];

    public function especialidade()
    {
        return $this->hasOne(Especialidade::class, 'espec_codigo', 'med_espec');
    }
}
