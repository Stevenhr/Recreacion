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
                        html += '<option value="'+eee['IdActividad']+'">'+eee['Actividad'].toLowerCase()+'</option>';
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
	                        html += '<option value="'+eee['IdTematica']+'">'+eee['Tematica'].toLowerCase()+'</option>';
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
	                        html += '<option value="'+eee['IdComponente']+'">'+eee['Component'].toLowerCase()+'</option>';
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
            }else{
                mnsj="<div class='alert alert-info'>"
                    +"<strong>Programa o Actividad!</strong> El programa o la actividad son diferentes a los registrados, solo se puede registrar un programa y actividad."
                    +"</div>";
            }
        }

        $('#alerta_datos').html(mnsj);
        setTimeout(function(){
            $('#alerta_datos').html("");
        }, 4000)

        return false;
    });
    

});