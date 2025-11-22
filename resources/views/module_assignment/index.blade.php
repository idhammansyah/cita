@extends('layout.index')

@section('title','Module Assignment')

@section('content')
<div class="pagetitle">
  <h1>Module Assignment</h1>
  {!! renderBreadcrumb() !!}
</div>

<section class="dashboard">
  <div class="row">

    <!-- LEFT SIDEBAR -->
    <div class="col-xl-3">
      <div class="card">
        <div class="card-body">

          <!-- SELECT ROLE -->
          <h5 class="card-title">Role</h5>
          <select id="selectRole" class="form-select mb-3">
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $r)
            <option value="{{ $r->id_roles }}">{{ $r->nama_roles }}</option>
            @endforeach
          </select>

          <!-- MODULE LIST -->
          <h5 class="card-title mt-4">Daftar Module</h5>
          <ul class="list-group" id="moduleList">
            @foreach($modules as $m)
            <li class="list-group-item module-item" data-id="{{ $m->id_modules }}">
              <strong>{{ $m->judul_modules }}</strong>
              <div class="text-muted small">{{ $m->nama_modules }}</div>
            </li>
            @endforeach
          </ul>

        </div>
      </div>
    </div>

    <!-- RIGHT CONTENT -->
    <div class="col-xl-9">
      <div class="card">
        <div class="card-body" id="assignPanel">

          <h5 class="text-center text-muted p-5">
            Pilih role & module untuk mengatur permission
          </h5>

        </div>
      </div>
    </div>

  </div>
</section>
@endsection


@section('scripts')

{{-- SWEETALERT CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  let selectedRole = null;
  let selectedModule = null;

  // Role selection
  $('#selectRole').on('change', function () {
    selectedRole = $(this).val();
    resetPanel();
  });

  // Module click
  $(document).on('click', '.module-item', function () {
    if (!selectedRole) {
      Swal.fire({
        title: "Role belum dipilih!",
        text: "Silakan pilih role terlebih dahulu.",
        icon: "warning"
      });
      return;
    }

    $('.module-item').removeClass('active');
    $(this).addClass('active');

    selectedModule = $(this).data('id');

    loadPermissions();
  });

  // Reset panel
  function resetPanel() {
    $('#assignPanel').html(`
        <h5 class="text-center text-muted p-5">
            Pilih module untuk mengatur permission
        </h5>
    `);
    $('.module-item').removeClass('active');
  }

  // Load permissions
  function loadPermissions() {
    $('#assignPanel').html(
      '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>');

    $.get(`/module-assign/get/${selectedModule}?role=${selectedRole}`, function (res) {

      let checkedRead = res.permissions.can_read ? 'checked' : '';
      let checkedCreate = res.permissions.can_create ? 'checked' : '';
      let checkedUpdate = res.permissions.can_update ? 'checked' : '';
      let checkedDelete = res.permissions.can_delete ? 'checked' : '';

      let html = `
            <h4 class="card-title">${res.module.judul_modules}</h4>
            <p class="text-muted">${res.module.nama_modules}</p>

            <form id="assignForm" class="mt-3">

                <input type="hidden" name="id_role" value="${selectedRole}">
                <input type="hidden" name="id_module" value="${selectedModule}">
                @csrf

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input perm" type="checkbox" name="read" ${checkedRead}>
                    <label class="form-check-label">Read</label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input perm" type="checkbox" name="create" ${checkedCreate}>
                    <label class="form-check-label">Create</label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input perm" type="checkbox" name="update" ${checkedUpdate}>
                    <label class="form-check-label">Update</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input perm" type="checkbox" name="delete" ${checkedDelete}>
                    <label class="form-check-label">Delete</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">
                    Simpan Permission
                </button>
            </form>
        `;

      $('#assignPanel').html(html);
    });
  }

  // Submit save with SweetAlert2
  $(document).on('submit', '#assignForm', function (e) {
    e.preventDefault();

    Swal.fire({
      title: 'Simpan Permission?',
      text: "Perubahan permission akan langsung diterapkan.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#0d6efd',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Simpan!',
      cancelButtonText: 'Batal'
    }).then((result) => {

      if (result.isConfirmed) {

        $.post("{{ route('module.assign.save') }}", $(this).serialize(), function () {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Permission berhasil disimpan.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
          });
        }).fail(function () {
          Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menyimpan.',
            icon: 'error'
          });
        });

      }

    });
  });

</script>
@endsection
