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
            $table->string('type')->nullable()->comment('type id');
            $table->string('file');
            $table->string('sender_phone');
            $table->string('receiver_phone');
            $table->string('letter_type')->nullable();
            $table->string('isAd')->default(1);
            $table->string('weight')->nullable()->comment('in gram');
            $table->string('cost')->nullable();
            $table->string('from')->nullable()->comment('post office id');
            $table->string('next')->nullable();
            $table->string('to')->nullable()->comment('post office id');
            $table->integer('status');
            $table->timestamp('received_at')->nullable();
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
