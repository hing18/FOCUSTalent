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
        Schema::create('eval_evaluado_evaluador',function(Blueprint $table){
            // DATOS PERSONALES
            $table->id();
            $table->integer('id_evaluacion')->nullable();
            $table->integer('id_evaluado')->nullable();
            $table->integer('id_posicion_evaluado')->nullable();
            $table->integer('id_evaluador')->nullable();
            $table->integer('id_posicion_evaluador')->nullable();
            $table->integer('status')->default(1)->comment('1-activa. 2-en proceso. 4-finalizada. 5-rechazada.'); 
            $table->decimal('resultado',10,7)->default('0.0000000'); 
             
            $table->text('logros')->nullable();
            $table->text('comentarios_evaldor')->nullable();
            $table->integer('carrera')->default(2)->comment('0-Promoverlo de forma inmediata, 1-Promoverlo a mediano plazo (1 a 2 años), 2-Promoverlo a largo plazo (3 a 4 años)'); 
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('eval_evaluado_evaluador');}
};
