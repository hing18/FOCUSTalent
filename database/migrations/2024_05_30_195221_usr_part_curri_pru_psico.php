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
        Schema::create('usr_part_curri_pru_psico',function(Blueprint $table){
            $table->id();
            $table->integer('id_curri')->nullable();            	
            $table->string('prueba',30)->nullable();		
            $table->date('f_prueba')->nullable();
            $table->string('resultado',30)->nullable();
            $table->integer('id_participante')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });       
    }

    public function down(): void
    {
        Schema::dropIfExists('usr_part_curri_pru_psico');
    }
};
