
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();

            $table->string('kode_pemesanan', 50)->unique();

            $table->foreignId('user_id')
                ->constrained('users');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->unsignedInteger('total_hari');
            $table->decimal('total_harga', 12, 2);

            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'berlangsung',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');

            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
