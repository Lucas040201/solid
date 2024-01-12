<?php

namespace App\Models;

use App\Models\Contracts\ModelContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model implements ModelContract
{
    use HasFactory;

    protected $table = 'tb_transaction';

    protected $fillable = [
        'uuid',
        'payer',
        'payee',
        'amount',
    ];


    protected $hidden = [
        'id',
    ];
}
