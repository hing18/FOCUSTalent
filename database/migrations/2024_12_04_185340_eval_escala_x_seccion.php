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
    {   Schema::create('eval_escala_x_seccion',function(Blueprint $table){
            $table->id();
            $table->integer('id_seccion')->nullable();
            $table->decimal('minimo_mayor_igual',5,2)->default('0.00');            
            $table->decimal('maximo_menor_que',5,2)->default('0.00');
            $table->decimal('porcentaje',5,2)->default('0.00');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('eval_escala_x_seccion');}
};
