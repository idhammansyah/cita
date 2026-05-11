<?php

namespace App\Http\Controllers\TemplateController;

use App\Models\Wedding\WeddingModel;
use App\Models\Undangan\Wedding\StoryUndangan;
use App\Models\Undangan\Wedding\GalleryWedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Template extends Controller
{
  public function wedding()
  {
    $data = [
      'title' => 'Wedding Data',
      'weddings' => $this->wedding->all()
    ];

    return view('undangan_layout.form_undangan.form',
      compact('data'));
  }

  public function save_data(Request $request)
  {
    // Validasi data input
    $request->validate([
      'slug' => 'required|unique:weddings,slug',
      'm_pria' => 'required',
      'm_wanita' => 'required',
      'foto_pria' => 'nullable|image|max:5048',
      'foto_wanita' => 'nullable|image|max:5048',
      'music_file' => 'nullable|mimes:mp3,mpeg|max:10120',
    ]);

    try {
      \DB::beginTransaction();

      $wedding = $this->wedding;
      $wedding->slug = $request->slug;
      $wedding->quote_quran = $request->quote_quran;

      // Data Pria
      $wedding->m_pria = $request->m_pria;
      $wedding->m_pria_panggilan = $request->m_pria_panggilan;
      $wedding->m_pria_anak_ke = $request->m_pria_anak_ke;
      $wedding->m_pria_ayah = $request->m_pria_ayah;
      $wedding->m_pria_ibu = $request->m_pria_ibu;

      // Data Wanita
      $wedding->m_wanita = $request->m_wanita;
      $wedding->m_wanita_panggilan = $request->m_wanita_panggilan;
      $wedding->m_wanita_anak_ke = $request->m_wanita_anak_ke;
      $wedding->m_wanita_ayah = $request->m_wanita_ayah;
      $wedding->m_wanita_ibu = $request->m_wanita_ibu;

      // Detail Acara
      $wedding->tgl_akad = $request->tgl_akad;
      $wedding->tgl_resepsi = $request->tgl_resepsi;
      $wedding->lokasi_nama = $request->lokasi_nama;
      $wedding->lokasi_address = $request->lokasi_address;
      $wedding->maps_url = $request->Maps_url;

      // Handle Upload Foto Profil & Musik
      if ($request->hasFile('foto_pria')) {
        $filePria = $request->file('foto_pria');
        $namePria = time() . '_pria_' . $filePria->getClientOriginalName();
        // Simpan ke: public/assets/mempelai/photo_mempelai
        $filePria->move(public_path('assets/mempelai/photo_mempelai'), $namePria);
        $wedding->foto_pria = 'assets/mempelai/photo_mempelai/' . $namePria;
      }

      if ($request->hasFile('foto_wanita')) {
        $fileWanita = $request->file('foto_wanita');
        $nameWanita = time() . '_wanita_' . $fileWanita->getClientOriginalName();
        $fileWanita->move(public_path('assets/mempelai/photo_mempelai'), $nameWanita);
        $wedding->foto_wanita = 'assets/mempelai/photo_mempelai/' . $nameWanita;
      }

      if ($request->hasFile('music_file')) {
        $fileMusic = $request->file('music_file');
        $nameMusic = time() . '_' . $fileMusic->getClientOriginalName();
        // Simpan ke: public/assets/mempelai/music
        $fileMusic->move(public_path('assets/mempelai/music'), $nameMusic);
        $wedding->music_path = 'assets/mempelai/music/' . $nameMusic;
      }

      $wedding->created_by = \Auth::user()->name ?? 'System';
      $wedding->save();

      // 2. Simpan ke table stories_undangan
      if ($request->has('story_year')) {
        foreach ($request->story_year as $key => $year) {
          if (!empty($year)) {
            \DB::table('stories_undangan')->insert([
              'weddings_id'  => $wedding->id,
              'title_moment' => $request->story_title[$key],
              'year'         => $year,
              'cerita'       => $request->story_description[$key],
              'created_at'   => now(),
              'created_by'   => \Auth::user()->name ?? 'System'
            ]);
          }
        }
      }

      // 3. Handle Galleries
      if ($request->hasFile('gallery_files')) {
        foreach ($request->file('gallery_files') as $file) {
          $nameGallery = time() . '_gallery_' . $file->getClientOriginalName();
          // Simpan ke: public/assets/mempelai/galleries
          $file->move(public_path('assets/mempelai/galleries'), $nameGallery);
          $pathGallery = 'assets/mempelai/galleries/' . $nameGallery;

          \DB::table('galleries_wedding')->insert([
            'wedding_id' => $wedding->id,
            'image_path' => $pathGallery,
            'created_at' => now(),
            'created_by' => \Auth::user()->name ??'System'
          ]);
        }
      }

      \DB::commit();
      return response()->json(['status' => 'success', 'message' => 'Undangan berhasil dibuat!']);

    } catch (\Exception $e) {
      \DB::rollBack();
      return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
  }

  public function invitation($slug)
  {
    $wedding = $this->wedding->with([
      'stories' => function($query)
      {
        $query->where('is_deleted', 0);
      },
      'galleries' => function($query)
      {
        $query->where('is_deleted', 0); // Hanya ambil gallery yang aktif
      }, 'rsvps'
    ])
    ->where('is_deleted', 0)
    ->where('slug', $slug)
    ->firstOrFail();

    $ucapanS = DB::table('rsvps') // Sesuaikan nama tabelmu
        ->where('wedding_id', $wedding->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $tamu = DB::table('tamu')
    ->join('weddings', 'tamu.wedding_id', '=', 'weddings.id')
    ->select(
        'tamu.*',
        'weddings.slug',
        'weddings.m_pria_panggilan',
        'weddings.m_wanita_panggilan',
        'weddings.tgl_akad'
    )
    ->first();

    // 4. Lempar ke view
    return view('undangan_layout.undangan_digital.index', [
        'slug'  => $slug,
        'wedding' => $wedding,
        'ucapanS'   => $ucapanS
    ]);
  }

  public function edit($id)
  {
    $wedding = $this->wedding->with(['stories' => function($query)
      {
        $query->where('is_deleted', 0);
      },
      'galleries' => function($query)
      {
        $query->where('is_deleted', 0); // Hanya ambil gallery yang aktif
      }])->findOrFail($id);

    return response()->json([
      'status' => 'success',
      'data'   => $wedding
    ]);
  }

  public function update(Request $request, $id)
  {
    // 1. Validasi (Saran: kecilkan max size foto wanita, itu terlalu besar)
    $request->validate([
      'slug' => 'required|unique:weddings,slug,' . $id,
        'm_pria' => 'required',
        'm_wanita' => 'required',
        'foto_pria' => 'nullable|image|max:5048',
        'foto_wanita' => 'nullable|image|max:5048',
        'music_file' => 'nullable|mimes:mp3|max:5000',
        'gallery_photos.*' => 'nullable|image|max:5048',
    ]);

    DB::beginTransaction();
    try
    {
      $wedding = $this->wedding->findOrFail($id);

      // 2. Ambil data teks
      $data = $request->only([
        'slug', 'quote_quran', 'm_pria', 'm_pria_panggilan', 'm_pria_anak_ke',
        'm_pria_ayah', 'm_pria_ibu', 'm_wanita', 'm_wanita_panggilan',
         'm_wanita_anak_ke', 'm_wanita_ayah', 'm_wanita_ibu', 'tgl_akad',
         'tgl_resepsi', 'lokasi_nama', 'lokasi_address', 'maps_url'
      ]);

      if ($request->hasFile('foto_pria')) {
        if ($wedding->foto_pria && File::exists(public_path($wedding->foto_pria))) {
          File::delete(public_path($wedding->foto_pria));
        }
        $file = $request->file('foto_pria');
        $fileName = time() . '_pria.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/mempelai/photo_mempelai'), $fileName);
        $data['foto_pria'] = 'assets/mempelai/photo_mempelai/' . $fileName;
      }

      if ($request->hasFile('foto_wanita')) {
        if ($wedding->foto_wanita && File::exists(public_path($wedding->foto_wanita))) {
          File::delete(public_path($wedding->foto_wanita));
        }
        $file = $request->file('foto_wanita');
        $fileName = time() . '_wanita.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/mempelai/photo_mempelai'), $fileName);
            $data['foto_wanita'] = 'assets/mempelai/photo_mempelai/' . $fileName;
        }

        if ($request->hasFile('music_file')) {
            if ($wedding->music_path && File::exists(public_path($wedding->music_path))) {
                File::delete(public_path($wedding->music_path));
            }
            $file = $request->file('music_file');
            $fileName = time() . '_music.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/mempelai/music'), $fileName);
            $data['music_path'] = 'assets/mempelai/music/' . $fileName;
        }

        $wedding->update($data);

        $existingStoryIds = $request->story_ids ?? []; // Pastikan di modal edit kamu tambahkan <input type="hidden" name="story_ids[]" value="${s.id}">

        // Set is_deleted = 1 untuk story yang TIDAK ADA di list input (artinya dihapus di UI)
        StoryUndangan::where('weddings_id', $id)
            ->whereNotIn('id', $existingStoryIds)
            ->update(['is_deleted' => 1]);

        if ($request->story_year) {
            foreach ($request->story_year as $key => $year) {
                $storyId = $request->story_ids[$key] ?? null;

                $storyData = [
                    'weddings_id' => $id,
                    'year' => $year,
                    'title_moment' => $request->story_title[$key],
                    'cerita' => $request->story_description[$key],
                    'is_deleted' => 0
                ];

                if ($storyId) {
                    // Jika ada ID-nya, update data yang sudah ada
                    StoryUndangan::where('id', $storyId)->update($storyData);
                } else {
                    // Jika tidak ada ID-nya, buat baru
                    StoryUndangan::create($storyData);
                }
            }
        }

        // --- 4. LOGIKA UPDATE GALLERY (SOFT DELETE) ---
        $existingGalleryIds = $request->existing_gallery_ids ?? []; // ID gallery yang masih dipertahankan di UI

        // Set is_deleted = 1 untuk gallery yang dihapus di UI
        GalleryWedding::where('wedding_id', $id)
            ->whereNotIn('id', $existingGalleryIds)
            ->update(['is_deleted' => 1]);

        // Upload Gallery Baru
        if ($request->hasFile('gallery_photos')) {
            foreach ($request->file('gallery_photos') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/mempelai/galleries'), $fileName);

                GalleryWedding::create([
                    'wedding_id' => $id,
                    'image_path' => 'assets/mempelai/galleries/' . $fileName,
                    'is_deleted' => 0
                ]);
            }
        }

        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Undangan berhasil diperbarui!']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
  }
}
