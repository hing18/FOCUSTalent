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
        Schema::create('usr_part_referencias',function(Blueprint $table){
            $table->id();
            $table->string('id_part_curriculum_alt',30)->nullable();
            $table->string('nombre',100)->nullable();
            $table->string('cargo',130)->nullable();
            $table->integer('id_tipo_rela_referencia')->nullable();
            $table->string('contacto',30)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_part_referencias');
    }
};
