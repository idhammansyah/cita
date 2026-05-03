@extends('layout.index')
@section('title', 'Daftar Tamu')

@section('content')

<div class="pagetitle mb-4">
  <h1 class="fw-bold">Daftar Tamu</h1>
  {!! renderBreadcrumb() !!}
</div>

<section class="dashboard">

  {{-- SUCCESS MESSAGE --}}
  @if (session('success'))
  <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
  @endif
  @if (session('error'))
  <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
  @endif

  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">Daftar Tamu
          @canCreate
          <button class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addGuestModal">
            Tambah Tamu
          </button>
          @endcanCreate
        </div>
        <div class="card-body">
          <button class="btn btn-success mt-3" id="bulkSend" disabled>
            Kirim Terpilih
          </button>
          <div class="table-responsive mt-3">
            <table class="table table-hover" id="table_tamu" style="min-width:100% !important;">

              <thead class="table-dark text-center">
                <tr>
                  <th width="5%">No</th>
                  <th width="5%">Check</th>
                  <th>Nama Tamu</th>
                  <th>No HP</th>
                  <th>Undangan Dari</th>
                  <th>Group</th>
                  <th>Alamat</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>

              <tbody>

              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
</section>

@include('undangan.daftar_tamu.modal.modal_add')
@include('undangan.daftar_tamu.modal.modal_update')
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.body.classList.remove('toggle-sidebar');
  });

</script>

<script>
  let table;

  $(document).ready(function () {

    table = $('#table_tamu').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('get.list.tamu') }}",

      columns: [{
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {

            let isSent = row.is_sent == 1;
            let disabled = isSent ? 'disabled' : '';
            let sentAttr = isSent ? 'data-sent="1"' : '';

            return `<input type="checkbox" class="wa-check" value="${row.id_tamu}">`;

          }
        },
        {
          data: 'nama_tamu',
          name: 'nama_tamu'
        },
        {
          data: 'phone',
          name: 'phone'
        },
        {
          data: 'tamu_dari',
          name: 'tamu_dari'
        },
        {
          data: 'group_nama',
          name: 'group_nama'
        },
        {
          data: 'address',
          name: 'address'
        },

        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {

            let isSent = row.is_sent == 1;
            let disabled = isSent ? 'disabled' : '';
            let sentAttr = isSent ? 'data-sent="1"' : '';

            return `
              <div class="d-flex flex-wrap gap-1 justify-content-center">
                  <!-- Button View -->
                  <a href="/wedding/${row.slug}/invitation/to/${encodeURIComponent(row.nama_tamu)}" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat Undangan">
                      <i class="bi bi-eye"></i>
                  </a>

                  <!-- Button Edit -->
                  <button type="button" class="btn btn-sm btn-outline-warning edit" data-id="${row.id_tamu}" title="Edit Tamu">
                      <i class="bi bi-pencil-square"></i>
                  </button>

                  <!-- Button Kirim WA -->
                  <button type="button" class="btn btn-sm btn-success send-wa row-send"
                      data-id="${row.id_tamu}"
                      ${sentAttr}
                      ${disabled}
                      title="Kirim WhatsApp">
                      <i class="bi bi-whatsapp"></i>
                  </button>

                  <!-- Button Hapus -->
                  <button type="button" class="btn btn-sm btn-outline-danger delete" data-id="${row.id_tamu}" title="Hapus Tamu">
                      <i class="bi bi-trash"></i>
                  </button>
              </div>
          `;
          }
        }
      ]
    });

    // Reset saat redraw table
    table.on('draw', function () {
      $('#bulkSend').prop('disabled', true);
    });

  });

  $(document).on('change', '.wa-check', function () {

    let checkedCount = $('.wa-check:checked').length;

    if (checkedCount > 0) {

      // Aktifkan tombol bulk
      $('#bulkSend').prop('disabled', false);

      // Disable semua tombol kirim per baris
      $('.row-send').prop('disabled', true);

    } else {

      // Disable tombol bulk
      $('#bulkSend').prop('disabled', true);

      // Aktifkan kembali tombol kirim per baris
      $('.row-send').each(function () {

        if (!$(this).data('sent')) {
          $(this).prop('disabled', false);
        }

      });

    }

  });


  // Pastikan selector-nya sesuai dengan class tombol kirim lo
  $(document).on('click', '.send-wa', function() {
    let button = $(this);
    let id = button.data('id');

    $.get("/wa/" + id, function (data) {
        console.log("Data Lengkap:", data); // Cek di sini, m_pria_panggilan muncul gak?

        if (!data.slug) {
            alert("Slug wedding-nya gak ketemu bray!");
            return;
        }

        let phone = data.phone.replace(/^0/, '62');
        let baseUrl = window.location.origin;

        // Nama untuk URL (pake encode) vs Nama untuk Teks (asli)
        let guestNameUrl = encodeURIComponent(data.nama_tamu);
        let guestNameText = data.nama_tamu;

        let weddingLink = `${baseUrl}/wedding/${data.slug}/invitation/to/${guestNameUrl}`;
        let weddingName = `${data.m_pria_panggilan} & ${data.m_wanita_panggilan}`;

        // Susun pesan rapat kiri biar gak ada spasi liar di WA
        let message = `Kepada Yth.
Bapak/Ibu/Saudara/i
*${guestNameText}*
_______

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami.

Berikut link undangan kami, untuk info lengkap dari acara, bisa kunjungi :

${weddingLink}

Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.

Terima Kasih

Hormat kami,
${weddingName}
________`;

        let url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);
        window.open(url, '_blank');

        button.prop('disabled', true).addClass('btn-secondary');
    });
  });

  $('#bulkSend').click(function () {

    let ids = $('.wa-check:checked').map(function () {
      return $(this).val();
    }).get();

    if (ids.length === 0) {
      swal.fire('Tidak ada yang dipilih', '', 'warning');
      return;
    }

    let delay = 0;

    ids.forEach(function (id) {

      setTimeout(function () {

        $.get("/wa/" + id, function (data) {

          let phone = data.phone.replace(/^0/, '62');

          let message =
            `Halo ${data.nama},

            Kami mengundang Anda untuk menghadiri acara kami.

            Terima kasih 🙏`;

          let url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);

          window.open(url, '_blank');

        });

      }, delay);

      delay += 5000; // 5 detik jeda

    });

  });

  $(document).on('click', '.delete', function () {

    let id = $(this).data('id');

    Swal.fire({
      title: 'Yakin hapus?',
      text: "Data tidak akan hilang permanen",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus'
    }).then((result) => {

      if (result.isConfirmed) {

        $.ajax({
          url: "/delete-tamu/" + id,
          type: "POST",
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function (response) {

            Swal.fire('Terhapus!', response.message, 'success');
            table.ajax.reload(null, false);

          }
        });

      }

    });

  });

</script>
@endsection
