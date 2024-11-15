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
    {   Schema::create('eval_res_gap',function(Blueprint $table){
            $table->id();
            $table->integer('id_eval')->nullable();
            $table->integer('id_evaluado')->nullable();
            $table->decimal('ci',11,7)->default('0.0000000');
            $table->decimal('na',11,7)->default('0.0000000');
            $table->decimal('comp',11,7)->default('0.0000000');
            $table->decimal('conhab',11,7)->default('0.0000000');
            $table->decimal('cumplimiento',11,7)->default('0.0000000'); 
            $table->decimal('gap_ci',11,7)->default('0.0000000');
            $table->decimal('gap_na',11,7)->default('0.0000000');
            $table->decimal('gap_comp',11,7)->default('0.0000000');
            $table->decimal('gap_conhab',11,7)->default('0.0000000');
            $table->decimal('gap',11,7)->default('0.0000000'); 
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('eval_res_gap');}
};
