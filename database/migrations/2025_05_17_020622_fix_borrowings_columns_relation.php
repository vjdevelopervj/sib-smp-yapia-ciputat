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
            // Hapus foreign key jika ada
            $table->dropForeign(['person_id']);

            // Hapus kolom person_id jika ada
            if (Schema::hasColumn('borrowings', 'person_id')) {
                $table->dropColumn('person_id');
            }

            // Buat kolom baru dengan relasi yang benar
            $table->foreignId('person_id')->constrained('people');
        });
    }
};
