<?php

namespace App\Http\Controllers\DigitalCardController\ListUndangan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Undangan\list_tamu\list_undangan;
use Illuminate\Support\Facades\DB;

class ListUndanganController extends Controller
{
  public function index()
  {
    return view('undangan.daftar_tamu.index');
  }

  public function get_list_tamu(Request $request)
  {
    $columns = [
        0 => 'id_tamu',
        1 => 'nama_tamu',
        2 => 'phone',
        3 => 'tamu_dari',
        4 => 'group_nama',
        5 => 'address',
    ];

    $totalData = list_undangan::count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    $query = list_undangan::from('tamu as lu')
    ->join('tamu_groups as g', 'g.id_group_tamu', '=', 'lu.id_groups')
    ->where('lu.is_deleted', 0)
    ->select(
        'lu.id_tamu',
        'lu.nama_tamu',
        'lu.phone',
        'lu.tamu_dari',
        'lu.address',
        'g.nama_group_tamu as group_nama'
    );

    // Search
    if (!empty($request->input('search.value'))) {

      $search = $request->input('search.value');

      $query->where('nama_tamu', 'LIKE', "%{$search}%")
        ->orWhere('phone', 'LIKE', "%{$search}%")
        ->orWhere('tamu_dari', 'LIKE', "%{$search}%")
        ->orWhere('group_nama', 'LIKE', "%{$search}%")
        ->orWhere('address', 'LIKE', "%{$search}%")
        ->andWhere('is_deleted', 0);

      $totalFiltered = $query->count();
    }

    $data = $query->offset($start)
      ->limit($limit)
      ->orderBy($order, $dir)
      ->get();

    $json_data = [
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    ];

    return response()->json($json_data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_tamu.*' => 'required',
      'no_hp.*' => 'required',
      'undangan_dari.*' => 'required',
      'group_undangan.*' => 'required',
    ]);

    try {
      DB::transaction(function () use ($request)
      {
        foreach ($request->nama_tamu as $index => $nama)
        {
          list_undangan::create([
            'nama_tamu' => $nama,
            'phone' => $request->no_hp[$index],
            'tamu_dari' => $request->undangan_dari[$index],
            'id_groups' => $request->group_undangan[$index],
            'address' => $request->alamat[$index] ?? null,
            'created_by' => auth()->user()->full_name
          ]);
        }

      });

      return response()->json([
        'status' => 'success',
        'message' => 'Data tamu berhasil disimpan!'
      ]);
    } catch (\Exception $e)
    {
      return response()->json([
        'status' => 'error',
        'message' => 'Gagal menyimpan data!',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show($id)
  {
    $data = list_undangan::findOrFail($id);
    return response()->json($data);
  }

  public function update(Request $request, $id)
  {
    $data = list_undangan::findOrFail($id);

    $data->update([
      'nama_tamu' => $request->nama_tamu,
      'phone' => $request->no_hp,
      'tamu_dari' => $request->undangan_dari,
      'id_groups' => $request->group_undangan,
      'address' => $request->alamat,
    ]);

    return response()->json([
      'message' => 'Data berhasil diupdate'
    ]);
  }

  public function destroy($id)
  {
    $data = list_undangan::findOrFail($id);
    $data->update([
      'is_deleted' => 1,
      'deleted_by' => auth()->user()->full_name,
      'deleted_at' => now()
    ]);

    return response()->json([
        'message' => 'Data berhasil dihapus'
    ]);
  }

  public function getWaData($id)
  {
    $data = list_undangan::where('is_deleted', 0)->findOrFail($id);

    return response()->json([
        'id' => $data->id_tamu,
        'nama' => $data->nama_tamu,
        'phone' => $data->phone,
    ]);
  }

  public function updateWaStatus(Request $request)
  {
    list_undangan::where('id_tamu', $request->id)
        ->update(['is_sent' => 1]);

    return response()->json(['success' => true]);
  }
}
