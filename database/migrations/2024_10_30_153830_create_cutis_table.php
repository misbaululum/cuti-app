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
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('nomor')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_input');
            $table->integer('sisa_cuti_awal');
            $table->integer('total_cuti');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->text('keterangan');
            $table->boolean('status_approve')->nullable();
            $table->foreignId('user_approve_id')->nullable()->constrained('users');
            $table->string('user_approve')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
