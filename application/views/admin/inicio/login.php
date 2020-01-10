<?php
/****************************************************************************************************
*
*	VIEWS/admin/content.php
*
*		Descripci�n:  		  
*			Vista del contenido de la pagina de inicio del Panel de Amdinistrador
*			Accesos R�pidos
*
*		Fecha de Creaci�n:
*			13/Octubre/2011
*
*		Ultima actualizaci�n:
*			13/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>           
	<div class="content" style="margin-top:0">
        <div class="cont_admin">
            <div class="titulo">Panel de Administrador</div>
			<?php
			$formulario = array(
				// * Boton submit
				'boton' => array (
					'name'		=> 'enviar',
					'class'		=> 'in_button'
				),
				// Nombre
				'in_usuario' => array (
					'name'		=> 'usuario',
					'id'		=> 'usuario',
					'value'		=> set_value('usuario'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('usuario')",
					'style'		=> "width:160px;",
				),
				// Apellido Paterno
				'in_contrasena' => array (
					'name'		=> 'contrasena',
					'id'		=> 'contrasena',
					'value'		=> set_value('contrasena'),
					'class'		=> 'in_text',
					'onfocus'	=> "hover('contrasena')",
					'style'		=> "width:160px;",
				)
			);
			echo form_open();
			echo '<br /><table class="tabla_form" style="width:250px; margin:auto;">';
			echo '<tr><th class="text_form" width="50">Usuario: </th>';
			echo '<td>'.form_input($formulario['in_usuario']).'</td></tr>';
			echo '<tr><th class="text_form">Contrase&ntilde;a: </th>';
			echo '<td>'.form_password($formulario['in_contrasena']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center">'.form_submit($formulario['boton'],'Aceptar').'</div>';
			echo form_close();
			?>
        </div>