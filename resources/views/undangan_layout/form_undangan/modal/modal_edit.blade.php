<!-- Modal Edit -->
<style>
  .step-wizard-edit {
    display: none;
    /* Sembunyikan semua step secara default */
  }

  .step-wizard-edit.active {
    display: block !important;
    /* Munculkan hanya yang active */
  }

  /* Style untuk Node (Bulatan angka) */
  .step-node-edit {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    position: relative;
    z-index: 2;
  }

  .step-node-edit.active {
    background: #0d6efd;
    color: white;
  }

  .step-node-edit.completed {
    background: #198754;
    color: white;
  }

</style>
<div class="modal fade" id="editForm" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
  aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Undangan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Progress Steps -->
        <div class="wizard-steps px-5">
          <div class="step-node-edit active" id="node-edit-1">1</div>
          <div class="step-node-edit" id="node-edit-2">2</div>
          <div class="step-node-edit" id="node-edit-3">3</div>
          <div class="step-node-edit" id="node-edit-4">4</div>
        </div>

        <form id="editWeddingWizard" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" id="edit_id">

          <!-- Step 1: Informasi Dasar -->
          <div class="step-wizard-edit active" id="step-edit-1">
            <h5 class="fw-bold mb-4">Step 1: Informasi Dasar & URL</h5>
            <div class="bg-light p-4 rounded mb-4">
              <label class="fw-bold mb-2">URL Undangan (Slug)</label>
              <div class="input-group">
                <span class="input-group-text bg-secondary text-white">undangan.com/</span>
                <input type="text" id="edit_slug" name="slug" class="form-control bg-white" readonly required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Quote / Ayat Suci</label>
              <textarea id="edit_editor" name="quote_quran" class="form-control" rows="4"></textarea>
            </div>
            <div class="text-end">
              <button type="button" class="btn btn-primary next-step-edit px-4">Lanjut <i
                  class="bi bi-arrow-right"></i></button>
            </div>
          </div>

          <!-- Step 2: Profil Mempelai -->
          <div class="step-wizard-edit" id="step-edit-2">
            <h5 class="fw-bold mb-4 text-center">Step 2: Profil Mempelai</h5>
            <div class="row">
              <!-- Pria -->
              <div class="col-md-6 border-end">
                <div class="p-3">
                  <h6 class="text-info fw-bold mb-3 text-center border-bottom pb-2">Mempelai Pria</h6>
                  <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                      <img id="prev_edit_pria" src="" class="rounded-circle shadow-sm border border-3 border-white"
                        style="width: 130px; height: 130px; object-fit: cover;">
                      <label for="edit_foto_pria"
                        class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle shadow"><i
                          class="bi bi-camera-fill"></i></label>
                      <input type="file" id="edit_foto_pria" name="foto_pria" class="d-none profile-preview-edit"
                        data-target="prev_edit_pria">
                    </div>
                  </div>
                  <input type="text" id="edit_m_pria" name="m_pria" class="form-control mb-3"
                    placeholder="Nama Lengkap Pria" required>
                  <div class="row g-2 mb-3">
                    <div class="col-sm-8">
                      <input type="text" id="edit_m_pria_panggilan" name="m_pria_panggilan" class="form-control"
                        placeholder="Panggilan">
                    </div>
                    <div class="col-sm-4">
                      <input type="number" id="edit_m_pria_anak_ke" name="m_pria_anak_ke" class="form-control"
                        placeholder="Anak Ke-">
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-6"><input type="text" id="edit_m_pria_ayah" name="m_pria_ayah" class="form-control"
                        placeholder="Nama Ayah"></div>
                    <div class="col-6"><input type="text" id="edit_m_pria_ibu" name="m_pria_ibu" class="form-control"
                        placeholder="Nama Ibu"></div>
                  </div>
                </div>
              </div>
              <!-- Wanita -->
              <div class="col-md-6 ps-md-4">
                <div class="p-3">
                  <h6 class="text-danger fw-bold mb-3 text-center border-bottom pb-2">Mempelai Wanita</h6>
                  <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                      <img id="prev_edit_wanita" src="" class="rounded-circle shadow-sm border border-3 border-white"
                        style="width: 130px; height: 130px; object-fit: cover;">
                      <label for="edit_foto_wanita"
                        class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle shadow"><i
                          class="bi bi-camera-fill"></i></label>
                      <input type="file" id="edit_foto_wanita" name="foto_wanita" class="d-none profile-preview-edit"
                        data-target="prev_edit_wanita">
                    </div>
                  </div>
                  <input type="text" id="edit_m_wanita" name="m_wanita" class="form-control mb-3"
                    placeholder="Nama Lengkap Wanita" required>
                  <div class="row g-2 mb-3">
                    <div class="col-sm-8">
                      <input type="text" id="edit_m_wanita_panggilan" name="m_wanita_panggilan" class="form-control"
                        placeholder="Panggilan">
                    </div>
                    <div class="col-sm-4">
                      <input type="number" id="edit_m_wanita_anak_ke" name="m_wanita_anak_ke" class="form-control"
                        placeholder="Anak Ke-">
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-6"><input type="text" id="edit_m_wanita_ayah" name="m_wanita_ayah"
                        class="form-control" placeholder="Nama Ayah"></div>
                    <div class="col-6"><input type="text" id="edit_m_wanita_ibu" name="m_wanita_ibu"
                        class="form-control" placeholder="Nama Ibu"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-4 d-flex justify-content-between">
              <button type="button" class="btn btn-secondary prev-step-edit">Kembali</button>
              <button type="button" class="btn btn-primary next-step-edit">Lanjut ke Acara <i
                  class="bi bi-arrow-right"></i></button>
            </div>
          </div>

          <!-- Step 3: Acara -->
          <div class="step-wizard-edit" id="step-edit-3">
            <h5 class="fw-bold mb-4">Step 3: Detail Acara & Musik</h5>
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label">Tgl Akad</label>
                <input type="datetime-local" id="edit_tgl_akad" name="tgl_akad" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Tgl Resepsi</label>
                <input type="datetime-local" id="edit_tgl_resepsi" name="tgl_resepsi" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Nama Gedung</label>
                <input type="text" id="edit_lokasi_nama" name="lokasi_nama" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Maps URL</label>
                <input type="url" id="edit_Maps_url" name="Maps_url" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Alamat Lengkap</label>
                <textarea id="edit_lokasi_address" name="lokasi_address" class="form-control" rows="2"></textarea>
              </div>
            </div>
            <div class="bg-light p-3 rounded mb-4">
              <div class="mb-2 border rounded bg-white">
                <small class="text-muted d-block mb-1">
                  <i class="bi bi-music-note-beamed"></i> Path Musik saat ini:
                </small>
                <code id="current_music_name" class="d-block mb-2 text-break" style="font-size: 11px;">Belum ada
                  musik</code>

                <audio id="audio_preview" controls class="w-100" style="height: 30px;">
                  <source src="" id="audio_source" type="audio/mpeg">
                  Browser kamu tidak mendukung pemutar musik.
                </audio>
              </div>
              <label class="form-label fw-bold">Update Music (Kosongkan jika tidak ganti)</label>
              <input type="file" name="music_file" class="form-control" accept="audio/mp3">
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary prev-step-edit">Kembali</button>
              <button type="button" class="btn btn-primary next-step-edit">Lanjut ke Galeri <i
                  class="bi bi-arrow-right"></i></button>
            </div>
          </div>

          <!-- Step 4: Story & Gallery -->
          <div class="step-wizard-edit" id="step-edit-4">
            <h5 class="fw-bold mb-4">Step 4: Love Story & Galeri Foto</h5>

            <!-- Story Update -->
            <div class="mb-4">
              <div class="d-flex justify-content-between mb-2">
                <h6 class="fw-bold">Cerita Cinta</h6>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-story-edit"><i
                    class="bi bi-plus-circle"></i> Tambah</button>
              </div>
              <div id="edit-story-container">
                <!-- Data story akan di-append lewat JS -->
              </div>
            </div>

            <!-- Gallery Update -->
            <div class="mb-4">
              <div class="d-flex justify-content-between mb-2">
                <h6 class="fw-bold">Galeri Foto</h6>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-photo-edit"><i
                    class="bi bi-plus-circle"></i> Tambah</button>
              </div>
              <div class="row g-3" id="edit-photo-container">
                <!-- Data galeri akan di-append lewat JS -->
              </div>
            </div>

            <div class="d-flex justify-content-between mt-5">
              <button type="button" class="btn btn-secondary prev-step-edit">Kembali</button>
              <button type="submit" class="btn btn-warning px-5 fw-bold">SAVE CHANGES <i
                  class="bi bi-check-all ms-1"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  function generateSlug(text) {
    return text.toString().toLowerCase()
      .trim()
      .replace(/\s+/g, '-') // Spasi jadi -
      .replace(/[^\w\-]+/g, '') // Hapus simbol aneh
      .replace(/\-\-+/g, '-') // Double dash jadi single
      .replace(/^-+/, '') // Hapus dash di awal
      .replace(/-+$/, ''); // Hapus dash di akhir
  }

  $(document).on('input', '#edit_m_pria_panggilan, #edit_m_wanita_panggilan', function () {
    let pria = $('#edit_m_pria_panggilan').val();
    let wanita = $('#edit_m_wanita_panggilan').val();

    // Gabungin dan generate
    let combined = pria + '-' + wanita;
    let slug = generateSlug(combined);

    // Tembak ke input slug
    $('#edit_slug').val(slug);
  });

  $(document).ready(function () {
    let editEditor;
    let currentEditStep = 1;

    // Definisikan BASE_URL supaya asset() Laravel bisa dibaca di JS
    const BASE_URL = "{{ asset('') }}";

    // Init CKEditor Edit
    ClassicEditor.create(document.querySelector('#edit_editor')).then(editor => {
      editEditor = editor;
    });

    // --- A. FETCH DATA ---
    $(document).on('click', '.btn-edit-wedding', function () {
      let id = $(this).data('id');

      // Reset Wizard ke Step 1
      currentEditStep = 1;
      showStepEdit(currentEditStep);

      $.ajax({
        url: `/wedding/edit/${id}`,
        type: "GET",
        success: function (res) {
          let d = res.data;

          // Step 1
          $('#edit_id').val(d.id);
          $('#edit_slug').val(d.slug);
          editEditor.setData(d.quote_quran || '');

          // Step 2 (Pria & Wanita)
          $('#edit_m_pria').val(d.m_pria);
          $('#edit_m_pria_panggilan').val(d.m_pria_panggilan);
          $('#edit_m_pria_anak_ke').val(d.m_pria_anak_ke);
          $('#edit_m_pria_ayah').val(d.m_pria_ayah);
          $('#edit_m_pria_ibu').val(d.m_pria_ibu);

          // Perbaikan Path Foto Pria
          let fotoPria = d.foto_pria ? (BASE_URL + d.foto_pria) : 'https://via.placeholder.com/150';
          $('#prev_edit_pria').attr('src', fotoPria);

          $('#edit_m_wanita').val(d.m_wanita);
          $('#edit_m_wanita_panggilan').val(d.m_wanita_panggilan);
          $('#edit_m_wanita_anak_ke').val(d.m_wanita_anak_ke);
          $('#edit_m_wanita_ayah').val(d.m_wanita_ayah);
          $('#edit_m_wanita_ibu').val(d.m_wanita_ibu);

          // Perbaikan Path Foto Wanita
          let fotoWanita = d.foto_wanita ? (BASE_URL + d.foto_wanita) : 'https://via.placeholder.com/150';
          $('#prev_edit_wanita').attr('src', fotoWanita);

          // Step 3 (Acara)
          $('#edit_tgl_akad').val(d.tgl_akad ? d.tgl_akad.replace(' ', 'T').substring(0, 16) : '');
          $('#edit_tgl_resepsi').val(d.tgl_resepsi ? d.tgl_resepsi.replace(' ', 'T').substring(0, 16) :
            '');
          $('#edit_lokasi_nama').val(d.lokasi_nama);
          $('#edit_lokasi_address').val(d.lokasi_address);
          $('#edit_Maps_url').val(d.maps_url);

          // --- BAGIAN MUSIK ---
          if (d.music_path) {
            let musicName = d.music_path.split('/').pop();
            $('#current_music_name').text(musicName);

            // Tembak src langsung ke tag audio agar lebih stabil
            $('#audio_preview').attr('src', BASE_URL + d.music_path);
            $('#audio_preview')[0].load();
            $('#audio_preview').show();
          } else {
            $('#current_music_name').text('Belum ada musik diunggah');
            $('#audio_preview').hide().attr('src', '');
          }

          // --- BAGIAN STORY (Mapping sesuai JSON: title_moment & cerita) ---
          $('#edit-story-container').empty();
          if (d.stories && d.stories.length > 0) {
            d.stories.forEach(s => {
              // y = year, t = title_moment, desc = cerita
              appendStoryEdit(s.year, s.title_moment, s.cerita);
            });
          }

          // --- BAGIAN GALLERY (Mapping sesuai JSON: image_path) ---
          $('#edit-photo-container').empty();
          if (d.galleries && d.galleries.length > 0) {
            d.galleries.forEach(g => {
              appendPhotoEdit(g.id, g.image_path);
            });
          }

          $('#editForm').modal('show');
        }
      });
    });

    // --- B. LOGIC WIZARD ---
    function showStepEdit(step) {
      $('.step-wizard-edit').hide().removeClass('active');
      $(`#step-edit-${step}`).show().addClass('active');

      $('.step-node-edit').removeClass('active completed');
      for (let i = 1; i <= step; i++) {
        if (i < step) $(`#node-edit-${i}`).addClass('completed');
        if (i === step) $(`#node-edit-${i}`).addClass('active');
      }
    }

    $('.next-step-edit').click(function () {
      if (currentEditStep < 4) {
        currentEditStep++;
        showStepEdit(currentEditStep);
      }
    });

    $('.prev-step-edit').click(function () {
      if (currentEditStep > 1) {
        currentEditStep--;
        showStepEdit(currentEditStep);
      }
    });

    // --- C. DYNAMIC STORY ---
    function appendStoryEdit(y = '', t = '', desc = '') {
      // Pastikan jika null tampil string kosong
      let valY = y ? y : '';
      let valT = t ? t : '';
      let valD = desc ? desc : '';

      let html = `
        <div class="card shadow-sm mb-3 story-item-edit">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-3"><input type="text" name="story_year[]" class="form-control" placeholder="Tahun" value="${valY}"></div>
                    <div class="col-md-8"><input type="text" name="story_title[]" class="form-control" placeholder="Judul" value="${valT}"></div>
                    <div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-story-edit w-100"><i class="bi bi-trash"></i></button></div>
                    <div class="col-12 mt-2"><textarea name="story_description[]" class="form-control" rows="2">${valD}</textarea></div>
                </div>
            </div>
        </div>`;
      $('#edit-story-container').append(html);
    }
    $('#add-story-edit').click(() => appendStoryEdit());

    // --- D. DYNAMIC GALLERY ---
    function appendPhotoEdit(id = null, image_path = null) {
      let imgSrc = image_path ? (BASE_URL + image_path) : 'https://via.placeholder.com/150';

      let html = `
        <div class="col-md-4 photo-item-edit">
          <div class="card shadow-sm h-100">
            <img src="${imgSrc}" class="card-img-top preview-galeri-edit" style="height:fit-content; object-fit:cover;">
            <div class="card-body p-2">
              <input type="hidden" name="existing_gallery_ids[]" value="${id}">
              <input type="file" name="gallery_photos[]" class="form-control form-control-sm mb-1 galeri-input-edit">
              <button type="button" class="btn btn-danger btn-sm w-100 remove-photo-edit"><i class="bi bi-trash"></i></button>
            </div>
          </div>
        </div>`;
      $('#edit-photo-container').append(html);
    }
    $('#add-photo-edit').click(() => appendPhotoEdit());

    // Remove Item
    $(document).on('click', '.remove-story-edit, .remove-photo-edit', function () {
      $(this).closest('.story-item-edit, .photo-item-edit').remove();
    });

    // --- E. SUBMIT ---
    $('#editWeddingWizard').submit(function (e) {
      e.preventDefault();
      let formData = new FormData(this);
      formData.set('quote_quran', editEditor.getData());

      $.ajax({
        url: `/wedding/update/${$('#edit_id').val()}`,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
          alert("Berhasil!");
          window.location.reload();
        }
      });
    });
  });

</script>
