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
        //DB::statement('SET search_path TO mi_esquema');

        Schema::create('exhanges_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_currency_id')->constrained('currency')->onDelete('cascade');
            $table->foreignId('target_currency_id')->constrained('currency')->onDelete('cascade');
            $table->decimal('exchange_rate',18,6);
            $table->datetime('valid_from');
            $table->datetime('valid_to')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        //DB::statement('SET search_path TO public');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhanges_rates');
    }
};
