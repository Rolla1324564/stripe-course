<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'buyer_country',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'receiver_country',
        'total_amount',
        'type',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
