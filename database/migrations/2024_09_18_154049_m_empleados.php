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
        Schema::create('m_empleados',function(Blueprint $table){
            // DATOS PERSONALES
            $table->id();
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

            // DATOS EMPRESARIALES
            
            $table->integer('id_posicion')->nullable(); // con este campo se busca la unidad, áreea y el jefe del puesto            
            $table->integer('id_estatus')->nullable(); // de acuerdo a estatus es planilla, deberia iniciar como ACTIVO

            // DATOS DE REMUNERACIÓN

            $table->decimal('salario',7,2)->default('0.00');    
            $table->date('finicio')->nullable();
            $table->date('fterminacion')->nullable();
            $table->string('tipo_contrato',2)->nullable();
            $table->string('tipo_salario',2)->nullable();

            
            

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('m_empleados');}
};
