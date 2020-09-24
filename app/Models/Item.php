<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'weight',
        'quantity',
        'order_id',
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
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
