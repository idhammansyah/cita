@extends('layout.index')
@section('title', 'Master Module')

@section('content')

<div class="pagetitle mb-4">
  <h1 class="fw-bold">Master Module</h1>
  {!! renderBreadcrumb() !!}
</div>

<section class="dashboard">

  {{-- SUCCESS MESSAGE --}}
  @if (session('success'))
  <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
  @endif

  <div class="row">

    {{-- FORM TAMBAH --}}
    <div class="col-xl-5">
      <div class="card border-0 shadow-sm rounded-3">

        <div class="card-header bg-primary text-white rounded-top-3">
          <h6 class="mb-0">Tambah Module</h6>
        </div>

        <div class="card-body">
          <form action="{{ route('modules.store') }}" method="POST" class="mt-3">
            @csrf

            <div class="mb-3">
              <label class="fw-semibold">Nama Module</label>
              <input type="text" name="nama_modules" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="fw-semibold">Judul Module</label>
              <input type="text" name="judul_modules" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="fw-semibold">Login Dibutuhkan?</label>
              <select name="login" class="form-select" required>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="2"></textarea>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    {{-- DAFTAR MODULE --}}
    <div class="col-xl-7">
      <div class="card border-0 shadow-sm rounded-3">

        <div class="card-header bg-dark text-white rounded-top-3">
          <h6 class="mb-0">Daftar Module</h6>
        </div>

        <div class="card-body">
          <table class="mt-3 table table-hover">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Judul</th>
                <th>Login</th>
                <th>Deskripsi</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($modules as $mod)
              <tr>
                <td class="fw-bold">{{ $loop->iteration }}</td>
                <td>{{ $mod->nama_modules }}</td>
                <td>{{ $mod->judul_modules }}</td>
                <td>
                  <span class="badge bg-{{ $mod->login ? 'success' : 'secondary' }}">
                    {{ $mod->login ? 'Ya' : 'Tidak' }}
                  </span>
                </td>
                <td>{{ $mod->deskripsi }}</td>

                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">

                    {{-- BUTTON EDIT --}}
                    <button type="button" class="btn btn-warning btn-sm px-3 btn-edit shadow-sm"
                      data-id="{{ $mod->id_modules }}">
                      <i class="bi bi-pencil-square"></i>
                    </button>

                    {{-- BUTTON DELETE --}}
                    <form action="{{ route('modules.destroy', $mod->id_modules) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin hapus module ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>

                  </div>
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>

        </div>

      </div>
    </div>

  </div>
</section>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">

    <form id="formEdit" method="POST" class="modal-content shadow-lg border-0">
      @csrf
      @method('PUT')

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Module</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <input type="hidden" id="edit_id">

        <div class="mb-3">
          <label class="fw-semibold">Nama Module</label>
          <input type="text" name="nama_modules" id="edit_nama_modules" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="fw-semibold">Judul Module</label>
          <input type="text" name="judul_modules" id="edit_judul_modules" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="fw-semibold">Login Dibutuhkan?</label>
          <select name="login" id="edit_login" class="form-select" required>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="fw-semibold">Deskripsi</label>
          <textarea name="deskripsi" id="edit_deskripsi" class="form-control"></textarea>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary px-4">Simpan</button>
      </div>

    </form>

  </div>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function () {

    $('.btn-edit').on('click', function () {
      let id = $(this).data('id');

      $.ajax({
        url: '/edit-module/' + id,
        type: 'GET',
        success: function (data) {

          $('#edit_nama_modules').val(data.nama_modules);
          $('#edit_judul_modules').val(data.judul_modules);
          $('#edit_login').val(data.login);
          $('#edit_deskripsi').val(data.deskripsi);

          $('#formEdit').attr('action', '/update-module/' + id);

          $('#editModal').modal('show');
        },
        error: function () {
          alert('Gagal mengambil data module.');
        }
      });
    });

  });

</script>
@endsection
