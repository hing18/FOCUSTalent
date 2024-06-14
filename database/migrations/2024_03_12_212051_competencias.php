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
        Schema::create('competencias',function(Blueprint $table){
            $table->id();
            $table->string('nombre')->nullable();
            $table->text('definicion')->nullable();
            $table->text('nivel_alto')->nullable();
            $table->text('nivel_bajo')->nullable();
            $table->string('status',5)->comment('true-Habilitado, false-Deshabilitado');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
        Schema::create('tipocompetencia',function(Blueprint $table){
            $table->id();
            $table->string('nombretipocompetencia')->nullable();// critico,  muy importante,   importante
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencias');
        Schema::dropIfExists('tipocompetencia');
    }
};
