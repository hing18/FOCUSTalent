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
        Schema::create('vacantes_etapas',function(Blueprint $table){
            $table->id();
            $table->string('etapa',80)->nullable();
            $table->string('res_etapa',30)->nullable();
            $table->string('avance')->nullable();
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
        Schema::dropIfExists('vacantes_etapas');
    }
};
