    <nav class="navbar navbar-expand-lg  bg-body-tertiary p-0 navbar-dark">
        <div class="container-fluid header1 px-3">
            <div class="logo">
                <a class="navbar-brand " href="/">
                    <img src="/assets/undip-logo.svg" alt="Logo" width="100"
                        class="d-inline-block align-text-center" />
                    Universitas Diponegoro <br />
                </a>
            </div>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <p class="text-white d-inline ms-2">{{ auth()->user()->nama . " (" . auth()->user()->jabatan->nama .")" . " | " . auth()->user()->unitKerja->nama }}</p>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="nav-item">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Log Out</button>
                                </form>

                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white d-inline" href="/login" role="button" aria-expanded="false">
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
