<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/modificar.php
*
*		Descripci�n:
*			Vista para modificar documentos
*
*		Fecha de Creaci�n:
*			03/Noviembre/2011
*
*		Ultima actualizaci�n:
*			03/Noviembre/2011
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
				<script>
				var act_sec = 0;
				var act_arc = 0;
				
				// funciones
				function modifica_seccion() {
					if( !act_sec ) {
						document.getElementById('tipo_documento').style.display = 'block';
						document.getElementById('seccion').style.display = 'none';
						act_sec = 1;
					}
					else {
						document.getElementById('tipo_documento').style.display = 'none';
						document.getElementById('seccion').style.display = 'block';
						act_sec = 0;
					}
				}				
				function modifica_archivo() {
					if( !act_arc ) {
						document.getElementById('archivo').style.display = 'block';
						document.getElementById('muestra_archivo').style.display = 'none';
						act_arc = 1;
					}
					else {
						document.getElementById('archivo').style.display = 'none';
						document.getElementById('muestra_archivo').style.display = 'block';
						act_arc = 0;
					}
				}
				
				// date picker
				$(function() {
                    $( "#fecha" ).datepicker({
						changeMonth: true,
						changeYear: true,
					});
					$('#fecha').datepicker($.datepicker.regional['es']);
					$('#fecha').datepicker('option', {dateFormat: 'yy-mm-dd'});
					var queryDate = '<?=$fec?>',
					dateParts = queryDate.match(/(\d+)/g)
					realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
					$('#fecha').datepicker('setDate', realDate);
				});
				
				// ajax de los documentos
				$(document).ready(function(){
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
									url:"<?=base_url()?>index.php/admin_files/documentos/ajax_secciones",
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
									url:"<?=base_url()?>index.php/admin_files/documentos/ajax_secciones",
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
									url:"<?=base_url()?>index.php/admin_files/documentos/ajax_secciones",
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
            // Area		
            $area_extras = 'id="area" onfocus="hover(\'area\')" ';
            $seccion_extras = 'id="seccion" onfocus="hover(\'seccion\')" ';            
            $formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
                // * Boton cancelar
                'boton_cancelar' => array (
                    'id'		=> 'cancelar',
                    'name'		=> 'cancelar',
                    'class'		=> 'in_button',
					'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',
                    'onfocus'	=> 'hover(\'cancelar\')',					
					'onclick'	=> "location.href='".base_url()."index.php/".$uri."'",
                ),
				// * Modificar Seccion
				'mod_seccion' => array (
					'name'		=> 'mod_seccion',
					'id'		=> 'mod_seccion',
					'onclick'	=> 'modifica_seccion()',
				),
				// * Modificar Archivo
				'mod_archivo' => array (
					'name'		=> 'mod_archivo[]',
					'id'		=> 'mod_archivo[]',
					'value'		=> '0',
					'onclick'	=> 'modifica_archivo()',
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
						'style'		=> 'margin-bottom:10px',
					),
				),
                // C�digo
                'codigo' => array (
                    'name'		=> 'codigo',
                    'id'		=> 'codigo',
                    'value'		=> $cod,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('codigo')",
                ),
                // Edici�n
                'edicion' => array (
                    'name'		=> 'edicion',
                    'id'		=> 'edicion',
                    'value'		=> $edi,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('edicion')",
                ),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> $nom,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
                ),
                // Retención
                'retencion' => array (
                    'name'		=> 'retencion',
                    'id'		=> 'retencion',
                    'value'		=> $ret,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('retencion')",
                ),
                
				// Retención
                'edicion' => array (
                    'name'		=> 'edicion',
                    'id'		=> 'edicion',
                    'value'		=> $edi,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('edicion')",
                ),
                // Disposición
                'disposicion' => array (
                    'name'		=> 'disposicion',
                    'id'		=> 'disposicion',
                    'value'		=> $dis,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('disposicion')",
                ),
                // Fecha
                'fecha' => array (
                    'name'		=> 'fecha',
                    'id'		=> 'fecha',
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
					'style'		=> 'display:none',
                ),
            );
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="70">&Aacute;rea: </th>';
            echo '<td>'.form_dropdown('area',$area_options,$ida,$area_extras).'</td></tr>';
            echo '<tr><th class="text_form" width="70">Secci&oacute;n: <br /><span style="letter-spacing:0; text-align:left; font-size:11px">'.form_checkbox($formulario['mod_seccion']).' Modificar</span></th>';
            echo '<td>';
			echo form_dropdown('seccion',$seccion_options,$ids ,$seccion_extras);
			echo '<img src="'.base_url().'includes/img/ajax-loader.gif" style="display:none;" alt="Cargando" id="imgloader"/>';
			echo '<div id="tipo_documento" style="display:none">';
			echo form_radio($formulario['seccion']['documentos'])." Documentos<br />";
			echo form_radio($formulario['seccion']['comun_sigc']).' Documentos de Uso Com&uacute;n SIGC<br />';
			echo form_radio($formulario['seccion']['comun_sibib']).' Documentos de Uso Com&uacute;n SIBIB';
			echo '</div>';
			echo '</td></tr>';
            echo '<tr><th class="text_form" width="70">C&oacute;digo: </th>';
            echo '<td>'.form_input($formulario['codigo']).'</td></tr>';
            echo '<tr><th class="text_form">Edici&oacute;n: </th>';
            echo '<td>'.form_input($formulario['edicion']).'</td>';
            echo '<tr><th class="text_form" width="70">Nombre: </th>';
            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
			if( $ids == 2 ) {
				echo '<tr><th class="text_form" width="70">Retenci&oacute;n: </th>';
	            echo '<td>'.form_input($formulario['retencion']).'</td></tr>';
	            echo '<tr><th class="text_form" width="70">Disposici&oacute;n: </th>';
	            echo '<td>'.form_input($formulario['disposicion']).'</td></tr>';
	        }
	        echo '<tr><th class="text_form">Fecha: </th>';
            echo '<td>'.form_input($formulario['fecha']).'</td>';
            echo '<tr><th class="text_form" width="70">Archivo: <br /><span style="letter-spacing:0; text-align:left; font-size:11px">'.form_checkbox($formulario['mod_archivo']).' Modificar</span></th>';
            echo '<td>'.form_upload($formulario['archivo']);
			echo '<span id="muestra_archivo"><a href="'.base_url().'includes/docs/'.$rut.'" target="_blank" onmouseover="tip(\'Abrir el Documento\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" /></a></span>';
			echo '</td></tr>';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>