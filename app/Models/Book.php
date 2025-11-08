<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'author',
        'genre',
        'release_date',
        'book_description',
        'page_count',
        'book_count',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function getAvailableCopiesAttribute(): int
    {
        $borrowed = $this->reservations()
            ->where('book_status', 'taken')
            ->count();

        return $this->book_count - $borrowed;
    }
}
