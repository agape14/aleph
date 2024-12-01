<!-- light-dark mode button -->
<a href="javascript: void(0);" id="mode" class="mode-btn text-white rounded-end" onclick="toggleBtn()">
    <i class="uil uil-brightness mode-dark mx-auto"></i>
    <i class="uil uil-moon bx-spin mode-light"></i>
</a>

<!-- START  NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-light" id="navbar">
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand logo text-uppercase" href="index-1.html">
            <img src="{{ asset('images/Aleph-school.png') }}" class="logo-light" alt="" height="30">
            <img src="{{ asset('images/Aleph-school.png') }}" class="logo-dark" alt="" height="30">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="mdi mdi-menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto" id="navbar-navlist">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Solicitud</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->
