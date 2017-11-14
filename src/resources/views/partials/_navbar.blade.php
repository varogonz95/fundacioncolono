
<nav id="nav-top" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}" style="border-right:thin solid #e4e4e4">{{ config('app.name') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->

            <ul class="nav navbar-nav">
                {{-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> --}}
                <li class="{{ \Request::is('expedientes*')? 'active' : '' }}"><a href="{{ route('expedientes.index') }}">Expedientes/Casos</a></li>
                <li class="{{ \Request::is('inspectores*')? 'active' : '' }}"><a href="{{ route('inspectores.index') }}">Inspectores</a></li>
                <li class=""><a href="#">Alianzas</a></li>
                <li class=""><a href="#">Mantenimiento</a></li>
                {{-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li> --}}
            </ul>

            {{-- @if (Request::is('expedientes'))
                <form class="navbar-form navbar-left">
                    <div class="input-group">
                        <input type="text" class="form-control" aria-label="...">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filtros <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right filters">
                                <li class="dropdown-header"><label>Filtros de búsqueda</label></li>
                                <li><div class="radio"><label><input type="radio">Cedula</label></div></li>
                                <li><div class="radio"><label><input type="radio">Nombre</label></div></li>
                                <li><div class="radio"><label><input type="radio">Apellidos</label></div></li>
                                <li><div class="radio"><label><input type="radio">Referente</label></div></li>
                            </ul>
                        </div>
                    </div>
                </form>
            @endif --}}

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Preferencias</a></li>
                            <li>
                                <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

    {{-- Flashed Notifications --}}
    {{-- @if (Session::has('status'))
        <div class="animated animatedModal-{{ Session::get('status')['type'] }}">
            <div class="animatedModal-header">
                <button type="button" class="close">&times;</button>
            </div>
            <div class="animatedModal-content">

            </div>
        </div>
    @endif --}}
</nav>
