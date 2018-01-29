@extends('master')                              

	@section('script')
		@parent
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmhb8BVo311Mnvr35sv8VngIvXiiTnKQ4" defer></script>
		<script src="{{ asset('public/Js/MisActividad/misactividades.js') }}"></script>	
	@stop


@section('content') 

<div class="container-fluid">
	<div class="content" id="main_actividad" class="row" data-url="{{ url('misActividades') }}" ></div>
	<div id="main" class="row" data-url="{{ url('personas') }}" data-url-parques="{{ url('parques') }}"></div>
		

		<div class="row">
			<form method="POST" id="form_consulta_actividades">
				<div class="col-md-12">
					<h4 ><b>TABLA DE MIS ACTIVIDADES</b><br><span class="glyphicon glyphicon-th-list text-{{$color}} " > <label class="text-{{$color}} ">{{$tipo}} </label></span></h4>
					<br>
				</div>
				<div class="col-md-12"></div>
				<div class="col-md-12">

					
					<table id="tbl_resposablePrograma" class="display responsive no-wrap table table-min table-bordered" width="100%" cellspacing="0" style="width:auto;">
		            <thead> 
		                <tr style="{{$style}}"> 
		                    <th>#</th> 
		                    <th>Id</th> 
		                    <th>Fecha Ejecuciòn</th> 
		                    <th>Hora incio</th> 
		                    <th>Hora fin</th>  
		                    <th>Programa</th> 
		                    <th>Actividad</th>
		                    <th>Tematicas / Componentes</th>
		                    <th>Gestor</th>
		                    <th>Responsable</th>
		                    <th data-priority="2">Confirmación</th>
		                    <th data-priority="3">Programación / <br>Ejecución</th>
		                    
		                </tr> 
		            </thead>
		            <tfoot>
						<tr>
							<th>#</th> 
		                    <th scope="row" class="text-center" style="width:auto;">Id</th> 
		                    <th>Fecha Ejecuciòn</th> 
		                    <th>Hora incio</th> 
		                    <th>Hora fin</th>  
		                    <th>Programa</th> 
		                    <th>Actividad</th> 
		                    <th>Tematicas / Componentes</th>
		                    <th>Gestor</th>
		                    <th>Responsable</th>
		                    <th data-priority="2">Confirmación</th>
		                    <th data-priority="3">Programación / <br>Ejecución</th>
						</tr>
					</tfoot>
		            <tbody>
		            <?php $num=1;?>
		            @if($actividades!='')
		                @foreach ($actividades as $actividad) 
		                    	<tr class="something" >
			                        <td class="col-md-1">{{$num}}</td>
			                        <td class="col-md-13"><b><p class="text-info text-center" style="font-size: 15px">{{$actividad['i_pk_id']}} </p></b></td>
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
			                        	<br><label>Acompantes:</label><br>
			                        	@foreach ($actividad->acompanates as $acompanante) 
			                        		<ul>
											 	<li>{{$acompanante->usuario['Primer_Apellido']}} {{$acompanante->usuario['Segundo_Apellido']}} {{$acompanante->usuario['Primer_Nombre']}}</li>
											</ul>
			                        	@endforeach
			                        </td>
			                        <td></td>
			                        <th class="text-center">
			                        	<ul class="list-group">
										  <li class="list-group-item"><button type="button" class="btn btn-link btn-xs" data-rel="{{$actividad['i_pk_id']}}" data-funcion="programacion" data-toggle="modal" data-target="#modalProgramacion"><span class="glyphicon glyphicon-eye-open"></span> Ver programaciòn </button></li>
										  <li class="list-group-item"><button type="button"  class="btn btn-link btn-xs"data-rel="{{$actividad['i_pk_id']}}" data-funcion="ejecucion" data-toggle="modal" data-target="#modalEjecucion"><span class="glyphicon glyphicon-eye-open text-success"></span> Ver Ejecuciòn</button></li>
										</ul>
			                        </th>
			                    </tr>
		                    <?php $num++; ?>
		                @endforeach
		            @endIf
		            </tbody>
		        </table>

				</div>
			</form>
		</div>




		<!-- MODAL EJECUCION-->
			<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEjecucion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 class="modal-title text-success text-center" id="myModalLabel">Ejecuciòn de la actividad<br>
							<b>ID:</b> <label id="id_actividadEjecucion"></label></h3>
						</div>
						<form id="form_agregar_estudio_comveniencia">
							
							<div class="modal-body">	
								<div class="row">
										<table class="table table-bordered table-striped table-condensed table-responsive" id="">
											<thead>
												<tr>
													<th>
														Programa
													</th>
													<th>
														Actividad
													</th>
													<th>
														Temática
													</th>
													<th>
														Componente
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
								</div>					
							</div>

							<div class="modal-footer" >
								<div class="row">
									<div class="col-xs-12 col-sm-12" style="text-align: left;">
										<button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
									</div>
								</div>
							</div>

						</form>

					</div>
				</div>
			</div>


			<!-- MODAL PROGRAMACION-->
			<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalProgramacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 class="modal-title text-primary text-center" id="myModalLabel">Programación de la actividad<br>
							<b>ID:</b> <label id="id_actividadProgramacion"></label></h3>
						</div>
						<form id="form_agregar_estudio_comveniencia">
							<div id="cargando"></div>
							<div class="modal-body" id="modalBody">		
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<h4>DATOS DE LA COMUNIDAD:</h4>
									</div>
																		
									<div class="col-xs-4 col-sm-4">
										<label>Localidad:</label>
										<p id="modalLocalidadP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Upz:</label>
										<p id="modalUpzP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Barrio:</label>
										<p id="modalBarrioP"></p>
									</div>


									<div class="col-xs-4 col-sm-4">
										<label>Institución, Grupo, Comunidad:</label>
										<p id="modalinstitucionGrupoCP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Características de la Población:</label>
										<p id="modalCaracteristicasP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Específico:</label>
										<p id="modalCaracEspecificasP"></p>
									</div>


									<div class="col-xs-12 col-sm-12">
										<h4>DATOS DE LA ACTIVIDAD:</h4>
									</div>

									<div class="col-xs-12 col-sm-12">
										<table class="table table-bordered table-striped table-condensed table-responsive">
											<thead>
												<tr>
													<th>
														Programa
													</th>
													<th>
														Actividad
													</th>
													<th>
														Temática
													</th>
													<th>
														Componente
													</th>
												</tr>
											</thead>
											<tbody id="datosModalActividad">
											</tbody>
										</table>
									</div>

									<div class="col-xs-12 col-sm-12">
										<h4>PROGRAMACIÓN Y ASIGNACIÓN DE LA ACTIVIDAD:</h4>
									</div>

									<div class="col-xs-3 col-sm-3">
										<label>Responsable:</label>
										<p id="modalResponsableP"></p>
									</div>
									<div class="col-xs-3 col-sm-3">
										<label>Fecha ejecución:</label>
										<p id="modalFechaEjecucionP"></p>
									</div>
									<div class="col-xs-3 col-sm-3">
										<label>Hora inicio:</label>
										<p id="modalHoraInicioP"></p>
									</div>
									<div class="col-xs-3 col-sm-3">
										<label>Hora fin:</label>
										<p id="modalHoraFinP"></p>
									</div>

									<div class="col-xs-12 col-sm-12">
										<h4>DATOS DEL ESCENARIO:</h4>
									</div>

									<div class="col-xs-4 col-sm-4">
										<label>Dirección:</label>
										<p id="modalDireccionEP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Escenario:</label>
										<p id="modalEscenarioEP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Codigo IDRD:</label>
										<p id="modalCodigoIP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Localidad:</label>
										<p id="modalLocalidadEP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Upz:</label>
										<p id="modalUpzEP"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Barrio:</label>
										<p id="modalBarrioEP"></p>
									</div>


									<div class="col-xs-12 col-sm-12">
										<h4>ASPECTOS A TENER EN CUENTA:</h4>
									</div>


									<div class="col-xs-4 col-sm-4">
										<label>Hora de implementación:</label>
										<p id="horaImplementacion"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Punto de encuentro:</label>
										<p id="puntoEncuentro"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Nombre de la persona de contacto:</label>
										<p id="nombreContacto"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Rol en la comunidad:</label>
										<p id="rollComunidad"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
										<label>Telefono:</label>
										<p id="telefono"></p>
									</div>
									<div class="col-xs-4 col-sm-4">
									</div>



								</div>					
							</div>

							<div class="modal-footer" >
								<div class="row">
									<div class="col-xs-12 col-sm-12" style="text-align: left;">
										<button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
									</div>
								</div>
							</div>

						</form>

					</div>
				</div>
			</div>

 
    
</div>

@stop


