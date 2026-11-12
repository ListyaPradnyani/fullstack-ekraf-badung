<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // --- Sesuai slide "Struktur Website: UMKM Directory" ---
            $table->string('nama_pelaku');                 // Nama Pelaku Usaha
            $table->string('nama_brand');                  // Nama Brand
            $table->string('kecamatan', 40)->nullable()->index(); // 6 kecamatan Badung
            $table->string('no_wa', 30)->nullable();       // No. WA
            $table->text('alamat')->nullable();            // Alamat Usaha
            $table->text('media_sosial')->nullable();      // Media sosial yang dimiliki
            $table->text('cerita_usaha')->nullable();      // Ceritakan tentang usaha
            $table->json('legalitas')->nullable();         // HKI / HACCP / Halal / Lainnya
            // Foto KTP, NIB, produk & legalitas ada di tabel umkm_files

            // --- Tambahan dari Excel kurasi & tampilan landing page ---
            $table->text('produk')->nullable();            // Produk yang diajukan
            $table->json('kesiapan')->nullable();          // Kesiapan stand & komitmen
            $table->string('kategori', 60)->nullable()->index(); // subsektor (filter di landing page)
            $table->string('jam_buka', 100)->nullable();
            $table->boolean('setuju_data')->default(false);
            $table->boolean('tampilkan_kontak')->default(false); // izin WA tampil publik

            // --- Kurasi admin ---
            $table->string('status', 10)->default('pending')->index(); // pending|approved|rejected
            $table->text('catatan_admin')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('umkm_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained()->cascadeOnDelete();
            $table->string('jenis', 15)->index();   // ktp | nib | produk | legalitas
            $table->string('label', 30)->nullable(); // HKI / HACCP / Halal / Lainnya
            $table->string('path')->nullable();      // file yang diunggah (storage)
            $table->text('url')->nullable();         // tautan lama (mis. Google Drive dari Excel)
            $table->string('nama_asli')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_files');
        Schema::dropIfExists('umkms');
    }
};
