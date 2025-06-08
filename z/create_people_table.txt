<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('kode_orang')->unique(); // NIS/NIP
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('role', ['Siswa', 'Siswi', 'Guru', 'Staff', 'Admin']);
            $table->string('kelas')->nullable(); // Hanya untuk siswa/siswi
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
};
