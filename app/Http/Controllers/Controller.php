<?php

namespace App\Http\Controllers;

use App\Models\User;

abstract class Controller
{
  protected $user, $wedding;

  public function __construct()
  {
    $this->user = new User();
    $this->wedding = new \App\Models\Undangan\Wedding\WeddingModel();
  }
}
