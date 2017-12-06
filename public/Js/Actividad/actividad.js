$(function()
{
	var URL = $('#main_actividad').data('url');
    window.location.hash = '#inicio';
    $("#fecha_ejecucdion").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd',
      yearRange: '-100:+0'
    });
    
	//Carga de las actividades 
    $('select[name="programa"]').on('change', function(e)
    {
        selecionar_actividad($(this).val());
    });

    var selecionar_actividad = function(id)
    { 
    	$('select[name="actividad"]').html('<option value="">Cargando...</option>');
        $('select[name="actividad"]').selectpicker('refresh');

        var html = '<option value="">Seleccionar</option>'; 
        $('select[name="tematica"]').html(html);
        $('select[name="componente"]').html(html);
        $('select[name="tematica"]').selectpicker('refresh');
        $('select[name="componente"]').selectpicker('refresh');
        $.ajax({
            url: URL+'/select_actividad/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="tematica"]').html(html).val($('select[name="tematica"]').data('value'));
                $('select[name="componente"]').html(html).val($('select[name="componente"]').data('value'));

                  var html2 = '<option value="">Seleccionar actividad</option>';
                  $.each(data, function(i, eee){
                    html2 += '<option value="'+eee['idActividad']+'">'+eee['actividad'].toUpperCase()+'</option>';
                  });   
                  $('select[name="actividad"]').html(html2);
                  $('select[name="actividad"]').selectpicker('refresh');
                  $('select[name="actividad"]').selectpicker('val', $('select[name="actividad"]').data('value'));

            }
        });
      
    };


     //Carga de las tematicas
    $('select[name="actividad"]').on('change', function(e)
    {
        selecionar_tematica($(this).val());
    });

    var selecionar_tematica = function(id)
    { 
    	$('select[name="tematica"]').html('<option value="">Cargando...</option>');
        $('select[name="tematica"]').selectpicker('refresh');
        var html = '<option value="">Seleccionar</option>'; 
        $('select[name="componente"]').html(html);
        $('select[name="componente"]').selectpicker('refresh');

        $.ajax({
            url: URL+'/select_tematica/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="componente"]').html(html).val($('select[name="componente"]').data('value'));

                  var html = '<option value="">Seleccionar tematica</option>';
                  $.each(data, function(i, eee)
                  {
                  		if(eee['estado']==1)
                  		{
	                        html += '<option value="'+eee['idTematica']+'">'+eee['tematica'].toUpperCase()+'</option>';
	                    }
                  });   
                  $('select[name="tematica"]').html(html);
                  $('select[name="tematica"]').selectpicker('refresh');
                  $('select[name="tematica"]').selectpicker('val', $('select[name="tematica"]').data('value'));
            }
        });
    };


    //Carga de los componentes
    $('select[name="tematica"]').on('change', function(e)
    {
        selecionar_componente($(this).val());
    });

    var selecionar_componente = function(id)
    { 
    	$('select[name="componente"]').html('<option value="">Cargando...</option>');
        $('select[name="componente"]').selectpicker('refresh');
        
        $.ajax({
            url: URL+'/select_componente/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                  var html = '<option value="">Seleccionar componente</option>';
                  $.each(data, function(i, eee)
                  {
                  		/*if(eee['estado']==1)
                  		{*/
	                        html += '<option value="'+eee['idComponente']+'">'+eee['componente'].toUpperCase()+'</option>';
	                    //}
                  });   
                  $('select[name="componente"]').html(html);
                  $('select[name="componente"]').selectpicker('refresh');
                  $('select[name="componente"]').selectpicker('val', $('select[name="componente"]').data('value'));
            }
        });
    };


    //Carga de las Upzs
    $('select[name="Id_Localidad"]').on('change', function(e)
    {
        selecionar_upz($(this).val());
    });

    var selecionar_upz = function(id)
    { 
        $('select[name="Id_Upz"]').html('<option value="">Cargando...</option>');
        $.ajax({
            url: URL+'/select_upz/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="Id_Barrio"]').html(html).val($('select[name="Id_Barrio"]').data('value'));

                  var html = '<option value="">Seleccionar tematica</option>';
                  $.each(data, function(i, eee)
                  {
                        if(eee['estado']==1)
                        {
                            html += '<option value="'+eee['cod_upz']+'">'+eee['Upz'].toUpperCase()+'</option>';
                        }
                  });   
                  $('select[name="Id_Upz"]').html(html).val($('select[name="Id_Upz"]').data('value'));
            }
        });
    };


    //Carga de las Upzs comunidad
    $('select[name="localidad_comunidad"]').on('change', function(e)
    {
        selecionar_upz_comunidad($(this).val(),$('select[name="Id_Upz_Comunidad"]'));
    });

    //Carga de las Upzs escenario
    $('select[name="localidad_escenario"]').on('change', function(e)
    {
        selecionar_upz_comunidad($(this).val(),$('select[name="Id_Upz_escenario"]'));
    });

    var selecionar_upz_comunidad = function(id,select)
    { 
        select.html('<option value="">Cargando...</option>');
        $.ajax({
            url: URL+'/select_upz/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="Id_Barrio_Comunidad"]').html(html).val($('select[name="Id_Barrio_Comunidad"]').data('value'));

                  var html = '<option value="">Seleccionar</option>';
                  $.each(data.upzs, function(i, eee)
                  {
                            html += '<option value="'+eee['Id_Upz']+'" data-othervalue="'+eee['cod_upz']+'">'+eee['Upz'].toUpperCase()+'</option>';
                  });   
                  select.html(html);
                  select.selectpicker('refresh');
                  select.selectpicker('val', select.data('value'));
            }
        });
    };

    $('select[name="Id_Upz_Comunidad"]').on('change', function(e)
    {
        var otherValue=$(this).find('option:selected').attr('data-othervalue');
        selecionar_barrios_comunidad(otherValue,$('select[name="Id_Barrio_Comunidad"]'));
    });

    $('select[name="Id_Upz_escenario"]').on('change', function(e)
    {
        var otherValue=$(this).find('option:selected').attr('data-othervalue');
        selecionar_barrios_comunidad(otherValue,$('select[name="Id_Barrio_escenario"]'));
    });

    var selecionar_barrios_comunidad = function(id, select)
    { 
       $('select[name="Id_Barrio_Comunidad"]').html('<option value="">Cargando...</option>');
        $.ajax({
            url: URL+'/select_barrio/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                select.html(html).val($('select[name="Id_Barrio_Comunidad"]').data('value'));

                  var html = '<option value="">Seleccionar</option>';
                  $.each(data, function(i, eee)
                  {
                            html += '<option value="'+eee['IdBarrio']+'"  >'+eee['Barrio'].toUpperCase()+'</option>';
                  });   
                  select.html(html);
                  select.selectpicker('refresh');
                  select.selectpicker('val', $('select[name="Id_Barrio_Comunidad"]').data('value'));
            }
        });
    };

    //Caracterisiticas especificas de la población
    $('select[name="caracteristicaPoblacion"]').on('change', function(e)
    {
        var otherValue = $(this).val();   
        selecionar_caracteristica_poblacion(otherValue);
    });

    var selecionar_caracteristica_poblacion = function(id)
    { 

        $.ajax({
            url: URL+'/select_caracteristicas_especificas_poblacion/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                  var html = '<option value="">Seleccionar</option>';
                  $.each(data, function(i, eee)
                  {
                            html += '<option value="'+eee['i_pk_id']+'"  >'+eee['vc_elemento'].toUpperCase()+'</option>';
                  });   
                  $('select[name="caracteristicaEspecifica"]').html(html);
                  $('select[name="caracteristicaEspecifica"]').selectpicker('refresh');
                  $('select[name="caracteristicaEspecifica"]').selectpicker('val', $('select[name="caracteristicaEspecifica"]').data('value'));
            }
        });
    };

    // Agregar datos de la actividad
    var datos_actividad = [];
    $('#btn_agregar_datos_actividad').on('click', function(e)
    {
        var variable=window.location.hash;
        $.post(
            URL+'/validarDatosActividad',
            //{ id_programa: id_programa, id_actividad: id_actividad, id_tematica:id_tematica, id_componente:id_componente ,id_actividad:variable.replace('#', '')},
            $('#form_registro_actividad').serialize(),
            function(data)
            {
                if(data.status == 'error')
                {
                    validador_datos_actividad(data.errors);
                    var listaError='';
                    var num=1;
                    $('#myTab a[href="#home"]').tab('show')
                    $.each(data.errors, function(i, e){
                      listaError += '<li class="list-group-item text-danger">'+num+'. '+e+'</li>';
                      num++;
                    });
                    $('#list_error').html(listaError);
                    $('#myModal_mal').modal('show');
                } 
                else 
                {
                    validador_datos_actividad(data.errors);   
                    var variable=window.location.hash;
                    $('#id').val(variable.replace('#', ''));

                    var num=1; 
                    var html=""; 
                    $.each(data.datos, function(i, e){ 
                        html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+ 
                            '<td>'+e.programa['programa']+'</td>'+ 
                            '<td>'+e.actividad['actividad']+'</td>'+ 
                            '<td>'+e.tematica['tematica']+'</td>'+ 
                            '<td>'+e.componente['componente']+'</td>'+ 
                            '<td class="text-center"><button type="button" data-rel="'+e['i_pk_id']+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>'; 
                        num++; 
                    }); 
                    $('#registros_datos').html(html);

                    $('#myTab a[href="#home"]').tab('show')
                    $('#list_error').html(data.mensaje);
                    $('#myModal_mal').modal('show'); 
                }
            }
        );
        return false;
    });

    var validador_datos_actividad = function(data)
    {
        $('#form_registro_actividad .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'programa':
                    case 'actividad':
                    case 'tematica':
                    case 'componente':
                        selector = 'select';
                    break;               
                }
                $('#form_registro_actividad '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }


    $('#btn_agregar_validar_disponiblidad').on('click', function(e)
    {
        $.post(
            URL+'/disponibilidad_acopanante',            
            $('#form_registro_actividad').serialize(),
            function(data)
            {
                
                if(data.status == 'error')
                {
                    validador_disponibilidad_responsables(data.errors);

                    var listaError='';
                    var num=1;
                    
                    $.each(data.errors, function(i, e){
                      listaError += '<li class="list-group-item text-danger">'+num+'. '+e+'</li>';
                      num++;
                    });
                    $('#list_error').html(listaError);
                    $('#myModal_mal').modal('show');
                } 
                else 
                {
                    validador_disponibilidad_responsables(data.errors);   
                    if(data.opcion=="Verfique hay un cruze de horarios"){
                        $('#alerta_datos_acompanantes').html('<div class="alert alert-dismissible alert-info" ><strong>Error!</strong> '+data.opcion+' <strong>ID de actividades con conflicto: '+data.id_actividades+'</strong> </div>');
                        setTimeout(function(){
                            $('#alerta_datos_acompanantes').html("");
                        }, 4000);
                    }
                    $('#list_error').html("Verfique hay un cruze de horarios");
                    $('#myModal_mal').modal('show'); 
                }

               
               /*if(data)
                {
                    var num=1;
                    var html="";
                    $.each(data, function(i, e){
                        html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+e.persona['Primer_Apellido']+' '+e.persona['Segundo_Apellido']+' '+e.persona['Primer_Nombre']+' '+e.persona['Segundo_Nombre']+'</td>'+
                            '<td>'+e['i_id_ambito']+'</td>'+
                            '<td>'+e['i_id_localidad']+'</td>'+
                            '<td>'+e['i_id_tipo_persona']+'</td>'+
                            '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                        num++;
                    });
                    $('#registros_datos_acompanante').html(html);
                }
                */

            }

        );

        return false;
    });

     var validador_disponibilidad_responsables = function(data)
    {
        $('#form_registro_actividad .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'responsable':
                        selector = 'select';
                    break;      

                    case 'fecha_ejecucion':
                    case 'hora_inicio':
                    case 'hora_fin':
                        selector = 'input';
                    break;            
                }
                $('#form_registro_actividad '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }

    $('#datos_actividad').delegate('button[data-funcion="eliminar"]','click',function (e) {
        var id = $(this).data('rel');
        $.get(
            URL+'/eliminarDatosActividad/'+id,
            function(data)
            {
                var num=1; 
                var html=""; 
                $('#registros_datos').html(html);
                $.each(data.datos, function(i, e){ 
                    html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+ 
                        '<td>'+e.programa['programa']+'</td>'+ 
                        '<td>'+e.actividad['actividad']+'</td>'+ 
                        '<td>'+e.tematica['tematica']+'</td>'+ 
                        '<td>'+e.componente['componente']+'</td>'+ 
                        '<td class="text-center"><button type="button" data-rel="'+e['i_pk_id']+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>'; 
                    num++; 
                }); 
                $('#registros_datos').html(html);

                $('#myTab a[href="#home"]').tab('show')
                $('#list_error').html(data.mensaje);
                $('#myModal_mal').modal('show'); 
            }
        );
        return false;

    });


    var latitud = $('input[name="Latitud"]').val() ? parseFloat($('input[name="Latitud"]').val()) : 59.327;
    var longitud = $('input[name="Longitud"]').val() ? parseFloat($('input[name="Longitud"]').val()) : 18.067;
    var zoom = $('input[name="Id_Punto"]').val() == '0' ? 11 : 13;


    function toggleBounce()
    {
        if (marker.getAnimation() !== null)
        {
            marker.setAnimation(null);
        } 
        else 
        {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    function actualizarPosicion(e)
    {
        $('input[name="Latitud"]').val(e.latLng.lat());
        $('input[name="Longitud"]').val(e.latLng.lng());
    }
    
    var map = new google.maps.Map($("#map").get(0), {
        center: {lat: latitud, lng: longitud},
        zoom: 13
    });

    var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: {lat: latitud, lng: longitud}
    });

    marker.addListener('click', toggleBounce);


    $('.nav-tabs a').click(function (e) {

            var target = $(this).attr("href") // activated tab
                
                if(target=="#profile")
                {
                    var hash = window.location.hash;
                    var id=hash.replace('#', '');
                    if(id>0){
                        $.get(
                            URL+'/validardatosactividadregistrados/'+id,
                            function(data)
                            {
                                if(data.status == 'ok')
                                {
                                    $('#id').val(id);
                                    $('#myTab a[href="#profile"]').tab('show');
                                    $('#list_error').html(data.mensaje);
                                    $('#myModal_mal').modal('show');  
                                } 
                                else 
                                {
                                    $('#id').val(id);
                                    $('#myTab a[href="#home"]').tab('show');
                                    $('#list_error').html(data.mensaje);
                                    $('#myModal_mal').modal('show');     
                                }
                            }
                        );
                    }else{
                        $('#myTab a[href="#datos_comunidad"]').tab('show')
                        $('#list_error').html("<strong> ACTIVIDAD NO HA SIDO CREADA:</strong> Registre los datos del primer paso.");
                        $('#myModal_mal').modal('show');  
                    }
                }
                

                if(target=="#home")
                {
                    $.post(
                        URL+'/validaPasos',
                        $('#form_registro_actividad').serialize(),
                        function(data){

                            if(data.status == 'error')
                            {
                                validador(data.errors);
                                var listaError='';
                                var num=1;
                                
                                $('#myTab a[href="#datos_comunidad"]').tab('show');

                                $.each(data.errors, function(i, e){
                                  listaError += '<li class="list-group-item text-danger">'+num+'. '+e+'</li>';
                                  num++;
                                });

                                $('#list_error').html(listaError);
                                $('#myModal_mal').modal('show');
                            } 
                            else 
                            {
                                validador(data.status);  
                                window.location.hash = '#'+data.datos['i_pk_id'];
                                var variable=window.location.hash;
                                var id=variable.replace('#', '');
                                $('#id').val(id);
                                $('#myTab a[href="#home"]').tab('show');
                                $('#list_error').html(data.mensaje);
                                $('#myModal_mal').modal('show');      
                            }
                        }
                    );
                }

        e.preventDefault();
        return false;
    });

    var validador = function(data)
    {

        $('#form_registro_actividad .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {

                    case 'localidad_comunidad':
                    case 'Id_Upz_Comunidad':
                    case 'Id_Barrio_Comunidad':
                    case 'caracteristicaPoblacion':
                    case 'caracteristicaEspecifica':
                        selector = 'select';
                    break;


                    case 'institucion_g_c':
                        selector = 'input';
                    break;
                            
                }
                $('#form_registro_actividad '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }

});

function soloNumeros(evt) 
    {
        if ( window.event ) { // IE
            keyNum = evt.keyCode;
        } else {
            keyNum = evt.which;
        }
        if ( keyNum >= 48 && keyNum <= 57 ) {
            return true;
        } else {
            return false;
        }
    }
