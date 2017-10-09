$(function()
{
	var URL = $('#main_actividad').data('url');

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

        var html = '<option value="">Seleccionar</option>'; 
        $('select[name="tematica"]').html(html);
        $('select[name="componente"]').html(html);
        $.ajax({
            url: URL+'/select_actividad/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
            
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="tematica"]').html(html).val($('select[name="tematica"]').data('value'));
                $('select[name="componente"]').html(html).val($('select[name="componente"]').data('value'));

                  var html = '<option value="">Seleccionar actividad</option>';
                  $.each(data, function(i, eee){
                        html += '<option value="'+eee['idActividad']+'">'+eee['actividad'].toUpperCase()+'</option>';
                  });   
                  $('select[name="actividad"]').html(html).val($('select[name="actividad"]').data('value'));
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
        var html = '<option value="">Seleccionar</option>'; 
        $('select[name="componente"]').html(html);
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
                  $('select[name="tematica"]').html(html).val($('select[name="tematica"]').data('value'));
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
                  $('select[name="componente"]').html(html).val($('select[name="componente"]').data('value'));
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
        selecionar_upz_comunidad($(this).val());
    });

    var selecionar_upz_comunidad = function(id)
    { 
        $('select[name="Id_Upz_Comunidad"]').html('<option value="">Cargando...</option>');
        $.ajax({
            url: URL+'/select_upz/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="Id_Barrio_Comunidad"]').html(html).val($('select[name="Id_Barrio_Comunidad"]').data('value'));

                  var html = '<option value="">Seleccionar</option>';
                  $.each(data, function(i, eee)
                  {
                            html += '<option value="'+eee['Id_Upz']+'" data-othervalue="'+eee['cod_upz']+'">'+eee['Upz'].toUpperCase()+'</option>';
                  });   
                  $('select[name="Id_Upz_Comunidad"]').html(html).val($('select[name="Id_Upz_Comunidad"]').data('value'));
            }
        });
    };

    $('select[name="Id_Upz_Comunidad"]').on('change', function(e)
    {
        var otherValue=$(this).find('option:selected').attr('data-othervalue');
        console.log(otherValue);
        selecionar_barrios_comunidad(otherValue);
    });

    var selecionar_barrios_comunidad = function(id)
    { 
       $('select[name="Id_Barrio_Comunidad"]').html('<option value="">Cargando...</option>');
        $.ajax({
            url: URL+'/select_barrio/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="Id_Barrio_Comunidad"]').html(html).val($('select[name="Id_Barrio_Comunidad"]').data('value'));

                  var html = '<option value="">Seleccionar</option>';
                  $.each(data, function(i, eee)
                  {
                            html += '<option value="'+eee['IdBarrio']+'"  >'+eee['Barrio'].toUpperCase()+'</option>';
                  });   
                  $('select[name="Id_Barrio_Comunidad"]').html(html).val($('select[name="Id_Barrio_Comunidad"]').data('value'));
            }
        });
    };

    // Agregar datos de la actividad
    var datos_actividad = [];
    $('#btn_agregar_datos_actividad').on('click', function(e)
    {


        var id_programa = $('select[name="programa"]').val();
        var programa = $('select[name="programa"]').find(':selected').text();
        var id_actividad = $('select[name="actividad"]').val();
        var actividad = $('select[name="actividad"]').find(':selected').text();
        var id_tematica = $('select[name="tematica"]').val();
        var tematica = $('select[name="tematica"]').find(':selected').text();
        var id_componente = $('select[name="componente"]').val();
        var componente = $('select[name="componente"]').find(':selected').text();
        var mnsj="";

        if(id_programa=="" || id_actividad=="" )
        {
            mnsj="<div class='alert alert-info'>"
                  +"<strong>Datos Vacios!</strong> Algunos campos del formulario están vacios."
                  +"</div>";
        }
        else
        {
            var paso=0;
            if(datos_actividad.length!=0){
                $.each(datos_actividad, function(i, e) {
                    if(e['id_programa']==id_programa && e['id_actividad']==id_actividad && e['id_tematica']==id_tematica && e['id_componente']==id_componente){
                        paso=2;
                        return false;
                    }else if(e['id_programa']==id_programa && e['id_actividad']==id_actividad ){
                        paso=1;
                    }else{
                        paso=0;
                        return false;
                    }
                });
            }else{
                paso=1;
            }
     
            if(paso==1) {

                if(id_tematica==""){tematica="";}
                if(id_componente==""){componente="";}

                datos_actividad.push({
                    "id_programa": id_programa,
                    "programa": programa,
                    "id_actividad": id_actividad,
                    "actividad": actividad,
                    "id_tematica": id_tematica,
                    "tematica": tematica,
                    "id_componente": id_componente,
                    "componente": componente
                });
                mnsj="<div class='alert alert-success'>"
                    +"<strong>Datos Agregados!</strong> Se agregaron los datos exitosamente."
                    +"</div>";

                if(datos_actividad.length > 0)
                {
                    var num=1;
                    var html="";
                    $.each(datos_actividad, function(i, e){
                        html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
                            '<td>'+e['programa']+'</td>'+
                            '<td>'+e['actividad']+'</td>'+
                            '<td>'+e['tematica']+'</td>'+
                            '<td>'+e['componente']+'</td>'+
                            '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                        num++;
                    });
                }
                $('#registros_datos').html(html);

            }else if(paso==2){
                mnsj="<div class='alert alert-info'>"
                    +"<strong>Registro Repetido! </strong>Los datos ya fueron registrados."
                    +"</div>";
            }else{
                mnsj="<div class='alert alert-info'>"
                    +"<strong>Programa o Actividad!</strong> El programa o la actividad son diferentes a los registrados, solo se puede registrar un programa y actividad."
                    +"</div>";
            }
        }

        $('#alerta_datos').html(mnsj);
        setTimeout(function(){
            $('#alerta_datos').html("");
        }, 4000);

        return false;
    });


    $('#btn_agregar_validar_disponiblidad').on('click', function(e)
    {

        var fecha_ejecucion = $('input[name="fecha_ejecucion"]').val();
        var responsable = $('input[name="responsable"]').val();
        var hora_inicio = $('input[name="hora_inicio"]').val();
        var hora_fin = $('input[name="hora_fin"]').val();
        var localidad_comunidad = $('select[name="localidad_comunidad"]').find('option:selected').val();
        
        if(fecha_ejecucion!="" ||  hora_inicio!=""  ||  hora_fin!="")
        {
           
            if(localidad_comunidad==""){
                $('#alerta_datos_acompanantes').html('<div class="alert alert-dismissible alert-info" ><strong>Error!</strong> Localidad de la comunidad no ha sido seleccionada. <strong>Ir a paso dos</strong> </div>');
                setTimeout(function(){
                    $('#alerta_datos_acompanantes').html("");
                }, 4000);
            }

            $.post(
            
            URL+'/disponibilidad_acopanante',
            {
                fecha_ejecucion: fecha_ejecucion,
                responsable: responsable,
                localidad_comunidad:localidad_comunidad,
                hora_inicio:hora_inicio,
                hora_fin:hora_fin
            },
            'json'
            ).done(function(data)
            {
                console.log(data);
                if(data)
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

            }).fail(function(xhr, status, error)
            {
                alert(error);
            });

            e.preventDefault();

        }else{
            $('#alerta_datos_acompanantes').html('<div class="alert alert-dismissible alert-info" ><strong>Error!</strong> Datos incompletos para la consulta. </div>');
            setTimeout(function(){
                $('#alerta_datos_acompanantes').html("");
            }, 4000);
        }

        return false;
    });

    $('#datos_actividad').delegate('button[data-funcion="eliminar"]','click',function (e) {
        var id = $(this).data('rel');
        datos_actividad.splice(id, 1);

        $('#alerta_datos').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato eliminado de la actividad con exito. </div>');
        setTimeout(function(){
            $('#alerta_datos').html("");
        }, 4000);

        if(datos_actividad.length > 0)
        {
            var num=1;
            var html="";
            $.each(datos_actividad, function(i, e){
                html += '<tr class="warning"><th scope="row" class="text-center">'+num+'</th>'+
                    '<td>'+e['programa']+'</td>'+
                    '<td>'+e['actividad']+'</td>'+
                    '<td>'+e['tematica']+'</td>'+
                    '<td>'+e['componente']+'</td>'+
                    '<td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
                num++;
            });
        }
        $('#registros_datos').html(html);

    });


    var latitud = $('input[name="Latitud"]').val() ? parseFloat($('input[name="Latitud"]').val()) : 59.327;
    var longitud = $('input[name="Longitud"]').val() ? parseFloat($('input[name="Longitud"]').val()) : 18.067;
    var zoom = $('input[name="Id_Punto"]').val() == '0' ? 11 : 13;


    function toggleBounce()
    {
        if (marker.getAnimation() !== null)
        {
            marker.setAnimation(null);
        } else {
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
