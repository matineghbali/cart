<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';
    const ALL_STATUSES = [
        self::ACTIVE_STATUS,
        self::INACTIVE_STATUS
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'status',
        'title',
        'description',
        'price',
        'inventory'
    ];
}
