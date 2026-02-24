<?php

namespace App\Http\Controllers\TemplateController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Template extends Controller
{
  public function flipbook()
  {
    return view('undangan_layout.flipbook.index');
  }

  public function wedding()
  {
    $data = [
      'title' => 'Wedding of Idham & Riska'
    ];

    return view('undangan_layout.idham_riska.flipbook.index',
      compact('data'));
  }

  public function invitation()
  {
    return view('undangan_layout.idham_riska.undanganku.undanganfix');
  }
}
