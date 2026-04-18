@extends('layout.index')

@section('title', $data['title'])

@section('content')

{!! renderBreadcrumb() !!}
{!! flash_message() !!}
<style>
  /* Style untuk Progress Wizard */
  .step-wizard {
    display: none;
  }

  .step-wizard.active {
    display: block;
  }

  .wizard-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
    position: relative;
  }

  /* Garis penghubung antar node */
  .wizard-steps::before {
    content: "";
    position: absolute;
    top: 20px;
    left: 50px;
    right: 50px;
    height: 2px;
    background: #e9ecef;
    z-index: 1;
  }

  .step-node {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #6c757d;
    transition: all 0.3s;
    position: relative;
    z-index: 2;
  }

  .step-node.active {
    background: #0d6efd;
    color: white;
  }

  .step-node.completed {
    background: #198754;
    color: white;
  }

  .border-dashed {
    border: 2px dashed #dee2e6;
    transition: 0.3s;
  }

  .border-dashed:hover {
    border-color: #0d6efd;
  }

</style>
<section class="dashboard">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Fill the form</h5>
          <div class="wizard-steps px-5">
            <div class="step-node active" id="node-1">1</div>
            <div class="step-node" id="node-2">2</div>
            <div class="step-node" id="node-3">3</div>
            <div class="step-node" id="node-4">4</div>
          </div>

          <form id="weddingWizard" action="{{ url('save-wedding') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="step-wizard active" id="step-1">
              <h5 class="fw-bold mb-4">Step 1: Informasi Dasar & URL</h5>
              <div class="bg-light p-4 rounded mb-4">
                <label class="fw-bold mb-2">URL Undangan (Slug)</label>
                <div class="input-group">
                  <span class="input-group-text bg-secondary text-white">undangan.com/</span>
                  <input type="text" id="slug" name="slug" class="form-control bg-white"
                    placeholder="akan-terisi-otomatis" readonly required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Quote / Ayat Suci</label>
                <textarea name="quote_quran" class="form-control" rows="4"
                  placeholder="Masukkan ayat atau kata mutiara pembuka..."></textarea>
              </div>
              <div class="text-end">
                <button type="button" class="btn btn-primary next-step px-4">Lanjut ke Data Mempelai <i
                    class="bi bi-arrow-right ms-1"></i></button>
              </div>
            </div>

            <div class="step-wizard" id="step-2">
              <h5 class="fw-bold mb-4 text-center">Step 2: Profil Mempelai</h5>

              <div class="row">

                <div class="col-md-6 border-end">
                  <div class="p-3">
                    <h6 class="text-info fw-bold mb-3 border-bottom pb-2 text-center">
                      <i class="bi bi-gender-male me-1"></i>Mempelai Pria
                    </h6>

                    <div class="text-center mb-4">
                      <div class="position-relative d-inline-block">
                        <img id="prev_pria" src="https://via.placeholder.com/150?text=Foto+Pria" class="rounded-circle shadow-sm border border-3 border-white"
                          style="width: 130px; height: 130px; object-fit: cover; background: #f8f9fa;">

                        <label for="foto_pria"
                          class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle shadow"
                          title="Upload Foto">
                          <i class="bi bi-camera-fill"></i>
                        </label>
                        <input type="file" id="foto_pria" name="foto_pria" class="d-none profile-preview-input"
                          data-target="prev_pria" accept="image/jpeg, image/png">
                      </div>
                      <div class="small text-muted mt-2">Format: JPG/PNG, Maks: 2MB</div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label small fw-bold">Nama Lengkap & Gelar</label>
                      <input type="text" id="m_pria" name="m_pria" class="form-control"
                        placeholder="Contoh: Idham Mansyah, S.T." required>
                    </div>

                    <div class="row g-2 mb-3">
                      <div class="col-sm-8">
                        <label class="form-label small">Nama Panggilan</label>
                        <input type="text" name="m_pria_panggilan" class="form-control" placeholder="Idham">
                      </div>
                      <div class="col-sm-4">
                        <label class="form-label small">Anak Ke-</label>
                        <input type="number" name="m_pria_anak_ke" class="form-control" placeholder="1" min="1">
                      </div>
                    </div>

                    <div class="row g-2">
                      <div class="col-6 mb-3">
                        <label class="form-label small">Nama Ayah</label>
                        <input type="text" name="m_pria_ayah" class="form-control" placeholder="Nama Bapak">
                      </div>
                      <div class="col-6 mb-3">
                        <label class="form-label small">Nama Ibu</label>
                        <input type="text" name="m_pria_ibu" class="form-control" placeholder="Nama Ibu">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 ps-md-4">
                  <div class="p-3">
                    <h6 class="text-danger fw-bold mb-3 border-bottom pb-2 text-center">
                      <i class="bi bi-gender-female me-1"></i>Mempelai Wanita
                    </h6>

                    <div class="text-center mb-4">
                      <div class="position-relative d-inline-block">
                        <img id="prev_wanita" src="https://via.placeholder.com/150?text=Foto+Wanita" class="rounded-circle shadow-sm border border-3 border-white" style="width: 130px; height: 130px; object-fit: cover; background: #f8f9fa;">

                        <label for="foto_wanita"
                          class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle shadow"
                          title="Upload Foto">
                          <i class="bi bi-camera-fill"></i>
                        </label>
                        <input type="file" id="foto_wanita" name="foto_wanita" class="d-none profile-preview-input"
                          data-target="prev_wanita" accept="image/jpeg, image/png">
                      </div>
                      <div class="small text-muted mt-2">Format: JPG/PNG, Maks: 2MB</div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label small fw-bold">Nama Lengkap & Gelar</label>
                      <input type="text" id="m_wanita" name="m_wanita" class="form-control"
                        placeholder="Contoh: Riska Oktaviani, S.Kom" required>
                    </div>

                    <div class="row g-2 mb-3">
                      <div class="col-sm-8">
                        <label class="form-label small">Nama Panggilan</label>
                        <input type="text" name="m_wanita_panggilan" class="form-control" placeholder="Riska">
                      </div>
                      <div class="col-sm-4">
                        <label class="form-label small">Anak Ke-</label>
                        <input type="number" name="m_wanita_anak_ke" class="form-control" placeholder="2" min="1">
                      </div>
                    </div>

                    <div class="row g-2">
                      <div class="col-6 mb-3">
                        <label class="form-label small">Nama Ayah</label>
                        <input type="text" name="m_wanita_ayah" class="form-control" placeholder="Nama Bapak">
                      </div>
                      <div class="col-6 mb-3">
                        <label class="form-label small">Nama Ibu</label>
                        <input type="text" name="m_wanita_ibu" class="form-control" placeholder="Nama Ibu">
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="mt-4 d-flex justify-content-between border-top pt-3">
                <button type="button" class="btn btn-secondary prev-step">
                  <i class="bi bi-arrow-left me-1"></i>Kembali
                </button>
                <button type="button" class="btn btn-primary next-step">
                  Lanjut ke Detail Acara <i class="bi bi-arrow-right ms-1"></i>
                </button>
              </div>
            </div>

            <div class="step-wizard" id="step-3">
              <h5 class="fw-bold mb-4">Step 3: Detail Acara & Musik</h5>
              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label">Tanggal Akad</label>
                  <input type="datetime-local" name="tgl_akad" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Tanggal Resepsi</label>
                  <input type="datetime-local" name="tgl_resepsi" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Nama Gedung</label>
                  <input type="text" name="lokasi_nama" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Maps URL</label>
                  <input type="url" name="Maps_url" class="form-control">
                </div>
                <div class="col-12">
                  <label class="form-label">Alamat Lengkap</label>
                  <textarea name="lokasi_address" class="form-control" rows="2"></textarea>
                </div>
              </div>
              <div class="bg-light p-3 rounded mb-4">
                <label class="form-label fw-bold text-primary">Upload Music (MP3)</label>
                <input type="file" name="music_file" class="form-control" accept="audio/mpeg, audio/mp3">
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-step">Kembali</button>
                <button type="button" class="btn btn-primary next-step">Lanjut ke Cerita & Foto <i
                    class="bi bi-arrow-right ms-1"></i></button>
              </div>
            </div>

            <div class="step-wizard" id="step-4">
              <h5 class="fw-bold mb-4">Step 4: Love Story & Galeri Foto</h5>

              <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="fw-bold text-primary">Cerita Cinta</h6>
                  <button type="button" class="btn btn-outline-primary btn-sm" id="add-story">
                    <i class="bi bi-plus-circle"></i> Tambah Momen
                  </button>
                </div>
                <div id="story-container">
                  <div class="card shadow-sm mb-3 story-item">
                    <div class="card-body">
                      <div class="row g-2">
                        <div class="col-md-3"><input type="text" name="story_year[]" class="form-control"
                            placeholder="Tahun"></div>
                        <div class="col-md-8"><input type="text" name="story_title[]" class="form-control"
                            placeholder="Judul Momen"></div>
                        <div class="col-md-1 text-end">
                          <button type="button" class="btn btn-outline-danger remove-story w-100"><i
                              class="bi bi-trash"></i></button>
                        </div>
                        <div class="col-12 mt-2">
                          <textarea name="story_description[]" class="form-control" rows="2"
                            placeholder="Deskripsi..."></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="fw-bold text-primary">Galeri Foto</h6>
                  <button type="button" class="btn btn-outline-primary btn-sm" id="add-photo">
                    <i class="bi bi-plus-circle"></i> Tambah Foto
                  </button>
                </div>
                <div class="row g-3" id="photo-container">
                  <div class="col-md-4 photo-item">
                    <div class="card p-2 text-center border-dashed">
                      <input type="file" name="gallery_files[]" class="form-control form-control-sm mb-2"
                        accept="image/*">
                      <button type="button" class="btn btn-link btn-sm text-danger remove-photo p-0">Hapus</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-between mt-5">
                <button type="button" class="btn btn-secondary prev-step">Kembali</button>
                <button type="submit" class="btn btn-success px-5 fw-bold">SIMPAN & PUBLIKASI <i
                    class="bi bi-rocket-takeoff ms-1"></i></button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">

          <h5 class="card-title">Master Roles</h5>

          <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal"
            data-bs-target="#addRoleModal">
            <i class="bi bi-plus"></i>&nbsp; Add New Roles
          </button>

          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr id="row-role">
                <th scope="row"></th>
                <td class="role-name"></td>
                <td>
                  <button type="button" class="btn btn-sm btn-warning edit-role-btn" data-id="" data-name="">
                    Edit
                  </button>
                  <button type="button" class="btn btn-sm btn-danger delete-role-btn" data-id="" data-name="">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  $(document).ready(function () {
    let currentStep = 1;

    // --- NAVIGASI WIZARD ---
    $('.next-step').click(function () {
      $(`#step-${currentStep}`).removeClass('active');
      $(`#node-${currentStep}`).addClass('completed').removeClass('active');
      currentStep++;
      $(`#step-${currentStep}`).addClass('active');
      $(`#node-${currentStep}`).addClass('active');
    });

    $('.prev-step').click(function () {
      $(`#step-${currentStep}`).removeClass('active');
      $(`#node-${currentStep}`).removeClass('active');
      currentStep--;
      $(`#step-${currentStep}`).addClass('active');
      $(`#node-${currentStep}`).removeClass('completed').addClass('active');
    });

    // --- AUTO SLUG ---
    function generateSlug() {
      let combined = $('#m_pria').val() + '-' + $('#m_wanita').val();
      let slugText = combined.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
      $('#slug').val(slugText);
    }
    $('#m_pria, #m_wanita').on('input', generateSlug);

    // --- DYNAMIC DOM: LOVE STORY ---
    $('#add-story').click(function () {
      let storyHtml = `
                <div class="card shadow-sm mb-3 story-item">
                  <div class="card-body">
                    <div class="row g-2">
                      <div class="col-md-3"><input type="text" name="story_year[]" class="form-control" placeholder="Tahun"></div>
                      <div class="col-md-8"><input type="text" name="story_title[]" class="form-control" placeholder="Judul Momen"></div>
                      <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-outline-danger remove-story w-100"><i class="bi bi-trash"></i></button>
                      </div>
                      <div class="col-12 mt-2">
                        <textarea name="story_description[]" class="form-control" rows="2" placeholder="Deskripsi..."></textarea>
                      </div>
                    </div>
                  </div>
                </div>`;
      $('#story-container').append(storyHtml);
    });

    $(document).on('click', '.remove-story', function () {
      if ($('.story-item').length > 1) {
        $(this).closest('.story-item').remove();
      } else {
        alert("Minimal harus ada satu cerita cinta.");
      }
    });

    // --- DYNAMIC DOM: GALLERY ---
    $('#add-photo').click(function () {
      let photoHtml = `
                  <div class="col-md-4 photo-item">
                    <div class="card p-2 text-center border-dashed">
                      <input type="file" name="gallery_files[]" class="form-control form-control-sm mb-2" accept="image/*">
                      <button type="button" class="btn btn-link btn-sm text-danger remove-photo p-0">Hapus</button>
                    </div>
                  </div>`;
      $('#photo-container').append(photoHtml);
    });

    $(document).on('click', '.remove-photo', function () {
      if ($('.photo-item').length > 1) {
        $(this).closest('.photo-item').remove();
      } else {
        alert("Minimal harus ada satu foto galeri.");
      }
    });
  });

  // --- JQUERY UNTUK PREVIEW FOTO MEMPELAI (STEP 2) ---
  $('.profile-preview-input').change(function () {
    const input = this;
    const targetId = $(this).data('target'); // Mengambil ID img target (prev_pria/prev_wanita)

    if (input.files && input.files[0]) {
      // Validasi tipe file sederhana
      const fileType = input.files[0].type;
      if (fileType !== 'image/jpeg' && fileType !== 'image/png') {
        alert('Harap upload file gambar (JPG atau PNG).');
        $(this).val(''); // Reset input
        return false;
      }

      // Validasi ukuran file (misal maks 2MB)
      if (input.files[0].size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal adalah 2MB.');
        $(this).val('');
        return false;
      }

      const reader = new FileReader();

      reader.onload = function (e) {
        // Mengganti src gambar preview
        $(`#${targetId}`).attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  });

</script>
@endsection
