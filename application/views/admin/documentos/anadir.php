<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/anadir.php
*
*		Descripci�n:
*			Vista para a�adir documentos
*
*		Fecha de Creaci�n:
*			20/Octubre/2011
*
*		Ultima actualizaci�n:
*			20/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="texto">
        	<?php
            // Area
            $area_extras = 'id="area" onfocus="hover(\'area\')" ';
            $formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
				// Secci�n
				'seccion' => array (
					'documentos' => array (
						'name'		=> 'seccion_tipo',
						'id'		=> 'documentos',
						'value'		=> '1',
					),
					'comun_sigc' => array (
						'name'		=> 'seccion_tipo',
						'id'		=> 'comun_sigc',
						'value'		=> '2',
					),
					'comun_sibib' => array (
						'name'		=> 'seccion_tipo',
						'id'		=> 'comun_sibib',
						'value'		=> '3',
					),
					'comun_ambos' => array (
						'name'		=> 'seccion_tipo',
						'id'		=> 'comun_ambos',
						'value'		=> '4',
					),
				),
                // Retencion
                'retencion' => array (
                    'name'		=> 'retencion',
                    'id'		=> 'retencion',
                    'value'		=> set_value('retencion'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover(\'retencion\')",
                ),
                // Disposicion
                'disposicion' => array (
                    'name'		=> 'disposicion',
                    'id'		=> 'disposicion',
                    'value'		=> set_value('disposicion'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover(\'disposicion\')",
                ),
                // C�digo
                'codigo' => array (
                    'name'		=> 'codigo',
                    'id'		=> 'codigo',
                    'value'		=> set_value('codigo'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('codigo')",
                ),
                // Edici�n
                'edicion' => array (
                    'name'		=> 'edicion',
                    'id'		=> 'edicion',
                    'value'		=> set_value('edicion'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('edicion')",
                ),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> set_value('nombre'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
                ),
                // Fecha
                'fecha' => array (
                    'name'		=> 'fecha',
                    'id'		=> 'fecha',
                    'value'		=> set_value('fecha'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('fecha')",
                    'style'		=> 'width:200px'

                ),
                // Archivo
                'archivo' => array (
                    'name'		=> 'archivo',
                    'id'		=> 'archivo',
                    'value'		=> set_value('archivo'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('archivo')",
                )
            );
            ?>
			<script>
          /*  function registro() {
                i = document.getElementById('seccion').value;
                if( i == "2" ) {
					datos = '<table class="tabla_form" width="980">';
					datos += '<tr><th class="text_form" width="80">Retenci&oacute;n: </th>';
					datos += '<td><?=form_input($formulario['retencion'])?></td></tr>';
					datos += '<tr><th class="text_form" width="80">Disposici&oacute;n: </th>';
					datos += '<td><?=form_input($formulario['disposicion'])?></td></tr>';
					datos += '</table>';
                    $("#registro_datos").append( datos );
                }
            }*/

            $(function() {
                  $( "#fecha" ).datepicker({
                      changeMonth: true,
                      changeYear: true,
                  });

                  $('#fecha').datepicker($.datepicker.regional['es']);
                  $('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
                  $("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
              });
              </script>
            <script>
            $(document).ready(function(){
            	// Documentos
                $("#documentos").click(function(){
                    if($(this).val()!=""){
                        var dato=$(this).val();
                        $("#tipo_documento").empty();
                        $("#imgloader").show();
                        $("#tipo_documento").css("padding","0");
                        $("#imgloader").css("padding-bottom","10px");
                        $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?=base_url()?>index.php/admin/documentos/ajax_secciones",
                            data:"id_seccion="+dato,
                            success:function(msg){
                                $("#tipo_documento").empty().removeAttr("disabled").append(msg);
                                $("#imgloader").hide();
                            }
                        });
                    }else{
                        $("#dep_cont").empty().attr("disabled","disabled");
                    }
                });

                // Común SIGC
                $("#comun_sigc").click(function(){
                    if($(this).val()!=""){
                        var dato=$(this).val();
                        $("#tipo_documento").empty();
                        $("#imgloader").show();
                        $("#tipo_documento").css("padding","0");
                        $("#imgloader").css("padding-bottom","10px");
                        $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?=base_url()?>index.php/admin/documentos/ajax_secciones",
                            data:"id_seccion="+dato,
                            success:function(msg){
                                $("#tipo_documento").empty().removeAttr("disabled").append(msg);
                                $("#imgloader").hide();
                            }
                        });
                    }else{
                        $("#dep_cont").empty().attr("disabled","disabled");
                    }
                });

                // Común SIBIB
                $("#comun_sibib").click(function(){
                    if($(this).val()!=""){
                        var dato=$(this).val();
                        $("#tipo_documento").empty();
                        $("#imgloader").show();
                        $("#tipo_documento").css("padding","0");
                        $("#imgloader").css("padding-bottom","10px");
                        $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?=base_url()?>index.php/admin/documentos/ajax_secciones",
                            data:"id_seccion="+dato,
                            success:function(msg){
                                $("#tipo_documento").empty().removeAttr("disabled").append(msg);
                                $("#imgloader").hide();
                            }
                        });
                    }else{
                        $("#dep_cont").empty().attr("disabled","disabled");
                    }
                });

                // Común SIGC y SIBIB
                $("#comun_ambos").click(function(){
                    if($(this).val()!=""){
                        var dato=$(this).val();
                        $("#tipo_documento").empty();
                        $("#imgloader").show();
                        $("#tipo_documento").css("padding","0");
                        $("#imgloader").css("padding-bottom","10px");
                        $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?=base_url()?>index.php/admin/documentos/ajax_secciones",
                            data:"id_seccion="+dato,
                            success:function(msg){
                                $("#tipo_documento").empty().removeAttr("disabled").append(msg);
                                $("#imgloader").hide();
                            }
                        });
                    }else{
                        $("#dep_cont").empty().attr("disabled","disabled");
                    }
                });
            });
            </script>
			<?php
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="80">&Aacute;rea: </th>';
            echo '<td>'.form_dropdown('area',$area_options,set_value('area'),$area_extras).'</td></tr>';
            echo '<tr><th class="text_form" width="80">Secci&oacute;n: </th>';
            echo '<td>';
			echo '<img src="'.base_url().'includes/img/ajax-loader.gif" style="display:none;" alt="Cargando" id="imgloader"/>';
			echo '<div id="tipo_documento">';
			echo form_radio($formulario['seccion']['documentos'])." Documentos<br />";
			echo form_radio($formulario['seccion']['comun_sigc']).' Documentos de Uso Com&uacute;n SIGC<br />';
			echo form_radio($formulario['seccion']['comun_sibib']).' Documentos de Uso Com&uacute;n SIBIB<br />';
			echo form_radio($formulario['seccion']['comun_ambos']).' Documentos de Uso Com&uacute;n SIGC y SIBIB<br />';
			echo '</div>';
			echo '</td></tr>';
            echo '</table>';
            echo '<div id="registro_datos"></div>';
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="80">C&oacute;digo: </th>';
            echo '<td>'.form_input($formulario['codigo']).'</td></tr>';
            echo '<tr><th class="text_form">Edici&oacute;n: </th>';
            echo '<td>'.form_input($formulario['edicion']).'</td>';
            echo '<tr><th class="text_form" width="80">Nombre: </th>';
            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
            echo '<tr><th class="text_form">Fecha: </th>';
            echo '<td>'.form_input($formulario['fecha']).'</td>';
            echo '<tr><th class="text_form" width="80">Archivo: </th>';
            echo '<td>'.form_upload($formulario['archivo']).'</td></tr>';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>
