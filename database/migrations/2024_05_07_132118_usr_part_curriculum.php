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
        Schema::create('usr_part_curriculum',function(Blueprint $table){
            $table->id();
            $table->string('id_part_curriculum_alt',30)->nullable();
            $table->string('prinombre',60)->nullable();
            $table->string('segnombre',60)->nullable();
            $table->string('priapellido',100)->nullable();
            $table->string('segapellido',100)->nullable();
            $table->string('genero',2)->nullable();
            $table->string('nacio_extran',2)->nullable();
            $table->date('f_nacimiento')->nullable();
            $table->integer('id_nacionalidad')->nullable();
            $table->string('id_tipo_doc_letra',2)->nullable();
            $table->string('num_doc',20)->nullable();
            $table->string('num_ss',20)->nullable();
            $table->string('estadocivil',20)->nullable();
            $table->date('f_vencimiento')->nullable();
            $table->string('tel',50)->nullable();
            $table->string('email',100)->nullable();
            $table->integer('id_provincia')->nullable();
            $table->integer('id_distrito')->nullable();
            $table->integer('id_corregimiento')->nullable();
            $table->string('direccion',130)->nullable();
            $table->string('discapacidad',30)->nullable();
            $table->string('detalle_descapacidad',200)->nullable();
            $table->string('cv_doc',50)->nullable();
            $table->string('permiso_trab',50)->nullable();
            $table->date('f_vence_permiso_trab')->nullable();
            $table->string('permiso_doc',50)->nullable();
            $table->string('estado_registro',20)->nullable()->comment('contratado, no contratado');
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
        Schema::dropIfExists('usr_part_curriculum');
    }
};
