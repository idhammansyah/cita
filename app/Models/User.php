<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use App\Models\Authentication\UserRole;
use App\Models\Authentication\Role;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

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

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function checkAccount($username)
  {
    return self::where('username', $username)
    ->orWhere('email', $username)
    ->with(['roles'])
    ->first();
  }

  public function roles()
  {
    return $this->hasManyThrough(Role::class, UserRole::class, 'id_user', 'id_roles', 'user_id', 'id_role');
  }
}
