@extends('layout.index')

@section('title', 'Menu Management')

@section('content')

<style>
  .menu-item {
    border-radius: 6px;
    margin-bottom: 4px;
    cursor: grab;
  }

  .menu-item .meta {
    font-size: 12px;
    color: #6c757d;
  }

  .placeholder {
    border: 1px dashed #999 !important;
    background: #f5f5f5;
    height: 40px;
    margin-bottom: 5px;
  }

</style>

<div class="card">
  <div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="card-title">Menu Management</h5>

      <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMenuModal">
        + Add New Menu
      </button>
    </div>

    {{-- TREEVIEW --}}
    <div id="menu-list-container">
      <p class="text-muted">Loading...</p>
    </div>

  </div>
</div>

{{-- Modal ADD --}}
@include('menu_management.modal.modal-add')

{{-- Modal EDIT --}}
@include('menu_management.modal.modal-edit')

{{-- Spinner --}}
<div id="loadingSpinner" style="
    display:none;position:fixed;inset:0;
    background:rgba(255,255,255,0.4);z-index:2000;">
  <div class="d-flex justify-content-center align-items-center h-100">
    <div class="spinner-border text-primary"></div>
  </div>
</div>

@endsection


@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.min.js"
  integrity="sha512-uAt5HkX8rwCV19v9HIeAocLUfQvQDfX0zuaMQr5HhGZc6GwhJoe9hzJYBxzsWTaDSMl4FazGovJwUbOA8rGuog=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  let spinnerTimer = null;

  function showSpinner() {
    spinnerTimer = setTimeout(() => $('#loadingSpinner').show(), 200);
  }

  function hideSpinner() {
    clearTimeout(spinnerTimer);
    $('#loadingSpinner').hide();
  }

  function escapeHtml(text) {
    return (text ? text : '').toString().replace(/[&<"']/g, m => ({
      '&': '&amp;',
      '<': '&lt;',
      '"': '&quot;',
      "'": '&#039;'
    } [m]));
  }

  /* ========================================
     BUILD TREE NODE
  ======================================== */
  function buildNode(node) {

    const hasChild = node.children && node.children.length > 0;

    let html = `
    <div id="menu_${node.id_menus}" data-id="${node.id_menus}" class="tree-node mb-1">

      <div class="menu-item d-flex justify-content-between align-items-center w-100">

        <!-- LEFT SIDE -->
        <div class="d-flex align-items-center">
          ${hasChild
            ? `<i class="bi bi-caret-right expand-icon me-2"></i>`
            : `<i class="expand-icon me-2"></i>`}

          <i class="${node.class} me-2"></i>

          <div>
            <span class="fw-semibold">${escapeHtml(node.nama_menu)}</span>
            <div class="meta small text-muted">${escapeHtml(node.url_link)}</div>
          </div>
        </div>

        <!-- RIGHT SIDE BUTTONS -->
        <div class="ms-auto">
          <button class="btn btn-warning btn-sm btn-edit" data-id="${node.id_menus}">Edit</button>
          <button class="btn btn-danger btn-sm btn-delete" data-id="${node.id_menus}">Delete</button>
        </div>

      </div>
  `;

    if (hasChild) {
      html += `<div class="child-container ms-4">`;
      node.children.forEach(ch => {
        html += buildNode(ch);
      });
      html += `</div>`;
    }

    html += `</div>`;

    return html;
  }

  function renderMenus(tree) {
    if (!tree.length) return `<p class="text-muted">Belum ada menu.</p>`;

    return `
    <ul id="menu-list" class="list-group list-group-flush">
      ${tree.map(n => buildNode(n)).join('')}
    </ul>
  `;
  }

  /* ========================================
     LOAD MENUS
  ======================================== */
  function loadMenus() {
    showSpinner();
    $.get("/menu/get-all", res => {
      $("#menu-list-container").html(renderMenus(res));

      $("#menu-list").nestedSortable({
        listType: "ul",
        items: "li",
        handle: "div, span, i",
        toleranceElement: "> div",
        maxLevels: 10,
        placeholder: "placeholder",
        stop: function () {
          let arr = $("#menu-list").nestedSortable("toArray", {
            startDepthCount: 0
          });
          saveReorder(arr);
        }
      });

    }).fail(() => {
      $("#menu-list-container").html("<p class='text-danger'>Gagal load menu.</p>");
    }).always(hideSpinner);
  }
  loadMenus();

  /* ========================================
     SAVE REORDER
  ======================================== */
  function saveReorder(arr) {
    showSpinner();
    $.post("{{ route('menu.reorder') }}", {
      _token: "{{ csrf_token() }}",
      menu_data: JSON.stringify(arr)
    }).done(() => {
      Swal.fire("Berhasil", "Urutan menu disimpan", "success");
    }).fail(() => {
      Swal.fire("Error", "Gagal menyimpan urutan", "error");
    }).always(hideSpinner);
  }

  $(document).on("click", ".btn-edit", function () {
    let id = $(this).data("id");

    showSpinner();
    $.get(`/menu/${id}`, res => {

      // === SET ALL FORM FIELD ===
      $("#edit_id").val(res.id_menus);
      $("#edit_nama_menu").val(res.nama_menu);
      $("#edit_url_link").val(res.url_link);
      $("#edit_class").val(res.class);
      $("#edit_id_parent").val(res.id_parent);
      $("#edit_urutan").val(res.urutan);

      // =========== Tambahan: Set kategori + module ===========
      $("#edit_id_menu_kategori").val(res.id_menu_kategori);
      $("#edit_id_modules").val(res.id_modules);

      // === Set action form ===
      $("#formEditMenu").attr("action", `/menu/${id}`);

      // === Tampilkan modal ===
      $("#editMenuModal").modal("show");

    }).fail(() => {
      Swal.fire("Error", "Gagal load data", "error");
    }).always(hideSpinner);
  });

  /* ========================================
      UPDATE MENU (tidak update jika modal ditutup)
  =========================================== */
  $("#formEditMenu").on("submit", function (e) {
    e.preventDefault();
    let url = $(this).attr("action");

    showSpinner();
    $.ajax({
      url: url,
      type: "PUT",
      data: $(this).serialize()
    }).done(() => {
      $("#editMenuModal").modal("hide");
      Swal.fire("Sukses", "Menu diperbarui", "success");
      loadMenus();
    }).fail(() => {
      Swal.fire("Gagal", "Tidak dapat update menu", "error");
    }).always(hideSpinner);
  });

  /* ========================================
     ADD MENU
  ======================================== */
  $("#formAddMenu").on("submit", function (e) {
    e.preventDefault();
    showSpinner();
    $.post($(this).attr("action"), $(this).serialize())
      .done(() => {
        $("#addMenuModal").modal("hide");
        Swal.fire("Sukses", "Menu ditambahkan", "success");
        loadMenus();
      }).fail(() => {
        Swal.fire("Gagal", "Tidak dapat menambah menu", "error");
      }).always(hideSpinner);
  });

  /* ========================================
     SOFT DELETE
  ======================================== */
  $(document).on("click", ".btn-delete", function () {
    let id = $(this).data("id");

    Swal.fire({
      title: "Nonaktifkan menu?",
      text: "Menu akan di-soft delete",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya"
    }).then(res => {
      if (!res.isConfirmed) return;

      showSpinner();
      $.post(`/menu/${id}/delete`, {
          _token: "{{ csrf_token() }}"
        }).done(() => {
          Swal.fire("Berhasil", "Menu di-nonaktifkan", "success");
          loadMenus();
        })
        .fail(() => Swal.fire("Error", "Gagal delete", "error"))
        .always(hideSpinner);
    });
  });

</script>

@endsection
