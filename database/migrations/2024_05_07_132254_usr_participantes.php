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
        Schema::create('usr_participantes',function(Blueprint $table){
            $table->id();
            $table->integer('id_part_curriculum')->nullable();
            $table->string('id_part_curriculum_alt',30)->nullable();
            $table->integer('id_ofl')->nullable();
            $table->integer('id_jer')->nullable();
            $table->integer('id_puesto')->nullable();
            $table->integer('id_etapa')->nullable();
            $table->integer('valida_sipe')->default(0)->comment('0-no validado. 1-validado.'); 
            $table->integer('marcacion')->default(0)->comment('0-no marca. 1-si marca.'); 
            $table->text('motivo_descarte')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_participantes');
    }
};
