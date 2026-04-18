<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Wedding Invitation</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">

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
        <h5 id="guestName">Tamu Undangan</h5>
        <b>Di Tempat</b> <br><br>
        <button id="openBtn" class="btn btn-dark">
          Buka Undangan
        </button>
      </div>

      <!-- KARTU UNDANGAN -->
      <div class="letter text-center">
        <h3>Wedding Invitation</h3>
        <h2>Riska & Idham</h2>
      </div>
    </div>
  </section>

  <!-- MAIN -->
  <section id="invitation">
    <!-- HERO -->
    <div class="hero text-white text-center" id="hero">
      <h1 data-aos="zoom-in">Riska & Idham</h1>
      <p data-aos="fade-up">Sabtu, 13 Juni 2026</p>
      <div class="mt-4" data-aos="fade-up" data-aos-delay="200">
        <a href="https://www.google.com/calendar/render?action=TEMPLATE&text=Pernikahan+Riska+%26+Idham&dates=20260613T010000Z/20260613T050000Z"
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
          <img src="assets/img/pria.jpg" class="img-fluid rounded-circle mb-3" width="200">
          <h4>Idham Mansyah</h4>
          <p>
            Putra ke-2 dari<br>
            Bapak Ahmad Mansyah<br>
            & Ibu Siti Aisyah
          </p>
        </div>

        <div class="col-md-6" data-aos="fade-left">
          <img src="assets/img/wanita.jpg" class="img-fluid rounded-circle mb-3" width="200">
          <h4>Riska Oktaviani</h4>
          <p>
            Putri ke-1 dari<br>
            Bapak Budi Santoso<br>
            & Ibu Dewi Lestari
          </p>
        </div>
      </div>
    </div>

    <!-- AR RUM -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">QS. Ar-Rum : 21</h2>
      <p class="mt-4" style="font-size:22px" data-aos="fade-up">
        وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُمْ مِنْ أَنْفُسِكُمْ أَزْوَاجًا
        لِتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُمْ مَوَدَّةً وَرَحْمَةً
      </p>

      <p class="mt-3" data-aos="fade-up">
        "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan
        untukmu pasangan hidup dari jenismu sendiri,
        supaya kamu merasa tenteram kepadanya,
        dan dijadikan-Nya di antaramu rasa kasih dan sayang."
      </p>
    </div>

    <!-- LOVE STORY -->
    <div class="container py-5" id="story">
      <h2 class="text-center mb-5">Love Story</h2>
      <div class="timeline">
        <div class="timeline-item" data-aos="fade-right">
          <div class="timeline-content">
            <h5>2018 - Pertama Bertemu</h5>
            <p>Kami pertama kali bertemu di acara kampus.</p>
          </div>
        </div>

        <div class="timeline-item" data-aos="fade-left">
          <div class="timeline-content">
            <h5>2019 - Mulai Bersama</h5>
            <p>Cerita cinta kami dimulai.</p>
          </div>
        </div>

        <div class="timeline-item" data-aos="fade-right">
          <div class="timeline-content">
            <h5>2025 - Lamaran</h5>
            <p>Kami memutuskan ke jenjang lebih serius.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- MOMEN BAHAGIA -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Momen Bahagia</h2>
      <div class="row mt-5">
        <div class="col-md-6" data-aos="fade-right">
          <h4>Akad Nikah</h4>
          <p>
            Sabtu, 13 Juni 2026<br>
            08.00 WIB
          </p>
        </div>

        <div class="col-md-6" data-aos="fade-left">
          <h4>Resepsi</h4>
          <p>
            Sabtu, 13 Juni 2026<br>
            11.00 WIB - Selesai
          </p>
        </div>
      </div>

      <div class="mt-5">
        <h4>Menuju Hari Bahagia</h4>
        <div id="countdown" class="countdown"></div>
      </div>
    </div>

    <!-- LOKASI -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Lokasi Acara</h2>
      <iframe src="https://maps.google.com/maps?q=jakarta&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="350"
        style="border:0;border-radius:12px;">
      </iframe>
      <div class="mt-4">
        <a href="https://share.google/agLpULNYJjxu1ndx3" target="_blank" class="btn btn-dark">
          Buka Google Maps
        </a>
      </div>
    </div>

    <!-- GALERI -->
    <div class="container py-5" id="gallery">
      <h2 class="text-center mb-5" data-aos="fade-up">Galeri Kenangan</h2>

      <div class="masonry-gallery">
        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/600?1" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/700?2" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/500?3" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/800?4" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/650?5" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/550?6" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/750?7" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/750?7" class="gallery-img">
        </div>

        <div class="gallery-card" data-aos="zoom-in">
          <img src="https://picsum.photos/500/750?7" class="gallery-img">
        </div>
      </div>
    </div>

    <!-- LOVE GIFT -->
    <div class="container py-5 text-center">
      <h2 data-aos="fade-up">Love Gift</h2>
      <p data-aos="fade-up">
        Doa restu Anda merupakan karunia yang sangat berarti bagi kami.
      </p>
    </div>

    <!-- RSVP -->
    <div class="container py-5" id="rsvp">
      <h2 class="text-center mb-4">RSVP & Ucapan</h2>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form id="rsvpForm">
            <input type="text" class="form-control mb-3" placeholder="Nama Anda" id="nama">
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

      <div class="row justify-content-center mt-5">
        <div class="col-md-6">
          <div id="guestbook"></div>
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

      <h4 class="mt-4">Riska & Idham</h4>

    </div>

    <!-- FLOATING NAV -->
    <nav class="floating-nav">
      <a href="#hero" class="active">Home</a>
      <a href="#mempelai" class="">Mempelai</a>
      <a href="#story" class="">Story</a>
      <a href="#gallery" class="">Gallery</a>
    </nav>

    <!-- MUSIC -->
    <button id="musicBtn" class="music-btn">🎵</button>
  </section>

  <audio id="music" loop>
    <source src="{{asset('assets/music/music.mp3')}}">
  </audio>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Simpan path ke dalam variabel global window
    window.sakuraPath = "{{ asset('assets/img/flower/sakura.png')}}";
  </script>
  <script src="{{asset('assets/js/script.js')}}"></script>

</body>

</html>
