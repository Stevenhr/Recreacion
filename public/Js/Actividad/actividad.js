$(function()
{
	var URL = $('#main_actividad').data('url');
    
	//Carga de las actividades 
    $('select[name="programa"]').on('change', function(e)
    {
        selecionar_actividad($(this).val());
    });

    var selecionar_actividad = function(id)
    { 
    	$('select[name="actividad"]').html('<option value="">Cargando...</option>');
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
                        html += '<option value="'+eee['IdActividad']+'">'+eee['Actividad'].toUpperCase()+'</option>';
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
	                        html += '<option value="'+eee['IdTematica']+'">'+eee['Tematica'].toUpperCase()+'</option>';
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
	                        html += '<option value="'+eee['IdComponente']+'">'+eee['Component'].toUpperCase()+'</option>';
	                    //}
                  });   
                  $('select[name="componente"]').html(html).val($('select[name="componente"]').data('value'));
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

        if(id_programa=="" || id_actividad=="")
        {
            mnsj="<div class='alert alert-info'>"
                  +"<strong>Datos Vacios!</strong> El programa o la actividad están vacios."
                  +"</div>";
        }
        else
        {
            var paso=0;
            if(datos_actividad.length!=0){
                $.each(datos_actividad, function(i, e) {
                    if(e['id_programa']==id_programa && e['id_actividad']==id_actividad){
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