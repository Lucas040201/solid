<?php

namespace App\Models;

use App\Models\Contracts\ModelContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model implements ModelContract
{
    use HasFactory;

    protected $table = 'tb_wallet';

    protected $fillable = [
        'uuid',
        'user_id',
        'amount'
    ];

    protected $hidden = [
        'id',
    ];

    public function user()
    {
        $user = $this->customer()->first();
        if ($user)
            return $user;

        return $this->shopkeeper()->first();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'uuid', 'user_id');
    }

    public function shopkeeper()
    {
        return $this->belongsTo(Shopkeeper::class, 'uuid', 'user_id');
    }

}
