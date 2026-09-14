<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_number_sequences', function (Blueprint $table) {
            $table->unsignedSmallInteger('year')->primary();
            $table->unsignedInteger('next_number');
            $table->timestamps();
        });

        $existingSequences = DB::table('orders')
            ->selectRaw('YEAR(created_at) as year, MAX(CAST(number AS UNSIGNED)) as maximum_number')
            ->groupByRaw('YEAR(created_at)')
            ->get();

        foreach ($existingSequences as $sequence) {
            $year = (int) $sequence->year;
            $maximumNumber = (int) $sequence->maximum_number;

            DB::table('order_number_sequences')->insert([
                'year' => $year,
                'next_number' => max(1, $maximumNumber - ($year * 10000) + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_number_sequences');
    }
};
