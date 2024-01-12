<?php

namespace App\Models;

use App\Models\Contracts\UserContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Shopkeeper extends Authenticatable implements UserContract
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tb_shopkeeper';

    protected $guarded = 'shopkeeper';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'surname',
        'email',
        'document_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id')->first();
    }

    public function getNameFullName(): string
    {
        return "{$this->name} {$this->surname}";
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'uuid');
    }
}
