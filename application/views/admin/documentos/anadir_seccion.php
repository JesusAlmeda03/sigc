<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/anadir_seccion.php
*
*		Descripci�n:
*			Vista para a�adir secciones
*
*		Fecha de Creaci�n:
*			25/Octubre/2011
*
*		Ultima actualizaci�n:
*			25/Octubre/2011
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
            $sistema_extras = 'id="sistema" onfocus="hover(\'sistema\')" ';
            $formulario = array(
                // * Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')'
                ),
				// Tipo
				'tipo' => array (
					'areas' => array (
						'name'		=> 'tipo',
						'id'		=> 'areas',
						'value'		=> '0',
					),
					'comun' => array (
						'name'		=> 'tipo',
						'id'		=> 'comun',
						'value'		=> '1',
						'style'		=> 'margin-bottom:10px',
					),
				),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> set_value('nombre'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
                ),
            );
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="150">Tipo de Secci&oacute;n: </th>';
            echo '<td>';
			echo '<div id="tipo_documento">';
			echo form_radio($formulario['tipo']['areas'],'',true).' &Aacute;reas<br />';
			echo form_radio($formulario['tipo']['comun']).' Uso Com&uacute;n';
			echo '</div>';
			echo '</td></tr>';
            echo '<tr><th class="text_form">Nombre: </th>';
            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>