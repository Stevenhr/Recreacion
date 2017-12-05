@extends('master')                              

	@section('script')
		@parent
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmhb8BVo311Mnvr35sv8VngIvXiiTnKQ4" defer></script>
	    <script src="{{ asset('public/Js/Actividad/actividad.js') }}"></script>	
	@stop




@section('content') 

<div class="container">
		<div class="content" id="main_actividad" class="row" data-url="{{ url('actividad') }}" ></div>
		<div class="row">
			<div class="board">
				


				<!-- MENU DE CREACIÓN DE LA ACTIVIDAD-->
				<div class="board-inner">

					<ul class="nav nav-tabs" id="myTab">
						<div class="liner"></div>
						
						<li class="active">
							<a href="#datos_comunidad" data-toggle="tab" title="bootsnipp goodies">
								<span class="round-tabs one">
									<i class="glyphicon glyphicon-user"></i>
								</span>
							</a>
						</li>

						<li >
							<a href="#home" data-toggle="tab" title="welcome">
								<span class="round-tabs two">
									<i class="glyphicon glyphicon-th"></i>
								</span> 
							</a>
						</li>

						<li>
							<a href="#profile" data-toggle="tab" title="profile">
								<span class="round-tabs three">
									<i class="glyphicon glyphicon-calendar"></i>
								</span> 
							</a>
						</li>

						<li>
							<a href="#settings" data-toggle="tab" title="blah blah">
								<span class="round-tabs four">
									<i class="glyphicon glyphicon-globe"></i>
								</span> 
							</a>
						</li>

						<li>
							<a href="#doner" data-toggle="tab" title="completed">
								<span class="round-tabs five">
									<i class="glyphicon glyphicon-ok"></i>
								</span>
							</a>
						</li>

					</ul>
				</div>
				<!--FIN:: MENU DE CREACIÓN DE LA ACTIVIDAD-->


			<form method="POST" id="form_registro_actividad">
				<!-- DATOS BASICOS DE LA ACTIVIDAD  -->
				<div class="tab-content">
					<div class="tab-pane fade" id="home">
						
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<h3 class="head text-center">Datos basicos de la actividad</h3>
								<p class="narrow text-center">
									Espacio para registrar las actividades basicas de la actvidad.
								</p>
								<br><br>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 1. Programa </label>
									<input type="hidden" name="id_datos" id="id_datos" value="0">
									<select class="form-control" data-live-search="true" name="programa">
										<option value="">Seleccionar</option>
										@foreach($programas as $programa)
											<option value="{{$programa['idPrograma']}}">{{strtoupper($programa['programa'])}}</option>	
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 2. Actividad </label>
									<select class="form-control" data-live-search="true" name="actividad">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 3. Temática</label>
									<select class="form-control" data-live-search="true" name="tematica">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 4. Componente </label>
									<select class="form-control" data-live-search="true" name="componente">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<p>
									<a href="" class="btn btn-success btn-xs" id="btn_agregar_datos_actividad"> Agregar datos de la actividad <span style="margin-left:10px;" class="glyphicon glyphicon-plus"></span></a><br>
								</p>
							</div>
						</div>

						<div id="alerta_datos">
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label> Registro de datos de la actividad</label>
									<div class="bs-example" data-example-id="bordered-table"> 
										<table class="table display no-wrap table-condensed table-bordered table-min" id="datos_actividad">
											<thead> 
												<tr class="active"> 
													<th>#</th> 
													<th>Programa</th> 
													<th>Actividad</th> 
													<th>Tematica</th> 
													<th>Componente</th> 
													<th>Eliminar</th> 
												</tr> 
											</thead>
												<tbody id="registros_datos">

												</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<br><br>
								<center>Registro de datos de la actividad</center>
								<br>
								<hr><br><br>
							</div>
						</div>

					</div>
					<!-- FIN:: DATOS BASICOS DE LA ACTIVIDAD  -->




					<div class="tab-pane fade in active" id="datos_comunidad">
						
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<h3 class="head text-center">DATOS DE LA COMUNIDAD</h3>
								<p class="narrow text-center">
									Registro del tipo de comunidad que va asistir a la actividad.
								</p>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label> 1. Localidad </label>
									<input type="hidden" name="id" id="id" value="0">
									<select class="form-control" data-live-search="true" name="localidad_comunidad" id="localidad_comunidad">
										<option value="">Seleccionar</option>
										@foreach($localidades as $localidad)
											<option value="{{$localidad['Id_Localidad']}}">{{strtoupper($localidad['Nombre_Localidad'])}}</option>	
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label> 2. Upz </label>
									<select class="form-control" data-live-search="true" name="Id_Upz_Comunidad" id="Id_Upz_Comunidad">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label> 3. Barrio </label>
									<select class="form-control" data-live-search="true" name="Id_Barrio_Comunidad" id="Id_Barrio_Comunidad">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label> 4. Institución, Grupo, Comunidad:	</label>
									<input type="text" class="form-control" name="institucion_g_c" autocomplete="off" onkeyup="javascript:this.value=this.value.toUpperCase();">
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label> 5. Características de la Poblacion a beneficiar:	</label>
									<select class="form-control"  name="caracteristicaPoblacion" >
										<option value="">Seleccionar</option>
										@foreach($caracteristicasPoblacion as $caracteristicaPoblacion)
											<option value="{{$caracteristicaPoblacion['i_pk_id']}}">{{strtoupper($caracteristicaPoblacion['tx_caracteristicas'])}}</option>	
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label> 6. Específico:	</label>
									<select class="form-control" multiple data-selected-text-format="count > 4" name="caracteristicaEspecifica" id="caracteristicaEspecifica">
										<option value="">Seleccionar</option>
									</select>

								</div>
							</div>

							<!--<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label> 7. Número de Asistentes a Beneficiar:</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off" onKeyPress="return soloNumeros( event )">
								</div>
							</div>-->
						</div>


						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<br><br>
								<center>Registro del tipo de comunidad que va asistir a la actividad.</center>
								<br>
								<hr><br><br>
							</div>
						</div>

					</div>




					<div class="tab-pane fade" id="profile">
						
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<h3 class="head text-center">Programación y asignación de la actividad</h3>
								<p class="narrow text-center">
									Espacio para registrar la programación y asignación de la activadad, se puede agregar varias actividades que coincidan con los mismos datos en los diferentes ítem
								</p>
								<br><br>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 1. Responsable </label>
									<select class="form-control" name="responsable">
										<option value="">Seleccionar</option>
										<option value="0">Dias</option>
										<option value="1">Meses</option>
										<option value="2">Años</option>
									</select>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 1. Fecha de ejecución</label>
									<input type="date" class="form-control" name="fecha_ejecucion" id="fecha_ejecucion"  data-role1="datepicker" placeholder="aa/mm/dd" autocomplete="off" >
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 2. Hora inicio</label>
									<input type="time" class="form-control" name="hora_inicio"  data-role1="datepicker" autocomplete="off">
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label> 4. Hora fin</label>
									<input type="time" class="form-control" name="hora_fin" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<p>
										<a href="javascript(0)" class="btn btn-primary btn-xs" id="btn_agregar_validar_disponiblidad"> Buscar Acompañantes disponibles <span style="margin-left:10px;" class="glyphicon glyphicon-plus"></span></a>
									</p>
								</div>
								<div id="alerta_datos_acompanantes"></div>
							</div>
						</div>

						

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label> 5. Registro de acompañantes</label>
									<div class="bs-example" data-example-id="bordered-table"> 
										<table id="tabla_responsable" class="table display no-wrap table-condensed table-bordered table-min"> 
											<thead> 
												<tr class="active"> 
													<th>#</th> 
													<th>Nombres</th> 
													<th>Apellidos</th> 
													<th>Validar</th> 
												</tr> 
											</thead> 
											<tbody id="registros_datos_acompanante"> 
											
											</tbody> 
										</table> 
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<p class="text-center">
									<a href="" class="btn btn-success btn-xs"> Agregar programación <span style="margin-left:10px;" class="glyphicon glyphicon-plus"></span></a>
								</p>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<br><br>
								<center>Programación y asignación de la actividad.</center>
								<br>
								<hr><br><br>
							</div>
						</div>

					</div>

					<div class="tab-pane fade" id="settings">

						<div class="col-xs-12 col-md-12">
							<h3 class="head text-center">DATOS DEL ESCENARIO</h3>
						</div>

						<div class="col-xs-12 col-md-6">
							<div class="row">
								<fieldset>
									<div class="col-xs-12">

										<div class="form-group">
											<label class="control-label" for="Direccion">Dirección</label>
											<input type="text" name="Direccion" class="form-control" value="">
										</div>
									</div>
									<div class="col-xs-12">
										<div class="form-group">
											<label class="control-label" for="Escenario">Escenario</label>
											<input type="text" name="Escenario" class="form-control" value="">
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<label class="control-label" for="Cod_IDRD">Cod. IDRD</label>
											<input type="text" name="Cod_IDRD" class="form-control" value="">
										</div>
									</div>
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
										</div>
									</div>
									<div class="col-xs-12"><hr></div>
									<div class="col-xs-12 col-md-4">
										<div class="form-group">
											<label>Localidad </label>
											<select class="form-control" data-live-search="true" name="localidad_escenario" id="localidad_escenario">
												<option value="">Seleccionar</option>
												@foreach($localidades as $localidad)
													<option value="{{$localidad['Id_Localidad']}}">{{strtoupper($localidad['Nombre_Localidad'])}}</option>	
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-md-4">
										<div class="form-group">
											<label class="control-label" for="Id_Upz">Upz</label>
											<select class="form-control" data-live-search="true" name="Id_Upz_escenario" id="Id_Upz_escenario">
												<option value="">Seleccionar</option>
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-md-4">
										<div class="form-group">
											<label class="control-label" for="Id_Barrio">Barrio</label>
											<select class="form-control" data-live-search="true" name="Id_Barrio_escenario" id="Id_Barrio_escenario">
												<option value="">Seleccionar</option>
											</select>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group ">
								<label class="control-label" for="">Ubicación</label>
								<div id="map"></div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<br><br>
								<center>Datos del escenario donde se va a realizar la actividad.</center>
								<br>
								<hr><br><br>
								<input type="hidden" name="Latitud" value="{{ $punto ? $punto['Latitud'] :  59.327 }}">
								<input type="hidden" name="Longitud" value="{{ $punto ? $punto['Longitud'] : 18.067  }}">
								<input type="hidden" name="Id_Punto" value="{{ $punto ? $punto['Id_Punto'] : 0 }}">
							</div>
						</div>
					</div>


					

					<div class="tab-pane fade" id="doner">
						
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<div class="text-center">
									<i class="img-intro icon-checkmark-circle"></i>
								</div>
								<h3 class="head text-center">ASPECTOS A TENER EN CUENTA</h3>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label> 1. Hora de implementación:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label> 2. Punto de encuentro:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label> 3. Nombre de la persona de contacto:</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label> 4. Rol en la comunidad:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label> 5. Telefono:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-md-6 col-xs-12">
								<div class="form-group">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<p class="text-center">
									<a href="" class="btn btn-success btn-outline-rounded green"> Registrar actividad <span style="margin-left:10px;" class="glyphicon glyphicon-ok"></span></a>
								</p>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-xs-12">
								<br><br>
								<center>Aspectos a tener en cuenta.</center>
								<br>
								<hr><br><br>
							</div>
						</div>

					</div>


					<div class="clearfix"></div>
				</div>
			</form>

			</div>
		</div>


		<div class="modal fade"  id="myModal_mal">
          <div class="modal-dialog">
            <div class="modal-content">
              
              <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>

              <div class="modal-body">
                <p>Mensaje:</p>
                <ul class="list-group" id="list_error"> 
                </ul>
              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="cerrar">Cerrar</button>
              </div>

            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

</div>

@stop

