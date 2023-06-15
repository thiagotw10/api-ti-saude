<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cons_proc extends Model
{
    use HasFactory;

    protected $fillable = ['consulta_id', 'procedimento_id'];
}
