<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <form id="formEditMenu" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="editMenuLabel">Edit Menu</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" id="edit_id" name="id_menus">

          <div class="row">
            <div class="col-md-8">

              <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" id="edit_nama_menu" name="nama_menu" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">URL</label>
                <input type="text" id="edit_url_link" name="url_link" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Class Icon</label>
                <input type="text" id="edit_class" name="class" class="form-control">
              </div>

            </div>

            <div class="col-md-4">

              <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select id="edit_id_menu_kategori" name="id_menu_kategori" class="form-select"></select>
              </div>

              <div class="mb-3">
                <label class="form-label">Module</label>
                <select id="edit_id_modules" name="id_modules" class="form-select"></select>
              </div>

              <div class="mb-3">
                <label class="form-label">Posisi</label>
                <select id="edit_posisi" name="posisi" class="form-select">
                  <option value="sidebar">Sidebar</option>
                  <option value="navbar">Navbar</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Parent</label>
                <select id="edit_id_parent" name="id_parent" class="form-select"></select>
              </div>

              <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" id="edit_urutan" name="urutan" class="form-control">
              </div>

            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-danger me-auto" id="btnSoftDelete">Nonaktifkan</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-primary" type="submit">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>
