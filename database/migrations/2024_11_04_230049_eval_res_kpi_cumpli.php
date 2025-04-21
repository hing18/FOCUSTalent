<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*** Run the migrations.***/
    public function up(): void
    {   Schema::create('eval_res_kpi_cumpli',function(Blueprint $table){
            $table->id();
            $table->integer('id_eval')->nullable();
            $table->integer('id_evaluado')->nullable();
            $table->decimal('cumplimiento_promedio',5,2)->default('0.00');
            $table->decimal('peso',10,7)->default('0.0000000'); 
            $table->decimal('obtenido',10,7)->default('0.0000000'); 
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();   
           
        });
    }

    /*** Reverse the migrations.***/
    public function down(): void
    {   Schema::dropIfExists('eval_res_kpi_cumpli');}
};
