<!DOCTYPE html>
<html lang="es-ES">

<head>
    @include("layouts.partials.admin.head")
    <title>{{ $meta_title ?? 'Colegio Áleph' }}</title>
    <meta name="description" content="Ofrecemos una educación que desafía al estudiante integralmente y que se caracteriza por ser bilingüe e interdisciplinaria.">
    <meta name="keywords" content="Colegios Áleph, educación bilingüe, interdisciplinaria">
    <meta content="Agapito De la Cruz Carlos" name="author">
</head>

<body style="background: linear-gradient(to right, #5487a7   , #45b39d);">
  <!-- container -->
  @yield('content')

  <!-- Scripts -->
  @include("layouts.partials.admin.scripts")
</body>

</html>
