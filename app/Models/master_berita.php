<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\master_penduduk;

class master_berita extends Model
{
    use HasFactory;

    protected $table = 'master_beritas'; 

    protected $primaryKey = 'id_berita';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_berita',
        'judul',
        'deskripsi',
        'nik',
    ];

    public $timestamps = true;
 
    
    public function penulis()
{
    return $this->belongsTo(master_penduduk::class, 'nik', 'nik');
}
}