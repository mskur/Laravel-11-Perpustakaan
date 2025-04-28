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
        Schema::create('returns', function (Blueprint $table) {
            $table->string('id_pengembalian', 12)->primary(); // ID Pengembalian (RTN000001)
            $table->string('id_peminjaman', 12);
            $table->date('tanggal_pengembalian');
            $table->decimal('denda', 8, 2)->default(0); // Denda (jika telat)
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
