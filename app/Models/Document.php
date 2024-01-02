<?php

namespace App\Models;

use App\Models\Contracts\ModelContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model implements ModelContract
{
    use HasFactory;

    protected $table = 'tb_document';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'document',
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
        return $this->hasOne(Customer::class);
    }

    public function shopkeeper()
    {
        return $this->hasOne(Shopkeeper::class);
    }
}
