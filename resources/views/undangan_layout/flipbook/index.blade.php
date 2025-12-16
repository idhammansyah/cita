<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wedding of Galih & Ratna</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&family=Dancing+Script:wght@400;700&display=swap');

    body {
      background: linear-gradient(135deg, #f5e6e8 0%, #d5c4c6 100%);
      font-family: 'Lato', sans-serif;
      overflow-x: hidden;
      min-height: 100vh;
      padding: 20px 0;
      transition: background 0.5s ease;
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
      /* ======================================= */
      /* Perubahan: Transisi Opacity ditambahkan di sini */
      transition: transform 0.8s ease-in-out, opacity 0.5s ease;
      /* ======================================= */
      will-change: transform, opacity;
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

    .page.is-center-pos {
      left: 25% !important;
      right: 25% !important;
      width: 50% !important;
      transform: none !important;
      border-right: none !important;
      border-left: none !important;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
    }

    .page-front {
      z-index: 10;
    }

    .page-back {
      z-index: 9;
    }

    .page.hide {
      display: none !important;
      opacity: 0 !important;
    }

    /* ======================================= */
    /* Menghapus class .page.fade-in yang lama */
    /* ======================================= */

    .page-content {
      padding: 50px 40px;
      height: 100%;
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
    }

    .title-text {
      font-family: 'Great Vibes', cursive;
      font-weight: 700;
      color: #8b0000;
    }

    .name-text {
      font-family: 'Dancing Script', cursive;
      font-weight: 700;
      color: #333;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      color: #555;
      border-bottom: 2px solid #ccc;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

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

    .book-controls {
      text-align: center;
      margin-top: 30px;
    }

    .nav-btn {
      background-color: #8b0000;
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
      background-color: #a52a2a;
      transform: translateY(-2px);
    }

    .nav-btn:disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }

    #page1-right .page-content {
      text-align: center;
    }

    .cover-border {
      border: 3px solid #d97979;
      padding: 20px;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .bow-decoration {
      position: absolute;
      font-size: 20px;
      color: #d97979;
    }

    .bow-top-left {
      top: 10px;
      left: 10px;
    }

    .bow-top-right {
      top: 10px;
      right: 10px;
    }

    .bow-bottom-left {
      bottom: 10px;
      left: 10px;
    }

    .bow-bottom-right {
      bottom: 10px;
      right: 10px;
    }

    .hearts-row {
      color: #d97979;
      margin: 10px 0;
      font-size: 18px;
    }

    .wedding-rings {
      width: 80px;
      height: 80px;
      margin: 15px 0;
    }

    .wedding-text {
      font-family: 'Playfair Display', serif;
      font-size: 14px;
      letter-spacing: 2px;
      color: #555;
      margin-top: 20px;
    }

    .groom-name {
      font-family: 'Great Vibes', cursive;
      font-size: 48px;
      color: #8b0000;
      margin-top: 10px;
    }

    .bride-name {
      font-family: 'Great Vibes', cursive;
      font-size: 48px;
      color: #8b0000;
      margin-bottom: 10px;
    }

    .wedding-date {
      font-family: 'Lato', sans-serif;
      font-weight: 700;
      font-size: 16px;
      color: #333;
      margin: 10px 0;
    }

    .tagline {
      font-family: 'Dancing Script', cursive;
      font-size: 20px;
      color: #d97979;
      margin-top: 15px;
    }

    .profile-card,
    .event-card,
    .detail-item {
      text-align: center;
      margin-bottom: 30px;
      padding: 15px;
      border: 1px dashed #f0f0f0;
      border-radius: 8px;
    }

    .profile-name {
      font-family: 'Dancing Script', cursive;
      font-size: 24px;
      color: #8b0000;
      margin-bottom: 10px;
    }

    .profile-photo {
      width: 80px;
      height: 80px;
      background-color: #f5f5f5;
      border-radius: 50%;
      margin: 0 auto 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #aaa;
    }

    .event-title {
      font-family: 'Playfair Display', serif;
      font-size: 20px;
      font-weight: 700;
      color: #333;
      margin-bottom: 5px;
    }

    .event-detail {
      font-size: 14px;
      color: #666;
    }

    .glimpse-title,
    .story-title,
    .detail-title,
    .gift-title,
    .rsvp-title,
    .thankyou-title {
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      font-weight: 700;
      color: #8b0000;
      text-align: center;
      margin-bottom: 20px;
    }

    .photo-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: 100px 100px;
      gap: 10px;
      margin-bottom: 25px;
    }

    .photo-placeholder {
      background-color: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 5px;
      color: #aaa;
    }

    .story-text {
      font-style: italic;
      font-size: 14px;
      color: #666;
      text-align: center;
      padding: 10px;
      border: 1px dotted #d97979;
      border-radius: 5px;
    }

    .story-item {
      margin-bottom: 20px;
      border-left: 3px solid #d97979;
      padding-left: 15px;
    }

    .story-label {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      color: #333;
      margin-bottom: 5px;
    }

    .story-content {
      font-size: 13px;
      color: #666;
    }

    .gift-box {
      border: 2px solid #d97979;
      padding: 20px;
      text-align: center;
      border-radius: 10px;
    }

    .rsvp-card {
      text-align: center;
      padding: 40px;
      border: 2px solid #d97979;
      border-radius: 10px;
      background-color: #fff9f9;
    }

    .rsvp-subtitle {
      font-family: 'Dancing Script', cursive;
      font-size: 30px;
      color: #d97979;
    }

    .rsvp-date {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      color: #333;
    }

    .rsvp-text {
      font-size: 14px;
      color: #666;
    }

    .couple-names {
      font-family: 'Great Vibes', cursive;
      font-size: 40px;
      color: #8b0000;
    }

    .thankyou-text,
    .credit {
      font-size: 14px;
      color: #666;
    }

    .calendar-container {
      text-align: center;
    }

    .calendar-title {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      color: #333;
    }

    .calendar-subtitle {
      font-size: 14px;
      color: #666;
      margin-bottom: 20px;
    }

    .month-year {
      font-family: 'Lato', sans-serif;
      font-weight: 700;
      font-size: 18px;
      color: #8b0000;
      margin-bottom: 10px;
    }

    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 5px;
      font-size: 12px;
    }

    .calendar-day {
      padding: 5px;
      border: 1px solid #eee;
      color: #333;
    }

    .calendar-day:nth-child(7n+1),
    .calendar-day:nth-child(7n) {
      color: #d97979;
    }

    .calendar-day.highlight {
      background-color: #d97979;
      color: white;
      font-weight: bold;
      border-radius: 50%;
      border: none;
    }


    @media (max-width: 768px) {

      body {
        padding: 0;
        margin: 0;
        overflow-x: hidden;
      }

      .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;
        padding: 0;
        margin: 0;
        position: relative;
      }

      .book-container {
        perspective: 1800px;
        width: 100%;
        max-width: 420px;
        margin: 0 auto;
        padding: 0;
        position: relative;
      }

      .book {
        width: 100%;
        aspect-ratio: 3 / 4;
        position: relative;
        height: auto;
        transform-style: preserve-3d;
      }

      .page-wrapper .page-wrapper {
        position: absolute;
        inset: 0;
      }

      .page {
        width: 50%;
        height: 100%;
        position: absolute;
        top: 0;
        background: white;
        transform-style: preserve-3d;
        backface-visibility: hidden;
        transition: transform 0.7s ease-in-out, opacity 0.5s ease;
        box-shadow: 0 3px 12px rgba(0, 0, 0, .15);
      }

      .page-left {
        left: 0;
        transform-origin: left center !important;
      }

      .page-right {
        right: 0;
        transform-origin: right center !important;
      }

      .page.flipped {
        transform: rotateY(-180deg) !important;
      }

      .page.hide {
        opacity: 0;
        pointer-events: none;
      }

      .page-content {
        height: 100%;
        overflow-y: auto;
        padding: 18px 14px;
      }

      .nav-btn {
        z-index: 999;
        font-size: 0.9rem;
        padding: 8px 14px;
      }

      .page-content {
        font-size: 12px;
        line-height: 1.35;
      }

      .title-text,
      .name-text,
      .section-title,
      .glimpse-title,
      .story-title,
      .detail-title,
      .gift-title,
      .rsvp-title,
      .thankyou-title {
        font-size: 12rem !important;
      }

      .groom-name,
      .bride-name {
        font-size: 2rem !important;
      }

      .tagline {
        font-size: 1.2rem !important;
      }

      .event-title,
      .profile-name {
        font-size: 1.1rem !important;
      }

      .story-text,
      .story-content,
      .event-detail,
      .calendar-subtitle,
      .rsvp-text,
      .thankyou-text,
      .credit {
        font-size: 0.8rem !important;
      }

      .calendar-day {
        font-size: 0.75rem !important;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="page-wrapper">
      <div class="book-container">
        <div class="book" id="book">
          <div class="page page-right" id="page1-right" style="z-index: 6;">
            <div class="page-content">
              <div class="cover-border">
                <div class="bow-decoration bow-top-left">🎀</div>
                <div class="bow-decoration bow-top-right">🎀</div>
                <div class="bow-decoration bow-bottom-left">🎀</div>
                <div class="bow-decoration bow-bottom-right">🎀</div>

                <div class="hearts-row">♡ ♡ ♡</div>

                <svg class="wedding-rings" viewBox="0 0 100 100">
                  <circle cx="35" cy="45" r="15" fill="none" stroke="#d97979" stroke-width="2.5" />
                  <circle cx="55" cy="45" r="15" fill="none" stroke="#d97979" stroke-width="2.5" />
                </svg>

                <div class="wedding-text">THE WEDDING OF</div>

                <div class="groom-name">Galih</div>
                <div class="bride-name">Ratna</div>

                <div class="wedding-date">12.12.2025</div>

                <div class="flower-box">
                  <div class="flower-icon">🌸 🌼</div>
                </div>

                <div class="hearts-row">♡ ♡ ♡</div>

                <div class="tagline">the beginning of our forever</div>
              </div>
            </div>
          </div>

          <div class="page page-left hide" id="page1-back" style="z-index: 6;">
            <div class="page-content">
              <div class="calendar-container">
                <div class="calendar-title">Turut mengundang</div>
                <div class="calendar-subtitle">Bpk/Ibu/Saudara/i dalam acara pernikahan kami</div>

                <div class="month-year">DESEMBER 2025</div>

                <div class="calendar-grid">
                  <div class="calendar-day" style="font-weight: bold;">S</div>
                  <div class="calendar-day" style="font-weight: bold;">S</div>
                  <div class="calendar-day" style="font-weight: bold;">R</div>
                  <div class="calendar-day" style="font-weight: bold;">K</div>
                  <div class="calendar-day" style="font-weight: bold;">J</div>
                  <div class="calendar-day" style="font-weight: bold;">S</div>
                  <div class="calendar-day" style="font-weight: bold;">M</div>

                  <div class="calendar-day">1</div>
                  <div class="calendar-day">2</div>
                  <div class="calendar-day">3</div>
                  <div class="calendar-day">4</div>
                  <div class="calendar-day">5</div>
                  <div class="calendar-day">6</div>
                  <div class="calendar-day">7</div>
                  <div class="calendar-day">8</div>
                  <div class="calendar-day">9</div>
                  <div class="calendar-day">10</div>
                  <div class="calendar-day">11</div>
                  <div class="calendar-day highlight">12</div>
                  <div class="calendar-day">13</div>
                  <div class="calendar-day">14</div>
                  <div class="calendar-day">15</div>
                  <div class="calendar-day">16</div>
                  <div class="calendar-day">17</div>
                  <div class="calendar-day">18</div>
                  <div class="calendar-day">19</div>
                  <div class="calendar-day">20</div>
                  <div class="calendar-day">21</div>
                  <div class="calendar-day">22</div>
                  <div class="calendar-day">23</div>
                  <div class="calendar-day">24</div>
                  <div class="calendar-day">25</div>
                  <div class="calendar-day">26</div>
                  <div class="calendar-day">27</div>
                  <div class="calendar-day">28</div>
                  <div class="calendar-day">29</div>
                  <div class="calendar-day">30</div>
                  <div class="calendar-day">31</div>
                </div>
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
                    <i class="fas fa-ring" style="font-size: 24px; color: #d97979;"></i>
                  </div>
                  <div class="event-title">Akad</div>
                  <div class="event-detail">
                    12 Desember 2025<br>
                    Pukul: 08.00 WIB - 10.00 WIB<br>
                    Tempat: Gedung Masjuban
                  </div>
                </div>

                <div class="event-card">
                  <div style="text-align: center; margin-bottom: 15px;">
                    <i class="fas fa-glass-cheers" style="font-size: 24px; color: #d97979;"></i>
                  </div>
                  <div class="event-title">Resepsi</div>
                  <div class="event-detail">
                    12 Desember 2025<br>
                    Pukul: 11.00 WIB - selesai<br>
                    Tempat: Gedung Masjuban
                  </div>
                </div>

                <div style="margin-top: 25px; color: #d97979; font-size: 18px;">
                  ✧･ﾟ: *✧･ﾟ:*
                </div>
              </div>
            </div>
          </div>

          <div class="page page-left hide" id="page2-back" style="z-index: 5;">
            <div class="page-content">
              <div class="section-title">The Bride<br>& Groom</div>

              <div class="profile-card">
                <div class="profile-name">Ratnadewi</div>
                <div class="profile-photo">
                  <i class="fas fa-user" style="font-size: 40px;"></i>
                </div>
                <div class="profile-info">
                  📷 @ratnadewi.2025<br>
                  Putri Bapak John Setiawan &<br>
                  Ibu Jeny Purwandari
                </div>
              </div>

              <div class="profile-card">
                <div class="profile-name">Galih Setiabudi</div>
                <div class="profile-photo">
                  <i class="fas fa-user" style="font-size: 40px;"></i>
                </div>
                <div class="profile-info">
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
                <p style="font-size: 13px; color: #d97979; margin-bottom: 20px;">Galih & Ratna</p>

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
                  ternyata tumbuh menjadi cinta yang telah menjadi kisah menarik yang akan dimulai hingga akhir hidup
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
                    Semua berawal dari pertemuan yang singkat dan sederhana, ketika dia saat kami berbeda dunia itu
                    membuat kami menguap. Dan setiap, bagi kami cinta tidak dipilih, tetapi takdir menciptakan, renung
                    yang alami sangat istiqamah.
                  </div>
                </div>

                <div style="text-align: center; margin: 15px 0;">
                  ✧･ﾟ: *✧･ﾟ:*
                </div>

                <div class="story-item">
                  <div class="story-label">Perselisihan</div>
                  <div class="story-content">
                    Mencari seoatua yang pinkan. Perlibatan kami dimulai dari berbedaa misi, sebuah perjalanan yang
                    membawa saljar seadang "jadi, cinta banyak kisah perkembangan yang terkedat".
                  </div>
                </div>

                <div style="text-align: center; margin: 15px 0;">
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

                <div style="text-align: center; margin: 15px 0;">
                  ✧･ﾟ: *✧･ﾟ:*
                </div>

                <div class="story-item">
                  <div class="story-label">Menikah</div>
                  <div class="story-content">
                    Pada, Dimahir maharyya untuk menghali arit awal lainnya simbol sebuah bercancang jaga Dari. Dengan
                    penuh syukur, komitmen tenggang kita mengandalkan di kepeda cinta yang sangat dalam untuk memulai.
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
                      style="width: 80px; height: 80px; margin: 0 auto; border: 2px solid #d97979; display: flex; align-items: center; justify-content: center;">
                      <i class="fas fa-qrcode" style="font-size: 50px; color: #d97979;"></i>
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
                    <i class="fas fa-gift" style="font-size: 50px; color: #d97979;"></i>
                    <i class="fas fa-gift" style="font-size: 40px; color: #d97979; margin: 0 10px;"></i>
                    <i class="fas fa-gift" style="font-size: 45px; color: #d97979;"></i>
                  </div>
                </div>

                <div class="gift-box">
                  <div
                    style="font-family: 'Dancing Script', cursive; font-size: 24px; color: #d97979; margin-bottom: 10px;">
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

                  <div style="margin: 20px 0;">
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
                    <path d="M 120 75 Q 130 85 140 75 Q 150 65 160 75" fill="white" stroke="#333" stroke-width="2" />
                    <line x1="140" y1="75" x2="140" y2="130" stroke="#333" stroke-width="2" />
                    <line x1="140" y1="90" x2="120" y2="110" stroke="#333" stroke-width="2" />
                    <line x1="140" y1="90" x2="160" y2="110" stroke="#333" stroke-width="2" />
                    <line x1="140" y1="130" x2="125" y2="160" stroke="#333" stroke-width="2" />
                    <line x1="140" y1="130" x2="155" y2="160" stroke="#333" stroke-width="2" />

                    <path d="M 70 30 Q 100 10 130 30" fill="none" stroke="#d97979" stroke-width="2" />
                    <circle cx="100" cy="15" r="5" fill="#d97979" />
                  </svg>
                </div>

                <div class="thankyou-text">
                  Terima kasih atas doa dan ucapan<br>
                  kehadirannya anda menjadi istimewa bagi keluarga<br>
                  kami lainnya yang telah hadir
                </div>

                <div style="margin: 30px 0;">
                  ♡ ♡ ♡
                </div>

                <div class="couple-names">
                  Galih & Ratna
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function () {
      let currentPage = 0;
      let isAnimating = false;
      const totalPages = 5;

      const rightPageSelectors = [
        '#page1-right', '#page2-right', '#page3-right', '#page4-right', '#page5-right',
      ];
      const leftPageSelectors = [
        null, '#page1-back', '#page2-back', '#page3-back', '#page4-back', '#page5-back',
      ];


      function updateButtons() {
        $('#prevBtn').prop('disabled', currentPage === 0 || isAnimating);
        $('#nextBtn').prop('disabled', currentPage === totalPages || isAnimating);
      }

      function showPage(pageNum) {

        if (isAnimating) return;
        isAnimating = true;

        // 1. CLEAR ALL STATE and hide them all
        $('.page').removeClass('flipped is-center-pos').css('opacity', ''); // Hapus style opacity inline
        $('.page').addClass('hide');


        const isCentered = (pageNum === 0 || pageNum === totalPages);

        if (isCentered) {
          // Logika Halaman Tengah (Cover atau Thank You)
          let targetPageSelector;
          if (pageNum === 0) {
            targetPageSelector = '#page1-right'; // Cover
          } else { // pageNum === 5
            targetPageSelector = '#page5-back'; // Thank You
          }

          $(targetPageSelector).removeClass('hide').addClass('is-center-pos');

          // Segera selesai karena tidak ada animasi flip
          setTimeout(function () {
            isAnimating = false;
            updateButtons();
          }, 10);

        } else {
          // Logika Normal Flipbook (Spread 1 hingga 4)

          // 2. Flip semua halaman KANAN sebelum halaman saat ini
          for (let i = 0; i < pageNum; i++) {
            $(rightPageSelectors[i]).removeClass('hide').addClass('flipped');
          }

          // 3. Tampilkan halaman KIRI (konten spread saat ini)

          const contentPage = $(leftPageSelectors[pageNum]);

          // 3a. Tampilkan element (removeClass('hide') -> display: block), dan pastikan opacity 0
          contentPage.removeClass('hide').css('opacity', 0);

          // 3b. Tunggu sebentar (600ms) agar flip (0.8s) berjalan terlebih dahulu
          setTimeout(() => {
            // 3c. Set opacity ke 1. CSS transition (0.5s) akan menangani fade-in yang smooth.
            contentPage.css('opacity', 1);
          }, 600);


          // 4. Tampilkan halaman KANAN (cover spread selanjutnya)
          if (pageNum < totalPages) {
            $(rightPageSelectors[pageNum]).removeClass('hide');
          }

          // Delay total diatur ke 1200ms (cukup untuk 600ms delay + 500ms fade + safety)
          setTimeout(function () {
            isAnimating = false;
            updateButtons();
          }, 1200);
        }
        updateButtons();
      }

      $('#nextBtn').on('click', function () {
        if (currentPage < totalPages && !isAnimating) {
          currentPage++;
          showPage(currentPage);
        }
      });

      $('#prevBtn').on('click', function () {
        if (currentPage > 0 && !isAnimating) {
          currentPage--;
          showPage(currentPage);
        }
      });

      $(window).on('resize', function () {
        showPage(currentPage);
        updateButtons();
      });

      // INITIAL LOAD
      showPage(0);


      /* ====================================================
         GESTURE SWIPE
      ===================================================== */

      const bookElement = document.getElementById('book');
      let touchStartX = 0;
      let touchEndX = 0;
      const swipeThreshold = 50;

      bookElement.addEventListener("touchstart", function (e) {
        touchStartX = e.changedTouches[0].screenX;
      }, {
        passive: true
      });

      bookElement.addEventListener("touchend", function (e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipeGesture();
      }, {
        passive: true
      });

      function handleSwipeGesture() {
        let diff = touchEndX - touchStartX;

        // 👉 SWIPE KANAN (prev)
        if (diff > swipeThreshold) {
          if (currentPage > 0 && !isAnimating) {
            currentPage--;
            showPage(currentPage);
          }
        }

        // 👉 SWIPE KIRI (next)
        if (diff < -swipeThreshold) {
          if (currentPage < totalPages && !isAnimating) {
            currentPage++;
            showPage(currentPage);
          }
        }
      }

    });
  </script>
</body>

</html>
