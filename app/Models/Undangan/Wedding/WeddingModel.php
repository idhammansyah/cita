<?php

namespace App\Models\Undangan\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class WeddingModel extends Model
{
    protected $table = 'weddings';

    protected $fillable = [];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);

    $this->fillable = $this->getAllowedFields();
  }

  protected function getAllowedFields()
  {
    return Schema::getColumnListing($this->getTable());
  }

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
