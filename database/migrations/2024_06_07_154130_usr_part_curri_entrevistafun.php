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
            $table->integer('id_part')->nullable();    
            $table->integer('id_ofl')->nullable();
            $table->integer('id_terna')->nullable();            
            $table->string('email_entrevistador',150)->nullable();
            $table->date('fecha')->nullable();   
            $table->string('hora',20)->nullable();   
            $table->string('lugar_entrevista',200)->nullable();
            $table->text('observaciones')->nullable(); 
            $table->integer('notificado')->default(0)->comment('0-Sin notificar, 1-Notificado.');  
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });       
    }

    public function down(): void
    {
        Schema::dropIfExists('usr_part_curri_entrevistafun');
    }
};
