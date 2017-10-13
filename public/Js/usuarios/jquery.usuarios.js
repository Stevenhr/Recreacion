(function ($) {
    $.fn.usuarios = function(options) {

        var settings = $.extend({
            titulo: 'Buscar un usuario',
            url: '/usuarios',
            eventos_personalizados: [{
                nombre: '',
                tipo: '',
                callback: function(usuario, item, evento) {}
            }],
            template_container: function() {
                return '<div class="col-md-12">' +
                    '<ul data-role="resultados" class="list-group">' +
                    '</ul>' +
                '</div>';
            },
            template_item: function(usuario) {
                return '<li>'+usuario.Primer_Nombre+' '+usuario.Primer_Apellido+'</li>';
            },
            onResult: function(){},
            onEdit: function(usuario, element, event){},
            onSelect: function (usuario, element, event){}
        }, options );

        var agregar_plantilla = function()
        {
            var plantilla = '<div class="row">' +
                '<div class="col-md-6 col-xs-12">' +
                    '<div class="form-group">' +
                        '<label for="">'+settings.titulo+'</label>' +
                        '<div class="input-group">' +
                            '<input type="text" class="form-control" data-role="key" placeholder="Identificación">' +
                            '<span class="input-group-btn">' +
                                '<button data-role="buscar" class="btn btn-default" type="button"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>' +
                            '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-6 form-group">' +
                    '<label for=""><br></label>' +
                    '<p class="form-control-static" data-role="estado"></p>' +
                '</div>' +
                +settings.template_container()+
            '</div>';

            this.html(plantilla);
        };

        var asignar_eventos = function()
        {
            var input_key = this.find('input[data-role="key"]');
            var boton_buscar = this.find('button[data-role="buscar"]');
            var resultados = this.find('*[data-role="resultados"]');
            var estado = this.find('*[data-role="estado"]');

            boton_buscar.on('click', function(e)
            {
                input_key.closest('.form-group').removeClass('has-error');
                var key = input_key.val();

                if(key.length > 0)
                {
                    var service = $.get(settings.url+'/'+key, {}, 'json');
                    estado.html('Buscando...');
                    resultados.html('');

                    service.done(function(data)
                    {
                        estado.html(data.length+' resultado(s) encontrado(s)');
                        $.each(data, function(i, persona)
                        {
                            var item = $(settings.template(persona));
                            item.find('*[data-event="onEdit"]').on('click', function (e) {
                                settings.onEdit(persona, item, e);
                            });

                            item.find('*[data-event="onSelect"]').on('click', function (e) {
                                settings.onSelect(persona, item, e);
                            });

                            $.each(settings.eventos_personalizados, function (i, evento) {
                                item.find('*[data-event="'+evento.nombre+'"]').on(evento.tipo, function(e)
                                {
                                    evento.callback(persona, item, e);
                                })
                            });

                            resultados.append(item);
                        });
                    });
                } else {
                    input_key.closest('.form-grouo').addClass('has-error');
                }
            })
        };

        agregar_plantilla.call(this);
        asignar_eventos.call(this);
        this.getContainer = function () {
            return this.find('*[data-role="resultados"]');
        };

        return this;
    };
}(jQuery));