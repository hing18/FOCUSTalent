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
        Schema::create('evaluaciones',function(Blueprint $table){
            // DATOS PERSONALES
            $table->id();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->integer('poblacion')->nullable();
            $table->string('observacion',150)->nullable();
            $table->integer('id_escala')->nullable();
            $table->integer('id_eval_anterior')->nullable();
            $table->integer('status')->default(0)->comment('0-Detenida. 1-Abierta. 3-Cerrada.');          
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('evaluaciones');}
};
