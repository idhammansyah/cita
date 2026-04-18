<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Data Tamu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editForm">

          <input type="hidden" id="edit_id">

          <div class="row border rounded p-3">

            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Tamu</label>
              <input type="text" class="form-control" id="edit_nama" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">No HP/Whatsapp</label>
              <input type="text" class="form-control" id="edit_no_hp" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Undangan Dari</label>
              <select id="edit_undangan" class="form-select" required>
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
              <label class="form-label">Group Undangan</label>
              <select id="edit_group" class="form-select" required>
                <option value="">Choose...</option>
                <option value="1">Keluarga</option>
                <option value="2">Teman</option>
                <option value="3">Rekan Kerja</option>
              </select>
            </div>

            <div class="col-12 mb-3">
              <label class="form-label">Alamat/Kota</label>
              <input type="text" class="form-control" id="edit_alamat">
            </div>

          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
      </div>

    </div>
  </div>
</div>

<script>
  $(document).on('click', '.edit', function () {

    let id = $(this).data('id');

    $.get("/show-tamu/" + id, function (data) {
      $('#edit_id').val(data.id_tamu);
      $('#edit_nama').val(data.nama_tamu);
      $('#edit_no_hp').val(data.phone);
      $('#edit_undangan').val(data.tamu_dari);
      $('#edit_group').val(data.id_groups);
      $('#edit_alamat').val(data.address);

      $('#editModal').modal('show');

    });

  });

</script>

<script>
  $('#btnUpdate').click(function () {

    let id = $('#edit_id').val();

    $.ajax({
      url: "/update-tamu/" + id,
      type: "PUT",
      data: {
        _token: "{{ csrf_token() }}",
        nama_tamu: $('#edit_nama').val(),
        no_hp: $('#edit_no_hp').val(),
        undangan_dari: $('#edit_undangan').val(),
        group_undangan: $('#edit_group').val(),
        alamat: $('#edit_alamat').val(),
      },
      success: function (response) {

        $('#editModal').modal('hide');

        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: response.message,
          timer: 1500,
          showConfirmButton: false
        });

        table.ajax.reload(null, false);
      }
    });

  });

</script>
