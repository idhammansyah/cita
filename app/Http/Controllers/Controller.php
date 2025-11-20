<?php

namespace App\Http\Controllers;

use App\Models\User;

abstract class Controller
{
  protected $user;

  public function __construct()
  {
    $this->user = new User();
  }
}
