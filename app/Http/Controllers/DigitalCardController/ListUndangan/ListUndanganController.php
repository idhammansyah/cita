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
    ->join('weddings as w', 'w.id', '=', 'lu.wedding_id')
    ->where('lu.is_deleted', 0)
    ->select(
        'lu.id_tamu',
        'lu.nama_tamu',
        'lu.phone',
        'lu.tamu_dari',
        'lu.address',
        'g.nama_group_tamu as group_nama',
        'w.slug'
    );

    // Search
    if (!empty($request->input('search.value'))) {

      $search = $request->input('search.value');

      $query->where('lu.nama_tamu', 'LIKE', "%{$search}%")
        ->orWhere('lu.phone', 'LIKE', "%{$search}%")
        ->orWhere('lu.tamu_dari', 'LIKE', "%{$search}%")
        ->orWhere('lu.group_nama', 'LIKE', "%{$search}%")
        ->orWhere('lu.address', 'LIKE', "%{$search}%")
        ->andWhere('lu.is_deleted', 0);

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
      // Ambil data lengkap: tamu + slug wedding + nama mempelai
      $data = DB::table('tamu')
        ->join('weddings', 'tamu.wedding_id', '=', 'weddings.id')
        ->where('tamu.id_tamu', $id)
        ->select(
          'tamu.id_tamu',
          'tamu.nama_tamu',
          'tamu.phone',
          'weddings.slug',
          'weddings.m_pria_panggilan', // WAJIB ADA biar weddingName gak undefined
          'weddings.m_wanita_panggilan' // WAJIB ADA biar weddingName gak undefined
        )
        ->first();

      if (!$data) {
        return response()->json(['message' => 'Data tamu kagak ada, cok!'], 404);
      }

      return response()->json($data);
  }

  public function updateWaStatus(Request $request)
  {
    list_undangan::where('id_tamu', $request->id)
        ->update(['is_sent' => 1]);

    return response()->json(['success' => true]);
  }

  public function showInvitation($slug, $guest_name)
  {
    $wedding = $this->wedding->with(['stories' => function($query)
      {$query->where('is_deleted', 0);},
      'galleries' => function($query){$query->where('is_deleted', 0);
      }, 'rsvps'])->where('slug', $slug)->firstOrFail();

    $decodedGuestName = str_replace(['+', '%20'], ' ', urldecode($guest_name));

    $ucapanS = DB::table('rsvps') // Sesuaikan nama tabelmu
        ->where('wedding_id', $wedding->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $tamu = DB::table('tamu')
    ->join('weddings', 'tamu.wedding_id', '=', 'weddings.id')
    ->where('weddings.id', $wedding->id)
    ->where('tamu.nama_tamu', $decodedGuestName)
    ->select(
        'tamu.*',
        'weddings.slug',
        'weddings.m_pria_panggilan',
        'weddings.m_wanita_panggilan',
        'weddings.tgl_akad'
    )
    ->first();

    // 4. Lempar ke view
    return view('undangan_layout.to_guests.index', [
        'slug'  => $slug,
        'wedding' => $wedding,
        'nama_tamu' => $decodedGuestName,
        'tamu' => $tamu,
        'ucapanS'   => $ucapanS
    ]);
  }

  public function storeUcapan(Request $request, $slug, $guest_name)
  {
    try {
      $request->validate([
        'wedding_id' => 'required',
        'nama_tamu' => 'required',
        'kehadiran' => 'required',
        'ucapan' => 'required',
      ]);

      $data = [
        'wedding_id' => $request->wedding_id,
        'name'  => $request->nama_tamu,
        'kehadiran'  => $request->kehadiran,
        'ucapan'     => $request->ucapan,
        'created_at' => now(),
      ];

      // Ganti 'ucapan_undangan' sesuai nama table lu
      DB::table('rsvps')->insert($data);

      return response()->json([
        'status' => 'success',
        'data' => [
          'nama' => $request->nama_tamu,
          'kehadiran' => $request->kehadiran,
          'ucapan' => $request->ucapan,
          'waktu' => 'Baru saja'
        ]
      ]);
    } catch (\Exception $e) {
      return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
  }
}
