<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','processing','delivering','completed','cancelled','refunded') NOT NULL DEFAULT 'pending'");

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->default(0)->after('discount');
            $table->index(['user_id', 'created_at'], 'orders_user_created_index');
            $table->index(['store_id', 'created_at'], 'orders_store_created_index');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->default(0)->after('quantity');
        });

        DB::statement('UPDATE order_items SET subtotal = price * quantity');
        DB::statement('UPDATE orders o SET subtotal = (SELECT COALESCE(SUM(oi.subtotal), 0) FROM order_items oi WHERE oi.order_id = o.id)');
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_user_created_index');
            $table->dropIndex('orders_store_created_index');
            $table->dropColumn('subtotal');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};
