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
        Schema::create('programmings', function (Blueprint $table) {
            $table->id();
            $table->string('naction', 6);
            $table->string('ngroup', 6);
            $table->foreignId('action_id')->constrained()->onUpdate('cascade');
            $table->string('modality')->default('TF');
            $table->foreignId('platform_id')->constrained()->onUpdate('cascade');
            $table->integer('nhours');
            $table->date('communication_date')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('number_students');
            $table->foreignId('company_id')->constrained()->onUpdate('cascade');
            $table->longText('observations')->nullable();
            $table->foreignId('tutor_id')->constrained()->onUpdate('cascade');
            $table->foreignId('coordinator_id')->constrained()->onUpdate('cascade');
            $table->foreignId('agent_id')->constrained()->onUpdate('cascade');
            $table->foreignId('supplier_id')->constrained()->onUpdate('cascade');
            $table->enum('course_type', ['Bonificado', 'Impartido', 'Privado', 'Gestionado']);
            $table->decimal('cost', 5, 2);
            $table->enum('billed_month', ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'])->nullable();
            $table->boolean('rlt')->default(false);
            $table->boolean('rlt_send')->default(false);
            $table->boolean('rlt_received')->default(false);
            $table->boolean('rlt_faborable')->default(false);
            $table->boolean('rlt_incident')->default(false);
            $table->boolean('incident')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programmings');
    }
};
