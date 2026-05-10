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
        <h5 id="guestName">Testing</h5> <!-- NAMA TAMU DARI URL -->
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
        {{ \Carbon\Carbon::parse($wedding->tgl_resepsi)->translatedFormat('l, d F Y') }}
      </p>
      <div class="mt-4" data-aos="fade-up" data-aos-delay="200">
        <a href="https://www.google.com/calendar/render?action=TEMPLATE&text=Pernikahan+{{ $wedding->m_pria_panggilan }}+%26+{{ $wedding->m_wanita_panggilan }}&dates={{ \Carbon\Carbon::parse($wedding->tgl_akad)->format('Ymd\THis\Z') }}"
          target="_blank" class="btn btn-light">
          Save The Date
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
            {{ \Carbon\Carbon::parse($wedding->tgl_resepsi)->locale('id')->format('H:i') }} WIB -
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
      <h2 class="text-center mb-4">RSVP & Ucapan</h2>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form id="rsvpForm">
            <input type="text" class="form-control mb-3" value="" readonly id="nama">
            <select class="form-control mb-3" id="kehadiran">
              <option value="">Konfirmasi Kehadiran</option>
              <option>Hadir</option>
              <option>Tidak Hadir</option>
            </select>
            <textarea class="form-control mb-3" placeholder="Ucapan" id="ucapan"></textarea>
            <button class="btn btn-dark w-100">Kirim</button>
          </form>
        </div>
      </div>
    </div>

    <!-- PENUTUP -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Terima Kasih</h2>
      <p data-aos="fade-up">
        Merupakan suatu kehormatan bagi kami apabila
        Bapak/Ibu/Saudara/i berkenan hadir.
      </p>

      <h4 class="mt-4">{{ $wedding->m_pria_panggilan }} & {{ $wedding->m_wanita_panggilan }}</h4>
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
  <script>
    window.sakuraPath = "{{ asset('assets/img/flower/sakura.png') }}";
  </script>
  <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>
