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
        Schema::create('estructuras',function(Blueprint $table){
            $table->id();
            $table->string('codigo',10)->nullable();
            $table->string('nameund');
            $table->integer('id_sup')->nullable();
            $table->integer('id_tipo')->nullable();
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
        Schema::dropIfExists('estructuras');
    }
};
