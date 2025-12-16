@php
$userData = getUserData();
$menus = getMenus();
@endphp

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
  <div class="brand">MyApp</div>

  <a href="#" class="nav-link active">
    <i class="fa-solid fa-table-columns"></i> Dashboard
  </a>

  <a href="#" class="nav-link">
    <i class="fa-solid fa-user"></i> Profile
  </a>

  <a href="#" class="nav-link">
    <i class="fa-solid fa-gear"></i> Settings
  </a>

  <hr class="my-4">

  <a href="#" class="nav-link">
    <i class="fa-solid fa-right-from-bracket"></i> Logout
  </a>

  <hr>

  <div class="nav-link mt-3">
    <i class="fa-solid fa-moon toggle-theme" id="themeSwitch"></i>
    <span>Dark Mode</span>
  </div>
</div>
