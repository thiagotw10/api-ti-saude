<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = ['med_codigo', 'espec_id', 'med_nome', 'med_CRM'];

    protected $hidden = ['created_at', 'updated_at', 'id', 'espec_id'];

    public function especialidade(){
        return $this->hasOne(Especialidade::class, 'id');
    }
}
