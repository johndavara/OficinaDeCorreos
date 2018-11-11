<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Oficina de Correos">
    <meta name="author" content="">
    <meta name="keyword" content="Oficina de correos">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Oficina de Correos</title>
    <!-- Icons -->
    <!-- Main styles for this application -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="app-body">
      @include('plantilla.sidebar')
      @yield('contenido')
    </div>
</div>
    <footer class="app-footer">
        <span><a href="">UNA</a> &copy; 2018</span>
        <span class="ml-auto">Desarrollado por <a href="">Johnnatan y Juan Pablo UNA</a></span>
    </footer>

    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>

</body>

</html>