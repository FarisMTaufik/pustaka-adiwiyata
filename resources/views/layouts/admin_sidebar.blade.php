<div class="d-flex flex-column flex-shrink-0 p-3 bg-light vh-100 border-end" style="width: 220px;">
  <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none fw-bold fs-5">
    <span class="me-2"><i class="bi bi-speedometer2"></i></span> Admin Panel
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
    <li><a href="{{ route('admin.books.index') }}" class="nav-link">Buku</a></li>
    <li><a href="{{ route('admin.members.index') }}" class="nav-link">Anggota</a></li>
    <li><a href="{{ route('admin.categories.index') }}" class="nav-link">Kategori</a></li>
    <li><a href="{{ route('admin.borrowings.index') }}" class="nav-link">Peminjaman</a></li>
    <li><a href="{{ route('admin.reservations.index') }}" class="nav-link">Reservasi</a></li>
    <li><a href="{{ route('admin.literacy_points.index') }}" class="nav-link">Poin Literasi</a></li>
    <li><a href="{{ route('admin.reports') }}" class="nav-link">Laporan</a></li>
  </ul>
  <hr>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn btn-outline-danger w-100">Logout</button>
  </form>
</div>
