
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
                <li class="{{ \Request::is('expedientes*')? 'active' : '' }} dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Expedientes/Casos<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('expedientes.index') }}">Ver los expedientes</a></li>
                        <li><a href="{{ route('expedientes.create') }}">Crear un nuevo caso</a></li>
                    </ul>
                </li>
                <li class="{{ \Request::is('inspectores*')? 'active' : '' }}"><a href="{{ route('inspectores.index') }}">Inspectores</a></li>
                <li class=""><a href="#">Alianzas</a></li>
                <li class=""><a href="#">Mantenimiento</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                
                <li class="dropdown">
                    {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-usd"></span></a>
                    <ul class="notification dropdown-menu" role="menu">
						<li class="notification-item">
							<div class="notification-header bg-danger text-danger">Aviso - <b>05/02/2018</b> 10:15 PM</div>
							<div class="notification-body">
								<p>Expiró el tiempo máximo de visita para el expediente asignado a
									<b>varo123 (Álvaro González Q.)</b>
								</p>
								<div class="text-right">
									<button class="btn btn-sm btn-outline btn-edit">Ver expediente</button>
								</div>
							</div>
						</li>
						<li class="notification-item">
							<div class="notification-header bg-success text-success">Observaciones - <b>05/02/2018</b> 11:25 PM</div>
							<div class="notification-body">
								<p><b>Álvaro González Quirós</b> ha hecho observaciones del caso asignado</p>
								<div class="text-right"><button class="btn btn-sm btn-outline btn-edit">Ver expediente</button></div>
							</div>
						</li>
                    </ul> --}}
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span></a>
                    <ul class="dropdown-menu" role="menu">
						<li class="dropdown-header">(Sin implementar aún)</li>
					</ul>
                </li>
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
            </ul>
        </div>
    </div>
</nav>
