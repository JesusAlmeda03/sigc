<?php
/****************************************************************************************************
*
*	VIEWS/admin/solicitudes/baja.php
*
*		Descripción:
*			Vista para la solicitud de baja de documentos desde el panel de administrador
*
*		Fecha de Creación:
*			6/Febrero/2012
*
*		Ultima actualización:
*			6/Febrero/2012
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
                    $( "#fecha" ).datepicker({
						changeMonth: true,
						changeYear: true,
					});
					$('#fecha').datepicker($.datepicker.regional['es']);
					$('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
					$("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
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
            );
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="80">Fecha del Documento: </th>';
            echo '<td>'.$fec.'</td></tr>';
            echo '<tr><th class="text_form" width="80">C&oacute;digo: </th>';
            echo '<td>'.$cod.'</td></tr>';
            echo '<tr><th class="text_form" width="80">Nombre: </th>';
            echo '<td>'.$nom.'</td></tr>';
            echo '<tr><th class="text_form" width="80">Secci&oacute;n: </th>';
            echo '<td>'.$sec.'</td></tr>';
            echo '<tr><th class="text_form">Fecha de la Baja: </th>';
            echo '<td>'.form_input($formulario['fecha']).'</td>';
            echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Causas: </th>';
            echo '<td>'.form_textarea($formulario['causas']).'</td>';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>