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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->string('category');
            $table->string('image_url')->nullable();

            $table->boolean('is_reservated')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->datetime('start-reservation')->nullable();
            $table->datetime('end-reservation')->nullable();

            $table->timestamps();

            $table->index('user_id', 'book_user_idx');
            $table->foreign('user_id', 'book_user_fk')->on('users')->references('id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
