<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GerenciamentoCarga extends Model
{
    CONST ERROR_STATUS = 0;
    CONST FINALIZADO_STATUS = 1;
    CONST INICIADO_STATUS = 2;
    CONST PENDENTE_STATUS = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'servico',
        'status',
    ];
}
