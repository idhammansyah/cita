<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'NiceAdmin Bootstrap Template')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.min.js">
  </script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    :root {
      --primary: #4f46e5;
      --bg: #f4f6fb;
      --card-bg: #ffffff;
      --text-dark: #1f2937;
      --text-muted: #6b7280;
      --sidebar-bg: #ffffff;
    }

    body[data-theme="dark"] {
      --primary: #6366f1;
      --bg: #0f0f14;
      --card-bg: #18181f;
      --text-dark: #f3f4f6;
      --text-muted: #9ca3af;
      --sidebar-bg: #14141c;
    }

    body {
      background: var(--bg);
      font-family: 'Inter', sans-serif;
      color: var(--text-dark);
      transition: .3s;
    }

    /* SIDEBAR */
    .sidebar {
      width: 260px;
      height: 100vh;
      background: var(--sidebar-bg);
      position: fixed;
      top: 0;
      left: 0;
      padding: 30px 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
      border-right: 1px solid rgba(0, 0, 0, 0.06);
      transition: .3s;
    }

    .sidebar .brand {
      font-size: 24px;
      font-weight: 800;
      margin-bottom: 40px;
    }

    .sidebar .nav-link {
      font-size: 15px;
      font-weight: 500;
      padding: 12px 15px;
      border-radius: 12px;
      color: var(--text-dark);
      display: flex;
      align-items: center;
      gap: 12px;
      transition: .2s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: var(--primary);
      color: #fff !important;
      transform: translateX(5px);
    }

    .toggle-theme {
      cursor: pointer;
    }

    /* CONTENT */
    .content {
      margin-left: 280px;
      padding: 40px 20px;
      transition: .3s;
    }

    /* CARDS */
    .card-modern {
      background: var(--card-bg);
      border-radius: 18px;
      padding: 25px;
      box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.05);
      transition: .25s;
    }

    .card-modern:hover {
      transform: translateY(-4px);
      box-shadow: 0px 12px 32px rgba(0, 0, 0, 0.08);
    }

    /* Responsive: sidebar collapse (mobile) */
    @media(max-width: 992px) {
      .sidebar {
        left: -260px;
      }

      .sidebar.active {
        left: 0;
      }

      .content {
        margin-left: 0;
      }

      #menuBtn {
        display: inline-block !important;
      }
    }

    #menuBtn {
      display: none;
      font-size: 26px;
      cursor: pointer;
      margin-bottom: 20px;
    }

  </style>
</head>


<body data-theme="light">

  <!-- NAVBAR -->
  @include('user.layout.header')

  <div class="content">

    <!-- Mobile open sidebar button -->
    <i class="fa-solid fa-bars" id="menuBtn"></i>

    @yield('content')
  </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      // Dynamic append data
      $(document).ready(function () {
        const data = [{
            id: 1,
            act: "Login",
            date: "2025-12-04",
            status: "Success"
          },
          {
            id: 2,
            act: "Update Profile",
            date: "2025-12-03",
            status: "Pending"
          },
          {
            id: 3,
            act: "Change Password",
            date: "2025-12-02",
            status: "Success"
          }
        ];

        data.forEach(item => {
          $("#activity-list").append(`
          <tr>
            <td>${item.id}</td>
            <td>${item.act}</td>
            <td>${item.date}</td>
            <td><span class="badge ${item.status === 'Success' ? 'bg-success' : 'bg-warning text-dark'}">${item.status}</span></td>
          </tr>
        `);
        })
      });


      // Toggle Theme
      $("#themeSwitch").on("click", function () {
        const body = $("body");
        const current = body.attr("data-theme");
        body.attr("data-theme", current === "light" ? "dark" : "light");
        $(this).toggleClass("bi-sun bi-moon");
      });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')


</body>


</html>
