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
        Schema::create('colab_pl_rh',function(Blueprint $table){
            $table->id();
            $table->string('CEDULA',20)->nullable(); 
            $table->string('NOMBRE_SEP',100)->nullable();
            $table->string('APELLIDO_SEP',100)->nullable();
            $table->string('NO_EMPLE',10)->nullable();
            $table->string('COD_PLANILLERA',5)->nullable();
            $table->string('PLANILLERA',100)->nullable();
            $table->string('COD_GRUPO',5)->nullable();
            $table->string('NOM_GRUPO',10)->nullable();
            $table->string('COD_SGRUPO',5)->nullable();
            $table->string('NOM_SGRUPO',10)->nullable();
            $table->string('COD_UBICACION',5)->nullable();
            $table->string('NOM_UBICACION',10)->nullable();
            $table->string('COD_CADENA',5)->nullable();
            $table->string('NOM_CADENA',100)->nullable();
            $table->string('COD_LINEA',5)->nullable();
            $table->string('NOM_LINEA',100)->nullable();
            $table->string('H_RESPONSABLE',5)->nullable();
            $table->string('COD_UE',5)->nullable();
            $table->string('UNI_ECO',150)->nullable();
            $table->string('COD_CIA_COSTO',15)->nullable();
            $table->string('CENTROCOSTO',100)->nullable();
            $table->string('COD_PUESTO_PL',15)->nullable();
            $table->string('COD_PUESTO_UNIPL',15)->nullable();
            $table->string('NOM_POSICIONPL',100)->nullable();
            $table->string('COD_PUESTO_RH',15)->nullable();
            $table->string('NOM_POSICIONRH',100)->nullable();
            $table->date('F_INGRESO')->nullable();
            $table->string('SEXO',2)->nullable();
            $table->date('F_NACIMI')->nullable();
            $table->string('ESTADO',3)->nullable();
            $table->string('COD_DEPTO_PL',10)->nullable();
            $table->string('NOMDEPTO_PL',100)->nullable();
            $table->string('COD_DEPTO_RH',5)->nullable();
            $table->string('DEPTO_RH',100)->nullable();
            $table->string('SECCION_PL',100)->nullable();
            $table->string('COD_EMP_JEFE',10)->nullable();
            $table->string('NOM_JEFE',100)->nullable();
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colab_pl_rh');
    }
};
