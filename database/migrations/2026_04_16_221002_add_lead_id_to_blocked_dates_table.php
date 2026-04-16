<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blocked_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable()->after('reason');
        });
    }

    public function down(): void
    {
        Schema::table('blocked_dates', function (Blueprint $table) {
            $table->dropColumn('lead_id');
        });
    }
};
