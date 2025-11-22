<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="formAddMenu" method="POST" action="{{ route('menu.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addMenuLabel">Tambah Menu Baru</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="row">
            <div class="col-md-8">
              <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label">URL</label>
                <input type="text" name="url_link" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Class Icon</label>
                <input type="text" name="class" class="form-control">
              </div>
            </div>

            <div class="col-md-4">

              <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="id_menu_kategori" class="form-select" required>
                  @foreach($categories as $c)
                    <option value="{{ $c->id_menu_kategori }}">{{ $c->nama_kategori }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Module</label>
                <select name="id_modules" class="form-select" required>
                  @foreach($modules as $m)
                    <option value="{{ $m->id_modules }}">{{ $m->nama_modules }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Posisi</label>
                <select name="posisi" class="form-select">
                  <option value="sidebar">Sidebar</option>
                  <option value="navbar">Navbar</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Parent</label>
                <select name="id_parent" class="form-select">
                  <option value="0">-- Main Menu --</option>
                  @foreach($all_menus as $pm)
                    @if($pm->id_parent == 0)
                      <option value="{{ $pm->id_menus }}">{{ $pm->nama_menu }}</option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="1" required>
              </div>

            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-primary" type="submit">Tambah</button>
        </div>

      </form>
    </div>
  </div>
</div>
