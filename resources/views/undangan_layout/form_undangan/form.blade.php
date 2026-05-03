@extends('layout.index')

@section('title', $data['title'])

@section('content')

{!! renderBreadcrumb() !!}
{!! flash_message() !!}
<style>
  /* Style untuk Progress Wizard */
  .step-wizard {
    display: none;
  }

  .step-wizard.active {
    display: block;
  }

  .wizard-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
    position: relative;
  }

  /* Garis penghubung antar node */
  .wizard-steps::before {
    content: "";
    position: absolute;
    top: 20px;
    left: 50px;
    right: 50px;
    height: 2px;
    background: #e9ecef;
    z-index: 1;
  }

  .step-node {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #6c757d;
    transition: all 0.3s;
    position: relative;
    z-index: 2;
  }

  .step-node.active {
    background: #0d6efd;
    color: white;
  }

  .step-node.completed {
    background: #198754;
    color: white;
  }

  .border-dashed {
    border: 2px dashed #dee2e6;
    transition: 0.3s;
  }

  .border-dashed:hover {
    border-color: #0d6efd;
  }

</style>
<section class="dashboard">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">

          <h5 class="card-title">{{ $data['title'] }}</h5>

          <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addForm">
            <i class="bi bi-plus"></i>&nbsp; Add {{ $data['title'] }}
          </button>

          <table id="weddingTable" class="table table-hover w-100">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Pasangan</th>
                <th>Tanggal Akad</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data['weddings'] as $index => $item)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    <strong>{{ $item->m_pria_panggilan }} & {{ $item->m_wanita_panggilan }}</strong>
                    <br>
                    <small class="text-muted">{{ $item->slug }}</small>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($item->tgl_akad)->format('d M Y') }}
                  </td>
                  <td>
                    <a href="{{ route('undanganku', $item->slug) }}" class="btn btn-sm btn-info">
                      View
                    </a> |
                    <a href="" class="btn btn-sm btn-warning">Edit</a> |
                    <button type="button" class="btn btn-sm btn-danger delete-wedding-btn" data-id="" data-name="">
                      Delete
                    </button>

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
@endsection
@include('undangan_layout.form_undangan.modal.modal_add')
@section('scripts')
<script>
  $(document).ready(function () {
    // Inisialisasi DataTables
    $('#weddingTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Biar bahasanya Indonesia bray
      }
    });

    // Handle Delete (Tetap pake delegasi 'on' karena row bisa berubah saat paging/search)
    $(document).on('click', '.delete-wedding-btn', function () {
      let id = $(this).data('id');
      let name = $(this).data('name');

      if (confirm(`Yakin mau hapus undangan ${name}?`)) {
        // Proses AJAX kamu di sini...
        console.log("Menghapus ID: " + id);
      }
    });
  });

</script>
@endsection
