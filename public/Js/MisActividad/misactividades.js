$(function () {
    $('#datetimepicker1').datetimepicker({
    	format: 'YYYY-MM-DD'
    });
    $('#datetimepicker2').datetimepicker({
    	format: 'YYYY-MM-DD'
    });
    var URL = $('#main_actividad').data('url');

    $('#btn_buscar_Actividades').on('click', function(e)
    {
        $("#resultadoBusqueda").hide();
        $.post(
            URL+'/busquedaActividad',            
            $('#form_consulta_actividades').serialize(),
            function(data)
            {
                if(data.status == 'error')
                {
                    validador_datos(data.errors);
                }else{

                	$('#uno').html(data.datos.actividadesPorRevisar);
					$('#dos').html(data.datos.actividadesAprobadas);
					$('#tres').html(data.datos.actividadesCanceladas);
					$('#cuatro').html(data.datos.actividadesDenegadas);
                	$("#resultadoBusqueda").show();

                }
                
                
            }
        );

        return false;
    });

    var validador_datos = function(data)
    {
        $('#form_consulta_actividades .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'fechaInicio':
                    case 'fechaFin':
                        selector = 'input';
                    break;               
                }
                $('#form_consulta_actividades '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }

});