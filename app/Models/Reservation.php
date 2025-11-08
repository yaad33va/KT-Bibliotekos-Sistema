<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\BookStatus;

class Reservation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'book_id',
        'reservation_date',
        'return_date',
        'returned_at',
        'book_status',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
        'return_date' => 'datetime',
        'returned_at' => 'datetime',
        'book_status' => BookStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
