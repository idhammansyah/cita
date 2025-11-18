<?php

namespace App\Models\Reimbursement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ReimbursementCategory extends Model
{
  use HasFactory;
  protected $table = 'reimburse_category';
  protected $primaryKey = 'id';
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
}
