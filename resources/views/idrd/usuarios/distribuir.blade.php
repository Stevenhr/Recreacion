@extends('master')

@section('content')
    <div id="main" class="row" data-url-area="{{ url('usuarios') }}" data-url="{{ url(config('usuarios.prefijo_ruta')) }}">
        <div class="col-md-12">
            <h4>Distribuir personal</h4>
        </div>
        <div class="col-md-12">
            <br>
        </div>
        <div class="col-md-12" id="panel-usuarios"></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12" id="form">
            <div class="row">
                <div class="col-md-4 form-group" id="seleccionado">
                   <label for="">Usuario</label>
                   <p class="form-control-static">
                        Seleccione un usuario
                   </p>
                </div>
                <div class="col-md-4 form-group">
                    <label for="">Perfil</label>
                    <select class="form-control" name="perfil" id="perfil" title="Seleccionar" data-size="10" data-live-search="true">
                        @foreach($perfiles as $key => $perfil)
                            <option value="{{ $key }}">{{ $perfil }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label for="">Localidad</label>
                    <select class="form-control" name="localidad" id="localidad" title="Seleccionar" data-size="10" data-live-search="true" multiple>
                        @foreach($localidades as $localidad)
                            <option value="{{ $localidad['Id_Localidad'] }}">{{ $localidad['Nombre_Localidad'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <button type="button" id="btn-guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @parent
    <script src="{{ asset('public/Js/usuarios/jquery.usuarios.js') }}"></script>
    <script>
        $(function()
        {
            var URL = $('#main').data('url-area');
            var persona_seleccionada = null;

            var usuarios = $('#panel-usuarios').usuarios({
                titulo: 'Busque y seleccione un usuario',
                url: $('#main').data('url')+'/service/buscar',
                onSelect: function(persona, item, event){
                    var container = usuarios.getContainer();
                    container.find('a').remove();
                    persona_seleccionada = persona;
                    $('#seleccionado').find('p').text(persona.Primer_Apellido+' '+persona.Primer_Nombre);

                    event.preventDefault();
                },
                onResult: function(){
                    persona_seleccionada = null;

                    $('#seleccionado').find('p').text('Seleccione un usuario');
                },
                template_container: function() {
                    return '<div class="col-md-12">' +
                            '<div data-role="resultados" class="list-group">' +
                            '</div>' +
                        '</div>';
                },
                template: function (usuario) {
                    return '<a href="#" data-id="'+usuario.Id_Persona+'" data-event="onSelect" class="list-group-item">' +
                            '<h5 class="list-group-item-heading">' +
                                usuario.Primer_Apellido+' '+usuario.Primer_Nombre+
                            '</h5>' +
                            '<p class="list-group-item-text">' +
                                '<small>'+ usuario.tipo_documento['Nombre_TipoDocumento']+' '+usuario.Cedula+'</small>' +
                            '</p>'+
                        '</a>';
                }
            });

            $('select[name="perfil"]').on('change', function()
            {
                if (persona_seleccionada)
                {
                    var validacion = $.post(
                        URL+'/cargarRol',
                        {
                            id_persona: persona_seleccionada.Id_Persona,
                            id_perfil: $('select[name="perfil"]').val()
                        },
                        'json'
                    );

                    validacion.done(function(data)
                    {
                        var localidades = [];

                        $.each(data, function(i, configuracion)
                        {
                            localidades.push(configuracion.i_id_localidad);
                        });

                        $('select[name="localidad"]').selectpicker('val', localidades);
                    });
                }
            });

            $('#btn-guardar').on('click', function(e)
            {
                if (persona_seleccionada)
                {
                    var guardar = $.post(
                        URL+'/asignarRol',
                        {
                            id_persona: persona_seleccionada.Id_Persona,
                            id_perfil: $('select[name="perfil"]').val(),
                            localidades: $('select[name="localidad"]').val()
                        },
                        'json'
                    );

                    guardar.done(function(data)
                    {
                        swal("Bien!", "Los datos se registraron satisfactoriamente!", "success");
                        $('select[name="perfil"]').val('').trigger('change');
                        $('select[name="localidad"]').val('').trigger('change');
                    });
                }
            })
        });
    </script>
@stop