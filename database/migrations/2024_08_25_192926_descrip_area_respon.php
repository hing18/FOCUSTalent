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
        Schema::create('descrip_area_respon',function(Blueprint $table){
            $table->id();
            $table->integer('iddf')->nullable();
            $table->string('id_temp',30)->nullable();
            $table->string('area_respon',200)->nullable();
            $table->string('kpi',150)->nullable();
            $table->integer('cant_tarea')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('descrip_area_respon');}
};
