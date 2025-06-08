<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik' => 500,
            'ATK' => 400,
            'Meja & Kursi' => 300,
            'Buku' => 200,
            'Lain-lain' => 100,
        ];

        $kondisiOptions = array_keys(Item::kondisiOptions());

        $counter = 1;

        foreach ($categories as $kategori => $jumlah) {
            for ($i = 0; $i < $jumlah; $i++) {
                Item::create([
                    'kode_barang' => 'BRG' . str_pad($counter, 5, '0', STR_PAD_LEFT),
                    'nama_barang' => fake()->words(2, true),
                    'kategori' => $kategori,
                    'lokasi' => 'Gudang ' . rand(1, 5),
                    'jumlah' => rand(1, 10),
                    'kondisi' => fake()->randomElement($kondisiOptions),
                    'tanggal_masuk' => Carbon::now()->subDays(rand(0, 365)),
                    'catatan' => fake()->optional()->sentence()
                ]);

                $counter++;
            }
        }
    }
}
