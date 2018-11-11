<div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-title">
                    Bienvenido {{ Auth::user()->name }} 
                </li>
                <li @click="menu=0" class="nav-item">
                    <a class="nav-link active" href="#"><i class="icon-bag"></i> Clientes</a>
                </li>
                <li @click="menu=1" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-bag"></i> Oficinas</a>
                </li>
                <li @click="menu=2" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-bag"></i> Paquetes</a>
                </li>
                <li @click="menu=3" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-bag"></i> Rutas</a>
                </li>
                <li @click="menu=4" class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="icon-bag"></i> Cerrar sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>