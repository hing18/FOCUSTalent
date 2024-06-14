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
        Schema::create('menu',function(Blueprint $table){
            $table->id();
            $table->string('name_menu',25)->nullable();
            $table->integer('id_sup')->nullable();
            $table->string('link')->nullable();
            $table->string('icono')->nullable();
            $table->integer('orden')->nullable();
            $table->string('tipo',2)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {        
        Schema::dropIfExists('menu');
    }
};
