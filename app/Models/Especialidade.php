<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;
    protected $primaryKey = 'espec_codigo';
    protected $fillable = ['espec_codigo', 'espec_nome'];

    protected $hidden = ['created_at', 'updated_at', 'id'];


}
