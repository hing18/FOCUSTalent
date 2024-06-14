<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
    Schema::create('colab_planillera_membretes',function(Blueprint $table){
        $table->id();
        $table->string('id_planillera',6)->nullable();
        $table->string('nombre_memb',100)->nullable();    
        $table->string('apartado',250)->nullable();
        $table->string('email',100)->nullable();
        $table->string('tel',50)->nullable();
        
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrentOnUpdate();
    });       
}

public function down(): void
{
    Schema::dropIfExists('colab_planillera_membrete');}
};
