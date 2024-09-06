<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void{
        Schema::create('usr_partici_cartaofl',function(Blueprint $table){
            $table->id();
            $table->integer('id_participante')->nullable();
            $table->decimal('salario',7,2)->default('0.00');    
            $table->date('finicio')->nullable();
            $table->date('fterminacion')->nullable();
            $table->string('sel_tipo_contrato',2)->nullable();
            $table->string('sel_tipo_salario',2)->nullable();
            $table->string('descargada_por',100)->nullable();
            $table->integer('estado')->default(1)->comment('1-activa. 2-Inactiva. 3-Aceptada. 4-Rechazada. 5-Descargada.');           
            $table->string('aprobacion_ofl',200)->nullable();
            $table->string('aceptacion_ofl',200)->nullable();
            $table->date('faceptacion')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });       
    }
    
    public function down(): void
    {   Schema::dropIfExists('usr_partici_cartaofl');}
};