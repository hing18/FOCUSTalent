<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Run the migrations. */
    public function up(): void
    {   Schema::create('numera',function(Blueprint $table){
            $table->id();
            $table->string('id_numera',20)->nullable();
            $table->integer('num')->default('0');            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();           
        });
    }

    /* Reverse the migrations. */
    public function down(): void
    {   Schema::dropIfExists('numera');}
};
