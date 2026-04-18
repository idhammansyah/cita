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
      'title' => 'Fill The Form',

    ];

    return view('undangan_layout.form_undangan.form',
      compact('data'));
  }

  public function invitation()
  {
    return view('undangan_layout.idham_riska.undanganku.undanganfix');
  }
}
