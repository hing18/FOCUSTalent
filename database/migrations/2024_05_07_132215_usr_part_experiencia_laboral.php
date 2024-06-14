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
        Schema::create('usr_part_experiencia_laboral',function(Blueprint $table){
            $table->id();
            $table->string('id_part_curriculum_alt',30)->nullable();
            $table->string('empresa',60)->nullable();
            $table->string('puesto',60)->nullable();
            $table->string('area',60)->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->text('logros')->nullable();
            $table->text('motivo_Salida')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_part_experiencia_laboral');
    }
};
