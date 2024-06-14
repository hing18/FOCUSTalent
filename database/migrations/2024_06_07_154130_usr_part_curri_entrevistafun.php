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
        Schema::create('usr_part_curri_entrevistafun',function(Blueprint $table){
            $table->id();
            $table->integer('id_curri')->nullable();
            $table->integer('id_participante')->nullable();    
            $table->string('nom_entrevistador',150)->nullable();
            $table->string('email',150)->nullable();
            $table->string('puesto',150)->nullable();
            $table->date('fecha')->nullable();   
            $table->string('hora',20)->nullable();   
            $table->integer('notificado')->default(0)->comment('0-Sin notificar, 1-Notificado.');  
            $table->text('comentarios')->nullable(); 
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });       
    }

    public function down(): void
    {
        Schema::dropIfExists('usr_part_curri_entrevistafun');
    }
};
