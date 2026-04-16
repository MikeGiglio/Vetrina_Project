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
        Schema::create('booking_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('arrival');
            $table->date('departure');
            $table->integer('nights')->nullable();
            $table->string('arrival_time')->nullable();
            $table->tinyInteger('guests');
            $table->string('ip_address', 45)->nullable();
            $table->enum('status', ['new', 'contacted', 'confirmed', 'cancelled'])->default('new');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_leads');
    }
};
