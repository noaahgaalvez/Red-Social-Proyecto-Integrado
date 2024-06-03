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
        Schema::table('adjunto_publicacions', function (Blueprint $table) {
            $table->integer('tamanio')->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adjunto_publicacions', function (Blueprint $table) {
            $table->dropColumn('tamanio');
        });
    }
};
