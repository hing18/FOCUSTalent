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
        Schema::create('posiciones',function(Blueprint $table){
            $table->id();
            $table->string('codigo',10)->nullable();
            $table->string('descpue')->nullable();
            $table->integer('aprobado')->nullable();
            $table->integer('idue')->nullable();
            $table->integer('iduni')->nullable();
            $table->integer('iddf')->nullable();
            $table->integer('idpuejefe')->nullable();
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
        Schema::dropIfExists('posiciones');
    }
};
