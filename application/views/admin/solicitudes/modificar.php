<?php
/****************************************************************************************************
*
*	VIEWS/solicitudes/modificar.php
*
*		Descripción:
*			Vista para la solicitud de alta de documentos
*
*		Fecha de Creación:
*			17/Enero/2011
*
*		Ultima actualización:
*			17/Enero/2011
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
				var act_arc = 0;
				
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
				
				$(function() {
                    $( "#fecha" ).datepicker({
						changeMonth: true,
						changeYear: true,
					});
					$('#fecha').datepicker($.datepicker.regional['es']);
					$('#fecha').datepicker('option', {dateFormat: 'yy-mm-dd'});
					var queryDate = '<?=$fecha?>',
					dateParts = queryDate.match(/(\d+)/g)
					realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
					$('#fecha').datepicker('setDate', realDate);
				});
                </script>
			<?php	
			if( $autorizar ) {
				$cancelar = "location.href='".base_url()."index.php/admin/solicitudes/autorizar/".$area."/".$tipo."'";
			}
			else {
				$cancelar = "location.href='".base_url()."index.php/admin/solicitudes/listado/".$area."/".$estado."/".$tipo."'";	
			}
            // Seccion
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
					'onclick'	=> $cancelar,
                ),
                // * Modificar Archivo
				'mod_archivo' => array (
					'name'		=> 'mod_archivo[]',
					'id'		=> 'mod_archivo[]',
					'value'		=> '0',
					'onclick'	=> 'modifica_archivo()',
				),
                // Código
                'codigo' => array (
                    'name'		=> 'codigo',
                    'id'		=> 'codigo',
                    'value'		=> $codigo,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('codigo')",                    
                ),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> $nombre,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
                ),
               //Edicion
				'edicion' => array (
                    'name'		=> 'edicion',
                    'id'		=> 'edicion',
                    'value'		=> $edicion,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('edicion')",                    
                ),
                // Causas
                'causas' => array (
					'name'		=> 'causas',
					'id'		=> 'causas',
					'value'		=> stripslashes($causas),
					'onfocus'	=> "hover('causas')",
                ),
                // Fecha
                'fecha' => array (
                    'name'		=> 'fecha',
                    'id'		=> 'fecha',
                    'value'		=> $fecha,
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
			echo '<tr><th class="text_form" width="80">Tipo de Solicitud: </th>';
	        echo '<td>'.$tipo_solicitud.'</td></tr>';
			if( $tipo_solicitud == 'Baja' ) {
				echo '<tr><th class="text_form" width="80">C&oacute;digo: </th>';
	            echo '<td>'.$codigo.'</td></tr>';
	            echo '<tr><th class="text_form" width="80">Nombre: </th>';
	            echo '<td>'.$nombre.'</td></tr>';
	            echo '<tr><th class="text_form" width="80">Secci&oacute;n: </th>';			
				echo '<td>'.$seccion_nombre.'</td></tr>';
			}
			else{
				echo '<tr><th class="text_form" width="80">C&oacute;digo: </th>';
	            echo '<td>'.form_input($formulario['codigo']).'</td></tr>';
	            echo '<tr><th class="text_form" width="80">Nombre: </th>';
	            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
				
	            echo '<tr><th class="text_form" width="80">Secci&oacute;n: </th>';			
				echo '<td>'.form_dropdown('seccion',$seccion_options,$id_seccion,$seccion_extras).'</td></tr>';				
			}            
            echo '<tr><th class="text_form">Fecha de la Solicitud: </th>';
            echo '<td>'.form_input($formulario['fecha']).'</td>';
			 echo '<tr><th class="text_form">Edicion: </th>';
            echo '<td>'.form_input($formulario['edicion']).'</td>';
            echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Causas: </th>';
            echo '<td>'.form_textarea($formulario['causas']).'</td>';					
			if( $tipo_solicitud == 'Alta' || $tipo_solicitud== 'Modificacion') {
				echo '<tr><th class="text_form" width="70">Archivo: <br /><span style="letter-spacing:0; text-align:left; font-size:11px">'.form_checkbox($formulario['mod_archivo']).' Modificar</span></th>';	            
	            echo '<td>'.form_upload($formulario['archivo']).'<span id="muestra_archivo"><a href="'.base_url().'includes/docs/'.$ruta.'" target="_blank" onmouseover="tip(\'Abrir el Documento\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/doc.png" /></a></span></td>';
			}
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
            echo form_close();
            ?> 
        </div>
    </div>
