<?php
/****************************************************************************************************
*
*	VIEWS/solicitudes/alta.php
*
*		Descripci�n:
*			Vista para la solicitud de alta de documentos
*
*		Fecha de Creaci�n:
*			24/Noviembre/2011
*
*		Ultima actualizaci�n:
*			24/Noviembre/2011
*	
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
	<div class="content">
		<div class="cont">
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
	                // C�digo
	                'codigo' => array (
	                    'name'		=> 'codigo',
	                    'id'		=> 'codigo',
	                    'value'		=> set_value('codigo'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('codigo')",
	                ),
	                // Nombre
	                'nombre' => array (
	                    'name'		=> 'nombre',
	                    'id'		=> 'nombre',
	                    'value'		=> set_value('nombre'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('nombre')",
	                ),
	                // Causas
	                'causas' => array (
						'name'		=> 'causas',
						'id'		=> 'causas',
						'value'		=> set_value('causas'),
						'onfocus'	=> "hover('causas')",
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
	            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
	            echo '<table class="tabla_form" width="700">';
	            echo '<tr><th class="text_form" width="80">C&oacute;digo: </th>';
	            echo '<td>'.form_input($formulario['codigo']).'</td></tr>';
	            echo '<tr><th class="text_form" width="80">Nombre: </th>';
	            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
	            echo '<tr><th class="text_form" width="80">Secci&oacute;n: </th>';
				echo '<td>'.form_dropdown('seccion',$seccion_options,set_value('seccion'),$seccion_extras).'</td></tr>';
	            echo '<tr><th class="text_form">Fecha del Alta: </th>';
	            echo '<td>'.form_input($formulario['fecha']).'</td>';
	            echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Causas: </th>';
	            echo '<td>'.form_textarea($formulario['causas']).'</td>';
	            echo '<tr><th class="text_form" width="80">Archivo: </th>';
	            echo '<td>'.form_upload($formulario['archivo']).'</td></tr>';
	            echo '</table><br />';
	            echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
	            echo form_close();
	            ?> 
        	</div>
    	</div>