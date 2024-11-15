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
    {   Schema::create('eval_res_comp',function(Blueprint $table){
            $table->id();
            $table->integer('id_eval')->nullable();
            $table->integer('id_evaluado')->nullable();
            $table->integer('id_evaluador')->nullable();
            $table->integer('id_comp')->nullable();
            $table->string('comp',50)->nullable();
            $table->integer('opt')->nullable();
            $table->integer('prf')->nullable();
            $table->decimal('peso',10,7)->default('0.0000000'); 
            $table->decimal('obtenido',10,7)->default('0.0000000'); 
            $table->decimal('gap',10,7)->default('0.0000000'); 
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('eval_res_comp');}
};
