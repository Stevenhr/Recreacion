@extends('master')                              

	@section('script')
		@parent
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmhb8BVo311Mnvr35sv8VngIvXiiTnKQ4" defer></script>
		<script src="{{ asset('public/Js/MisActividad/misactividades.js') }}"></script>	
	@stop


@section('content') 

<div class="container">
		<div class="content" id="main_actividad" class="row" data-url="{{ url('actividad') }}" ></div>
		<div id="main" class="row" data-url="{{ url('personas') }}" data-url-parques="{{ url('parques') }}">
		
		<div class="row">
 			
 			<div class="col-md-6">
				<div class="card">
		            <div class="form-group">
		            	<label>Fecha inicio:</label>
		                <div class='input-group date' id='datetimepicker1'>
		                    <input type='text' class="form-control" />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card">
		            <div class="form-group">
		            	<label>Fecha fin:</label>
		                <div class='input-group date' id='datetimepicker2'>
		                    <input type='text' class="form-control" />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card">
					<img class="card-img-top" src="02-reino-unido.jpg" alt="Mi Imagen">
					<div class="card-body">
					<h4 class="card-title">Titulo de la tarjeta</h4>
					<p class="card-text">Texto de ejemplo</p>
					<a href="#" class="btn btn-primary">Ir a ...</a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<img class="card-img-top" src="03-india.jpg" alt="Mi Imagen">
					<div class="card-body">
					<h4 class="card-title">Titulo de la tarjeta</h4>
					<p class="card-text">Texto de ejemplo</p>
					<a href="#" class="btn btn-primary">Ir a ...</a>
					</div>
				</div> 
			</div>
			<div class="col-md-4">
				<div class="card">
					<img class="card-img-top" src="04-china.jpg" alt="Mi Imagen">
					<div class="card-body">
					<h4 class="card-title">Titulo de la tarjeta</h4>
					<p class="card-text">Texto de ejemplo</p>
					<a href="#" class="btn btn-primary">Ir a ...</a>
					</div>
				</div>
			</div>
 
		</div>
 
</div>
</div>

@stop

