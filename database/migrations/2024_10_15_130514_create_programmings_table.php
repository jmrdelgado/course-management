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
            $table->string('denomination');
            $table->string('ngroup', 6);
            $table->string('cod_fundae', 8)->default(0);
            $table->foreignId('action_id')->constrained()->onUpdate('cascade');
            $table->string('modality',6);
            $table->foreignId('platform_id')->constrained()->onUpdate('cascade');
            $table->integer('nhoursp')->default(0);
            $table->integer('nhourstf')->default(0);
            $table->integer('nhourst')->default(0);
            $table->date('communication_date')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('number_students');
            $table->boolean('sionline')->default(false);
            $table->foreignId('company_id')->constrained()->onUpdate('cascade');
            $table->string('groupcompany')->nullable();
            $table->longText('observations')->nullable();
            $table->foreignId('tutor_id')->constrained()->onUpdate('cascade');
            $table->foreignId('coordinator_id')->constrained()->onUpdate('cascade');
            $table->string('agent');
            $table->string('supplier');
            $table->enum('course_type', ['Bonificado', 'Impartido', 'Privado', 'Gestionado']);
            $table->decimal('student_cost', 6, 2);
            $table->decimal('cost', 6, 2);
            $table->decimal('project_cost', 6, 2)->nullable();
            $table->enum('billed_month', ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'])->nullable();
            $table->boolean('rlt')->default(false);
            $table->boolean('rlt_send')->default(false);
            $table->boolean('rlt_received')->default(false);
            $table->boolean('rlt_faborable')->default(false);
            $table->boolean('rlt_incident')->default(false);
            $table->boolean('incident')->default(false);
            $table->boolean('canceled')->default(false);
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
