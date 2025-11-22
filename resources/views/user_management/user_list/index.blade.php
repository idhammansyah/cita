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

              {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#addRoleModal">
                <i class="bi bi-plus"></i>&nbsp; Add New User
              </button> --}}
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


@endsection
