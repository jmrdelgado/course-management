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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('naction',6);
            $table->string('cod_fundae', 8)->default(0)->nullable();
            $table->string('denomination');
            $table->enum('modality', ['P','M','AV','TF']);
            $table->string('nhoursp', 6)->default(0);
            $table->string('nhourstf', 6)->default(0);
            $table->string('nhourst', 6)->default(0);
            $table->foreignId('supplier_id')->constrained()->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
