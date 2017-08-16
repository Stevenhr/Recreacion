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

    
    

});