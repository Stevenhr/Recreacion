
$(function()
{
	var URL = $('#main_actividad').data('url');
    var URL_PARQUES = $('#main').data('url-parques');
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

    //Carga de las Upzs escenario
    $('select[name="localidad_escenario"]').on('hidden.bs.select', function(e)
    {
       
        selecionar_upz_escenario($(this).val(),$('select[name="Id_Upz_escenario"]'));
    });

    var selecionar_upz_escenario = function(id,select)
    { 
        select.html('<option value="">Cargando...</option>');
        $.ajax({
            url: URL+'/select_upz/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '<option value="">Seleccionar</option>'; 
                $('select[name="Id_Barrio_escenario"]').html(html).val($('select[name="Id_Barrio_escenario"]').data('value'));

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
    var temas_seleccionados = {};

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
                  $('select[name="caracteristicaEspecifica"]').selectpicker('val',  temas_seleccionados[id]);
            }
        });
    };
  
    $('select[name="caracteristicaEspecifica"]').on('changed.bs.select', function(i, ov, nv)
    {
        if (!temas_seleccionados.hasOwnProperty($('select[name="caracteristicaPoblacion"]').val()))
            temas_seleccionados[$('select[name="caracteristicaPoblacion"]').val()] = [];

        temas_seleccionados[$('select[name="caracteristicaPoblacion"]').val()] = [$('select[name="caracteristicaEspecifica"]').selectpicker('val')];
         
        var datosCaracterisitica = JSON.stringify(temas_seleccionados);
        $('input[name="datosCaracterisitica"]').val(datosCaracterisitica);

    });

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
                var variable=window.location.hash;
                $('#id').val(variable.replace('#', ''));

                if(data.status == 'Hora'){
                      $('#list_error').html('<div class="alert alert-dismissible alert-info" ><strong>Error!!!</strong><br><br>Hora inicio debe ser menor a la hora final. Modifique la hora de incio y fin de la actividad. <br><br><strong>Gracias.</strong></div>');
                      $('#myModal_mal').modal('show');
                }
                else if(data.status != 'Bien')
                {
                    if(data.status=='Campos'){
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
                    else if(data.status=='Error'){
                        validador_disponibilidad_responsables(data.errors);   
                        $('#list_error').html('<div class="alert alert-dismissible alert-info" ><strong>Error!</strong> '+data.mensaje+' <br><br><strong>ID de actividades con conflicto: <br><br>'+data.id_actividades+'</strong> </div>');
                        $('#myModal_mal').modal('show'); 
                    }
                } 
                else 
                {
                    validador_disponibilidad_responsables(data.errors);
                    //$persona["Primer_Apellido"]." ".$persona["Segundo_Apellido"]." ".$persona["Primer_Nombre"]." ".$persona["Segundo_Nombre"]
                    $('#responsable_validada').val(data.request['responsable']);
                    $('#fecha_ejecucion_validada').val(data.request['fecha_ejecucion']);
                    $('#hora_inicio_validada').val(data.request['hora_inicio']);
                    $('#hora_fin_validada').val(data.request['hora_fin']);
                    
                    $('#label0').text('DATOS VALIDADOS:');
                    $('#label1').text('Responsable: '+data.request['responsablenombre']['Primer_Apellido']+' '+data.request['responsablenombre']['Segundo_Apellido']+' '+data.request['responsablenombre']['Primer_Nombre']);
                    $('#label2').text('Fecha: '+data.request['fecha_ejecucion']);
                    $('#label3').text('Hora inicio: '+data.request['hora_inicio']);
                    $('#label4').text('Hora fin: '+data.request['hora_fin']);
                    
                    listaError = '<div class="alert alert-dismissible alert-success" ><strong>Bien!</strong> '+data.mensaje+'<strong></div>';
                    $('#list_error').html(listaError);
                    $('#myModal_mal').modal('show');
                }
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


    $('.nav-tabs a').click(function (e) {

            var target = $(this).attr("href") // activated tab
                
                if(target=="#datos_comunidad")
                {
                    $('#myTab a[href="#datos_comunidad"]').tab('show');
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
                        $('#list_error').html("<div class='alert alert-danger'><center><strong> ACTIVIDAD NO HA SIDO CREADA:</strong></center> <br><br>Registre los datos del primer <strong>PASO I.</strong> <br><br><strong>Gracias!!!</strong></div>");
                        $('#myModal_mal').modal('show');  
                    }
                }

                if(target=="#settings")
                {
                    var hash = window.location.hash;
                    var id=hash.replace('#', '');
                    if(id>0){
                        $.get(
                            URL+'/validardatosactividadregistradosPasoIII/'+id,
                            function(data)
                            {
                                if(data.status == 'ok')
                                {
                                    $('#myTab a[href="#settings"]').tab('show');
                                } 
                                else 
                                {
                                    $('#id').val(id);
                                    $('#list_error').html(data.mensaje);
                                    $('#myModal_mal').modal('show');     
                                }
                            }
                        );
                    }else{
                        $('#myTab a[href="#datos_comunidad"]').tab('show')
                        $('#list_error').html("<div class='alert alert-danger'><center><strong> ACTIVIDAD NO HA SIDO CREADA:</strong></center> <br><br>Registre los datos del primer <strong>PASO I.</strong> <br><br><strong>Gracias!!!</strong></div>");
                        $('#myModal_mal').modal('show');  
                    }
                    
                }

                 if(target=="#doner")
                {
                    var hash = window.location.hash;
                    var id=hash.replace('#', '');
                    
                    if(id>0)
                    {
                        $.post(
                            URL+'/validardatosactividadregistradosPasoIV',
                            $('#form_registro_actividad').serialize(),
                            function(data)
                            {   
                                if(data.status == 'error')
                                {
                                    validadorDatosEscenario(data.errors);
                                    var listaError='';
                                    var num=1;
                                    
                                    $('#myTab a[href="#settings"]').tab('show');

                                    $.each(data.errors, function(i, e){
                                      listaError += '<li class="list-group-item text-danger">'+num+'. '+e+'</li>';
                                      num++;
                                    });

                                    $('#list_error').html(listaError);
                                    $('#myModal_mal').modal('show');
                                } 
                                else 
                                {
                                    validadorDatosEscenario(data.status);  
                                    window.location.hash = '#'+data.datos['i_pk_id'];
                                    var variable=window.location.hash;
                                    var id=variable.replace('#', '');
                                    $('#id').val(id);
                                    $('#myTab a[href="#doner"]').tab('show');
                                    $('#list_error').html(data.mensaje);
                                    $('#myModal_mal').modal('show');      
                                }
                            }
                        );
                    }else{
                        $('#myTab a[href="#datos_comunidad"]').tab('show')
                        $('#list_error').html("<div class='alert alert-danger'><center><strong> ACTIVIDAD NO HA SIDO CREADA:</strong></center> <br><br>Registre los datos del primer <strong>PASO I.</strong> <br><br><strong>Gracias!!!</strong></div>");
                        $('#myModal_mal').modal('show');  
                    }
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

     var validadorDatosEscenario = function(data)
    {

        $('#form_registro_actividad .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'localidad_escenario':
                    case 'Id_Upz_escenario':
                    case 'Id_Barrio_escenario':
                        selector = 'select';
                    break;


                    case 'Direccion':
                    case 'Escenario':
                    case 'Latitud':
                    case 'Longitud':
                        selector = 'input';
                    break;
                            
                }
                $('#form_registro_actividad '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }

    $('input[name="Cod_IDRD"]').on('blur', function(e)
    {
        var key = $(this).val();
        if (key)
        {
            $.get(
                URL_PARQUES+'/service/buscar/'+$(this).val(),
                {},
                function(data)
                {
                    if(data.length > 0)
                    {
                        $('input[name="Direccion"]').val(data[0].Direccion);
                        $('input[name="Escenario"]').val(data[0].Nombre);

                        $.when($('select[name="localidad_escenario"]').val(data[0].Id_Localidad).trigger('change')).done(function(){
                            if(data[0].upz){
                                var  html = '<option value="'+data[0].upz['Id_Upz']+'">'+data[0].upz['Upz']+'</option>';
                                $('select[name="Id_Upz_escenario"]').html(html);
                                $('select[name="Id_Upz_escenario"]').selectpicker('refresh');
                                $('select[name="Id_Upz_escenario"]').selectpicker('val', data[0].upz['Id_Upz']);
                            }
                        });
                    }
                },
                'json'
            )
        }
    });


    var latitud = 4.738367555801973;
    var longitud = -74.22956602123418;
    var zoom = 12;

    function actualizarPosicion(e)
    {
        $('input[name="Latitud"]').val(e.latLng.lat());
        $('input[name="Longitud"]').val(e.latLng.lng());
    }

    function toggleBounce()
    {
        if (marker.getAnimation() !== null)
        {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
    
    var map = new google.maps.Map($("#map").get(0), {
      center: {lat: latitud, lng: longitud},
      zoom: zoom
    });

    var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: {lat: 4.656674901073374, lng: -74.08563868549504}
    });

    marker.addListener('click', toggleBounce);

    marker.addListener('dragend', actualizarPosicion);


    $('#registrarActividad').on('click', function(e)
    {
        var variable=window.location.hash;
        $.post(
            URL+'/registroActividadPasoV',
            $('#form_registro_actividad').serialize(),
            function(data)
            {
                if(data.status == 'error')
                {
                    validador_registro_actividad(data.errors);
                    var listaError='';
                    var num=1;
                    $('#myTab a[href="#doner"]').tab('show')
                    $.each(data.errors, function(i, e){
                      listaError += '<li class="list-group-item text-danger">'+num+'. '+e+'</li>';
                      num++;
                    });
                    $('#list_error').html(listaError);
                    $('#myModal_mal').modal('show');
                } 
                else 
                {
                    validador_registro_actividad(data.errors);   
                    $('#id').val(0);
                    $('#list_error').html(data.mensaje);
                    $('#myModal_mal').modal('show'); 

                    setTimeout(function(){
                          $('#myModal_mal').modal('hide');
                          window.location.reload(true);
                    }, 2000)

                    
                }
            }
        );
        return false;
    });

    var validador_registro_actividad = function(data)
    {
        $('#form_registro_actividad .form-group').removeClass('has-error');
        var selector = '';
        for (var error in data){
            if (typeof data[error] !== 'function') {
                switch(error)
                {
                    case 'hora_implementacion':
                    case 'punto_encuentro':
                    case 'nombre_persona':
                    case 'telefono_persona':
                    case 'roll_comunidad':
                        selector = 'input';
                    break;               
                }
                $('#form_registro_actividad '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }



    $('#mostrar_seleccionados').on('click', function(e)
    {
        var listaError="";
        var num=1;
            
         $.post(
            URL+'/getCaracterisiticasEspecificas',
            { temas_seleccionados: temas_seleccionados},
            function(data)
            {
                $('#list_error').html(data);
                $('#myModal_mal').modal('show');

            }
        );

       
        return false;
    });



    $('#busquedaAcompananteLocalidad').on('click', function(e)
    {
        var listaError="";
        var num=1;
            
         $.post(
            URL+'/getAcompananteLocalidad',
            $('#form_registro_actividad').serialize(),
            function(data)
            {
                $('#list_error').html(data);
                $('#myModal_mal').modal('show');

            }
        );

        return false;
    });

    $('#busquedaAcompananteOtraLocalidad').on('click', function(e)
    {
        var listaError="";
        var num=1;
            
         $.post(
            URL+'/getAcompananteOtraLocalidad',
            $('#form_registro_actividad').serialize(),
            function(data)
            {
                $('#list_error').html(data);
                $('#myModal_mal').modal('show');

            }
        );

        return false;
    });


    $('#myModal_mal').delegate('input:checkbox', 'change', function () {
        var idActividad=$(this).data('rel');
        var idUsuario=this.id;
        if (this.checked) {
            $.post(
                URL+'/setAcompanante',
                {idUsuario:idUsuario,idActividad:idActividad,opcion:'insertar'},
                function(data)
                {
                    $('#confAcompanante'+idUsuario).html(data.mensaje);
                     setTimeout(function(){
                          $('#confAcompanante'+idUsuario).html('');
                    }, 2000)
                }
            );
        }else{
            $.post(
                URL+'/setAcompanante',
                {idUsuario:idUsuario,idActividad:idActividad,opcion:'eliminar'},
                function(data)
                {
                    $('#confAcompanante'+idUsuario).html(data.mensaje);
                     setTimeout(function(){
                          $('#confAcompanante'+idUsuario).html('');
                    }, 2000)
                }
            );
        }
        return false;
    });



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




