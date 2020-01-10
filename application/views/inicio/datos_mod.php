<?php
/****************************************************************************************************
*
*	VIEWS/misc/datos_mod.php
*
*		Descripci�n:  		  
*			Vista de los datos del usuario
*
*		Fecha de Creaci�n:
*			12/Octubre/2011
*
*		Ultima actualizaci�n:
*			12/Octubre/2011
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
					$nom = $row->Nombre;
					$pat = $row->Paterno;
					$mat = $row->Materno;
					$cor = $row->Correo;					
				endforeach;
					
				$formulario = array(
					// * Boton submit
					'boton' => array (
						'name'		=> 'enviar',
						'class'		=> 'in_button'
					),
					// Nombre
					'nombre' => array (
						'name'		=> 'nombre',
						'id'		=> 'nombre',
						'value'		=> $nom,
						'class'		=> 'in_text',
						'onfocus'	=> "hover('nombre')",
					),
					// Apellido Paterno
					'paterno' => array (
						'name'		=> 'paterno',
						'id'		=> 'paterno',
						'value'		=> $pat,
						'class'		=> 'in_text',
						'onfocus'	=> "hover('paterno')",
					),
					// Apellido Materno
					'materno' => array (
						'name'		=> 'materno',
						'id'		=> 'materno',
						'value'		=> $mat,
						'class'		=> 'in_text',
						'onfocus'	=> "hover('materno')",
					),
					// Correo
					'correo' => array (
						'name'		=> 'correo',
						'id'		=> 'correo',
						'value'		=> $cor,
						'class'		=> 'in_text',
						'onfocus'	=> "hover('correo')",
					),
				);
				echo form_open();
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="50">Nombre: </th>';
				echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
				echo '<tr><th class="text_form">Paterno: </th>';
				echo '<td>'.form_input($formulario['paterno']).'</td></tr>';
				echo '<tr><th class="text_form">Materno: </th>';
				echo '<td>'.form_input($formulario['materno']).'</td></tr>';
				echo '<tr><th class="text_form">Correo: </th>';
				echo '<td>'.form_input($formulario['correo']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
				?>
			</div>
		</div>