<?php

namespace App\Models\Undangan\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class GalleryWedding extends Model
{
    protected $table = 'galleries_wedding';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Schema::getColumnListing($this->getTable());
    }

    /**
     * Balikan relasi ke Wedding
     */
    public function wedding()
    {
        return $this->belongsTo(WeddingModel::class, 'wedding_id', 'id');
    }
}
