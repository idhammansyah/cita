<?php

namespace App\Http\Controllers\ReimbursementController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Reimbursement\ReimbursementCategory;
use App\Models\Reimbursement\ReimbursementEmployee;
use App\Mail\NewReimbursementNotification;
use Illuminate\Support\Facades\Mail;

class Reimbursement extends Controller
{
  public function index()
  {
    $user = Auth::user();
    if($user->role_id != 3) {
      $reimbursements = DB::table('reimburse_employee')
      ->join('reimburse_category', 'reimburse_employee.id_category_reimburse', '=', 'reimburse_category.id')
      ->join('users', 'reimburse_employee.id_user', '=', 'users.id')
      ->select('reimburse_employee.*', 'reimburse_category.category_name', 'users.full_name')
      ->where('reimburse_employee.is_deleted', 0)
      ->get();
    } else {
      $reimbursements = DB::table('reimburse_employee')
      ->join('reimburse_category', 'reimburse_employee.id_category_reimburse', '=', 'reimburse_category.id')
      ->join('users', 'reimburse_employee.id_user', '=', 'users.id')
      ->select('reimburse_employee.*', 'reimburse_category.category_name', 'users.full_name')
      ->where('reimburse_employee.id_user', $user->id)
      ->where('reimburse_employee.is_deleted', 0)
      ->get();
    }

    $reimburse_category = ReimbursementCategory::where('is_deleted', 0)->get();

    return view('reimbursement.index', compact('user', 'reimbursements', 'reimburse_category'));
  }

  public function store(Request $request)
  {
    // Validasi role_id: hanya role_id 1 (Admin) atau 3 (Employee) yang bisa mengajukan reimbursement
    // Perhatikan: "menambahkan menu" di pesan error sepertinya typo, seharusnya "mengajukan reimbursement".
    if (Auth::user()->role_id != 3 && Auth::user()->role_id != 1) {
      abort(403, 'Anda tidak diizinkan mengajukan reimbursement.'); // Menggunakan 403 Forbidden lebih tepat
    }

    $request->validate([
      'title' => 'required|string|max:255',
      'category_id' => 'required|exists:reimburse_category,id',
      'amount' => 'required|numeric|min:0.01',
      'description' => 'nullable|string',
      'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Mengaktifkan kembali validasi upload file
    ]);

    $category = ReimbursementCategory::find($request->category_id);
    if (!$category) {
      return back()->withErrors(['category_id' => 'Kategori tidak ditemukan.']);
    }

    // Hitung total pengeluaran user untuk kategori ini di bulan berjalan
    $currentMonthTotal = ReimbursementEmployee::where('id_user', Auth::user()->id)
    ->where('id_category_reimburse', $request->category_id)
    ->whereMonth('submitted_at', now()->month)
    ->whereYear('submitted_at', now()->year)
    ->sum('amount');

    // Cek validasi limit
    if (($currentMonthTotal + $request->amount) > $category->limit_per_month) {
      // Menggunakan withErrors agar pesan error muncul di input yang terkait (amount)
      return back()->withInput()->withErrors([
        'amount' => 'Pengajuan ini melebihi batas bulanan untuk kategori ' . $category->name . '. Limit: Rp' . number_format($category->limit_per_month, 0, ',', '.') . '. Total terpakai bulan ini: Rp' . number_format($currentMonthTotal, 0, ',', '.')
      ]);
    }

    // Proses upload file
    $filePath = null; // Inisialisasi path file
    // Proses upload file jika ada
    if ($request->hasFile('attachment')) {
      // Simpan file ke direktori 'reimbursement_attachments' di dalam 'storage/app/public'
      // dan dapatkan path relatifnya (e.g., 'reimbursement_attachments/gambar_abcdef.jpg')
      $filePath = $request->file('attachment')->store('reimbursement_attachments', 'public');
    }

    // Simpan data ke database
    // Tangkap instance model yang baru dibuat untuk diteruskan ke Mailable
    $reimbursement = ReimbursementEmployee::create([
      'title' => $request->title,
      'description' => $request->description,
      'amount' => $request->amount,
      'id_user' => Auth::user()->id,
      'id_category_reimburse' => $request->category_id,
      'status_reimburse' => 'Pending',
      'is_deleted' => 0, // Asumsi default is_deleted adalah 0
      'submitted_at' => now(),
      'bukti_transaksi' => $filePath
    ]);

    logReimbursementActivity($reimbursement->id, 'pengajuan', 'Pengajuan reimbursement baru dibuat.');


    // **MENGAMBIL EMAIL MANAGER DARI DATABASE DAN MENGIRIM NOTIFIKASI**

    // Cara 1: Ambil semua manajer (jika ada banyak dan ingin kirim ke semua)
    // Asumsi 'role_id = 2' adalah manajer
    $managers = User::where('role_id', 2)->get();
    if ($managers->isNotEmpty()) {
      foreach ($managers as $manager) {
        // Mengirim email ke setiap manajer menggunakan antrian

        Mail::to($manager->email)->send(new NewReimbursementNotification($reimbursement));
      }
    } else {
      // Opsional: Log atau berikan pesan jika tidak ada manajer yang ditemukan
      abort(404, 'Tidak ada manajer ditemukan untuk menerima notifikasi reimbursement.');
    }

    // Cara 2: Jika hanya ingin kirim ke 1 manajer saja (misalnya manajer pertama yang ditemukan)
    /*
    $manager = User::where('role_id', 2)->first(); // Ambil manajer pertama

    if ($manager) {
      Mail::to($manager->email)->send(new NewReimbursementNotification($reimbursement));
    } else {
      \Log::warning('Tidak ada manajer ditemukan untuk menerima notifikasi reimbursement.');
    }
    */

    return redirect()->route('reimbursement-menu')->with('success', 'Pengajuan reimbursement berhasil diajukan dan notifikasi telah dikirim ke manager!');
  }

  public function approve($id)
  {
    $reimburse = ReimbursementEmployee::findOrFail($id);
    $reimburse->status_reimburse = 'Approved';
    $reimburse->approved_at = now();
    $reimburse->save();

    logReimbursementActivity($id, 'approve', 'Reimbursement disetujui.');


    return redirect()->back()->with('success', 'Reimbursement disetujui.');
  }

  public function reject($id)
  {
    $reimburse = ReimbursementEmployee::findOrFail($id);
    $reimburse->status_reimburse = 'Rejected';
    $reimburse->approved_at = now();
    $reimburse->save();
    logReimbursementActivity($reimburse->id, 'reject', 'Reimbursement ditolak.');


    return redirect()->back()->with('success', 'Reimbursement ditolak.');
  }

  public function show($id)
  {
    $data = ReimbursementEmployee::select(
        'reimburse_employee.*',
        'reimburse_category.category_name',
        'users.full_name'
    )
    ->join('reimburse_category', 'reimburse_employee.id_category_reimburse', '=', 'reimburse_category.id')
    ->join('users', 'reimburse_employee.id_user', '=', 'users.id')
    ->where('reimburse_employee.id', $id)
    ->firstOrFail();

    return response()->json($data);
  }

  public function edit($id)
  {
    $user = Auth::user();
    if (!in_array($user->role_id, [1, 3])) {
      abort(403, 'Akses ditolak');
    }

    $reimbursement = ReimbursementEmployee::findOrFail($id);
    $categories = ReimbursementCategory::all();

    return view('reimbursement.edit', compact('reimbursement', 'categories'));
  }

  public function update(Request $request, $id)
  {
    $user = Auth::user();
    if (!in_array($user->role_id, [1, 3])) {
        abort(403, 'Akses ditolak');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'id_category_reimburse' => 'required|exists:reimburse_category,id',
        'bukti_transaksi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
    ]);

    $reimbursement = ReimbursementEmployee::findOrFail($id);

    // Update data dasar
    $reimbursement->title = $request->title;
    $reimbursement->amount = $request->amount;
    $reimbursement->description = $request->description;
    $reimbursement->id_category_reimburse = $request->id_category_reimburse;

    // Jika ada file baru
    if ($request->hasFile('bukti_transaksi')) {
        $file = $request->file('bukti_transaksi');
        $filename = $file->getClientOriginalName(); // nama asli file
        $path = 'reimbursement_attachments/' . $filename;

        // Hapus file lama kalau namanya sama atau berbeda
        if ($reimbursement->bukti_transaksi && Storage::disk('public')->exists($reimbursement->bukti_transaksi)) {
            Storage::disk('public')->delete($reimbursement->bukti_transaksi);
        }

        // Simpan file baru dengan nama dan path tetap
        $file->storeAs('reimbursement_attachments', $filename, 'public');
        $reimbursement->bukti_transaksi = $path;
    }

    $reimbursement->save();
    logReimbursementActivity($reimbursement->id, 'update', 'Data reimbursement diperbarui.');


    return redirect()->route('reimbursement-menu')->with('success', 'Data berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $user = Auth::user();
    if (!in_array($user->role_id, [1, 3])) {
        abort(403, 'Akses ditolak');
    }

    $reimbursement = ReimbursementEmployee::findOrFail($id);
    $reimbursement->is_deleted = 1;
    $reimbursement->save();

    return redirect()->route('reimbursement-menu')->with('success', 'Data berhasil dihapus.');
  }
}
