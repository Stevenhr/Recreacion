<!DOCTYPE html>

<html lang="es">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <script type="text/javascript">
        var URL= "{{asset('pubic/')}}";
      </script>

      @section('style')
          <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
          <link rel="stylesheet" href="{{ asset('public/components/jquery-ui/themes/base/jquery-ui.css') }}" media="screen">    
          <link rel="stylesheet" href="{{ asset('public/Css/bootstrap.css') }}" media="screen">
          
          <link rel="stylesheet" href="{{ asset('public/components/bootstrap-select/dist/css/bootstrap-select.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/bootstrap-sweetalert/dist/sweetalert.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/datatables.net-bs/css/dataTables.bootstrap.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/highcharts/css/highcharts.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/loaders.css/loaders.min.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/Css/main.css') }}" media="screen">    
          <link rel="shortcut icon" href="{{ asset('public/Img/Institucionales/iconoModulo.png') }}">  


          <link rel="stylesheet" href="{{ asset('public/Css/sticky-footer.css') }}" media="screen">  
          <link rel="stylesheet" href="{{ asset('public/Css/css_datatable/jquery.dataTables.min.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/Css/css_datatable/buttons.dataTables.min.css') }}" media="screen"> 
          <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.1/css/responsive.bootstrap.min.css"> 

      @show

      @section('script')
          <script src="{{ asset('public/components/jquery/jquery.js') }}"></script>
          <script src="{{ asset('public/components/jquery-ui/jquery-ui.js') }}"></script>
          <script src="{{ asset('public/components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
          <script src="{{ asset('public/components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
          <script src="{{ asset('public/components/bootstrap-sweetalert/dist/sweetalert.min.js') }}"></script>
          <script src="{{ asset('public/components/moment/moment.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net/js/jquery.dataTables.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-bs/js/dataTables.bootstrap.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-responsive/js/dataTables.responsive.js') }}"></script>
          <script src="{{ asset('public/components/highcharts/js/highcharts.js') }}"></script>
          <script src="{{ asset('public/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
          <script src="{{ asset('public/Js/main.js') }}"></script>
    
          <script src="{{ asset('public/Js/js_datatable/jquery.dataTables.min.js') }}"></script>
          <script src="{{ asset('public/Js/js_datatable/dataTables.buttons.min.js') }}"></script>
          <script src="{{ asset('public/Js/js_datatable/jszip.min.js') }}"></script>
          <script src="{{ asset('public/Js/js_datatable/vfs_fonts.js') }}"></script>
          <script src="{{ asset('public/Js/js_datatable/buttons.html5.min.js') }}"></script>  
          <script src="https://cdn.datatables.net/responsive/2.0.1/js/dataTables.responsive.min.js"></script>
          <script src="https://cdn.datatables.net/responsive/2.0.1/js/responsive.bootstrap.min.js"></script>
          <script src="https://code.highcharts.com/modules/exporting.js"></script>
      @show
      <title>Módulo Recreación</title>
  </head>

  <body>
      
       <!-- Menu Módulo -->
       <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <a href="#" class="navbar-brand">SIM</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
              
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Configuración<span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="themes">
                  <li><a href="#">Configuración</a></li>
                  <li class="divider"></li>
                  <li><a href="{{ url('usuarios/distribuir') }}">Distribuir usuarios</a></li>
                  <li><a href="#">Sub-Item 2</a></li>
                  <li><a href="#">Sub-Item 3</a></li>
                  <li><a href="#">Sub-Item 4</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Gestión Usuarios</a></li>
                  <li class="divider"></li>
                  <li class="{{ Request::is( 'personas') ? 'active' : '' }}"><a href="{{ URL::to( 'personas') }}">Usuarios</a></li>
                  <li class="{{ Request::is( 'asignarActividad') ? 'active' : '' }}"><a href="{{ URL::to( 'asignarActividad') }}">Agregar Permisos</a></li>
                </ul>
              </li>


              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">Actividades<span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="download">
                  <li><a href="#">Actividad</a></li>
                  <li class="divider"></li>
                  <li class="{{ Request::is( 'proceso_actividad') ? 'active' : '' }}"><a href="{{ route('proceso_actividad') }}">Crear actividad</a></li>
                  <li class="{{ Request::is( 'mis_actividades') ? 'active' : '' }}"><a href="{{ route('mis_actividades') }}">Aprobar programación</a></li>
                  <li class="{{ Request::is( 'confirmar_actividades') ? 'active' : '' }}"><a href="{{ route('confirmar_actividades') }}">Confirmar actividad</a></li>
                  <li class="{{ Request::is( 'mis_actividades') ? 'active' : '' }}"><a href="{{ route('mis_actividades') }}">Aprobar ejecucion (NR)</a></li>
                  <li class="{{ Request::is( 'mis_actividades') ? 'active' : '' }}"><a href="{{ route('mis_actividades') }}">Mis actividades (NR)</a></li>
                </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li><a href="http://www.idrd.gov.co/sitio/idrd/" target="_blank">I.D.R.D</a></li>
              <li><a href="#" target="_blank">Cerrar Sesión</a></li>
            </ul>

          </div>
        </div>
      </div>
      <!-- FIN Menu Módulo -->
        
      <!-- Contenedor información módulo -->
      </br></br>
      <div class="container">
          <div class="page-header" id="banner">
            <div class="row">
              <div class="col-lg-8 col-md-7 col-sm-6">
                <h1>MÓDULO RECREACIÓN</h1>
                <p class="lead"><h1>Subdirección Técnica de Recreación y Deportes</h1></p>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6">
                 <div align="right"> 
                    <img src="" width="50%" heigth="40%"/>
                 </div>                    
              </div>
            </div>
          </div>        
          <div class="row">
            <div class="col-xs-6 col-md-6 ">
              <div class="alert" role="alert">
                <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                <span >PERFIL:</span>
                <b></b>
              </div>
            </div>
            <div class="col-xs-6 col-md-6 " align="right">
              <div class="alert" role="alert">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <span >USUARIO:</span>
                <b>{{$_SESSION['Nombre']}}</b>
              </div>
            </div>
          </div>
       </div>
      <!-- FIN Contenedor información módulo -->

      <!-- Contenedor panel principal -->
      <div class="container">
          @yield('content')
      </div>        
      <!-- FIN Contenedor panel principal -->
  </body>

</html>





