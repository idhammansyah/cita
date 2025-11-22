@extends('layout.index')

@section('title', 'Menu Assignment')

@section('content')

<style>
  /* simple styling */
  .menu-tree {
    max-height: 75vh;
    overflow: auto;
  }

  .menu-item {
    cursor: pointer;
    padding: .35rem .5rem;
    border-radius: 6px;
  }

  .menu-item:hover {
    background: rgba(74, 108, 247, 0.06);
  }

  .menu-item.active {
    background: rgba(74, 108, 247, 0.12);
  }

  .indent {
    display: inline-block;
    width: 1.25rem;
  }

  /* base indent unit */

  .role-switch {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 8px;
    border-radius: 6px;
  }

  .role-switch+.role-switch {
    margin-top: 6px;
  }

  .tree-node {
    padding: 6px 10px;
    cursor: pointer;
    border-radius: 6px;
  }

  .tree-node:hover {
    background: #f1f5ff;
  }

  .expand-icon {
    font-size: 12px;
    width: 14px;
    margin-right: 6px;
  }

  .child-container {
    margin-left: 18px;
    display: none;
  }

  .child-container.open {
    display: block;
  }

</style>

<div class="pagetitle">
  <h1>Menu Assignment</h1>
  {!! renderBreadcrumb() !!}
</div>

<section class="dashboard">
  <div class="row">
    <!-- LEFT: menu tree -->
    <div class="col-xl-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">All Menus</h5>
          <div class="menu-tree mt-3" id="menuTreeContainer">
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: form assign per selected menu -->
    <div class="col-xl-8">
      <div class="card">
        <div class="card-body">
          <div id="assignCard">
            <h5 class="card-title text-muted">Select the menu item on the left to view the assignment options</h5>
            <p class="text-muted">Click a menu item to view and assign roles.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

@section('scripts')

<script>
  $(function () {

    // Setup CSRF token for ajax
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    });

    // load full menus tree on page load
    function loadMenusTree() {
      $('#menuTreeContainer').html(
        '<div class="spinner-border text-primary" role="status"> <span class="visually-hidden"> Loading...</span></div>'
      );
      $.get("{{ route('menu.assignment.menusTree') }}", function (res) {
        const tree = res.tree || [];
        const html = buildTreeHtml(tree);
        $('#menuTreeContainer').html(html);
        // attach click handlers
        $('.menu-item').on('click', onMenuClick);
      }).fail(function () {
        $('#menuTreeContainer').html('<p class="text-danger">Failed to load menus.</p>');
      });
    }

    // build tree markup recursively; each item is a clickable div
    function buildTreeHtml(nodes) {
      let out = '<div>';
      nodes.forEach(n => out += buildNodeHtml(n));
      out += '</div>';
      return out;
    }

    function buildNodeHtml(node) {
      const hasChild = node.children.length > 0;

      let html = `
        <div class="tree-node d-flex align-items-start flex-column" data-id="${node.id}">
          <div class="d-flex align-items-center w-100">
            ${hasChild ? `<i class="bi bi-caret-right expand-icon"></i>` : `<i class="expand-icon"></i>`}

            <i class="${node.class} me-2"></i>

            <div>
              <span class="fw-semibold">${escapeHtml(node.name)}</span>
              <div class="text-muted small">${escapeHtml(node.url || "")}</div>
            </div>
          </div>
        </div>
      `;

      if (hasChild) {
        html += `<div class="child-container">`;
        node.children.forEach(ch => html += buildNodeHtml(ch));
        html += `</div>`;
      }

      return html;
    }


    $(document).on("click", ".tree-node", function (e) {
      const icon = $(this).find(".expand-icon");
      const child = $(this).next(".child-container");

      if (child.length) {
        child.toggleClass("open");
        icon.toggleClass("bi-caret-right bi-caret-down");
      }

      $(".tree-node").removeClass("active");
      $(this).addClass("active");

      const id = $(this).data("id");
      loadRolesForMenu(id);
    });

    // escape helper
    function escapeHtml(text) {
      return String(text || '').replace(/[&<>"'`=\/]/g, function (s) {
        return {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#39;',
          '`': '&#96;',
          '/': '&#47;',
          '=': '&#61;'
        } [s];
      });
    }

    // when user clicks a menu item
    function onMenuClick(e) {
      e.preventDefault();
      const id = $(this).data('id');

      // highlight selected
      $('.menu-item').removeClass('active');
      $(this).addClass('active');

      loadRolesForMenu(id);
    }

    // load roles and assigned state for selected menu
    function loadRolesForMenu(menuId) {
      $('#assignCard').html(
        '<div class="spinner-border text-primary" role="status"> <span class="visually-hidden"> Loading... </span></div>'
      );

      $.get(`/menu-assignment/menu/${menuId}/roles`, function (res) {
        const roles = res.roles || [];
        const assigned = res.assigned || [];
        renderAssignCard(menuId, roles, assigned);
      }).fail(function () {
        $('#assignCard').html('<p class="text-danger">Failed to load roles.</p>');
      });
    }

    // render right card form with switch toggles
    function renderAssignCard(menuId, roles, assigned) {
      let html =
        `<h5 class="card-title">Assign Roles for: <span class="text-primary">${escapeHtml($('.menu-item.active strong').text())}</span></h5>`;
      html += `<p class="text-muted small mb-3">Menu ID: ${menuId}</p>`;
      html += `<div id="rolesList">`;

      roles.forEach(r => {
        const isChecked = assigned.indexOf(r.id_roles) !== -1 ? 'checked' : '';
        html += `
        <div class="role-switch border p-2 mb-2 d-flex align-items-center justify-content-between">
          <div>
            <div class="fw-semibold">${escapeHtml(r.nama_roles)}</div>
            <div class="small text-muted">Roles ID: ${r.id_roles}</div>
          </div>
          <div>
            <div class="form-check form-switch">
              <input class="form-check-input role-toggle" type="checkbox" role-id="${r.id_roles}" menu-id="${menuId}" ${isChecked}>
            </div>
          </div>
        </div>
      `;
      });

      html += `</div>`; // rolesList
      html +=
        `<div class="mt-3"><button class="btn btn-secondary btn-sm me-2" id="btnRefreshRoles">Refresh</button></div>`;

      $('#assignCard').html(html);

      // attach toggle event
      $('.role-toggle').off('change').on('change', function () {
        const roleId = $(this).attr('role-id');
        const menuId = $(this).attr('menu-id');
        const assign = $(this).is(':checked') ? 1 : 0;
        toggleRole(menuId, roleId, assign, $(this));
      });

      // refresh
      $('#btnRefreshRoles').off('click').on('click', function () {
        loadRolesForMenu(menuId);
      });
    }

    // AJAX toggle assign/unassign role
    function toggleRole(menuId, roleId, assign, $input) {
      // disable while processing
      $input.prop('disabled', true);

      $.post(`/menu-assignment/menu/${menuId}/toggle-role`, {
        role_id: roleId,
        assign: assign
      }).done(function (resp) {
        // optionally show small toast / feedback (skipped)
      }).fail(function () {
        alert('Gagal mengubah assign. Refresh dan coba lagi.');
        // revert checkbox if failed
        $input.prop('checked', !assign);
      }).always(function () {
        $input.prop('disabled', false);
      });
    }

    // initial load
    loadMenusTree();
  });

</script>
@endsection
