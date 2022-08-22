<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracteristicaProdutosPainel extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'caracteristica_do_produto'
    ];
}
