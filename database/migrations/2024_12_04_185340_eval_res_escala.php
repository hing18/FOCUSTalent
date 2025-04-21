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
    {   Schema::create('eval_res_escala',function(Blueprint $table){
            $table->id();
            $table->integer('id_eval')->nullable();
            $table->decimal('minimo',11,7)->default('0.0000000');            
            $table->decimal('maximo',11,7)->default('0.0000000');
            $table->string('categoria',30)->nullable();
            $table->string('color',10)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists('eval_res_escala');}
};
