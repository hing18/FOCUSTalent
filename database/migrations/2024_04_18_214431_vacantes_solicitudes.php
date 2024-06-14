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
        Schema::create('vacantes_solicitudes',function(Blueprint $table){
            $table->id();
            $table->integer('id_puesto')->nullable();
            $table->string('codigo_puesto',20)->nullable();
            $table->integer('cantidad')->nullable();
            $table->integer('proceso')->nullable();
            $table->integer('contratados')->nullable();
            $table->string('genero',2)->nullable();
            $table->string('rango_edad',20)->nullable();
            $table->text('comentarios')->nullable();
            $table->integer('id_secc')->nullable();
            $table->integer('id_ue')->nullable();
            $table->integer('id_jer')->nullable();
            $table->integer('id_estatus')->nullable();
            $table->integer('id_escala')->nullable();
            $table->integer('tiemporeal')->nullable();
            $table->integer('tiempocalculado')->nullable();
            $table->integer('id_motivo')->nullable();
            $table->string('autorizacion')->nullable();
            $table->integer('id_user_solicitante')->nullable();
            $table->date('hasta')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->text('observacion')->nullable();
            $table->string('cod_planillera',6)->nullable();
            $table->string('cod_ceco',6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacantes_solicitudes');
    }
};
