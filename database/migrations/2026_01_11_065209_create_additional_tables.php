<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    // Tabel Artikel Blog
    Schema::create('blogs', function (Blueprint $table) {
        $table->id('id_blog');
        $table->string('judul');
        $table->string('slug')->unique(); // Untuk URL (tips-liburan-bali)
        $table->text('konten');
        $table->string('gambar')->nullable();
        $table->string('penulis');
        $table->timestamps();
    });

    // Tabel Log Aktivitas Admin (Opsional tapi direkomendasikan)
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_user'); // Siapa pelakunya
        $table->string('aksi'); // Contoh: "Mengubah status reservasi #123"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_tables');
    }
};
