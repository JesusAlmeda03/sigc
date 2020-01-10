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
			$sis_a = $sis_b = $sis_c = false;
			$tip_a = $tip_b = false;			
			// tipo
			switch( $com ) {
				case 0 : $tip_a = true; break;
				case 1 : $tip_b = true; break;
			}
			
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
                // * Boton cancelar
                'boton_cancelar' => array (
                    'id'		=> 'cancelar',
                    'name'		=> 'cancelar',
                    'class'		=> 'in_button',
					'style'		=> 'margin:10px; width:150px; height:55px',
                    'onfocus'	=> 'hover(\'cancelar\')',					
					'onclick'	=> "location.href='".base_url()."index.php/".$uri."'",
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
                    'value'		=> $nom,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
                ),
            );
            echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="50">Tipo de Secci&oacute;n: </th>';
            echo '<td>';
			echo '<div id="tipo_documento">';
			echo form_radio($formulario['tipo']['areas'],'',$tip_a).' &Aacute;reas<br />';
			echo form_radio($formulario['tipo']['comun'],'',$tip_b).' Uso Com&uacute;n';
			echo '</div>';
			echo '</td></tr>';
            echo '<tr><th class="text_form" width="50">Nombre: </th>';
            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
            echo '</table>';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>