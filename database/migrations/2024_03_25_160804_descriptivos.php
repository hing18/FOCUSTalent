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
            $table->string('status',5)->comment('true-Habilitado, false-Deshabilitado');
            $table->string('nombredesc')->nullable();
            $table->integer('idjer')->nullable();
            $table->string('cargojefe')->nullable();
            $table->string('area_depto')->nullable();
            $table->integer('reportes')->nullable();

            $table->text('proposito')->nullable();

            $table->text('relacion_interna')->nullable();
            $table->text('relacion_externa')->nullable();

            $table->integer('riesgo_ofi_cam',40)->nullable();
            $table->string('epp',255)->nullable();

            $table->string('nivel_academico',20)->nullable();
            $table->string('estatus_academico',1)->nullable()->comment('c-Completo, p-Parcial');
            $table->text('estudio_requerido')->nullable();

            $table->integer('experiencia_norequiere')->nullable()->nullable()->comment('1-Habilitado, 0-Deshabilitado');
            $table->integer('experiencia_aux_asis')->nullable()->nullable()->comment('1-Habilitado, 0-Deshabilitado');
            $table->integer('experiencia_ana_esp')->nullable()->nullable()->comment('1-Habilitado, 0-Deshabilitado');
            $table->integer('experiencia_sup_coor')->nullable()->nullable()->comment('1-Habilitado, 0-Deshabilitado');
            $table->integer('experiencia_jef_dep')->nullable()->nullable()->comment('1-Habilitado, 0-Deshabilitado');
            $table->integer('experiencia_ge_dir')->nullable()->nullable()->comment('1-Habilitado, 0-Deshabilitado');

            $table->string('anos_experiencia',200)->nullable();

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
