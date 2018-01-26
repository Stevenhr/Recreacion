$(function () {
    $('#datetimepicker1').datetimepicker({
    	format: 'YYYY-MM-DD'
    });
    $('#datetimepicker2').datetimepicker({
    	format: 'YYYY-MM-DD'
    });
    var URL = $('#main_actividad').data('url');



     $('#tbl_resposablePrograma tfoot th').each( function () {
        var title = $(this).text();
        if(title!="Menu" && title!="#"){
          $(this).html( '<input type="text" placeholder="Buscar"/>' );
        }
    } );
 
    // DataTable
    var t = $('#tbl_resposablePrograma').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'],
        pageLength: 5
    });
 
    // Apply the search
    t.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    });

    $('#btn_buscar_Actividades').on('click', function(e)
    {

    	$('.fechaInicioHiden').val($('#fechaInicio').val());
    	$('.fechaFinHiden').val($('#fechaFin').val());

        $("#resultadoBusqueda").hide();
        $.post(
            URL+'/busquedaActividad',            
            $('#form_consulta_actividades').serialize(),
            function(data)
            {
                if(data.status == 'error')
                {
                    validador_datos(data.errors);
                }
                else
                {
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
        for (var error in data)
        {
            if (typeof data[error] !== 'function') 
            {
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


    $('#tbl_resposablePrograma').delegate('a[data-funcion="ejecucion"]','click',function (e) {  

        var id = $(this).data('rel'); 

        $('#id_actividadEjecucion').html(id);

    }); 

    $('#tbl_resposablePrograma').delegate('a[data-funcion="programacion"]','click',function (e) {  

        var id = $(this).data('rel'); 
        $.get(
            URL+'/datosprogramacionactividad/'+id,
            function(data)
            {
                console.log(data);

                $('#modalLocalidadP').html(data.localidad_comunidad['Localidad']);
                $('#modalUpzP').html(data.upz_comunidad['Upz']);
                $('#modalBarrioP').html(data.barrio_comunidad['Barrio']);


                $('#modalinstitucionGrupoCP').html(data['vc_institutoGrupoComunidad']);
                $('#modalCaracteristicasP').html('');
                $('#modalCaracEspecificasP').html('');

                $('#modalResponsableP').html(data.responsable['Primer_Apellido']+' '+data.responsable['Segundo_Apellido']+' '+data.responsable['Primer_Nombre']);
                $('#modalFechaEjecucionP').html(data['d_fechaEjecucion']);
                $('#modalHoraInicioP').html(data['t_horaInicio']);
                $('#modalHoraFinP').html(data['t_horaFin']);


                $('#modalDireccionEP').html(data['vc_direccion']);
                $('#modalEscenarioEP').html(data['vc_escenario']);
                $('#modalCodigoIP').html(data['vc_codigoParque']);
                $('#modalLocalidadEP').html(data.localidad_escenario['Localidad']);
                $('#modalUpzEP').html(data.upz_escenario['Upz']);
                $('#modalBarrioEP').html(data.barrio_escenario['Barrio']);

                var html = '';
                if(data.datos_actividad.length > 0)
                {
                    var num=1;
                    $.each(data.datos_actividad, function(i, e){
                      html += '<tr><td>'+e.programa['programa']+'</td><td>'+e.actividad['actividad']+'</td><td>'+e.tematica['tematica']+'</td><td>'+e.componente['componente']+'</td></tr>';
                      num++;
                    });
                }
                $('#datosModalActividad').html(html);
            }
        );
        $('#id_actividadProgramacion').html(id);

    }); 



});