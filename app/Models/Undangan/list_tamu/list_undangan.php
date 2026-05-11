<?php

namespace  App\Models\Undangan\list_tamu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Models\Undangan\Wedding\WeddingModel;

class list_undangan extends Model
{
  use HasFactory;
  protected $table = 'tamu';
  protected $primaryKey = 'id_tamu';
  public $incrementing = true;
  protected $keyType = 'int';
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

  public function wedding() {
    return $this->belongsTo(WeddingModel::class, 'wedding_id');
  }
}
