<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="titulo"><?=$titulo2?></div>
            <div class="texto">
				<?php
				$formulario = array(
					// * Boton submit
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')'
					),
					// Archivo
	                'archivo' => array (
	                    'name'		=> 'archivo',
	                    'id'		=> 'archivo',
	                    'class'		=> 'in_text',
						'onfocus'	=> "hover('archivo')",
						'type'		=> "file"
                       ),

                    'nombre' => array (
	                    'name'		=> 'nombre',
	                    'id'		=> 'nombre',
	                    'value'		=> set_value('nombre'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('nombre')",
	                   ),
				);
				$ano_extras = 'id="ano" onfocus="hover(\'ano\')" style="width:80px"';
				$area_extras = 'id="area" onfocus="hover(\'area\')"';

				// Nueva Evidencia
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Selecciona el documento que dejaras como evidencia</td></tr></table><br />';
				echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripcion:</th>';
				echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
				echo '<tr><th class="text_form" width="80">Archivo: </th>';
	            echo '<td>'.form_input($formulario['archivo']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
                ?>
        </div>
    </div>
