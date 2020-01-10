<?php
/****************************************************************************************************
*
*	VIEWS/itarh/usuarios/resolver.php
*
*		Descripción:
*			Resolver Observaciones
*
*		Fecha de Creación:
*			09/Octubre/2011
*
*		Ultima actualización:
*			09/Octubre/2011
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
                    'onfocus'	=> 'hover(\'cancelar\')',
                    'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',
                    'onclick'	=> 'location=\''.base_url().'index.php/itarh/observaciones/listado/'.$enlace.'\'',
                ),
                // Acción Correctiva
                'accion' => array (
                    'name'		=> 'accion',
                    'id'		=> 'accion',
                    'value'		=> set_value('accion'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('accion')",
                ),
            );
            
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="150">Quincena: </th>';
            echo '<td>'.$quincena.'</td></tr>';
            echo '<tr><th class="text_form">Matricula: </th>';
            echo '<td>'.$matricula.'</td></tr>';
            echo '<tr><th class="text_form">Nombre: </th>';
            echo '<td>'.$nombre.'</td></tr>';
			echo '<tr><th class="text_form">Unidad Responsable: </th>';
            echo '<td>'.$unidad.'</td></tr>';
            echo '<tr><th class="text_form">Tipo de Empleado: </th>';
            echo '<td>'.$empleado.'</td></tr>';
            echo '<tr><th class="text_form">Permanencia: </th>';
            echo '<td>'.$permanencia.'</td></tr>';
            echo '<tr><th class="text_form">Horas Contrato: </th>';
            echo '<td>'.$contrato.'</td></tr>';
			echo '<tr><th class="text_form" valign="top">Sistema: </th>';
            echo '<td>'.$sistema.'</td></tr>';
			echo '<tr><th class="text_form" valign="top">Contraloria: </th>';
            echo '<td>'.$contraloria.'</td></tr>';
			echo '<tr><th class="text_form" valign="top">Observaci&oacute;n: </th>';
            echo '<td>'.$observacion.'</td></tr>';
			echo '</table><br />';
			
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
			echo '<tr><th class="text_form" valign="top">Acci&oacute;n Correctiva: </th>';
            echo '<td>'.form_textarea($formulario['accion']).'</td></tr>';
			echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>