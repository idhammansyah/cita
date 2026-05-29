<?php

namespace App\Http\Controllers\DigitalCardController\ListUndangan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Undangan\list_tamu\list_undangan;
use App\Models\Undangan\Wedding\WeddingModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListUndanganController extends Controller
{
  public function index()
  {
    $data = WeddingModel::where('is_deleted', 0)->get();
    return view('undangan.daftar_tamu.index', compact('data'));
  }

  public function get_list_tamu(Request $request)
  {
    $columns = [
      0 => 'lu.id_tamu',   // No
      1 => 'lu.id_tamu',   // Check
      2 => 'w.slug',       // slug
      3 => 'lu.nama_tamu', // Nama Tamu
      4 => 'lu.phone',     // No HP
      5 => 'lu.tamu_dari', // Undangan Dari
      6 => 'g.nama_group_tamu', // Group
      7 => 'lu.address',   // Alamat
    ];

    // 2. Query utama (Gunakan join agar search group_nama jalan)
    $query = list_undangan::from('tamu as lu')
        ->join('tamu_groups as g', 'g.id_group_tamu', '=', 'lu.id_groups')
        ->join('weddings as w', 'w.id', '=', 'lu.wedding_id')
        ->where('lu.is_deleted', 0);

    $totalData = $query->count(); // Total data aktif
    $totalFiltered = $totalData;

    // 3. Logic Search (Gunakan Parameter Grouping biar is_deleted gak jebol)
    if (!empty($request->input('search.value'))) {
        $search = $request->input('search.value');

        $query->where(function($q) use ($search) {
            $q->where('lu.nama_tamu', 'LIKE', "%{$search}%")
              ->orWhere('lu.phone', 'LIKE', "%{$search}%")
              ->orWhere('lu.tamu_dari', 'LIKE', "%{$search}%")
              ->orWhere('lu.address', 'LIKE', "%{$search}%")
              ->orWhere('g.nama_group_tamu', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $query->count();
    }

    // 4. Logic Sorting & Pagination
    $limit = $request->input('length');
    $start = $request->input('start');
    $orderIndex = $request->input('order.0.column');
    $order = $columns[$orderIndex] ?? 'lu.id_tamu'; // Fallback ke id_tamu
    $dir = $request->input('order.0.dir');

    $data = $query->select(
            'lu.id_tamu',
            'lu.nama_tamu',
            'lu.phone',
            'lu.tamu_dari',
            'lu.address',
            'lu.is_sent', // Dibutuhkan buat logic tombol di JS
            'g.nama_group_tamu as group_nama',
            'w.slug',
            'w.m_pria_panggilan', // Tambahin ini biar WA gak undefined
            'w.m_wanita_panggilan'
        )
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

    $json_data = [
        "draw"            => intval($request->input('draw')),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    ];

    return response()->json($json_data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'wedding_id' => 'required',
      'nama_tamu.*' => 'required',
      'no_hp.*' => 'required',
      'undangan_dari.*' => 'required',
      'group_undangan.*' => 'required',
    ]);

    try {
      $weddingId = $request->wedding_id;
      DB::transaction(function () use ($request, $weddingId)
      {
        foreach ($request->nama_tamu as $index => $nama)
        {
          list_undangan::create([
            'nama_tamu' => $nama,
            'wedding_id' => $weddingId,
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

  public function bulkSend(Request $request)
  {
    $ids = $request->ids;

    if (empty($ids)) {
      return response()->json(['message' => 'Gak ada ID terpilih'], 400);
    }

    try {
      // 1. Ambil data lengkap: tamu + slug wedding + nama mempelai
      $daftarTamu = list_undangan::join('weddings', 'tamu.wedding_id', '=', 'weddings.id')
        ->whereIn('tamu.id_tamu', $ids)
        ->select(
            'tamu.id_tamu',
            'tamu.nama_tamu',
            'tamu.phone',
            'weddings.slug',
            'weddings.m_pria_panggilan',
            'weddings.m_wanita_panggilan'
        )
        ->get();

      if ($daftarTamu->isEmpty()) {
        return response()->json(['message' => 'Data tamu tidak ditemukan'], 404);
      }

      // 2. Tarik credential aman langsung dari file .env
      $wablasToken   = env('WABLAS_TOKEN');
      $wablasSecret  = env('WABLAS_SECRET_KEY');
      $tokenGabungan = $wablasToken . '.' . $wablasSecret;

      // Ambil Base URL domain secara dinamis
      $baseUrl = url('/');

      // 3. Bungkus semua nomor dan pesan ke dalam array 'data' sesuai format bulk Wablas
      $dataPesan = [];
      foreach ($daftarTamu as $tamu) {

        $nomorRaw = trim($tamu->phone); // Ambil nomor asli dari database

        // Cek jika nomor diawali angka '0', potong angka 0 nya lalu ganti jadi '62'
        if (strpos($nomorRaw, '0') === 0) {
          $nomorWablas = '62' . substr($nomorRaw, 1);
        } elseif (strpos($nomorRaw, '+62') === 0) {
          $nomorWablas = substr($nomorRaw, 1);
        } else {
          $nomorWablas = $nomorRaw;
        }

        // Generate variabel link dan nama secara dinamis per tamu
        $guestNameUrl  = rawurlencode($tamu->nama_tamu);
        $guestNameText = $tamu->nama_tamu;

        $weddingLink   = "{$baseUrl}/wedding/{$tamu->slug}/invitation/to/{$guestNameUrl}";
        $weddingName   = "{$tamu->m_pria_panggilan} & {$tamu->m_wanita_panggilan}";

        // Susun template pesan resmi (Rapat kiri mutlak biar rapi di WA)
        $isiPesan = "Kepada Yth.\n" .
"Bapak/Ibu/Saudara/i\n" .
"*{$guestNameText}*\n" .
"_______\n\n" .
"Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami.\n\n" .
"Berikut link undangan kami, untuk info lengkap dari acara, bisa kunjungi :\n\n" .
"{$weddingLink}\n\n" .
"Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n" .
"Terima Kasih\n\n" .
"Hormat kami,\n" .
"{$weddingName}\n" .
"________";

        $dataPesan[] = [
          'phone'   => $nomorWablas,
          'message' => $isiPesan,
        ];
      }

      // 4. Susun payload utama beserta Secret Key dari .env
      $payload = [
        'secret' => $wablasSecret,
        'data'   => $dataPesan
      ];

      // 5. Eksekusi tembak ke Wablas
      $response = \Http::withOptions([
        'curl' => [
          CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
        ]
      ])->withHeaders([
        'Authorization' => $tokenGabungan,
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json'
      ])->post('https://tegal.wablas.com/api/v2/send-message', $payload);

      if ($response->successful()) {
        return response()->json([
          'status'  => 'success',
          'message' => 'Bulk pesan berhasil didorong ke antrean Wablas.',
          'detail'  => $response->json()
        ], 200);
      } else {
        return response()->json([
          'status'     => 'failed',
          'message'    => 'Wablas menolak request bulk.',
          'error_code' => $response->status(),
          'detail'     => $response->json()
        ], $response->status());
      }
    } catch (\Exception $e) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Terjadi kesalahan sistem saat memproses bulk send.',
        'detail'  => $e->getMessage()
      ], 500);
    }
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
