<?php
/****************************************************************************************************
*
*	VIEWS/misc/datos_mod_contrase�a.php
*
*		Descripci�n:  		  
*			Vista de los datos del usuario con contrase�a
*
*		Fecha de Creaci�n:
*			20/Octubre/2011
*
*		Ultima actualizaci�n:
*			20/Octubre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo">Datos del Usuario</div>
            <div class="texto">
				<?php
				foreach( $consulta->result() as $row ) :
					$usu = $row->Usuario;
				endforeach;
					
				$formulario = array(
					// * Boton submit
					'boton' => array (
						'name'		=> 'enviar',
						'class'		=> 'in_button'
					),
					// Usuario
					'usuario' => array (
						'name'		=> 'usuario',
						'id'		=> 'usuario',
						'value'		=> $usu,
						'class'		=> 'in_text',
						'onfocus'	=> "hover('usuario')",
					),
					// Contrase�a
					'contrasena' => array (
						'name'		=> 'contrasena',
						'id'		=> 'contrasena',
						'class'		=> 'in_text',
						'onfocus'	=> "hover('contrasena')",
					),
					// Contrase�a otra vez
					'contrasena_o' => array (
						'name'		=> 'contrasena_o',
						'id'		=> 'contrasena_o',
						'class'		=> 'in_text',
						'onfocus'	=> "hover('contrasena_o')",
					),
				);
				echo form_open();
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="100">Usuario: </th>';
				echo '<td>'.form_input($formulario['usuario']).'</td></tr>';
				echo '<tr><th class="text_form">Nueva Contrase&ntilde;a: </th>';
				echo '<td>'.form_password($formulario['contrasena']).'</td></tr>';
				echo '<tr><th class="text_form">Nueva Contrase&ntilde;a otra vez: </th>';
				echo '<td>'.form_password($formulario['contrasena_o']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
				?>
			</div>
		</div>