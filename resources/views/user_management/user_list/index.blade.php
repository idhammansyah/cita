@extends('layout.index')

@section('title', 'User List')

@section('content')

<div class="pagetitle">
  <h1>User List</h1>
  {!! renderBreadcrumb() !!}
</div>

<style>
  .user-card {
    border: 2px solid #4a6cf7 !important;
    border-radius: 7px;
    backdrop-filter: blur(8px);
    background: rgba(255, 255, 255, 0.85);
    transition: all 0.3s ease;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
  }

  .user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
  }

  .user-avatar {
    width: 70px;
    height: 70px;
    font-size: 26px;
    font-weight: 600;
    background: linear-gradient(145deg, #4a6cf7, #6a9dfc);
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
  }

  .role-badge {
    background: #eef2ff;
    color: #4a6cf7;
    font-weight: 500;
    letter-spacing: .3px;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
  }

  .action-btn {
    border-radius: 50px;
    padding: 6px 16px;
    font-size: 12px;
    font-weight: 600;
  }

  .action-btn i {
    font-size: 14px;
  }

</style>

<section class="dashboard">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">User List</h5>

            <div>
              <button class="btn btn-secondary btn-sm" id="switchToTable">
                <i class="bi bi-table"></i> Table View
              </button>
              <button class="btn btn-secondary btn-sm d-none" id="switchToCard">
                <i class="bi bi-grid"></i> Card View
              </button>

              @canCreate
              <button class="btn btn-primary btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Add User</button>
              @endcanCreate
            </div>
          </div>

          <!-- TABLE VIEW -->
          <div id="tableView">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Full Name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $index => $user)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $user->full_name }}</td>
                  <td>{{ $user->username }}</td>
                  <td>
                    @if (is_array($user->role_list))
                    {{ implode(', ', json_decode($user->role_list, true)) }}
                    @else
                    {{ $user->role_list }}
                    @endif
                  </td>
                  <td>
                    @canUpdate
                    <button class="btn btn-sm btn-warning edit-role-btn" data-id="{{ $user->id }}"
                      data-name="{{ $user->username }}">
                      Edit
                    </button>
                    @else
                    <small class="text-muted d-block">No update permission</small>
                    @endcanUpdate


                    @canDelete
                    <button class="btn btn-sm btn-danger delete-role-btn" data-id="{{ $user->id }}"
                      data-name="{{ $user->username }}">
                      Delete
                    </button>
                    @else
                    <small class="text-muted d-block">No delete permission</small>
                    @endcanDelete

                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted">No users found</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>


          <!-- CARD VIEW -->


          <div id="cardView" class="row d-none">
            @foreach ($users as $user)
            <div class="col-md-4 col-lg-3 mb-4">
              <div class="card user-card h-100">
                <div class="card-body text-center">

                  <!-- Avatar -->
                  <div class="user-avatar mb-3 shadow-sm">
                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                  </div>

                  <!-- Nama -->
                  <h6 class="fw-bold mb-0" style="font-size: 15px;">
                    {{ $user->full_name }}
                  </h6>

                  <!-- Username -->
                  <p class="text-muted" style="font-size: 13px; margin-top: 2px;">
                    {{ '@' . $user->username }}
                  </p>

                  <!-- Role -->
                  <span class="role-badge">
                    {{ $user->role_list }}
                  </span>

                </div>

                <div class="card-footer bg-white border-0">
                  <div class="mt-3 d-flex justify-content-center gap-2">

                    @canUpdate
                    <button class="btn btn-sm btn-warning edit-role-btn" data-id="{{ $user->id }}"
                      data-name="{{ $user->username }}">
                      Edit
                    </button>
                    @else
                    <small class="text-muted d-block">No update permission</small>
                    @endcanUpdate


                    @canDelete
                    <button class="btn btn-sm btn-danger delete-role-btn" data-id="{{ $user->id }}"
                      data-name="{{ $user->username }}">
                      Delete
                    </button>
                    @else
                    <small class="text-muted d-block">No delete permission</small>
                    @endcanDelete


                  </div>
                </div>

              </div>
            </div>
            @endforeach
          </div>



        </div>
      </div>
    </div>
  </div>
</section>

<!-- MODAL EDIT ROLE -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="formEditUser" method="POST">
      @csrf
      @method('PUT')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" id="edit_user_id" name="user_id">

          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" id="edit_username" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" id="edit_role_id" class="form-select">
              @foreach($roles as $r)
              <option value="{{ $r->id_roles }}">{{ $r->nama_roles }}</option>
              @endforeach
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>

      </div>
    </form>
  </div>
</div>


<script>
  const tableView = document.getElementById("tableView");
  const cardView = document.getElementById("cardView");
  const btnToTable = document.getElementById("switchToTable");
  const btnToCard = document.getElementById("switchToCard");

  btnToTable.addEventListener("click", () => {
    tableView.classList.remove("d-none");
    cardView.classList.add("d-none");
    btnToTable.classList.add("d-none");
    btnToCard.classList.remove("d-none");
  });

  btnToCard.addEventListener("click", () => {
    tableView.classList.add("d-none");
    cardView.classList.remove("d-none");
    btnToCard.classList.add("d-none");
    btnToTable.classList.remove("d-none");
  });

</script>

<script>
  // ================================
  // OPEN EDIT MODAL
  // ================================
  $(document).on("click", ".edit-role-btn", function () {
    const id = $(this).data("id");

    $.get(`/users/${id}/edit`, function (res) {
      $("#edit_user_id").val(res.id);
      $("#edit_username").val(res.username);
      $("#edit_role_id").val(res.role_id);

      $("#formEditUser").attr("action", `/users/${id}`);
      $("#editUserModal").modal("show");
    });
  });


  // ================================
  // SUBMIT EDIT
  // ================================
  $("#formEditUser").on("submit", function (e) {
    e.preventDefault();

    const url = $(this).attr("action");

    $.ajax({
      url: url,
      type: "PUT",
      data: $(this).serialize(),
      success: function () {
        $("#editUserModal").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Updated!",
          text: "User role updated successfully.",
        }).then(() => {
          location.reload();
        });
      },
      error: function () {
        Swal.fire("Error", "Failed to update user.", "error");
      }
    });

  });



  // ================================
  // DELETE USER CONFIRMATION
  // ================================
  $(document).on("click", ".delete-role-btn", function () {
    const id = $(this).data("id");
    const name = $(this).data("name");

    Swal.fire({
      title: "Delete User?",
      text: `Are you sure want to delete '${name}'?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/users/${id}`,
          type: "POST",
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function () {
            Swal.fire("Deleted!", "User has been removed.", "success")
              .then(() => location.reload());
          },
          error: function () {
            Swal.fire("Error", "Failed to delete user.", "error");
          },
        });
      }
    });

  });

</script>



@endsection
