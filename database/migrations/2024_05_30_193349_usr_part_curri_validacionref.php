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
        Schema::create('usr_part_curri_validacionref',function(Blueprint $table){
            $table->id();
            $table->integer('id_curri')->nullable();            	
            $table->string('entidad',100)->nullable();		
            $table->string('nombre',100)->nullable();
            $table->string('puesto',100)->nullable();
            $table->string('contacto',40)->nullable();
            $table->text('comentarios')->nullable();
            $table->integer('id_participante')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });       
    }

    public function down(): void
    {
        Schema::dropIfExists('usr_part_curri_validacionref');
    }
};
