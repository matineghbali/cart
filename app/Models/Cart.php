<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    const OPEN_STATUS = 'open';
    const CLOSE_STATUS = 'close';
    const ALL_STATUSES = [
        self::OPEN_STATUS,
        self::CLOSE_STATUS
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'user_id',
        'token',
        'total_price'
    ];

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
