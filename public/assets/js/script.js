/* ============================================================
   WEDDING JS FULL VERSION
   ============================================================ */

$(document).ready(function () {
  initGuestName();
  initEnvelope();
  initMusic();
  initCountdown();
  initSakura();
  initGallery();
  initFloatingNav();
});

/* =========================
AMBIL NAMA TAMU DARI URL
========================= */
function initGuestName() {
  const params = new URLSearchParams(window.location.search);
  const guest = params.get('to');
  if (guest) {
    $("#guestName").text(guest);
    $("#nama").val(guest); // Set otomatis di input RSVP juga
  }
}

/* =========================
BUKA AMPLOP & INISIALISASI AOS
========================= */
function initEnvelope() {
  $("#openBtn").one("click", function () {
    const envelope = $(".envelope");

    // 1. Jalankan animasi buka amplop
    envelope.addClass("open");
    $(".seal").fadeOut(400);

    // 2. Transisi Cover ke Konten Utama
    setTimeout(function () {
      $("#cover").fadeOut(800, function () {
        // Tampilkan konten utama dengan fadeIn
        $("#invitation").fadeIn(1000, function () {

          // 3. INISIALISASI AOS (PENTING: Di dalam callback fadeIn)
          AOS.init({
            duration: 1000,
            easing: "ease-in-out",
            once: true,
            offset: 120,
            mirror: false
          });

          // Paksa refresh agar posisi elemen dihitung ulang
          AOS.refresh();
        });
      });
    }, 1200);

    playMusic();
  });
}

/* =========================
MUSIC CONTROL
========================= */
const music = document.getElementById("music");

function playMusic() {
  if (music) {
    music.play().catch(() => {
      console.log("Autoplay ditahan browser, menunggu interaksi.");
    });
  }
}

function initMusic() {
  $("#musicBtn").click(function () {
    if (music.paused) {
      music.play();
      $(this).removeClass("off");
    } else {
      music.pause();
      $(this).addClass("off");
    }
  });
}


/* =========================
COUNTDOWN DINAMIS
========================= */
function initCountdown() {
  const $countdown = $("#countdown");
  const targetDateStr = $countdown.data("time"); // Ambil dari attribute data-time di HTML

  if (!targetDateStr) return;

  const target = new Date(targetDateStr).getTime();

  const timer = setInterval(function () {
    const now = new Date().getTime();
    const distance = target - now;

    if (distance < 0) {
      clearInterval(timer);
      $countdown.html("Hari Bahagia Telah Tiba ❤️");
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    $countdown.html(
      `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`
    );
  }, 1000);
}

/* =========================
SAKURA EFFECT
========================= */
function initSakura() {
  if ($(".sakura-container").length) {
    setInterval(createSakura, 1000);
  }
}

function createSakura() {
  const size = Math.random() * 20 + 10;
  const startPos = Math.random() * window.innerWidth;
  const duration = Math.random() * 5 + 6;

  const sakura = $(`
      <img src="${window.sakuraPath}" class="sakura">
    `);

  sakura.css({
    left: startPos + "px",
    width: size + "px",
    animationDuration: duration + "s",
    position: "fixed",
    top: "-50px",
    zIndex: "9999",
    pointerEvents: "none" // Penting agar tidak menghalangi klik
  });

  $(".sakura-container").append(sakura);

  setTimeout(function () {
    sakura.remove();
  }, 11000);
}

/* =========================
GALLERY LIGHTBOX
========================= */
function initGallery() {
  $(".gallery-img").click(function () {
    const src = $(this).attr("src");
    $("#lightbox-img").attr("src", src);
    $("#lightbox").fadeIn();
  });

  $("#lightbox").click(function () {
    $(this).fadeOut();
  });
}

/* =========================
FLOATING NAV AUTO ACTIVE
========================= */
function initFloatingNav() {
  const sections = $("#hero, #mempelai, #story, #gallery, #rsvp");
  const navLinks = $(".floating-nav a");

  $(window).on("scroll", function () {
    let current = "";
    const scrollPos = $(window).scrollTop();

    sections.each(function () {
      const sectionTop = $(this).offset().top - 200;
      if (scrollPos >= sectionTop) {
        current = $(this).attr("id");
      }
    });

    navLinks.removeClass("active");
    if (current) {
      $(`.floating-nav a[href="#${current}"]`).addClass("active");
    }
  });
}

/* =========================
AOS FORCE REFRESH ON LOAD
========================= */
$(window).on("load", function () {
  // Hanya refresh jika AOS sudah pernah di-init
  if (typeof AOS !== "undefined") {
    AOS.refresh();
  }
});
