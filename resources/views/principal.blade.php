<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Oficina de Correos">
    <meta name="author" content="">
    <meta name="keyword" content="Oficina de correos">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Sistema Ventas - IncanatoIT</title>
    <!-- Icons -->
    <!-- Main styles for this application -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav ml-auto">
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="img/avatars/user.png" class="img-avatar" alt="admin@oficinacorreos.com">
                    <span class="d-md-down-none"> {{ Auth::user()->name }}  </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Cerrar sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">
                        Administrar
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Clientes</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Oficinas</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Paquetes</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Rutas</a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>

      @yield('contenido')
    </div>

    

    <footer class="app-footer">
        <span><a href="">UNA</a> &copy; 2018</span>
        <span class="ml-auto">Desarrollado por <a href="">Johnnatan y Juan Pablo UNA</a></span>
    </footer>

    <script src="js/plantilla.js"></script>
</body>

</html>