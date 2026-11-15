
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('kata_sandi');

            $table->enum('peran', ['admin', 'pelanggan'])
                ->default('pelanggan');

            $table->string('nomor_telepon', 20)->nullable();
            $table->string('berkas_ktp')->nullable();

            $table->enum('status_verifikasi', [
                'menunggu',
                'terverifikasi',
                'ditolak'
            ])->default('menunggu');

            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
