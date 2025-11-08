<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\BookStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('reservation_date');
            $table->timestamp('return_date');   //grazinti_iki - iki kurios dienos grazinti
            $table->timestamp('returned_at')->nullable();   //grazinimo_data - kada grazino
            $table->enum('book_status', array_column(BookStatus::cases(), column_key: 'value'));
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
