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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('nomor')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_input');
            $table->integer('total_izin');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->text('keterangan');
            $table->enum('jenis', ['izin', 'sakit']);
            $table->boolean('status_approve')->nullable();
            $table->foreignId('user_approve_id')->nullable()->constrained('users');
            $table->string('user_approve')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
