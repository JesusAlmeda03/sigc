<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/identidad.php
*
*		Descripci�n:
*			Vista que muestra la identidad 
*
*		Fecha de Creaci�n:
*			30/Octubre/2011
*
*		Ultima actualizaci�n:
*			29/Noviembre/2011
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
        <div class="text">
			<?php 
			$formulario = array(
				// * Boton submit
				'boton' => array (
					'id'		=> 'modificar',
					'name'		=> 'modificar',
					'class'		=> 'in_button',
					'onfocus'	=> 'hover(\'modificar\')'
				),
				// Texto
				'texto' => array (
					'name'		=> 'texto',
					'id'		=> 'texto',
					'value'		=> $tex,
					'onfocus'	=> "hover('texto')",
				)
			);
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th class="text_form">Titulo: </th>';
			echo '<td>'.$tit.'</td>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Texto: </th>';
			echo '<td>'.form_textarea($formulario['texto']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').'</div>';
			echo form_close();
            ?>
        </div>
    </div>