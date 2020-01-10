<?php
/****************************************************************************************************
*
*	VIEWS/admin/solicitudes/modificar.php
*
*		Descripción:
*			Vista para la solicitud de modificacion de documentos desde el panel de administrador
*
*		Fecha de Creación:
*			06/Febrero/2012
*
*		Ultima actualización:
*			06/Febrero/2012
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
				$(function() {					
					// fecha del documento
                    $( "#fecha_doc" ).datepicker({
						changeMonth: true,
						changeYear: true,
					});
					$('#fecha_doc').datepicker($.datepicker.regional['es']);
					$('#fecha_doc').datepicker('option', {dateFormat: 'yy-mm-d'});
					var queryDate = '<?=$fec?>',
					dateParts = queryDate.match(/(\d+)/g)
					realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
					$('#fecha_doc').datepicker('setDate', realDate);
					
					// fecha de la solicitud
                    $( "#fecha" ).datepicker({
						changeMonth: true,
						changeYear: true,
					});
					$('#fecha').datepicker($.datepicker.regional['es']);
					$('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
				});
                </script>                
			<?php	
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
                // Fecha del documento
                'fecha_doc' => array (
                    'name'		=> 'fecha_doc',
                    'id'		=> 'fecha_doc',
                    'value'		=> $fec,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('fecha_doc')",
                    'style'		=> 'width:200px'
                ),
				// Edicion
                'edicion' => array (
                    'name'		=> 'edicion',
                    'id'		=> 'edicion',
                    'value'		=> $edi,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('edicion')",
                    'style'		=> 'width:200px'
                ),
                // C�digo
                'codigo' => array (
                    'name'		=> 'codigo',
                    'id'		=> 'codigo',
                    'value'		=> $cod,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('codigo')",
                ),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> $nom,
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
                // Causas
                'causas' => array (
					'name'		=> 'causas',
					'id'		=> 'causas',
					'value'		=> set_value('causas'),
					'onfocus'	=> "hover('causas')",
                ),
                // Archivo
                'archivo' => array (
                    'name'		=> 'archivo',
                    'id'		=> 'archivo',
                    'value'		=> set_value('archivo'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('archivo')",
                ),
                // Seccion
                'seccion' => array (
                    'name'		=> 'seccion',
                    'id'		=> 'seccion',
                    'value'		=> $ids,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('seccion')",
					'style'		=> "display:none",
                ),
            );
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="80">Secci&oacute;n: </th>';
            echo '<td>'.$sec.'</td></tr>';
            echo '<tr><th class="text_form" width="80">Fecha del Documento: </th>';
            echo '<td>'.form_input($formulario['fecha_doc']).'</td></tr>';
            echo '<tr><th class="text_form" width="80">C&oacute;digo: </th>';
            echo '<td>'.form_input($formulario['codigo']).'</td></tr>';
            echo '<tr><th class="text_form" width="80">Nombre: </th>';
            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
            echo '<tr><th class="text_form">Fecha de la Modificaci&oacute;n: </th>';
            echo '<td>'.form_input($formulario['fecha']).'</td>';
            echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Causas: </th>';
            echo '<td>'.form_textarea($formulario['causas']).'</td>';
            echo '<tr><th class="text_form" width="80">Archivo: </th>';
            echo '<td>'.form_upload($formulario['archivo']).'</td></tr>';
            echo '</table>';
			echo form_input($formulario['seccion']);
            echo '<br /><div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>
