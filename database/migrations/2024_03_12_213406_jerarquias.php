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
        Schema::create('jerarquias',function(Blueprint $table){
            $table->id();
            $table->string('nombrejer')->nullable();
            $table->integer('tipo')->nullable();
            $table->integer('orden')->nullable();
            $table->string('status',5)->comment('true-Habilitado, false-Deshabilitado');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });

        Schema::create('tipojerarquia',function(Blueprint $table){
            $table->id();
            $table->string('nombretipojer')->nullable();// administrativo o operativo
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });

        Schema::create('reljercomp',function(Blueprint $table){
            $table->id();
            $table->integer('idjer')->nullable();
            $table->integer('idcomp')->nullable();
            $table->integer('idtipocomp')->nullable();
            $table->integer('esperado')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jerarquias');
        Schema::dropIfExists('tipojerarquia');
        Schema::dropIfExists('reljercomp');
    }
};
