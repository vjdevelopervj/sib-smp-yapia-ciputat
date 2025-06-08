<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_peminjaman',
        'item_id',
        'person_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'kondisi_kembali',
        'catatan'
    ];

    protected $dates = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'created_at',
        'updated_at'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
