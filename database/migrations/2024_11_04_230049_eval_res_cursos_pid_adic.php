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
    {   Schema::create('eval_res_cursos_pid_adic',function(Blueprint $table){
            $table->id();
            $table->integer('id_eval')->nullable();
            $table->integer('id_evaluado')->nullable();
            $table->integer('id_evaluador')->nullable();
            $table->string('area')->nullable();
            $table->string('curso')->nullable();
            $table->text('accion')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('eval_res_cursos_pid_adic');}
};
