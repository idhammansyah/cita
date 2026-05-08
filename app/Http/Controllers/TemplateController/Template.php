<?php

namespace App\Http\Controllers\TemplateController;

use App\Models\Wedding\WeddingModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

  public function invitation()
  {
    return view('undangan_layout.undangan_digital.index');
  }
}
