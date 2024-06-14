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
        Schema::create('usr_part_dependientes',function(Blueprint $table){
            $table->id();
            $table->integer('id_part_curriculum',20)->nullable();
            $table->string('nombre',100)->nullable();
            $table->string('parentesco',40)->nullable();
            $table->date('f_nacimiento')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_part_dependientes');
    }
};
