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
        Schema::create('usr_part_educacion',function(Blueprint $table){
            $table->id();
            $table->string('id_part_curriculum_alt',30)->nullable();
            $table->string('nivel_educ',30)->nullable();
            $table->string('estatuseduc',30)->nullable();
            $table->string('entidad',60)->nullable();
            $table->string('titulo',130)->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->string('docum',30)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_part_educacion');
    }
};
