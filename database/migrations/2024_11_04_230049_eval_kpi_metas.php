<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*** Run the migrations.***/
    public function up(): void
    {   Schema::create('eval_kpi_metas',function(Blueprint $table){
            $table->id();
            $table->integer('id_eval')->nullable();
            $table->integer('id_evaluado')->nullable();
            $table->string('nom_kpi')->nullable();
            $table->decimal('real',5,2)->default('0.00');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();   
           
        });
    }

    /*** Reverse the migrations.***/
    public function down(): void
    {   Schema::dropIfExists('eval_kpi_metas');}
};
