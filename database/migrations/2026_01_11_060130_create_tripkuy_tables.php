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
        // 1. Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // Primary Key
            $table->string('nama', 64);
            $table->string('email', 64)->unique();
            $table->string('password', 255);
            $table->enum('role', ['user', 'admin']);
            $table->string('no_telepon', 16)->nullable();
            $table->timestamps(); // created_at, updated_at
        });

        // 2. Tabel Hotel
        Schema::create('hotel', function (Blueprint $table) {
            $table->id('id_hotel');
            $table->string('nama_hotel', 255)->unique()->nullable();
            $table->string('email', 64)->unique()->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('kontak', 64)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();
        });

        // 3. Tabel Pembayaran
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->integer('total_harga')->nullable();
            $table->string('tipe_pembayaran', 255)->nullable();
            $table->timestamps();
        });

        // 4. Tabel Pembatalan
        Schema::create('pembatalan', function (Blueprint $table) {
            $table->id('id_pembatalan');
            $table->string('alasan', 255)->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->string('catatan_admin', 255)->nullable();
            $table->date('tanggal_refund')->nullable();
            $table->timestamps();
        });

        // 5. Tabel Tipe Kamar (Relasi ke Hotel)
        Schema::create('tipe_kamar', function (Blueprint $table) {
            $table->id('id_kamar');
            
            // Foreign Key ke id_hotel
            $table->unsignedBigInteger('id_hotel')->nullable();
            $table->foreign('id_hotel')->references('id_hotel')->on('hotel')->onDelete('cascade');

            $table->string('nama_kamar', 64)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->integer('kapasitas_orang')->nullable(); // INT(2)
            $table->integer('total_kamar')->nullable();     // INT(3)
            $table->integer('harga')->nullable();
            $table->timestamps();
        });

        // 6. Tabel Review (Relasi ke Users)
        Schema::create('review', function (Blueprint $table) {
            $table->id('id_review');

            // Foreign Key ke id_user
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            $table->string('gambar', 255)->nullable();
            $table->tinyInteger('rating')->unsigned()->nullable(); // Range 1-5 bisa divalidasi di logic
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();
        });

        // 7. Tabel Reservasi (Relasi ke Semua)
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('id_reservasi');

            // Foreign Keys
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('id_kamar')->nullable();
            $table->foreign('id_kamar')->references('id_kamar')->on('tipe_kamar')->onDelete('cascade');

            $table->unsignedBigInteger('id_pembayaran')->nullable();
            $table->foreign('id_pembayaran')->references('id_pembayaran')->on('pembayaran')->onDelete('set null');

            $table->unsignedBigInteger('id_pembatalan')->nullable();
            $table->foreign('id_pembatalan')->references('id_pembatalan')->on('pembatalan')->onDelete('set null');

            $table->date('tanggal_reservasi')->useCurrent();
            $table->date('tanggal_check_in')->nullable();
            $table->date('tanggal_check_out')->nullable();
            $table->integer('jumlah_kamar')->nullable();
            $table->integer('total_malam')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tabel harus dibalik urutannya (Anak dulu baru Induk)
        Schema::dropIfExists('reservasi');
        Schema::dropIfExists('review');
        Schema::dropIfExists('tipe_kamar');
        Schema::dropIfExists('pembatalan');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('hotel');
        Schema::dropIfExists('users');
    }
};