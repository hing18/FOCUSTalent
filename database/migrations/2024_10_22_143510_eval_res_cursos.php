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
        Schema::create('eval_res_cursos',function(Blueprint $table){
            // DATOS PERSONALES
            $table->id();
            $table->integer('id_eval')->nullable();
            $table->integer('cod_colab')->nullable();
            $table->integer('id_curso')->nullable();
            $table->string('nom_curso',150)->nullable();
            $table->integer('nota')->nullable();
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('eval_res_cursos');}
};
