<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'lokasi',
        'jumlah',
        'kondisi',
        'tanggal_masuk',
        'catatan'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'jumlah' => 'integer'
    ];

    public const KONDISI_BAIK = 'Baik';
    public const KONDISI_RUSAK_RINGAN = 'Rusak Ringan';
    public const KONDISI_RUSAK_BERAT = 'Rusak Berat';
    public const KONDISI_HILANG = 'Hilang';

    public static function kondisiOptions(): array
    {
        return [
            self::KONDISI_BAIK => 'Baik',
            self::KONDISI_RUSAK_RINGAN => 'Rusak Ringan',
            self::KONDISI_RUSAK_BERAT => 'Rusak Berat',
            self::KONDISI_HILANG => 'Hilang'
        ];
    }

    protected function namaBarang(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value)
        );
    }

    protected function tanggalMasukFormatted(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::parse($attributes['tanggal_masuk'])->format('d/m/Y')
        );
    }

    public function scopeBaik($query)
    {
        return $query->where('kondisi', self::KONDISI_BAIK);
    }

    public function scopeRusak($query)
    {
        return $query->whereIn('kondisi', [self::KONDISI_RUSAK_RINGAN, self::KONDISI_RUSAK_BERAT]);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
