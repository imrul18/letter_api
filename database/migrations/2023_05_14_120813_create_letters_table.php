<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_id');
            $table->string('bag_id')->nullable();
            $table->string('file');
            $table->string('sender_phone');
            $table->string('receiver_phone');
            $table->string('stamp_value')->nullable();
            $table->enum('status', ['uploaded', 'received', 'delivering', 'delivered']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
