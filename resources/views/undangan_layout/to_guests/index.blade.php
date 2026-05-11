<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wedding of {{ $wedding->m_pria_panggilan }} & {{ $wedding->m_wanita_panggilan }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    #invitation {
      display: none;
    }

    /* Mencegah scroll saat amplop masih tertutup */
    body.modal-open {
      overflow: hidden;
    }

  </style>
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body>

  <div class="sakura-container"></div>

  <div id="lightbox">
    <img id="lightbox-img">
  </div>

  <!-- COVER -->
  <section id="cover">
    <div class="envelope">
      <div class="flap"></div>
      <div class="seal">❤</div>
      <!-- TEXT DI AMPLOP -->
      <div class="envelope-content text-center" id="envelope-content">
        <h5 id="guestName">{{ $nama_tamu }}</h5> <!-- NAMA TAMU DARI URL -->
        <b>Di Tempat</b> <br><br>
        <button id="openBtn" class="btn btn-dark">
          Buka Undangan
        </button>
      </div>

      <!-- KARTU UNDANGAN -->
      <div class="letter text-center">
        <h3>Wedding Invitation</h3>
        <h2>{{ $wedding->m_pria_panggilan }} & {{ $wedding->m_wanita_panggilan }}</h2>
      </div>
    </div>
  </section>

  <!-- MAIN -->
  <section id="invitation">
    <!-- HERO -->
    <div class="hero text-white text-center" id="hero">
      <h1 data-aos="zoom-in">{{ $wedding->m_pria_panggilan }} & {{ $wedding->m_wanita_panggilan }}</h1>
      <p data-aos="fade-up">
        {{ \Carbon\Carbon::parse($wedding->tgl_akad)->translatedFormat('l, d F Y') }}
      </p>
      <div class="mt-4" data-aos="fade-up" data-aos-delay="200">
        @php
          // Parse tanggal resepsi
          $start = \Carbon\Carbon::parse($wedding->tgl_resepsi)->format('Ymd\THis');
          // Tambahin durasi 2 jam biar di kalender ada durasinya
          $end = \Carbon\Carbon::parse($wedding->tgl_resepsi)->addHours(2)->format('Ymd\THis');
          $dates = $start . '/' . $end;

          // Siapin teks buat judul kalender
          $title = urlencode("The Wedding of " . $wedding->m_pria_panggilan . " & " . $wedding->m_wanita_panggilan);
        @endphp

        <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ $title }}&dates={{ $dates }}&details=Mohon+doa+restunya+pada+acara+pernikahan+kami.&location=Lokasi+Acara"
          target="_blank" class="btn" style="background: linear-gradient(45deg, #d4af37, #f2d06b);
          color: #fff;
          border: none;
          padding: 12px 25px;
          border-radius: 50px;
          font-weight: 600;
          letter-spacing: 1px;
          text-transform: uppercase;
          font-size: 0.8rem;
          box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
          transition: all 0.3s ease;
          display: inline-flex;
          align-items: center;
          text-decoration: none;">
            Save Date &nbsp;<i class="bi bi-heart-fill"></i>
        </a>
      </div>
    </div>

    <!-- SALAM -->
    <div class="container py-5 text-center" id="mempelai">
      <h2 data-aos="fade-up">Assalamu'alaikum Warahmatullahi Wabarakatuh</h2>
      <p data-aos="fade-up" data-aos-delay="100">
        Dengan memohon rahmat dan ridho Allah SWT,
        kami bermaksud menyelenggarakan pernikahan putra-putri kami.
      </p>
      <div class="row mt-5">
        <div class="col-md-6" data-aos="fade-right">
          <img src="{{ asset($wedding->foto_pria) }}" class="img-fluid rounded-circle mb-3" width="200"
            style="height:200px; object-fit:cover;">
          <h4>{{ $wedding->m_pria }}</h4>
          <p>
            Putra ke-{{ $wedding->m_pria_anak_ke }} dari<br>
            Bapak {{ $wedding->m_pria_ayah }}<br>
            & Ibu {{ $wedding->m_pria_ibu }}
          </p>
        </div>

        <div class="col-md-6" data-aos="fade-left">
          <img src="{{ asset($wedding->foto_wanita) }}" class="img-fluid rounded-circle mb-3" width="200"
            style="height:200px; object-fit:cover;">
          <h4>{{ $wedding->m_wanita }}</h4>
          <p>
            Putri ke-{{ $wedding->m_wanita_anak_ke }} dari<br>
            Bapak {{ $wedding->m_wanita_ayah }}<br>
            & Ibu {{ $wedding->m_wanita_ibu }}
          </p>
        </div>
      </div>
    </div>

    <!-- AR RUM (PAKAI DATA CKEDITOR) -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Ayat Suci</h2>
      <div class="mt-4" data-aos="fade-up">
        {!! $wedding->quote_quran !!}
        <!-- RENDER HTML DARI CKEDITOR -->
      </div>
    </div>

    <!-- LOVE STORY (LOOPING DARI TABLE STORIES) -->
    <div class="container py-5" id="story">
      <h2 class="text-center mb-5">Love Story</h2>
      {{-- <div class="timeline">
@foreach($wedding->stories as $index => $story)
        <div class="timeline-item" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}">
      <div class="timeline-content">
        <h5>{{ $story->year }} - {{ $story->title_moment }}</h5>
        <p>{{ $story->cerita }}</p>
      </div>
    </div>
    @endforeach
    </div> --}}
    @foreach($wedding->stories as $index => $story)
      <p class="card-text text-muted text-center" style="line-height: 1.8; font-style: italic; font-size: 1.05rem;">
        "{{ $story->cerita }}"
      </p>
    @endforeach
    </div>

    <!-- MOMEN BAHAGIA -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Momen Bahagia</h2>
      <div class="row mt-5">
        <div class="col-md-6" data-aos="fade-right">
          <h4>Akad Nikah</h4>
          <p>
            {{ \Carbon\Carbon::parse($wedding->tgl_akad)->translatedFormat('l, d F Y') }}<br>
            {{ \Carbon\Carbon::parse($wedding->tgl_akad)->format('H:i') }} WIB
          </p>
        </div>

        <div class="col-md-6" data-aos="fade-left">
          <h4>Resepsi</h4>
          <p>
            {{ \Carbon\Carbon::parse($wedding->tgl_resepsi)->locale('id')->translatedFormat('l, d F Y') }}<br>
            {{ \Carbon\Carbon::parse($wedding->tgl_resepsi)->locale('id')->format('H:i') }}
            WIB -
            Selesai
          </p>
        </div>
      </div>

      <div class="mt-5">
        <h4>Menuju Hari Bahagia</h4>
        <!-- Pass tanggal ke data-attribute untuk JS -->
        <div id="countdown" class="countdown" data-time="{{ $wedding->tgl_akad }}"></div>
      </div>
    </div>

    <!-- LOKASI -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Lokasi Acara</h2>
      <p><b>{{ $wedding->lokasi_nama }}</b><br>{{ $wedding->lokasi_address }}</p>

      <iframe src="{{ $wedding->maps_url }}" width="100%" height="350" style="border:0;border-radius:12px;"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

      <div class="mt-4">
        <a href="{{ $wedding->maps_url }}" target="_blank" class="btn btn-dark">
          Buka Google Maps
        </a>
      </div>
    </div>

    <!-- GALERI (LOOPING DARI TABLE GALLERIES) -->
    <div class="container py-5" id="gallery">
      <h2 class="text-center mb-5" data-aos="fade-up">Galeri Kenangan</h2>

      <div class="masonry-gallery">
        @foreach($wedding->galleries as $gallery)
          <div class="gallery-card" data-aos="zoom-in">
            <img src="{{ asset($gallery->image_path) }}" class="gallery-img">
          </div>
        @endforeach
      </div>
    </div>

    <!-- RSVP -->
    <div class="container py-5" id="rsvp">
      <div class="rsvp-section p-4" data-aos="fade-up">
        <h2 class="text-center mb-5 fw-bold">RSVP & Ucapan</h2>
        <div class="row row-equal justify-content-center">
          <div class="col-md-6 border-end-md">
            <div class="rsvp-box">
              <form id="rsvpForm">
                <div class="mb-3">
                  <label class="form-label small fw-bold">Nama Tamu</label>
                  <input type="text" class="form-control form-control-lg bg-light border-0" value="{{ $nama_tamu }}"
                    readonly id="nama">
                </div>

                <div class="mb-3">
                  <label class="form-label small fw-bold">Konfirmasi Kehadiran</label>
                  <select class="form-select form-control-lg border-0 bg-light" id="kehadiran" required>
                    <option value="" disabled>-- Pilih Kehadiran --</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Tidak Hadir">Tidak Hadir</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label small fw-bold">Ucapan & Doa</label>
                  <textarea class="form-control border-0 bg-light" placeholder="Tulis doa restu Anda..." id="ucapans"
                    rows="4" required></textarea>
                </div>

                <button type="submit" id="btnKirim" class="btn btn-dark w-100 fw-bold py-3 rounded-3 shadow-sm">Kirim
                  Ucapan</button>
              </form>
            </div>
          </div>

          <div class="col-md-6">
            <div class="guestbook-box">
              <h6 class="fw-bold mt-3 ms-3 d-flex align-items-center">
                <i class="bi bi-chat-heart text-danger me-2" style="font-size: 1.2rem;"></i>
                Doa & Ucapan Tamu
              </h6>
              <div id="ucapanList" class="ucapan-list-wrapper">
                @foreach($ucapanS as $u)
                  <div class="ucapan-item card mb-3 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">{{ $u->name }}</h6>
                        <span
                          class="badge {{ $u->kehadiran === 'Hadir' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill"
                          style="font-size: 0.7rem;">
                          {{ $u->kehadiran }}
                        </span>
                      </div>
                      <p class="text-muted small mb-1">{{ $u->ucapan }}</p>
                      <small class="text-muted" style="font-size: 0.7rem;">
                        <i
                          class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }}
                      </small>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- PENUTUP -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Terima Kasih</h2>
      <p data-aos="fade-up">
        Merupakan suatu kehormatan bagi kami apabila
        Bapak/Ibu/Saudara/i berkenan hadir. Kami ucapkan terima kasih atas doa dan dukungan yang diberikan kepada kami.
        <br><br>

        <b>{{ $wedding->m_pria_panggilan }} & {{ $wedding->m_wanita_panggilan }}</b> <br>
        <small class="text-muted mb-5">Wedding Invitation created by Idham Mansyah Awwalu</small>
      </p>
    </div>

    <!-- FLOATING NAV -->
    <nav class="floating-nav">
      <a href="#hero" class="active">Home</a>
      <a href="#mempelai">Mempelai</a>
      <a href="#story">Story</a>
      <a href="#gallery">Gallery</a>
    </nav>

    <!-- MUSIC -->
    <button id="musicBtn" class="music-btn">🎵</button>
  </section>

  <audio id="music" loop>
    <source src="{{ asset($wedding->music_path) }}">
  </audio>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.26.24/dist/sweetalert2.all.min.js "></script>
  <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.26.24/dist/sweetalert2.min.css " rel="stylesheet">
  <script>
    window.sakuraPath = "{{ asset('assets/img/flower/sakura.png') }}";

  </script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script>
    $('#rsvpForm').on('submit', function (e) {
      e.preventDefault();

      // 1. Ambil data
      const btn = $('#btnKirim');
      const weddingId = "{{ $wedding->id }}";
      const nama = $('#nama').val();
      const kehadiran = $('#kehadiran').val();
      const ucapan = $('#ucapans').val();

      // Debugging: Cek di console log (F12)
      console.log("Mengirim data:", {
        weddingId,
        nama,
        kehadiran,
        ucapan
      });

      if (!kehadiran) {
        swal.fire('Opps!', 'Pilih status kehadiran dulu bray.', 'warning');
        return;
      }

      // 2. Loading State
      btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Mengirim...');

      // 3. AJAX Request
      $.ajax({
        url: "{{ route('store.ucapan', ['slug' => $wedding->slug, 'guest_name' => $nama_tamu]) }}",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          wedding_id: weddingId,
          nama_tamu: nama,
          kehadiran: kehadiran,
          ucapan: ucapan
        },
        success: function (response) {
          if (response.status === 'success') {
            // Reset Form
            $('#ucapans').val('');
            $('#kehadiran').val('').trigger('change');

            // Template Ucapan Baru
            let badgeClass = response.data.kehadiran === 'Hadir' ? 'bg-success-subtle text-success' :
              'bg-danger-subtle text-danger';

            let newUcapan = `
            <div class="ucapan-item card mb-3 shadow-sm animate__animated animate__fadeInDown" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">${response.data.nama}</h6>
                        <span class="badge ${badgeClass} rounded-pill" style="font-size: 0.7rem;">${response.data.kehadiran}</span>
                    </div>
                    <p class="text-muted small mb-1">${response.data.ucapan}</p>
                    <small class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-clock me-1"></i>Baru saja</small>
                </div>
            </div>`;

            $('#ucapanList').prepend(newUcapan);

            swal.fire({
              icon: 'success',
              title: 'Terkirim!',
              text: 'Terima kasih atas doa restunya.',
              timer: 2000,
              showConfirmButton: false
            });
          }
        },
        error: function (xhr) {
          // Biar tau salahnya dimana
          console.error(xhr.responseText);
          let msg = 'Gagal kirim ucapan.';
          if (xhr.status === 422) msg = 'Pastikan semua form sudah terisi dengan benar.';

          swal.fire('Error', msg, 'error');
        },
        complete: function () {
          btn.prop('disabled', false).html('Kirim Ucapan');
        }
      });
    });

  </script>

</body>

</html>
