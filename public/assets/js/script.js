$(document).ready(function () {

  initGuestName();
  initEnvelope();
  initMusic();
  initRSVP();
  initCountdown();
  initSakura();
  initGallery();

  initFloatingNav();
});


/* =========================
AMBIL NAMA TAMU
========================= */

function initGuestName() {

  const params = new URLSearchParams(window.location.search);
  const guest = params.get('to');

  if (guest) {
    $("#guestName").text(guest);
  }

}


/* =========================
BUKA AMPLOP
========================= */

function initEnvelope() {

  $("#openBtn").one("click", function () {

    const envelope = $(".envelope");
    const envelope_content = $("#envelope-content");

    // buka amplop
    envelope.addClass("open");

    // hilangkan seal
    $(".seal").fadeOut(400);

    // tunggu animasi flap + letter
    setTimeout(function () {

      $("#cover").fadeOut(800, function () {

        $("#invitation").fadeIn(800, function () {

          AOS.init({
            duration: 1200,
            easing: "ease-in-out-cubic",
            once: true,
            offset: 120
          });

        });

      });

    }, 1200);

    playMusic();

  });

}


/* =========================
MUSIC
========================= */

let music = document.getElementById("music");

function playMusic() {

  if (music) {
    music.play().catch(() => {});
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
RSVP GUESTBOOK
========================= */

function initRSVP() {

  $("#rsvpForm").submit(function (e) {

    e.preventDefault();

    const nama = $("#nama").val().trim();
    const hadir = $("#kehadiran").val();
    const ucapan = $("#ucapan").val().trim();

    if (!nama || !ucapan) {

      alert("Isi nama dan ucapan dulu ya");
      return;

    }

    const html = `
      <div class="guest-item" data-aos="fade-up">
        <b>${nama}</b> (${hadir})
        <p>${ucapan}</p>
      </div>
    `;

    $("#guestbook").prepend(html);

    AOS.refresh();

    $("#rsvpForm")[0].reset();

  });

}


/* =========================
COUNTDOWN
========================= */

function initCountdown() {

  const target = new Date("June 13, 2026 08:00:00").getTime();

  const timer = setInterval(function () {

    const now = new Date().getTime();
    const distance = target - now;

    if (distance < 0) {

      clearInterval(timer);
      $("#countdown").html("Hari Bahagia Telah Tiba ❤️");
      return;

    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    $("#countdown").html(
      `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`
    );

  }, 1000);

}


/* =========================
SAKURA EFFECT
========================= */

function initSakura() {

  setInterval(createSakura, 1000);

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
    animationDuration: duration + "s"
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

  const sections = $("section, #hero, #mempelai, #story, #gallery");

  const navLinks = $(".floating-nav a");

  $(window).on("scroll", function () {

    let current = "";

    sections.each(function () {

      const sectionTop = $(this).offset().top - 150;
      const sectionHeight = $(this).outerHeight();

      if ($(window).scrollTop() >= sectionTop) {
        current = $(this).attr("id");
      }

    });

    navLinks.removeClass("active");

    $('.floating-nav a[href="#' + current + '"]').addClass("active");

  });
}



/* =========================
AOS REFRESH
========================= */

$(window).on("load", function () {

  if (typeof AOS !== "undefined") {
    AOS.refreshHard();
  }

});
