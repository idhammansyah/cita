@extends('user.layout.index')

@section('title', 'Dashboard User')

@section('content')

<h2 class="fw-bold mb-4">Hi, User 👋</h2>
<p class="text-muted mb-4">Selamat datang kembali! Berikut ringkasan aktivitas Anda.</p>

<!-- Cards -->
<div class="row g-4">
  <div class="col-md-4">
    <div class="card-modern">
      <div class="d-flex justify-content-between">
        <h5 class="fw-bold">Status Akun</h5>
        <i class="fa-solid fa-user text-primary fs-4"></i>
      </div>
      <p class="text-muted mt-2">Akun Anda aktif dan tervalidasi.</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card-modern">
      <div class="d-flex justify-content-between">
        <h5 class="fw-bold">Aktivitas</h5>
        <i class="fa-solid fa-chart-line text-primary fs-4"></i>
      </div>
      <p class="text-muted mt-2">Cek aktivitas terbaru Anda.</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card-modern">
      <div class="d-flex justify-content-between">
        <h5 class="fw-bold">Pengaturan</h5>
        <i class="fa-solid fa-gear text-primary fs-4"></i>
      </div>
      <p class="text-muted mt-2">Sesuaikan tampilan dan preferensi Anda.</p>
    </div>
  </div>
</div>

<!-- Table -->
<div class="mt-5">
  <h5 class="fw-bold mb-3">Riwayat Aktivitas</h5>
  <div class="table-responsive bg-white p-3 rounded-4 shadow-sm">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Aktivitas</th>
          <th>Tanggal</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="activity-list"></tbody>
    </table>
  </div>
</div>

@endsection
