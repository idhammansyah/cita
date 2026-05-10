<?php

namespace App\Models\Undangan\Wedding;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class RSVP extends Model
{
  protected $table = 'rsvps';

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
    return $this->belongsTo(WeddingModel::class, 'weddings_id', 'id');
  }
}
