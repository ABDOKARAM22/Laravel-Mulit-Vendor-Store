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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users','id')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('image')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->date('birthday')->nullable();
            $table->enum('gender',['male','femal'])->nullable();
            $table->string('street_address');
            $table->string('city');
            $table->string('postal_code');
            $table->char('country',2);
            $table->char('language',2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
