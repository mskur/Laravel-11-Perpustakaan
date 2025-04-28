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
        Schema::create('return_details', function (Blueprint $table) {
            $table->string('id_detail_pengembalian', 15)->primary(); // ID Detail Pengembalian (DRTN000001)
            $table->string('id_pengembalian', 12);
            $table->string('id_buku', 10);
            $table->integer('jumlah'); // Jumlah buku yang dikembalikan
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_pengembalian')->references('id_pengembalian')->on('returns')->onDelete('cascade');
            $table->foreign('id_buku')->references('id_buku')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_details');
    }
};
