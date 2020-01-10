<?php
/****************************************************************************************************
*
*	VIEWS/misc/datos.php
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
				$boton= array(
					// Modificar
					'modificar' => array (
						'id'		=> 'modificar',
						'name'		=> 'modificar',
						'class'		=> 'in_button',
						'onclick'	=> "location.href = '".base_url()."index.php/inicio/mod_datos'",
						'style'		=> 'width:390px; margin-bottom:10px',
					),
					// Modificar Contrase�a
					'modificar_contrasena' => array (
						'id'		=> 'modificar_contrasena',
						'name'		=> 'modificar_contrasena',
						'class'		=> 'in_button',
						'onclick'	=> "location.href = '".base_url()."index.php/inicio/mod_datos_contrasena'",
						'style'		=> 'width:390px',
					),
				);
                if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla_form" style="width:700px;">';
                    foreach( $consulta->result() as $row ) :
                        echo '<tr><th class="text_form" style="font-weight:normal; width:110px">Nombre: </th><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.'</td></tr>';
                        echo '<tr><th class="text_form" style="font-weight:normal">Correo: </th><td>'.$row->Correo.'</td></tr>';
                        echo '<tr><th class="text_form" style="font-weight:normal">Usuario: </th><td>'.$row->Usuario.'</td></tr>';
                        echo '<tr><th class="text_form" style="font-weight:normal">Contrase&ntilde;a: </th><td>******</td></tr>';
                    endforeach;
					echo '</table><br />';
					echo '<div style="width:700px; text-align:center;">'.form_submit($boton['modificar'],'Modificar Datos').'<br />'.form_submit($boton['modificar_contrasena'],'Modificar Usuario y Contrasena').'</div>';
                }
				?>
			</div>
		</div>