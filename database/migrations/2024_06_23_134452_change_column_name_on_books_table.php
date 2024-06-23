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
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('start-reservation');
            $table->dropColumn('end-reservation');
            $table->datetime('start_reservation')->nullable();
            $table->datetime('end_reservation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('start_reservation');
            $table->dropColumn('end_reservation');
            $table->datetime('start-reservation')->nullable();
            $table->datetime('end-reservation')->nullable();
        });
    }
};
