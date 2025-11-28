<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Added for safer truncation
use App\Enums\BookStatus;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        // 1. Disable Foreign Key Checks (Works for SQLite & MySQL)
        Schema::disableForeignKeyConstraints();

        // 2. Empty the table to remove old data
        DB::table('reservations')->truncate();

        // 3. Re-enable Foreign Key Checks
        Schema::enableForeignKeyConstraints();

        // 4. Define your manual data
        $reservations = [
            // DATA FOR USER 1 -> user@library.com
            [
                'user_id' => 1,
                'book_id' => 5,
                'reservation_date' => '2025-11-28 10:00:00',
                'return_date' => '2025-12-06 10:00:00',
                'returned_at' => null,
                'book_status' => 'taken',
            ],
            [
                'user_id' => 1,
                'book_id' => 3,
                'reservation_date' => '2025-11-05 12:00:00',
                'return_date' => '2025-11-20 12:00:00',
                'returned_at' => null,
                'book_status' => 'taken',
            ],
            [
                'user_id' => 1,
                'book_id' => 20,
                'reservation_date' => '2023-11-05 12:00:00',
                'return_date' => '2023-11-20 12:00:00',
                'returned_at' => '2023-11-18 09:30:00',
                'book_status' => 'returned',
            ],
            [
                'user_id' => 1,
                'book_id' => 4,
                'reservation_date' => '2025-11-27 12:00:00',
                'return_date' => '2025-12-05 12:00:00',
                'returned_at' => '2023-11-18 09:30:00',
                'book_status' => 'taken',
            ],
            // DATA FOR USER 2 -> user2@Library.com
            [
                'user_id' => 2,
                'book_id' => 9,
                'reservation_date' => '2025-11-28 10:00:00',
                'return_date' => '2025-12-07 10:00:00',
                'returned_at' => null,
                'book_status' => 'taken',
            ],
            [
                'user_id' => 2,
                'book_id' => 5,
                'reservation_date' => '2025-11-28 10:00:00',
                'return_date' => '2025-12-06 10:00:00',
                'returned_at' => null,
                'book_status' => 'taken',
            ],
            [
                'user_id' => 2,
                'book_id' => 4,
                'reservation_date' => '2025-11-27 12:00:00',
                'return_date' => '2025-12-05 12:00:00',
                'returned_at' => '2025-11-28 09:30:00',
                'book_status' => 'returned',
            ],
            [
                'user_id' => 2,
                'book_id' => 5,
                'reservation_date' => '2025-11-28 10:00:00',
                'return_date' => '2025-12-04 10:00:00',
                'returned_at' => null,
                'book_status' => 'taken',
            ],
        ];

        // 5. Insert the new data
        DB::table('reservations')->insert($reservations);
    }
}
