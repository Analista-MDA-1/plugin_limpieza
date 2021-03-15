<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="{{ asset('login/images/icons/favicon.ico') }}"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

	<title>REVIEW AREAS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>

    <!-- Bootstrap core CSS     --> 
    <link href="{{ asset('templated/css/bootstrap.min.css') }}" rel="stylesheet"/>

    <!-- Animation library for notifications   -->
    <link href="{{ asset('templated/css/animate.min.css') }}" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{ asset('templated/css/light-bootstrap-dashboard.css?v=1.4.0') }}" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

    <link href="{{ asset('templated/css/pe-icon-7-stroke.css') }}" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="{{ asset('login/images/icons/favicon.ico') }}" style="overflow-y: hidden!important;">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    Review Areas Plugin
                </a>
            </div>
            <ul class="nav">
                @foreach( $config['permisos'] as $permiso )
                    @if( $permiso['action'] == 'menu_dashboard' && $permiso['?'] == 2)
                        @if( empty($unlock_pass) )
                        <li class="active">
                            <a href="#">
                                <i class="pe-7s-graph"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @endif
                    @endif
                    @if( $permiso['action'] == 'menu_evaluaciones' && $permiso['?'] == 2)
                        @if( empty($unlock_pass) )
                        <li>
                            <a data-toggle="collapse" href="#evaluaciones">
                                <i class="pe-7s-note2"></i>
                                <p>Evaluaciones</p>
                            </a>
                            <div class="collapse" id="evaluaciones">
                                <ul class="nav">
                                    <li><a href="{{route('show_evaluar_type')}}">Evaluar Ahora</a></li>
                                    <li><a href="#">Ver Evaluaciones</a></li>
                                </ul>
                            </div>
                        </li>
                        @endif
                    @endif
                    @if( $permiso['action'] == 'menu_limpiezas' && $permiso['?'] == 2)
                        @if( empty($unlock_pass) )
                        <li>
                            <a data-toggle="collapse" href="#limpieza">
                                <i class="pe-7s-magic-wand"></i>
                                <p>Limpieza</p>
                            </a>
                            <div class="collapse" id="limpieza">
                                <ul class="nav">
                                    <li><a href="#">Limpiar Ahora</a></li>
                                    <li><a href="#">Ver Limpiezas</a></li>
                                </ul>
                            </div>
                        </li>
                        @endif
                    @endif
                    @if( $permiso['action'] == 'menu_areas' && $permiso['?'] == 2)
                         @if( empty($unlock_pass) )
                        <li>
                            <a data-toggle="collapse" href="#areas">
                                <i class="pe-7s-box2"></i>
                                <p>Areas</p>
                            </a>
                            <div class="collapse" id="areas">
                                <ul class="nav">
                                    <li><a href="{{route('ver_nueva_area')}}">Nueva Area</a></li>
                                    <li><a href="{{route('ver_areas')}}">Gestionar Areas</a></li>
                                </ul>
                            </div>
                        </li>
                        @endif
                    @endif
                    @if( $permiso['action'] == 'menu_atctg' && $permiso['?'] == 2)
                        @if( empty($unlock_pass) )
                        <li>
                            <a data-toggle="collapse" href="#at_ctg">
                                <i class="pe-7s-ribbon"></i>
                                <p>Atributos y Categorías</p>
                            </a>
                            <div class="collapse" id="at_ctg">
                                <ul class="nav">
                                    <li><a href="{{route('attributes')}}">Atributos</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{route('categories')}}">Categorías</a></li>
                                </ul>
                            </div>
                        </li>
                        @endif
                    @endif
                    @if( $permiso['action'] == 'menu_reportes' && $permiso['?'] == 2)
                        @if( empty($unlock_pass) )
                        <li>
                            <a data-toggle="collapse" href="#reports">
                                <i class="pe-7s-notebook"></i> 
                                <p>Reportes</p>
                            </a>
                            <div class="collapse" id="reports">
                                <ul class="nav">
                                    <li><a href="#">Reporte de Evaluaciones</a></li>
                                    <li><a href="#">Reporte de Limpiezas</a></li>
                                    <li><a href="#">Reporte de Areas</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Reporte de Atributos</a></li>
                                    <li><a href="#">Reporte de Categorías</a></li>
                                    <li><a href="#">Permisos de Usuarios</a></li>
                                </ul>
                            </div>
                        </li>
                        @endif
                    @endif
                @endforeach
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#" style="color: #1DC7EA">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-rocket fa-spin"></i>
                            </a>
                        </li>
                    </ul>
                    @if( empty($unlock_pass) )
                    <ul class="nav navbar-nav navbar-left">
                        <li> 
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Limpiar Ahora !
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Evaluar Ahora !
                            </a>
                        </li>
                    </ul>
                    @endif
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <form method="POST" action="{{route('logout')}}"> @csrf
                                <button type="submit" class="btn btn-danger">Cerrar Sessión <i class="pe-7s-next-2"></i></button>
                            </form> 
                        </li>
                        @if( empty($unlock_pass) )
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Ajustes<b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach( $config['permisos'] as $permiso )
                                    @if( $permiso['action'] == 'menu_parametros' && $permiso['?'] == 2)
                                        <li><a href="#">Parametros</a></li>
                                    @endif
                                    @if( $permiso['action'] == 'menu_accesstkn' && $permiso['?'] == 2)
                                        <li><a data-toggle="modal" data-target="#fichas_acceso">Fichas de Acceso</a></li>
                                    @endif
                                    @if( $permiso['action'] == 'menu_user_permissions' && $permiso['?'] == 2)
                                            <li><a href="#">Permisos de Usuarios</a></li>
                                    @endif
                                @endforeach
                                <li><a href="{{route('editar_perfil')}}"><strong>{{ $config['username'] }}</strong></a></li>
                                <li class="divider"></li>
                                <li><a href="#" data-toggle="modal" data-target="#about">Acerca De</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @if( !empty($unlock_pass) && !is_null($unlock_pass) )
                        <script>
                            window.onload=function() {
                                $('#screensaver').modal({backdrop: 'static', keyboard: false});
                            };
                        </script>
                    @endif
                </div>
                <div class="row">
                    @if($errors->count())
                    <div class="text-center p-t-12">
                        <span style="color: #FF0000;"><strong>{!! $errors->first() !!}</strong></span>
                    </div>
                    @endif
                    @if(session()->has('success'))
                    <div class="text-center p-t-12">
                        <span style="color: #0000FF;"><strong>{!! session('success') !!}</strong></span>
                    </div>
                    @endif
                    @yield('body')
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="https://es.orisonhostels.com">Orison Hostels</a>; Made with Love for a Better App
                </p>
            </div>
        </footer>

    </div>
</div>

</body>
    <div class="modal" id="fichas_acceso">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Administrar Fichas de Acceso<button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NICKNAME</th>
                                    <th>EXPIRACION</th>
                                    <th>ESTADO</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- #$#$#$#$#$#$#$#$#$#$ -->
    <div class="modal" id="screensaver">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Sistema Bloqueado</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form>
                        <input type="" name="unlock_pass" placeholder="Clave de Desbloqueo" class="form-control">
                        <button class="btn btn-success" type="submit"><li class="pe-7s-key"></li></button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <form method="POST" action="{{route('logout')}}">@csrf
                        <button type="submit" class="btn btn-danger"><i class="pe-7s-next-2"></i></button>
                    </form> 
                </div>

            </div>
        </div>
    </div>
    <!-- #$#$#$#$#$#$#$#$#$#$ -->
    <div class="modal" id="about">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Información del Sistema
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('templated/js/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('templated/js/bootstrap.min.js') }}" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="{{ asset('templated/js/chartist.min.js') }}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{ asset('templated/js/bootstrap-notify.js') }}"></script>

    <!--  Google Maps Plugin    
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="{{ asset('templated/js/light-bootstrap-dashboard.js?v=1.4.0') }}"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="{{ asset('templated/js/demo.js') }}"></script>


</html>
