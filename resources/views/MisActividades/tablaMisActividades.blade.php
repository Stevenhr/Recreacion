@extends('master')                              

	@section('script')
		@parent
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmhb8BVo311Mnvr35sv8VngIvXiiTnKQ4" defer></script>
		<script src="{{ asset('public/Js/MisActividad/misactividades.js') }}"></script>	
	@stop


@section('content') 

<div class="container">
	<div class="content" id="main_actividad" class="row" data-url="{{ url('misActividades') }}" ></div>
	<div id="main" class="row" data-url="{{ url('personas') }}" data-url-parques="{{ url('parques') }}">
		

		<div class="row">
			<form method="POST" id="form_consulta_actividades">
				<div class="col-md-12">
					<h4 ><b>TABLA DE MIS ACTIVIDADES</b><br><span class="glyphicon glyphicon-th-list text-{{$color}} " > <label class="text-{{$color}} ">{{$tipo}} </label></span></h4>
					<br>
				</div>
				<div class="col-md-12"></div>
				<div class="col-md-12">
					
					<table class="table display no-wrap table-condensed table-bordered table-min" id="datos_actividad">
		            <thead> 
		                <tr class="active"> 
		                    <th>#</th> 
		                    <th>Id</th> 
		                    <th>Fecha</th> 
		                    <th>Hora incio</th> 
		                    <th>Hora fin</th> 
		                </tr> 
		            </thead>
		            <tbody>
		            <?php $num=1;?>
		            @if($actividades!='')
		                @foreach ($actividades as $actividad) 
		                    	<tr class='danger'>
			                        <td>{{$num}}</td>
			                        <td><center>{{$actividad['i_pk_id']}}</center></td>
			                        <td >{{$actividad['d_fechaEjecucion']}}</td>
			                        <td>{{$actividad['t_horaInicio']}}</td>
			                        <td>{{$actividad['t_horaFin']}}</td>
			                    </tr>
		                    <?php $num++; ?>
		                @endforeach
		            @endIf
		            </tbody>
		        </table>

				</div>
			</form>
		</div>

 
    </div>
</div>

@stop


