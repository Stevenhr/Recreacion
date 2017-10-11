@extends('master')

@section('script')
    @parent
    <script src="{{ asset('public/Js/usuarios/jquery.usuarios.js') }}"></script>
    <script>
        $(function()
        {
            $('#panel-usuarios').usuarios({
                titulo: 'Busque y seleccione un usuario',
                url: $('#main').data('url')+'/service/buscar',
                onEdit: function(persona, item, event){
                    alert('onEdit');
                },
                template: function (usuario) {
                    return '<li class="list-group-item">' +
                        '<h5 class="list-group-item-heading">' +
                            usuario.Primer_Apellido+' '+usuario.Primer_Nombre+'' +
                            '<a data-event="onEdit" class="pull-right btn btn-primary btn-xs">' +
                                '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' +
                            '</a>' +
                        '</h5>' +
                        '<p class="list-group-item-text">' +
                            '<small>'+ usuario.tipo_documento['Nombre_TipoDocumento']+' '+usuario.Cedula+'</small>' +
                        '</p>'+
                    '</li>';
                }
            })
        });
    </script>
@stop

@section('content')
    <div id="main" class="row" data-url="{{ url(config('usuarios.prefijo_ruta')) }}">
        <div class="col-md-12">
            <h4>Distribuir personal</h4>
        </div>
        <div class="col-md-12">
            <br>
        </div>
        <div class="col-md-12" id="panel-usuarios"></div>
    </div>
@stop
<!--
    <p class="list-group-item-text">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3"><small>Identificación: $persona->tipoDocumento['Nombre_TipoDocumento'].' '.$persona['Cedula'] </small></div>
            </div>
        </div>
    </div>
    </p>
</li>-->