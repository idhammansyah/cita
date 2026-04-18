<div class="modal fade" id="addGuestModal" tabindex="-1" aria-labelledby="addGuestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addGuestModalLabel">Tambah Data Tamu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="add_tamu">
        @csrf

        <div class="modal-body">

          <button type="button" id="addGuestRow" class="btn btn-primary btn-sm mb-3">
            <i class="bi bi-plus-square"></i> Tambah Tamu
          </button>

          <p class="fw-bold text-danger">* Wajib diisi</p>

          <div id="guestWrapper">
            <div class="row guest-item border rounded p-3 mb-3">

              <div class="col-12 mb-2">
                <strong class="guest-title">Tamu 1</strong>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Nama Tamu <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nama_tamu[]" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">No HP/Whatsapp <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="no_hp[]" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Undangan Dari <span class="text-danger">*</span></label>
                <select name="undangan_dari[]" class="form-select" required>
                  <option value="">-- Choose One --</option>
                  <option value="Idham">Idham</option>
                  <option value="Riska">Riska</option>
                  <option value="Ibu dari Riska">Ibu dari Riska</option>
                  <option value="Ibu dari Idham">Ibu dari Idham</option>
                  <option value="Ayah dari Idham">Ayah dari Idham</option>
                  <option value="Ayah dari Riska">Ayah dari Riska</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Group Undangan <span class="text-danger">*</span></label>
                <select class="form-select" name="group_undangan[]" required>
                  <option value="">Choose...</option>
                  <option value="1">Keluarga</option>
                  <option value="2">Teman</option>
                  <option value="3">Rekan Kerja</option>
                </select>
              </div>

              <div class="col-12 mb-3">
                <label class="form-label">Alamat/Kota <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="alamat[]" placeholder="Alamat lengkap">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    function updateGuestNumber() {
      $('.guest-item').each(function (index) {
        $(this).find('.guest-title').text('Tamu ' + (index + 1));
      });
    }

    // TAMBAH TAMU
    $('#addGuestRow').on('click', function () {

      let newItem = $('.guest-item').first().clone();

      // reset input
      newItem.find('input').val('');
      newItem.find('select').prop('selectedIndex', 0);

      // tambah tombol hapus jika belum ada
      if (newItem.find('.remove-guest').length === 0) {
        newItem.append(`
        <div class="col-12 text-end">
          <button type="button" class="btn btn-danger btn-sm remove-guest">
            <i class="bi bi-trash"></i>&nbsp; Hapus
          </button>
        </div>
      `);
      }

      $('#guestWrapper').append(newItem);

      updateGuestNumber();
    });

    // HAPUS TAMU
    $(document).on('click', '.remove-guest', function () {
      if ($('.guest-item').length > 1) {
        $(this).closest('.guest-item').remove();
        updateGuestNumber();
      }
    });

  });

</script>

<script>
  $(document).ready(function () {

    $('#add_tamu').on('submit', function (e) {
      e.preventDefault();
      let form = $(this);
      Swal.fire({
        title: 'Yakin mau simpan?',
        text: "Data tamu akan disimpan ke database",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!'
      }).then((result) => {
        if (result.isConfirmed) {

          $.ajax({
            url: "{{ route('add.tamu') }}",
            type: "POST",
            data: form.serialize(),

            beforeSend: function () {
              Swal.fire({
                title: 'Menyimpan...',
                allowOutsideClick: false,
                didOpen: () => {
                  Swal.showLoading()
                }
              });
            },

            success: function (response) {

              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.message
              });

              $('#addGuestModal').modal('hide');
              $('#add_tamu')[0].reset();
              $('.guest-item').not(':first').remove();

              if (typeof table !== 'undefined') {
                table.ajax.reload(null, false);
              }

            },

            error: function (xhr) {

              let errorText = 'Terjadi kesalahan';

              if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorText = '';
                $.each(xhr.responseJSON.errors, function (key, value) {
                  errorText += value[0] + '<br>';
                });
              }

              Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: errorText
              });

            }

          });

        }
      });
    });

  });

</script>
