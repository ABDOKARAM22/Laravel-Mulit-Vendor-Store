<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->enum('gender', ['male', 'female'])->nullable()->change();
            $table->foreignId('admin_id')->nullable()->unique()->after('user_id')->constrained('admins')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropUnique(['admin_id']);
            $table->dropColumn('admin_id');
            $table->foreignId('user_id')->nullable(false)->change();
            $table->enum('gender', ['male', 'femal'])->nullable()->change();
        });
    }
};
