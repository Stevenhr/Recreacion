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
        pageLength: 8
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



});