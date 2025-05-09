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
        Schema::create('pruebaspsicoresp',function(Blueprint $table){
            $table->id();
            $table->string('respuesta',30)->nullable();
            $table->integer('id_prueba')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });       
    }

    public function down(): void
    {
        Schema::dropIfExists('pruebaspsicoresp');
    }
};
