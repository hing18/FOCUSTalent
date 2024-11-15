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
        Schema::create('descrip_idioma',function(Blueprint $table){
            $table->id();
            $table->integer('iddf')->nullable();
            $table->string('idioma',30)->nullable();
            $table->integer('nivel')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('descrip_idioma');}
};
