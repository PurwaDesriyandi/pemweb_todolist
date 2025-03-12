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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul tugas
            $table->text('description')->nullable(); // Deskripsi tugas
            $table->enum('status', ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'])->default('Belum Dikerjakan'); // Status tugas
            $table->date('deadline'); // Deadline tugas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
