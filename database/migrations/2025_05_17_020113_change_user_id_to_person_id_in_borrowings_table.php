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
        Schema::table('borrowings', function (Blueprint $table) {
            // Cek apakah person_id sudah ada
            if (!Schema::hasColumn('borrowings', 'person_id')) {
                // Jika person_id belum ada dan user_id ada, rename
                if (Schema::hasColumn('borrowings', 'user_id')) {
                    $table->renameColumn('user_id', 'person_id');
                }
                // Jika keduanya tidak ada, buat baru
                else {
                    $table->foreignId('person_id')->constrained('people');
                }
            }
            // Jika person_id sudah ada, tidak perlu melakukan apa-apa
        });
    }
};
