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
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('status')->default(true)->comment('false - inactivo, true - activo');
            $table->string('icon')->nullable()->comment('Icono del menu');
            $table->unsignedInteger('sort')->nullable()->comment('Para organizar el menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('icon');
            $table->dropColumn('sort');
        });
    }
};
