<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'status',
        'user_id',
    ];

    /**
     * Constants
     */
    const STATUS_AWAITING_CARRIER = 'awaiting_carrier';
    const STATUS_NEW = 'new';
    const STATUS_ON_CARRIAGE = 'on_carriage';
    const STATUSES = [
        self::STATUS_AWAITING_CARRIER,
        self::STATUS_NEW,
        self::STATUS_ON_CARRIAGE,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'order_id', 'id');
    }
}
