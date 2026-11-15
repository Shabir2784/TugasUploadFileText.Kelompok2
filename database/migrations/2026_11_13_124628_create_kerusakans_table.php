
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kerusakans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('detail_pemesanan_id')
                ->constrained('detail_pemesanans')
                ->cascadeOnDelete();

            $table->text('deskripsi');
            $table->string('foto_kerusakan');
            $table->decimal('jumlah_denda', 12, 2)->default(0.00);
            $table->text('catatan_admin')->nullable();

            $table->enum('status', [
                'dilaporkan',
                'ditinjau',
                'diselesaikan'
            ])->default('dilaporkan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kerusakans');
    }
};
