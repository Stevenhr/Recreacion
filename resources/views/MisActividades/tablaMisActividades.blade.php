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

					
					<table id="tbl_resposablePrograma" class="table table-min table-striped table-bordered responsive display compact dataTables_wrapper" cellspacing="0" width="100%" role="grid" style="width: 100%;">
		            <thead> 
		                <tr class='{{$color}}'> 
		                    <th>#</th> 
		                    <th>Id</th> 
		                    <th>Fecha</th> 
		                    <th>Hora incio</th> 
		                    <th>Hora fin</th>  
		                    <th>Programa</th> 
		                    <th>Actividad</th>
		                    <th>Tematicas / Componentes</th>
		                    <th>Gestor</th>
		                    <th>Responsable</th>
		                    <th>Programacion</th>
		                    <th>Confirmacion</th>
		                    <th>Ejecucion</th>
		                </tr> 
		            </thead>
		            <tfoot>
						<tr>
							<th>#</th> 
		                    <th scope="row" class="text-center" >Id</th> 
		                    <th>Fecha</th> 
		                    <th>Hora incio</th> 
		                    <th>Hora fin</th>  
		                    <th>Programa</th> 
		                    <th>Actividad</th> 
		                    <th>Tematicas / Componentes</th>
		                    <th>Gestor</th>
		                    <th>Responsable</th>
		                    <th>Programacion</th>
		                    <th>Confirmacion</th>
		                    <th>Ejecucion</th>
						</tr>
					</tfoot>
		            <tbody>
		            <?php $num=1;?>
		            @if($actividades!='')
		                @foreach ($actividades as $actividad) 
		                    	<tr>
			                        <td>{{$num}}</td>
			                        <td><b><p class="text-info text-center" style="font-size: 15px">{{$actividad['i_pk_id']}} </p></b></td>
			                        <td >{{$actividad['d_fechaEjecucion']}}</td>
			                        <td>{{$actividad['t_horaInicio']}}</td>
			                        <td>{{$actividad['t_horaFin']}}</td>
			                        <td>{{$actividad->datosActividad[0]->programa['programa']}}</td>
			                        <td>{{$actividad->datosActividad[0]->actividad['actividad']}}</td>
			                        <td>
			                        	<label>Tematicas:</label><br>
			                        	@foreach ($actividad->datosActividad as $datoTC) 
			                        		<ul>
											 	<li>{{$datoTC->tematica['tematica']}}</li>
											</ul>
			                        	@endforeach
			                        	<label>Componente:</label>
			                        	@foreach ($actividad->datosActividad as $datoTC) 
			                        		<ul>
											  	<li>{{$datoTC->componente['componente']}}</li>
											</ul>
			                        	@endforeach
			                        </td>
			                        <td>{{$actividad->responsable['Primer_Apellido']}} {{$actividad->responsable['Segundo_Apellido']}}<br>{{$actividad->responsable['Primer_Nombre']}}</td>
			                        <td>
			                        	<label>Responsable:</label><br>
			                        	{{$actividad->gestor['Primer_Apellido']}} {{$actividad->gestor['Segundo_Apellido']}}<br>{{$actividad->gestor['Primer_Nombre']}}
			                        	<label>Acompantes:</label><br>
			                        	@foreach ($actividad->acompanates as $acompanante) 
			                        		<ul>
											 	<li>{{$acompanante->usuario['Primer_Apellido']}} {{$acompanante->usuario['Segundo_Apellido']}} {{$acompanante->usuario['Primer_Nombre']}}</li>
											</ul>
			                        	@endforeach
			                        </td>
			                        <td><a href="/mypath"><span class="glyphicon glyphicon-eye-open"></span></a> Ir</td>
			                        <td></td>
			                        <td></td>
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


