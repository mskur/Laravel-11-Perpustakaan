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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->string('id_detail_peminjaman', 15)->primary(); // ID Detail Peminjaman (DPNJMN000001)
            $table->string('id_peminjaman', 12);
            $table->string('id_buku', 10);
            $table->integer('jumlah'); // Jumlah buku yang dipinjam
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('loans')->onDelete('cascade');
            $table->foreign('id_buku')->references('id_buku')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_details');
    }
};
