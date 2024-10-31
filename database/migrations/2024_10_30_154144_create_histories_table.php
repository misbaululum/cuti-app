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
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('referensi_id');
            $table->string('referensi_type');
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_approve')->nullable();
            $table->boolean('status_approve')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('next_approve_id')->nullable()->constrained('users');
            $table->string('next_approve')->nullable();
            $table->dateTime('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
