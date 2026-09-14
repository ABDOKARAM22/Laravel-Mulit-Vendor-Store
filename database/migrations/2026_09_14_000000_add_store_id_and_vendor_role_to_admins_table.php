<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->foreignId('store_id')
                ->nullable()
                ->after('role')
                ->constrained('stores')
                ->nullOnDelete();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE admins MODIFY role ENUM('Admin', 'Super_Admin', 'Vendor') NOT NULL DEFAULT 'Admin'"
            );
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE admins MODIFY role ENUM('Admin', 'Super_Admin') NOT NULL DEFAULT 'Admin'"
            );
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->dropConstrainedForeignId('store_id');
        });
    }
};
