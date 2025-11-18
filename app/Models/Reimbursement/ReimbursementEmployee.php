<?php

namespace App\Models\Reimbursement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Models\Reimbursement\ReimbursementCategory;
Use App\Models\User;

class ReimbursementEmployee extends Model
{
  use HasFactory;
  protected $table = 'reimburse_employee';
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

  public function user()
  {
    return $this->belongsTo(User::class, 'id_user', 'id');
  }

  public function category()
  {
    return $this->belongsTo(ReimbursementCategory::class, 'id_category_reimburse', 'id');
  }
}
