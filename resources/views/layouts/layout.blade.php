<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Apoteker App</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
              <a class="navbar-brand" href="#">Apotek App</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                  @if (Auth::check())
                  <li class="nav-item">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page" href="/">Dashboard</a>
                  </li>
                  @if (Auth::user()->role == 'admin')
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Route::is('medicines.create') || Route::is('medicines.index') || Route::is('medicines.edit') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Obat
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('medicines.index') }}">Data Obat</a></li>
                      <li><a class="dropdown-item" href="{{route('medicines.create')}}">Tambah</a></li>
                    </ul>
                  </li>
                  @endif
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('kasir.order.index') }}">Pembelian</a>
                  </li>
                  @if(Auth::user()->role == 'admin')
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('acc.akun') }}">Kelola Akun</a>
                  </li> 
                  @endif
                      <li class="nav-item">
                       <form action="{{ route('logout') }}" method="POST" style="display: inline">
                        @csrf
                          <button type="submit" class="btn nav-link" style="background: none; border:none; color:inherit;">Logout</button>
                       </form>
                      </li>
                  @endif
                </ul>
              </div>
            </div>
        </nav>

        <div class="container mt-5">
            @yield('content')
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        
        @stack('script')
    </body>
</html>
