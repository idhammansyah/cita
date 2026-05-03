<?php

namespace App\Models\Undangan\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeddingModel extends Model
{
    protected $table = 'weddings';

    protected $fillable = [
        'slug',
        'photo_pria',
        'm_pria',
        'm_pria_panggilan',
        'm_pria_ayah',
        'm_pria_ibu',
        'photo_wanita',
        'm_wanita',
        'm_wanita_panggilan',
        'm_wanita_ayah',
        'm_wanita_ibu',
        'tgl_akad',
        'tgl_resepsi',
        'lokasi_nama',
        'lokasi_address',
        'maps_url',
        'music_url',
        'quote_quran'
    ];

    /**
     * Relasi ke table stories_undangan
     */
    public function stories(): HasMany
    {
        return $this->hasMany(StoryUndangan::class, 'weddings_id', 'id');
    }

    /**
     * Relasi ke table galleries_wedding
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(GalleryWedding::class, 'wedding_id', 'id');
    }
}
