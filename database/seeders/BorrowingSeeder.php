<?php

namespace Database\Seeders;

use App\Models\Borrowing;
use App\Models\Item;
use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        $itemIds = Item::pluck('id')->toArray();
        $personIds = Person::pluck('id')->toArray();

        if (empty($itemIds) || empty($personIds)) {
            $this->command->warn('Item atau Person belum ada, jalankan ItemSeeder dan PersonSeeder terlebih dahulu.');
            return;
        }

        for ($i = 1; $i <= 300; $i++) {
            $tanggalPinjam = Carbon::now()->subDays(rand(1, 30));
            $tanggalKembali = (clone $tanggalPinjam)->addDays(rand(3, 10));

            $dikembalikan = rand(0, 1);
            $tanggalDikembalikan = $dikembalikan ? (clone $tanggalPinjam)->addDays(rand(1, 15)) : null;

            Borrowing::create([
                'kode_peminjaman' => 'PINJ' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'item_id' => fake()->randomElement($itemIds),
                'person_id' => fake()->randomElement($personIds),
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_kembali' => $tanggalKembali,
                'tanggal_dikembalikan' => $tanggalDikembalikan,
                'status' => $dikembalikan ? 'Dikembalikan' : 'Dipinjam',
                'kondisi_kembali' => $dikembalikan ? fake()->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']) : null,
                'catatan' => fake()->boolean(20) ? fake()->sentence() : null,
            ]);
        }
    }
}
