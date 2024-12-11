 <!-- footer section -->
 <section class=" section footer bg-dark overflow-hidden">
    <div class="bg-arrow">

    </div>
    <!-- container -->
    <div class="container">
        <div class="row ">
            <div class="col-lg-4">
                <a class="navbar-brand logo text-uppercase" href="index-1.html">
                    <img src="{{ asset('images/Aleph-school.png') }}" class="logo-light" alt="" height="30">
                </a>
                <p class="text-white-50 mt-2 mb-0">Nuestra metodología educativa está alineada con las neurociencias y los últimos estudios sobre el aprendizaje efectivo y significativo.</p>

                <div class="footer-icon mt-4">
                    <div class=" d-flex align-items-center">
                        <a href="#" class="me-2 avatar-sm text-center" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Facebook">
                            <i class="mdi mdi-facebook f-24 align-middle text-primary"></i>
                        </a>
                        <a href="#" class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Twitter">
                            <i class="mdi mdi-twitter f-24 align-middle text-primary"></i>
                        </a>
                        <a href="#" class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Googleplay">
                            <i class="mdi mdi-google-play f-24 align-middle text-primary"></i>
                        </a>
                        <a href="#" class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Linkedin">
                            <i class="mdi mdi-linkedin f-24 align-middle text-primary"></i>
                        </a>
                    </div>

                </div>
            </div>

            <div class="col-lg-2">
                {{-- <div class="text-start mt-4 mt-lg-0">
                    <h5 class="text-white fw-bold">Menu 1</h5>
                    <ul class="footer-item list-unstyled footer-link mt-3">
                        <li><a href="#">Sub menu 1</a></li>
                        <li><a href="#">Sub menu 2</a></li>
                        <li><a href="#">Sub menu 3</a></li>
                        <li><a href="#">Sub menu 4</a></li>
                    </ul>
                </div>--}}
            </div>

            <div class="col-lg-2 ">
                {{--  <div class="text-start">
                    <h5 class="text-white fw-bold">Menu 2</h5>
                    <ul class="footer-item list-unstyled footer-link mt-3">
                        <li><a href="">Sub menu 2.1</a></li>
                        <li><a href="">Sub menu 2.2</a></li>
                        <li><a href="">Sub menu 2.3</a></li>
                        <li><a href="">Sub menu 2.4</a></li>
                    </ul>
                </div>--}}
            </div>

            <div class="col-lg-4">
                {{-- <h5 class="text-white">Suscribirse</h5>
                <div class="input-group my-4">
                    <input type="text" class="form-control p-3" placeholder="subscribe" aria-label="subscribe"
                        aria-describedby="basic-addon2">
                    <a href="" class="input-group-text bg-primary text-white px-4" id="basic-addon2">Registrar</a>
                </div>
                <p class="mb-0 text-white-50">Las publicaciones aparecerán en tu feed de Suscripciones. Tú también puedes empezar.
                </p>--}}
            </div>
        </div>
    </div>
    <!-- end container -->
</section>

<section class="bottom-footer py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <p class="mb-0 text-center text-muted">©
                    <script>document.write(new Date().getFullYear())</script> Aleph. Diseñado <i
                        class="mdi mdi-heart text-danger"></i> por <a href="https://delacruzdev.tech/"
                        target="_blank" class="text-muted">Delacruzdev.</a>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- end footer -->

<script>
    const baseCssPath = "{{ asset('css/colors') }}";
</script>
<!-- Style switcher -->
<div class="style-switcher" id="style-switcher" onclick="toggleSwitcher()" style="left: -189px;">
    <div>
        <h6>Selecciona el color</h6>
        <ul class="pattern list-unstyled mb-0">
            <li>
                <a class="color1" href="javascript: void(0);" onclick="setColor('default')"></a>
            </li>
            <li>
                <a class="color2" href="javascript: void(0);" onclick="setColor('blue')"></a>
            </li>
            <li>
                <a class="color3" href="javascript: void(0);" onclick="setColor('warning')"></a>
            </li>
        </ul>
    </div>
    <div class="bottom">
        <a href="javascript: void(0);" class="settings rounded-end"><i class="uil uil-setting text-white"
                style="display: inline; line-height: 46px;"></i></a>
    </div>
</div>
<!-- end switcher-->


<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--Bootstrap Js-->
<script src="{{ asset('js/bootstrap.bundle.min.js') }} "></script>

<!-- Slider Js-->
{{-- <script src="{{ asset('js/tiny-slider.js') }} "></script>--}}
<script src="{{ asset('js/swiper.min.js') }} "></script>

<!-- <script src="js/smooth-scroll.polyfills.min.js"></script> -->

<!-- counter -->
<!-- <script src="js/counter.init.js"></script> -->

<!-- App Js -->
<script src="{{ asset('js/app.js') }} "></script>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    })
</script>
