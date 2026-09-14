<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE products MODIFY price DECIMAL(12,2) NOT NULL');
        DB::statement('ALTER TABLE products MODIFY compare_price DECIMAL(12,2) NULL');
        DB::statement('ALTER TABLE orders MODIFY shipping DECIMAL(12,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE orders MODIFY tax DECIMAL(12,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE orders MODIFY discount DECIMAL(12,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE orders MODIFY total DECIMAL(12,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE order_items MODIFY price DECIMAL(12,2) NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE products MODIFY price FLOAT NOT NULL');
        DB::statement('ALTER TABLE products MODIFY compare_price FLOAT NULL');
        DB::statement('ALTER TABLE orders MODIFY shipping FLOAT NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE orders MODIFY tax FLOAT NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE orders MODIFY discount FLOAT NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE orders MODIFY total FLOAT NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE order_items MODIFY price FLOAT NOT NULL');
    }
};
