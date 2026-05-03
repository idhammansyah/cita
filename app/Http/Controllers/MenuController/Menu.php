<?php

namespace App\Http\Controllers\MenuController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class Menu extends Controller
{
  public function index()
  {
    $data = [
      'title' => 'Menu Management',
      'categories' => DB::table("menus_kategori")->where('is_active', 1)->orderBy('urutan')->get(),
      'modules' => DB::table("modules")->where('is_deleted', 0)->get(),
      'all_menus' => DB::table("menus")->where('is_active', 1)->orderBy('urutan')->get()
    ];
    $categories = DB::table("menus_kategori")->where('is_active', 1)->orderBy('urutan')->get();
    $modules = DB::table("modules")->where('is_deleted', 0)->get();
    $all_menus = DB::table("menus")->where('is_active', 1)->orderBy('urutan')->get();

    return view("menu_management.index", compact("categories", "modules", "all_menus", "data"));
  }

  public function getAll()
  {
    $menus = DB::table("menus")
      ->where("is_active", 1)
      ->orderBy("urutan")
      ->get()
      ->toArray();

    $tree = $this->buildTree($menus);

    return response()->json($tree);
  }

  private function buildTree($menus, $parent = 0)
  {
    $branch = [];

    foreach ($menus as $m) {
      if ($m->id_parent == $parent) {
        $children = $this->buildTree($menus, $m->id_menus);

        if ($children) $m->children = $children;
        else           $m->children = [];

        $branch[] = $m;
      }
    }

    return $branch;
  }


  public function store(Request $r)
  {
    DB::table("menus")->insert([
      "nama_menu" => $r->nama_menu,
      "url_link"  => $r->url_link,
      "class"     => $r->class,
      "id_menu_kategori"  => $r->id_menu_kategori,
      "id_modules" => $r->id_modules,
      "id_parent" => $r->id_parent ?? 0,
      "posisi"    => $r->posisi,
      "urutan"    => $r->urutan ?? 1,
      "is_active" => 1
    ]);

    return response()->json(["message" => "Menu created"]);
  }

  public function show($id)
  {
    $menu = DB::table("menus")->where("id_menus", $id)->first();
    return response()->json($menu);
  }

  public function update(Request $r, $id)
  {
    DB::table("menus")
      ->where("id_menus", $id)
      ->update([
        "nama_menu" => $r->nama_menu,
        "url_link"  => $r->url_link,
        "class"     => $r->class,
        "id_menu_kategori"  => $r->id_menu_kategori,
        "id_modules" => $r->id_modules,
        "posisi"    => $r->posisi,
        "id_parent" => $r->id_parent,
        "urutan"    => $r->urutan
      ]);

    return response()->json(["message" => "Updated"]);
  }

  public function softDelete($id)
  {
    DB::table("menus")
      ->where("id_menus", $id)
      ->update(["is_active" => 0]);

    return response()->json(["message" => "Soft deleted"]);
  }

  public function reorder(Request $r)
  {
    $items = json_decode($r->menu_data, true);
    foreach ($items as $item) {
      // nestedSortable returns "item_id"
      $id = $item["item_id"];
      DB::table("menus")
        ->where("id_menus", $id)
        ->update([
            "id_parent" => $item["parent_id"] == "null" ? 0 : $item["parent_id"],
            "urutan"    => $item["depth"]
        ]);
    }

    return response()->json(["message" => "Reordered"]);
  }
}
