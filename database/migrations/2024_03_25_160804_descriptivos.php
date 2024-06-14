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
        Schema::create('descriptivos',function(Blueprint $table){
            $table->id();
            $table->string('nombredesc')->nullable();
            $table->string('cargojefe')->nullable();
            $table->string('area_depto')->nullable();
            $table->integer('idjer')->nullable();
            $table->integer('reportes')->nullable();
            $table->text('proposito')->nullable();
            $table->string('status',5)->comment('true-Habilitado, false-Deshabilitado');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descriptivos');
    }
};
