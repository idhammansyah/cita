<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editor Undangan - Idham Mansyah & Riska Oktaviani</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display&family=Poppins&display=swap"
    rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&family=Dancing+Script:wght@400;700&display=swap');

    /* ======================================= */
    /* CSS Variables untuk Tema */
    /* ======================================= */
    :root {
      /* Warna default */
      --primary-color: #8b0000;
      --secondary-accent: #d97979;
      --background-gradient: linear-gradient(135deg, #f5e6e8 0%, #d5c4c6 100%);
    }

    /* ======================================= */
    /* CSS dari Editor Panel (kolom chat) */
    /* ======================================= */
    body {
      background: #f8f5f5;
      font-family: Poppins, sans-serif;
    }

    .editor-panel {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      height: 100vh;
      overflow-y: auto;
      border-right: 1px solid #ddd;
      position: sticky;
      top: 0;
    }

    .preview-area {
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* ======================================= */
    /* CSS Responsive Preview Toggle */
    /* ======================================= */
    .view-mode-selector {
      margin-top: 20px;
      width: 100%;
      max-width: 1000px;
    }

    .book-container-wrapper.mobile-view {
      max-width: 420px;
      margin: 20px auto;
      border: 10px solid #ddd;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
      border-radius: 30px;
      background-color: #fff;
      overflow: hidden;
      padding: 0 !important;
      min-height: 80vh;
    }

    .book-container-wrapper.mobile-view .book-container {
      transform: scale(1) !important;
      max-width: 100% !important;
      margin: 0 auto !important;
      padding: 0;
    }

    /* ======================================= */
    /* CSS dari Undangan (index.blade.php) */
    /* ======================================= */
    .book-container-wrapper {
      background: var(--background-gradient);
      font-family: 'Lato', sans-serif;
      overflow-x: hidden;
      min-height: 100vh;
      padding: 20px 0;
      transition: all 0.5s ease;
      width: 100%;
    }

    .book-container {
      perspective: 2500px;
      width: 100%;
      max-width: 1000px;
      margin: 50px auto;
      position: relative;
      box-sizing: border-box;
    }

    .book {
      position: relative;
      width: 100%;
      padding-bottom: 65%;
      height: 0;
      transform-style: preserve-3d;
      will-change: transform, box-shadow;
    }

    .page {
      position: absolute;
      width: 50%;
      height: 100%;
      background: white;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
      transform-origin: left center;
      transition: transform 0.8s ease-in-out;
      will-change: transform;
      backface-visibility: hidden;
      opacity: 1;
      display: block;
    }

    .page-left {
      left: 0;
      border-right: 1px solid #f0f0f0;
    }

    .page-right {
      right: 0;
      border-left: 1px solid #f0f0f0;
    }

    .page.flipped {
      transform: rotateY(-180deg);
      box-shadow: -8px 0 25px rgba(0, 0, 0, 0.25);
    }

    .page.hide {
      display: none !important;
      opacity: 0 !important;
    }

    .page-content {
      padding: 50px 40px;
      height: 100%;
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
    }

    /* ======================================= */
    /* CSS BARU: Centering Halaman 50% (Cover & Thank You) */
    /* ======================================= */

    /* Kelas untuk halaman yang diposisikan di tengah (50% lebar buku) */
    .page.is-center-pos {
      /* Memosisikan halaman (yang 50% lebar) tepat di tengah */
      left: 25% !important;
      right: 25% !important;
      width: 50% !important;

      /* Pastikan tidak ada transform flip yang mengganggu */
      transform: none !important;

      /* Override border dari .page-left/.page-right untuk tampilan terpusat yang bersih */
      border-right: none !important;
      border-left: none !important;
    }

    /* ======================================= */


    /* FIX: WARNA TOMBOL NAVIGASI */
    .nav-buttons {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      width: 100%;
      margin-top: 30px;
      margin-bottom: 30px;
      z-index: 99;
    }

    .nav-btn {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 10px 20px;
      margin: 0 10px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.1s;
      font-size: 1rem;
    }

    .nav-btn:hover:not(:disabled) {
      background-color: var(--secondary-accent);
      transform: translateY(-2px);
    }

    .nav-btn:disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }

    /* Menggunakan Primary Color */
    .title-text,
    .groom-name,
    .bride-name,
    .calendar-title,
    .profile-name,
    .glimpse-title,
    .story-title,
    .detail-title,
    .gift-title,
    .rsvp-title,
    .thankyou-title {
      font-family: 'Great Vibes', cursive;
      font-weight: 700;
      color: var(--primary-color);
    }

    .groom-name,
    .bride-name {
      width: 100%;
    }

    /* Menggunakan Secondary Accent Color */
    .cover-border {
      border: 2px solid var(--secondary-accent);
      padding: 20px;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .bow-decoration,
    .hearts-row,
    .tagline,
    .event-card i {
      color: var(--secondary-accent);
    }

    .bow {
      position: absolute;
    }

    .top-left {
      top: 5px;
      left: 5px
    }

    .top-right {
      top: 5px;
      right: 5px
    }

    .bottom-left {
      bottom: 5px;
      left: 5px
    }

    .bottom-right {
      bottom: 5px;
      right: 5px
    }

    .wedding-rings circle {
      stroke: var(--secondary-accent);
    }

    .calendar-day.highlight {
      background-color: var(--secondary-accent);
      color: white !important;
      font-weight: bold;
      box-shadow: 0 2px 5px rgba(217, 121, 121, 0.5);
    }

    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 5px;
      font-size: 12px;
    }

    .wedding-text {
      font-family: 'Playfair Display', serif;
      font-size: 12px;
      letter-spacing: 2px;
      color: #555;
      margin-top: 20px;
    }

    .wedding-rings {
      width: 80px;
      height: 80px;
      margin: 15px 0;
    }

  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">

      <div class="col-xl-4 col-lg-5 editor-panel">
        <h3 class="fw-bold mb-4 text-center">Editor Undangan</h3>

        <div class="editorSteps">
          <div class="editor-step" id="editor-page-1">
            <h5 class="text-danger">Page 1 <br><br>Judul & Nama</h5>

            <div class="mb-3">
              <label class="text-muted">Nama Pria <b class="text-danger">*</b></label>
              <input id="groomCoverInput" class="form-control" name="" required>
            </div>

            <div class="mb-3">
              <label class="text-muted">Nama Wanita <b class="text-danger">*</b></label>
              <input id="brideCoverInput" class="form-control" name="" required>
            </div>

            <div class="mb-3">
              <label class="text-muted" class="form-label">Tanggal Pernikahan <b class="text-danger">*</b></label>
              <input type="text" id="dateCoverInput" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="text-muted">Tagline</label>
              <input id="taglineInput" class="form-control" name="" placeholder="(optional)">
            </div>

            <hr>

            <h5 class="text-danger">Font & Posisi</h5>

            <div class="mb-3">
              <label class="text-muted">Font Family</label>
              <select id="fontInput" class="form-select">
                <option value="'Great Vibes', cursive" selected>Great Vibes</option>
                <option value="'Playfair Display', serif">Playfair Display</option>
                <option value="'Poppins', sans-serif">Poppins</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="text-muted">Ukuran Nama (px)</label>
              <input type="range" min="20" max="50" value="25" id="nameSizeInput">
            </div>

            <div class="mb-3">
              <label class="text-muted">Text Align</label>
              <select id="alignInput" class="form-control">
                <option value="center">Center</option>
                <option value="left">Left</option>
                <option value="right">Right</option>
              </select>
            </div>

            <hr>

            <h5 class="text-danger">Dekorasi</h5>

            <div class="mb-3">
              <label class="text-muted">Icon Pita</label>
              <select id="bowIconInput" class="form-control">
                <option value="🎀">🎀</option>
                <option value="🌸">🌸</option>
                <option value="✨">✨</option>
                <option value="❀">❀</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="text-muted">Ukuran Pita</label>
              <input type="range" min="10" max="40" value="20" id="bowSizeInput">
            </div>

            <div class="mb-3">
              <label class="text-muted">Hati</label>
              <select id="heartInput" class="form-control">
                <option value="♡ ♡ ♡">♡ ♡ ♡</option>
                <option value="♥ ♥ ♥">♥ ♥ ♥</option>
                <option value="❥ ❥ ❥">❥ ❥ ❥</option>
              </select>
            </div>

          </div>

          <hr class="my-4">

          <div class="editor-step d-none" id="editor-page-2">
            <h5 class="mt-3 mb-2 text-danger"><i class="fas fa-paint-brush"></i> Styling & Tema</h5>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Background Undangan (Color/Gradient)</label>
              <input type="text" id="bgGradientInput" class="form-control"
                value="linear-gradient(135deg, #f5e6e8 0%, #d5c4c6 100%)"
                placeholder="cth: #f5f5f5 atau linear-gradient(...)">
            </div>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Warna Aksen Utama (HEX - cth: #8b0000)</label>
              <input type="text" id="primaryColorInput" class="form-control" value="#8b0000" placeholder="#8b0000">
            </div>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Warna Aksen Sekunder (HEX - cth: #d97979)</label>
              <input type="text" id="secondaryColorInput" class="form-control" value="#d97979" placeholder="#d97979">
            </div>

            <h5 class="mt-3 mb-2 text-danger"><i class="fas fa-calendar-alt"></i> Acara</h5>

            <div class="mb-3">
              <label class="text-muted" class="form-label">Tempat Acara (Akad & Resepsi)</label>
              <input type="text" id="venueInput" class="form-control" value="Gedung Masjuban">
            </div>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Waktu Akad</label>
              <input type="text" id="akadTimeInput" class="form-control" value="Pukul: 08.00 WIB - 10.00 WIB">
            </div>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Waktu Resepsi</label>
              <input type="text" id="resepsiTimeInput" class="form-control" value="Pukul: 11.00 WIB - selesai">
            </div>
          </div>

          <div class="editor-step d-none" id="editor-page-3">
            <hr class="my-4">

            <h5 class="mt-3 mb-2 text-danger"><i class="fas fa-user-friends"></i> Detail Mempelai</h5>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Nama Lengkap Wanita (Halaman Profil)</label>
              <input type="text" id="brideNameProfileInput" class="form-control" value="Ratnadewi">
            </div>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Nama Lengkap Pria (Halaman Profil)</label>
              <input type="text" id="groomNameProfileInput" class="form-control" value="Galih Setiabudi">
            </div>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Info Wanita (Cth: Putra/Putri dari...)</label>
              <textarea id="brideInfoInput" class="form-control"
                rows="3">📷 @ratnadewi.2025&#10;Putri Bapak John Setiawan &amp;&#10;Ibu Jeny Purwandari</textarea>
            </div>
            <div class="mb-3">
              <label class="text-muted" class="form-label">Info Pria (Cth: Putra/Putri dari...)</label>
              <textarea id="groomInfoInput" class="form-control"
                rows="3">📷 @galihsabudi2025&#10;Putra Bapak Dodo Sudiman &amp;&#10;Ibu Ani Rahmawati</textarea>
            </div>

            <hr class="my-4">
          </div>
        </div>

        <p class="text-muted text-center small mt-5">Auto Preview aktif • Perubahan tampil secara real-time</p>
      </div>

      <div class="col-xl-8 col-lg-7 preview-area d-flex justify-content-center align-items-center">

        {{-- <div class="view-mode-selector d-flex justify-content-center mb-3">
          <button class="btn btn-sm btn-dark me-2" id="viewDesktop"><i class="fas fa-desktop"></i> Desktop</button>
          <button class="btn btn-sm btn-outline-dark" id="viewMobile"><i class="fas fa-mobile-alt"></i> Mobile</button>
        </div> --}}

        <div class="book-container-wrapper">
          <div class="page-wrapper">
            <div class="book-container">
              <div class="book" id="book">
                <div class="page page-right" id="page1-right" style="z-index: 6;">
                  <div class="page-content">
                    <div class="cover-border">

                      <div class="bow-decoration bow top-left" data-key="bow"></div>
                      <div class="bow-decoration bow top-right" data-key="bow"></div>
                      <div class="bow-decoration bow bottom-left" data-key="bow"></div>
                      <div class="bow-decoration bow bottom-right" data-key="bow"></div>

                      <div class="decoration hearts" data-key="hearts"></div>

                      <svg class="wedding-rings" viewBox="0 0 100 100">
                        <circle cx="35" cy="45" r="15" fill="none" stroke="#d97979" stroke-width="2.5"></circle>
                        <circle cx="55" cy="45" r="15" fill="none" stroke="#d97979" stroke-width="2.5"></circle>
                      </svg>

                      <div class="wedding-text text-center">THE WEDDING OF <br><br></div>

                      <div class="groom-name" id="previewGroomCover"></div>
                      <div class="ambersand" id="previewGroomCover">&</div>
                      <div class="bride-name" id="previewBrideCover"></div>

                      <div class="wedding-date text-center" id="previewDateCover">30 June 2026</div>

                      <div class="flower-box">
                        <div class="flower-icon">🌸 🌼</div>
                      </div>

                      <div class="hearts-row">♡ ♡ ♡</div>

                      <div class="tagline" id="previewTagline">the beginning of our forever</div>
                    </div>
                  </div>
                </div>

                <div class="page page-left hide" id="page1-back" style="z-index: 6;">
                  <div class="page-content">
                    <div class="calendar-container">

                      <div class="calendar-title">Turut Mengundang</div>
                      <div class="calendar-subtitle">
                        Bpk/Ibu/Saudara/i dalam acara pernikahan kami
                      </div>

                      <div class="month-year" id="calendarMonthYear"></div>

                      <div class="calendar-grid" id="calendarGrid"></div>

                    </div>
                  </div>
                </div>

                <div class="page page-right hide" id="page2-right" style="z-index: 5;">
                  <div class="page-content">
                    <div class="save-date-box">
                      <div class="save-date-title">Save the Date</div>
                      <p style="font-size: 13px; color: #666; margin-bottom: 25px;">
                        Dan baik yang hadir lebih bahayu bermanfaat bagi seolek untuk masjid
                      </p>

                      <div class="event-card">
                        <div style="text-align: center; margin-bottom: 15px;">
                          <i class="fas fa-ring" style="font-size: 24px;"></i>
                        </div>
                        <div class="event-title">Akad</div>
                        <div class="event-detail">
                          <span id="previewDateAkad">12 Desember 2025</span><br>
                          <span id="previewAkadTime">Pukul: 08.00 WIB - 10.00 WIB</span><br>
                          Tempat: <span id="previewAkadVenue">Gedung Masjuban</span>
                        </div>
                      </div>

                      <div class="event-card">
                        <div style="text-align: center; margin-bottom: 15px;">
                          <i class="fas fa-glass-cheers" style="font-size: 24px;"></i>
                        </div>
                        <div class="event-title">Resepsi</div>
                        <div class="event-detail">
                          <span id="previewDateResepsi">12 Desember 2025</span><br>
                          <span id="previewResepsiTime">Pukul: 11.00 WIB - selesai</span><br>
                          Tempat: <span id="previewResepsiVenue">Gedung Masjuban</span>
                        </div>
                      </div>

                      <div style="margin-top: 25px; color: var(--secondary-accent); font-size: 18px;">
                        ✧･ﾟ: *✧･ﾟ:*
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page page-left hide" id="page2-back" style="z-index: 5;">
                  <div class="page-content">
                    <div class="section-title">The Bride<br>& Groom</div>

                    <div class="profile-card">
                      <div class="profile-name" id="previewBrideNameProfile">Ratnadewi</div>
                      <div class="profile-photo">
                        <i class="fas fa-user" style="font-size: 40px;"></i>
                      </div>
                      <div class="profile-info" id="previewBrideInfo" style="white-space: pre-wrap;">
                        📷 @ratnadewi.2025<br>
                        Putri Bapak John Setiawan &<br>
                        Ibu Jeny Purwandari
                      </div>
                    </div>

                    <div class="profile-card">
                      <div class="profile-name" id="previewGroomNameProfile">Galih Setiabudi</div>
                      <div class="profile-photo">
                        <i class="fas fa-user" style="font-size: 40px;"></i>
                      </div>
                      <div class="profile-info" id="previewGroomInfo" style="white-space: pre-wrap;">
                        📷 @galihsabudi2025<br>
                        Putra Bapak Dodo Sudiman &<br>
                        Ibu Ani Rahmawati
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page page-right hide" id="page3-right" style="z-index: 4;">
                  <div class="page-content">
                    <div class="glimpse-section">
                      <div class="glimpse-title">A Glimpse of Us</div>
                      <p style="font-size: 13px; color: var(--secondary-accent); margin-bottom: 20px;"
                        id="glimpseCoupleName">Galih &
                        Ratna</p>

                      <div class="photo-grid">
                        <div class="photo-placeholder">
                          <i class="fas fa-image" style="font-size: 30px;"></i>
                        </div>
                        <div class="photo-placeholder" style="grid-row: span 2;">
                          <i class="fas fa-image" style="font-size: 40px;"></i>
                        </div>
                        <div class="photo-placeholder">
                          <i class="fas fa-image" style="font-size: 30px;"></i>
                        </div>
                      </div>

                      <div class="story-text">
                        "Dua kepribadian di usia muda yang berjudul benci,<br>
                        ternyata tumbuh menjadi cinta yang telah menjadi kisah menarik yang akan dimulai hingga akhir
                        hidup
                        kami."<br>
                        - Galih & Ratna -
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page page-left hide" id="page3-back" style="z-index: 4;">
                  <div class="page-content">
                    <div class="love-story-section">
                      <div class="story-title">Love<br>Story</div>

                      <div class="story-item">
                        <div class="story-label">Awal Perkenalan</div>
                        <div class="story-content">
                          Semua berawal dari pertemuan yang singkat dan sederhana, ketika dia saat kami berbeda dunia
                          itu
                          membuat kami menguap. Dan setiap, bagi kami cinta tidak dipilih, tetapi takdir menciptakan,
                          renung
                          yang alami sangat istiqamah.
                        </div>
                      </div>

                      <div style="text-align: center; margin: 15px 0; color: var(--secondary-accent);">
                        ✧･ﾟ: *✧･ﾟ:*
                      </div>

                      <div class="story-item">
                        <div class="story-label">Perselisihan</div>
                        <div class="story-content">
                          Mencari seoatua yang pinkan. Perlibatan kami dimulai dari berbedaa misi, sebuah perjalanan
                          yang
                          membawa saljar seadang "jadi, cinta banyak kisah perkembangan yang terkedat".
                        </div>
                      </div>

                      <div style="text-align: center; margin: 15px 0; color: var(--secondary-accent);">
                        ✧･ﾟ: *✧･ﾟ:*
                      </div>

                      <div class="story-item">
                        <div class="story-label">Lamaran</div>
                        <div class="story-content">
                          Seogang lamaran merujuk tenisa halitima bersama menja kita menhukiri tujuan kita, sebuah era,
                          terohang
                          "jalan yang meno sebuah semangat untuk memutpikan cinta yang telah terjalin".
                        </div>
                      </div>

                      <div style="text-align: center; margin: 15px 0; color: var(--secondary-accent);">
                        ✧･ﾟ: *✧･ﾟ:*
                      </div>

                      <div class="story-item">
                        <div class="story-label">Menikah</div>
                        <div class="story-content">
                          Pada, Dimahir maharyya untuk menghali arit awal lainnya simbol sebuah bercancang jaga Dari.
                          Dengan
                          penuh syukur, komitmen tenggang kita mengandalkan di kepeda cinta yang sangat dalam untuk
                          memulai.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page page-right hide" id="page4-right" style="z-index: 3;">
                  <div class="page-content">
                    <div class="detail-section">
                      <div class="detail-title">detail<br>lokasi</div>

                      <div class="detail-item">
                        <div style="margin-bottom: 15px;">
                          <div
                            style="width: 80px; height: 80px; margin: 0 auto; border: 2px solid var(--secondary-accent); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-qrcode" style="font-size: 50px; color: var(--secondary-accent);"></i>
                          </div>
                        </div>
                        <div class="detail-text">
                          Buka Lokasi di Google Maps
                        </div>
                      </div>

                      <div style="margin: 30px 0;">
                        ───── ✧ ─────
                      </div>

                      <div class="detail-item">
                        <div class="detail-label">dresscode</div>
                        <div style="margin: 15px 0;">
                          <div
                            style="width: 100px; height: 100px; margin: 0 auto; background: linear-gradient(135deg, #ffb6c1, #ffc0cb); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-tshirt" style="font-size: 40px; color: white;"></i>
                          </div>
                        </div>
                        <div class="detail-text">
                          Kami mengharapkan Bapak/Ibu/Saudara/i<br>
                          mengenakan pakaian dengan<br>
                          nuansa pink, salem dan putih
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page page-left hide" id="page4-back" style="z-index: 3;">
                  <div class="page-content">
                    <div class="gift-section">
                      <div class="gift-title">gift of love</div>

                      <div class="gift-text">
                        Jika ingin mengirimkan hadiah untuk kami, dapat dikirim<br>
                        melalui alamat transfer yang kami dengan link tombol<br>
                        "KIRIM HADIAH" dibawah ini!
                      </div>

                      <div style="text-align: center; margin: 30px 0;">
                        <div style="display: inline-block;">
                          <i class="fas fa-gift" style="font-size: 50px; color: var(--secondary-accent);"></i>
                          <i class="fas fa-gift"
                            style="font-size: 40px; color: var(--secondary-accent); margin: 0 10px;"></i>
                          <i class="fas fa-gift" style="font-size: 45px; color: var(--secondary-accent);"></i>
                        </div>
                      </div>

                      <div class="gift-box">
                        <div
                          style="font-family: 'Dancing Script', cursive; font-size: 24px; color: var(--secondary-accent); margin-bottom: 10px;">
                          KIRIM HADIAH
                        </div>
                        <div style="font-size: 12px; color: #666;">
                          Klik untuk mengirim hadiah
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page page-right hide" id="page5-right" style="z-index: 2;">
                  <div class="page-content" style="display: flex; align-items: center; justify-content: center;">
                    <div class="rsvp-card">
                      <div style="position: relative; z-index: 1;">
                        <div style="margin-bottom: 20px;">
                          <i class="fas fa-wine-glass-alt" style="font-size: 50px;"></i>
                        </div>

                        <div class="rsvp-title">Wedding</div>
                        <div class="rsvp-subtitle">RSVP</div>

                        <div style="margin: 20px 0; color: var(--secondary-accent);">
                          ✧･ﾟ: *✧･ﾟ:*
                        </div>

                        <div class="rsvp-date">12 Des '25</div>

                        <div style="margin: 20px 0;">
                          ─────────
                        </div>

                        <div class="rsvp-text">
                          Bila teman inginkan tidak konfirmasi<br>
                          kehadirannya<br>
                          <br>
                          <strong>RSVP</strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="page page-left hide" id="page5-back" style="z-index: 2;">
                  <div class="page-content">
                    <div class="thankyou-section">
                      <div class="thankyou-title">Thank<br>You</div>

                      <div style="margin: 30px 0;">
                        <svg class="couple-illustration" viewBox="0 0 200 200">
                          <circle cx="60" cy="50" r="25" fill="none" stroke="#333" stroke-width="2" />
                          <line x1="60" y1="75" x2="60" y2="130" stroke="#333" stroke-width="2" />
                          <line x1="60" y1="90" x2="40" y2="110" stroke="#333" stroke-width="2" />
                          <line x1="60" y1="90" x2="80" y2="110" stroke="#333" stroke-width="2" />
                          <line x1="60" y1="130" x2="45" y2="160" stroke="#333" stroke-width="2" />
                          <line x1="60" y1="130" x2="75" y2="160" stroke="#333" stroke-width="2" />

                          <circle cx="140" cy="50" r="25" fill="none" stroke="#333" stroke-width="2" />
                          <path d="M 120 75 Q 130 85 140 75 Q 150 65 160 75" fill="white" stroke="#333"
                            stroke-width="2" />
                          <line x1="140" y1="75" x2="140" y2="130" stroke="#333" stroke-width="2" />
                          <line x1="140" y1="90" x2="120" y2="110" stroke="#333" stroke-width="2" />
                          <line x1="140" y1="90" x2="160" y2="110" stroke="#333" stroke-width="2" />
                          <line x1="140" y1="130" x2="125" y2="160" stroke="#333" stroke-width="2" />
                          <line x1="140" y1="130" x2="155" y2="160" stroke="#333" stroke-width="2" />

                          <path d="M 70 30 Q 100 10 130 30" fill="none" stroke="var(--secondary-accent)"
                            stroke-width="2" />
                          <circle cx="100" cy="15" r="5" fill="var(--secondary-accent)" />
                        </svg>
                      </div>

                      <div class="thankyou-text">
                        Terima kasih atas doa dan ucapan<br>
                        kehadirannya anda menjadi istimewa bagi keluarga<br>
                        kami lainnya yang telah hadir
                      </div>

                      <div class="hearts-row" style="margin: 30px 0;">
                        ♡ ♡ ♡
                      </div>

                      <div class="couple-names">
                        <span id="thankyouGroom">Galih</span> & <span id="thankyouBride">Ratna</span>
                      </div>

                      <div style="margin: 20px 0;">
                        <div style="display: inline-block; background: white; padding: 5px 15px; border-radius: 20px;">
                          🎀
                        </div>
                      </div>

                      <div class="credit">
                        Designed by Taptohear
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="nav-buttons">
                <button class="nav-btn" id="prevBtn" disabled>
                  <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn" id="nextBtn">
                  <i class="fas fa-chevron-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

  <script>
    /* =======================
      GLOBAL STATE
    ======================= */
    const state = {
      cover: {
        groom: '',
        bride: '',
        tagline: '',
        dates: '30 June 2026',
        nameSize: 25,
        font: "'Great Vibes', cursive",
        align: 'center',
        bow: '🎀',
        bowSize: 20,
        hearts: '♡ ♡ ♡'
      }
    };

    /* =======================
      RENDER COVER (PAGE 1)
    ======================= */
    function renderCover() {
      previewGroomCover.innerText = state.cover.groom;
      previewBrideCover.innerText = state.cover.bride;
      previewTagline.innerText = state.cover.tagline;
      previewDateCover.innerText = state.cover.dates;

      document
        .querySelectorAll('.groom-name, .ambersand, .bride-name')
        .forEach(el => {
          el.style.fontSize = state.cover.nameSize + 'px';
          el.style.fontFamily = state.cover.font;
          el.style.textAlign = state.cover.align;
        });

      document.querySelectorAll('[data-key="bow"]').forEach(el => {
        el.innerText = state.cover.bow;
        el.style.fontSize = state.cover.bowSize + 'px';
      });

      const hearts = document.querySelector('[data-key="hearts"]');
      if (hearts) hearts.innerText = state.cover.hearts;
    }

    /* =======================
      RENDER CALENDAR (PAGE BACK)
    ======================= */
    function renderCalendar() {
      if (!state.cover.dates) return;

      const date = new Date(state.cover.dates);
      if (isNaN(date)) return;

      const day = date.getDate();
      const month = date.getMonth();
      const year = date.getFullYear();

      const monthNames = [
        'JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI',
        'JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'
      ];

      calendarMonthYear.innerText =
        `${monthNames[month]} ${year}`;

      calendarGrid.innerHTML = '';

      // Header hari
      ['S','S','R','K','J','S','M'].forEach(d => {
        const el = document.createElement('div');
        el.className = 'calendar-day';
        el.style.fontWeight = 'bold';
        el.innerText = d;
        calendarGrid.appendChild(el);
      });

      const firstDay = new Date(year, month, 1).getDay();
      const offset = (firstDay + 6) % 7;

      for (let i = 0; i < offset; i++) {
        calendarGrid.appendChild(document.createElement('div'));
      }

      const totalDays = new Date(year, month + 1, 0).getDate();

      for (let i = 1; i <= totalDays; i++) {
        const el = document.createElement('div');
        el.className = 'calendar-day';
        el.innerText = i;
        if (i === day) el.classList.add('highlight');
        calendarGrid.appendChild(el);
      }
    }

    /* =======================
      MASTER RENDER
    ======================= */
    function renderAll() {
      renderCover();
      renderCalendar();
    }

    /* =======================
      FORM BINDING
    ======================= */
    groomCoverInput.oninput = e => {
      state.cover.groom = e.target.value;
      renderAll();
    };

    brideCoverInput.oninput = e => {
      state.cover.bride = e.target.value;
      renderAll();
    };

    taglineInput.oninput = e => {
      state.cover.tagline = e.target.value;
      renderAll();
    };

    nameSizeInput.oninput = e => {
      state.cover.nameSize = e.target.value;
      renderAll();
    };

    alignInput.onchange = e => {
      state.cover.align = e.target.value;
      renderAll();
    };

    fontInput.onchange = e => {
      state.cover.font = e.target.value;
      renderAll();
    };

    bowIconInput.onchange = e => {
      state.cover.bow = e.target.value;
      renderAll();
    };

    bowSizeInput.oninput = e => {
      state.cover.bowSize = e.target.value;
      renderAll();
    };

    heartInput.onchange = e => {
      state.cover.hearts = e.target.value;
      renderAll();
    };

    /* =======================
      DATE PICKER
    ======================= */
    $(function () {
      $('#dateCoverInput')
        .val(state.cover.dates)
        .datepicker({
          dateFormat: 'dd MM yy',
          onSelect: function (dateText) {
            state.cover.dates = dateText;
            renderAll();
          }
        });
    });

    /* =======================
      INIT
    ======================= */
    renderAll();
  </script>

  <script>
    $(document).ready(function () {

      let currentPage = 0;
      let isAnimating = false;
      const totalPages = 5;

      const rightPageSelectors = [
        '#page1-right',
        '#page2-right',
        '#page3-right',
        '#page4-right',
        '#page5-right'
      ];

      const leftPageSelectors = [
        null,
        '#page1-back',
        '#page2-back',
        '#page3-back',
        '#page4-back',
        '#page5-back'
      ];

      function updateButtons() {
        if ($(window).width() > 768) {
          $('#prevBtn').prop('disabled', currentPage === 0 || isAnimating);
          $('#nextBtn').prop('disabled', currentPage === totalPages || isAnimating);
        } else {
          $('#prevBtn, #nextBtn').prop('disabled', false);
        }
      }

     function updateEditorPanel(pageNum) {
        $('.editor-step').addClass('d-none');
        $('#editor-page-' + (pageNum + 1)).removeClass('d-none');
      }

      function showPage(pageNum) {

        if (isAnimating) return;
        isAnimating = true;

        $('.page')
          .removeClass('is-center-pos flipped fade-in')
          .addClass('hide');

        const isCentered = (pageNum === 0 || pageNum === totalPages);

        setTimeout(() => {

          if (isCentered) {

            if (pageNum === 0) {
              $('#page1-right').removeClass('hide').addClass('is-center-pos');
            }

            if (pageNum === totalPages) {
              $('#page5-back').removeClass('hide').addClass('is-center-pos');
            }

            isAnimating = false;
            updateButtons();
            updateEditorPanel(pageNum);

          } else {

            for (let i = 0; i < pageNum; i++) {
              $(rightPageSelectors[i]).removeClass('hide').addClass('flipped');
            }

            $(leftPageSelectors[pageNum]).removeClass('hide').addClass('fade-in');

            if (pageNum < totalPages) {
              $(rightPageSelectors[pageNum]).removeClass('hide');
            }

            setTimeout(() => {
              isAnimating = false;
              updateButtons();
              updateEditorPanel(pageNum);
            }, 850);
          }

        }, 10);
      }

      $('#nextBtn').on('click', () => {
        if (currentPage < totalPages && !isAnimating) {
          currentPage++;
          showPage(currentPage);
        }
      });

      $('#prevBtn').on('click', () => {
        if (currentPage > 0 && !isAnimating) {
          currentPage--;
          showPage(currentPage);
        }
      });

      $(window).on('resize', () => {
        updateButtons();
        showPage(currentPage);
      });

      const book = document.getElementById('book');
      let startX = 0;

      book.addEventListener('touchstart', e => {
        startX = e.changedTouches[0].screenX;
      }, { passive: true });

      book.addEventListener('touchend', e => {
        let diff = e.changedTouches[0].screenX - startX;
        if (diff > 50 && currentPage > 0) currentPage--;
        if (diff < -50 && currentPage < totalPages) currentPage++;
        showPage(currentPage);
      }, { passive: true });

      showPage(0);

    });
  </script>



  {{-- <script>
    // Fungsi untuk memperbarui CSS Variables
    function updateCssVariables(variable, value) {
      document.documentElement.style.setProperty(variable, value);
    }

    function updateLivePreview() {
      // 1. JUDUL & NAMA
      document.title = $("#titleInput").val();
      $("#previewBrideCover").text($("#brideCoverInput").val());
      $("#previewGroomCover").text($("#groomCoverInput").val());
      $("#previewTagline").text($("#taglineInput").val());
      $("#previewDateCover").text($("#dateCoverInput").val());
      $("#glimpseCoupleName").text($("#groomCoverInput").val() + " & " + $("#brideCoverInput").val());
      $("#thankyouGroom").text($("#groomCoverInput").val());
      $("#thankyouBride").text($("#brideCoverInput").val());


      // 2. STYLING & TEMA
      updateCssVariables('--background-gradient', $("#bgGradientInput").val());
      updateCssVariables('--primary-color', $("#primaryColorInput").val());
      updateCssVariables('--secondary-accent', $("#secondaryColorInput").val());


      // 3. IKON/EMOTICON
      const bowIcon = $("#bowIconInput").val() || '🎀';
      $(".bow-decoration").text(bowIcon);
      $("#page5-back .couple-illustration + div + div div").text(bowIcon);

      const heartIcon = $("#heartIconInput").val() || '♡';
      // Update semua elemen .hearts-row
      $(".hearts-row").each(function () {
        $(this).html(heartIcon + " " + heartIcon + " " + heartIcon);
      });
      // Update ikon cincin di cover (mengganti flower-icon)
      $("#page1-right .flower-box .flower-icon").text(heartIcon + " " + heartIcon);


      // 4. DETAIL MEMPELAI
      $("#previewBrideNameProfile").text($("#brideNameProfileInput").val());
      $("#previewGroomNameProfile").text($("#groomNameProfileInput").val());
      $("#previewBrideInfo").text($("#brideInfoInput").val());
      $("#previewGroomInfo").text($("#groomInfoInput").val());


      // 5. DETAIL ACARA
      const dateAkadResepsi = $("#dateCoverInput").val().replace(/\./g, ' ');
      $("#previewDateAkad").text(dateAkadResepsi);
      $("#previewDateResepsi").text(dateAkadResepsi);
      $("#previewAkadTime").text($("#akadTimeInput").val());
      $("#previewResepsiTime").text($("#resepsiTimeInput").val());
      $("#previewAkadVenue").text($("#venueInput").val());
      $("#previewResepsiVenue").text($("#venueInput").val());
    }

    // Panggil fungsi update setiap kali input berubah (AUTO PREVIEW)
    $("#titleInput, #brideCoverInput, #groomCoverInput, #taglineInput, #dateCoverInput, #brideNameProfileInput, #groomNameProfileInput, #brideInfoInput, #groomInfoInput, #venueInput, #akadTimeInput, #resepsiTimeInput, #primaryColorInput, #secondaryColorInput, #bgGradientInput, #bowIconInput, #heartIconInput")
      .on("keyup change", updateLivePreview);

    // Initial run
    updateLivePreview();

  </script> --}}

</body>

</html>
