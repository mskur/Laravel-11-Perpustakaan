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
        Schema::create('books', function (Blueprint $table) {
            $table->string('id_buku', 10)->primary(); // ID Buku (BOOK0001)
            $table->string('judul_buku');
            $table->integer('jumlah_buku');
            $table->string('id_kategori', 10);
            $table->string('barcode_buku')->unique();
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_kategori')->references('id_kategori')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
