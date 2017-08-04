@extends('master')                              

@section('content') 

<div class="container">

		<div class="row">
			<div class="board">
				<!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
				<div class="board-inner">
					<ul class="nav nav-tabs" id="myTab">
						<div class="liner"></div>
						
						<li class="active">
							<a href="#home" data-toggle="tab" title="welcome">
								<span class="round-tabs one">
									<i class="glyphicon glyphicon-th"></i>
								</span> 
							</a>
						</li>

						<li>
							<a href="#profile" data-toggle="tab" title="profile">
								<span class="round-tabs two">
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
							<a href="#messages" data-toggle="tab" title="bootsnipp goodies">
								<span class="round-tabs three">
									<i class="glyphicon glyphicon-user"></i>
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

				<div class="tab-content">
					
					<div class="tab-pane fade in active" id="home">
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<h3 class="head text-center">Datos basicos de la actividad</h3>
								<p class="narrow text-center">
									Espacio para registrar las actividades basicas de la actvidad.
								</p>
								<br><br>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 1. Programa </label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
										@foreach($programas as $programa)
											<option value="{{$programa['IdPrograma']}}">{{$programa['Programa']}}</option>	
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 2. Actividad </label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
						</div>

			            <div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 3. Temática</label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 4. Componente </label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<p class="text-center">
									<a href="" class="btn btn-success"> Agregar datos<span style="margin-left:10px;" class="glyphicon glyphicon-plus"></span></a>
								</p>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label> Registro de datos de la actividad</label>
									<div class="bs-example" data-example-id="bordered-table"> 
										<table class="table display no-wrap table-condensed table-bordered table-min"> 
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
													<tbody> 
														<tr> 
															<th scope="row">1</th> 
															<td>Mark</td> 
															<td>Mark</td> 
															<td>Mark</td> 
															<td>Otto</td> 
															<td>
																<button type="button" class="btn btn-danger btn-xs">eliminar</button>
															</td> 
														</tr> 
														<tr> 
															<th scope="row">2</th> 
															<td>Jacob</td> 
															<td>Jacob</td> 
															<td>Jacob</td> 
															<td>Thornton</td> 
															<td>
																<button type="button" class="btn btn-danger btn-xs">eliminar</button>
															</td> 
														</tr> 
														</tbody> </table> </div>
								</div>
							</div>
						</div>

					</div>



					<div class="tab-pane fade" id="profile">
						
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<h3 class="head text-center">Programación y asignación de la actividad</h3>
								<p class="narrow text-center">
									Espacio para registrar la programación y asignación de la activadad, se puede agregar varias actividades que coincidan con los mismos datos en los diferentes ítem
								</p>
								<br><br>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 1. Fecha de ejecución</label>
									<input type="date" class="form-control" name="fecha_inicio"  data-role1="datepicker" placeholder="aa/mm/dd" autocomplete="off" >
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 2. Responsable </label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
										<option value="0">Dias</option>
										<option value="1">Meses</option>
										<option value="2">Años</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 3. Horario inicio</label>
									<input type="time" class="form-control" name="fecha_suscripcion"  data-role1="datepicker" autocomplete="off">
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="form-group">
									<label> 4. Horario fin</label>
									<input type="time" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>
						</div>

						

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<div class="form-group">
									<label> 5. Registro de acompañantes</label>
									<div class="bs-example" data-example-id="bordered-table"> 
										<table class="table display no-wrap table-condensed table-bordered table-min"> 
											<thead> 
												<tr class="active"> 
													<th>#</th> 
													<th>Nombres</th> 
													<th>Apellidos</th> 
													<th>Validar</th> 
												</tr> 
												</thead> 
													<tbody> 
														<tr> 
															<th scope="row">1</th> 
															<td>Mark</td> 
															<td>Otto</td> 
															<td>
																<div class="checkbox">
															      <label>
															        <input type="checkbox"> Agregar
															      </label>
															    </div>
															</td> 
														</tr> 
														<tr> 
															<th scope="row">2</th> 
															<td>Jacob</td> 
															<td>Thornton</td> 
															<td>
																<div class="checkbox">
															      <label>
															        <input type="checkbox"> Agregar
															      </label>
															    </div>
															</td> 
														</tr> 
														<tr> 
															<th scope="row">3</th> 
															<td>Larry</td> 
															<td>the Bird</td> 
															<td>
																<div class="checkbox">
															      <label>
															        <input type="checkbox"> Agregar
															      </label>
															    </div>
															</td> 
														</tr> </tbody> </table> </div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<p class="text-center">
									<a href="" class="btn btn-warning"> Agregar programación <span style="margin-left:10px;" class="glyphicon glyphicon-plus"></span></a>
								</p>
							</div>
						</div>

					</div>

					<div class="tab-pane fade" id="settings">
						<h3 class="head text-center">DATOS DEL ESCENARIO</h3>
						<p class="narrow text-center">
							Datos del escenario donde se va a realizar la actividad.
						</p>
					</div>


					<div class="tab-pane fade" id="messages">
						
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<h3 class="head text-center">DATOS DE LA COMUNIDAD</h3>
								<p class="narrow text-center">
									Registro del tipo de comunidad que va asistir a la actividad.
								</p>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 1. Localidad </label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
										@foreach($localidades as $localidad)
											<option value="{{$localidad['Id_Localidad']}}">{{$localidad['Nombre_Localidad']}}</option>	
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 2. Upz </label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
										<option value="0">Dias</option>
										<option value="1">Meses</option>
										<option value="2">Años</option>
									</select>
								</div>
							</div>
							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 3. Barrio </label>
									<select class="form-control" name="unidad_tiempo">
										<option value="">Seleccionar</option>
										<option value="0">Dias</option>
										<option value="1">Meses</option>
										<option value="2">Años</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 4. Institución, Grupo, Comunidad:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 5. Características de la Poblacion a beneficiar:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 6. Número de Asistentes a Beneficiar:</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
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
							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 1. Hora de implementación:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 2. Punto de encuentro:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 3. Nombre de la persona de contacto:</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 4. Rol en la comunidad:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-xs-4 col-sm-4">
								<div class="form-group">
									<label> 5. Telefono:	</label>
									<input type="text" class="form-control" name="fecha_suscripcion" autocomplete="off">
								</div>
							</div>

							<div class="col-xs-4 col-sm-4">
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


					</div>


					<div class="clearfix"></div>
				</div>

			</div>
		</div>

</div>

@stop

