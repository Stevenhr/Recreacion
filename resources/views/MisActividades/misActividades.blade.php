@extends('master')                              

	@section('script')
		@parent
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmhb8BVo311Mnvr35sv8VngIvXiiTnKQ4" defer></script>
		<script src="{{ asset('public/Js/MisActividad/misactividades.js') }}"></script>	
	@stop


@section('content') 

<div class="container-fluid">
	<div class="content" id="main_actividad" class="row" data-url="{{ url('misActividades') }}" ></div>
	<div id="main" class="row" data-url="{{ url('personas') }}" data-url-parques="{{ url('parques') }}">
		

		<div class="row">
			<form method="POST" id="form_consulta_actividades">
				<div class="col-md-2"></div>
				<div class="col-md-10">
					<h4><b>BUSCADOR DE MIS ACTIVIDADES</b><br><span class="glyphicon glyphicon-user"> Responsable de programa</span></h4>
					<br>
				</div>
				<div class="col-md-12"></div>

				<div class="col-md-2"></div>
	 			<div class="col-md-4">
			            <div class="form-group">
			            	<label>Fecha inicio:</label>
			                <div class='input-group date' id='datetimepicker1'>
			                    <input type='text' class="form-control" name="fechaInicio" id="fechaInicio" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
			            </div>
				</div>

				<div class="col-md-4">
			            <div class="form-group">
			            	<label>Fecha fin:</label>
			                <div class='input-group date' id='datetimepicker2'>
			                    <input type='text' class="form-control" name="fechaFin" id="fechaFin"/>
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
			            </div>
				</div>
				<div class="col-md-2"></div>

				<div class="col-md-12"></div>
				<div class="col-md-2"></div>
				<div class="col-md-10"><button type="button" class="btn btn-primary btn-sm" id="btn_buscar_Actividades"><span class="glyphicon glyphicon-search"></span> Buscar</button></div>
			</form>
		</div>


		<div class="row" id="resultadoBusqueda" style="display: none;">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<br>
				<h3>RESULTADO:</h3>
				<br>
			</div>
			<div class="col-md-2"></div>
			
			

				<div class="col-md-2">
					<div class="card" style="width: 100%;">
					  <img class="card-img-top" src="../public/Img/revisando.png" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title">Por aprobar</h5>
					    <p class="card-text">Actividades registradas por el gestor, pendientes por aprobar.</p>
					    	{{ Form::open(array('route' => 'actividadesResposableProgramaPendientes','target' => '_blank')) }}
								<input type="hidden" name="fechaInicioHiden" class="fechaInicioHiden">
								<input type="hidden" name="fechaFinHiden" class="fechaFinHiden">
								<input type="hidden" name="opcion" id="opcion" value="0">
								<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
						    	<button type="submit" class="btn btn-default btn-sm"><span class="badge" id="uno"></span> Ir a actividades</button>
						    {{ Form::close() }}
					  </div>
					</div>
				</div>

				<div class="col-md-2">
					<div class="card" style="width: 100%;">
					  <img class="card-img-top" src="../public/Img/aprobado.png" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title">Aprobado</h5>
					    <p class="card-text">Actividades registradas por el gestor, revisadas y aprobadas.</p>
					   		{{ Form::open(array('route' => 'actividadesResposableProgramaPendientes','target' => '_blank')) }}
								<input type="hidden" name="fechaInicioHiden" class="fechaInicioHiden">
								<input type="hidden" name="fechaFinHiden" class="fechaFinHiden">
								<input type="hidden" name="opcion" id="opcion" value="1">
								<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
								<button type="submit" class="btn btn-success btn-sm"><span class="badge" id="dos"></span> Ir a actividades</button>
					    	{{ Form::close() }}
					  </div>
					</div>
				</div>

				

				<div class="col-md-2">
					<div class="card" style="width: 100%;">
					  <img class="card-img-top" src="../public/Img/denegada.png" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title">Denegada</h5>
					    <p class="card-text">Actividades registradas por el gestor, revisadas y denegadas.</p>
					    	{{ Form::open(array('route' => 'actividadesResposableProgramaPendientes','target' => '_blank')) }}
								<input type="hidden" name="fechaInicioHiden" class="fechaInicioHiden">
								<input type="hidden" name="fechaFinHiden" class="fechaFinHiden">
								<input type="hidden" name="opcion" id="opcion" value="2">
								<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
								<button type="submit" class="btn btn-warning btn-sm"><span class="badge" id="cuatro"></span> Ir a actividades</button>
					    	{{ Form::close() }}
					  </div>
					</div>
				</div>


				<div class="col-md-2">
					<div class="card" style="width: 100%;">
					  <img class="card-img-top" src="../public/Img/cancelado.png" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title">Canceladas</h5>
					    <p class="card-text">Actividades registradas por el gestor, revisadas y canceladas.</p>
					    	{{ Form::open(array('route' => 'actividadesResposableProgramaPendientes','target' => '_blank')) }}
								<input type="hidden" name="fechaInicioHiden" class="fechaInicioHiden">
								<input type="hidden" name="fechaFinHiden" class="fechaFinHiden">
								<input type="hidden" name="opcion" id="opcion" value="3">
								<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
								<button type="submit" class="btn btn-danger btn-sm"><span class="badge" id="tres"></span> Ir a actividades</button>
					    	{{ Form::close() }}
					  </div>
					</div>
				</div>

			<div class="col-md-2"></div>
		</div>
 
    </div>
</div>

@stop

