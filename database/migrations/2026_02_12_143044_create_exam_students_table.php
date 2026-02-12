<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_students', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('student_code')->unique();

            // Champs statiques (valeurs par défaut)
            $table->string('level')->default('A2');
            $table->string('center_name')->default('Centre Marrakech');
            $table->date('letter_date')->default('2026-02-11'); // Date du document
            $table->string('exam_dates')->default('16 - 17 février 2026');
            $table->string('exam_time')->default('18h00 - 21h30');
            $table->text('address_block')->default("3ème étage Bureau 28, Immeuble Espace,<br>Av. Yacoub El Mansour, Marrakesh 40000<br>Maroc");

            // Champs variables par étudiant
            $table->string('class_name')->nullable(); // salle / groupe / classe
            $table->string('reference')->nullable();  // optionnel

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_students');
    }
};
