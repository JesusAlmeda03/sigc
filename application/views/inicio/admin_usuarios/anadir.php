<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/anadir.php
*
*		Descripci�n:
*			Vista para a�adir usuarios
*
*		Fecha de Creaci�n:
*			20/Octubre/2011
*
*		Ultima actualizaci�n:
*			20/Octubre/2011
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
						'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',
	                    'onfocus'	=> 'hover(\'cancelar\')',					
						'onclick'	=> "location.href='".base_url()."index.php/inicio/administracion_usuarios/".$estado."'",
	                ),
	                // Nombre
	                'nombre' => array (
	                    'name'		=> 'nombre',
	                    'id'		=> 'nombre',
	                    'value'		=> set_value('nombre'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('nombre')",
	                ),
	                // Paterno
	                'paterno' => array (
	                    'name'		=> 'paterno',
	                    'id'		=> 'paterno',
	                    'value'		=> set_value('paterno'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('paterno')",
	                ),
	                // Materno
	                'materno' => array (
	                    'name'		=> 'materno',
	                    'id'		=> 'materno',
	                    'value'		=> set_value('materno'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('materno')",
	                ),
	                // Correo
	                'correo' => array (
	                    'name'		=> 'correo',
	                    'id'		=> 'correo',
	                    'value'		=> set_value('correo'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('correo')",
	                ),
	                // Usuario
	                'usuario' => array (
	                    'name'		=> 'usuario',
	                    'id'		=> 'usuario',
	                    'value'		=> set_value('usuario'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('usuario')",
	                ),
	                // Contrase�a
	                'contrasena' => array (
	                    'name'		=> 'contrasena',
	                    'id'		=> 'contrasena',
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('contrasena')",
						'style'		=> 'width:310px; font-weight:bold; font-style:italic; letter-spacing:1px',
	                ),				
	            );
	            echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
	            echo '<table class="tabla_form" width="700">';
	            echo '<tr><th class="text_form" width="50">Nombre: </th>';
	            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
	            echo '<tr><th class="text_form" width="50">Apellido Paterno: </th>';
	            echo '<td>'.form_input($formulario['paterno']).'</td></tr>';
	            echo '<tr><th class="text_form" width="50">Apellido Materno: </th>';
	            echo '<td>'.form_input($formulario['materno']).'</td></tr>';
	            echo '<tr><th class="text_form" width="50">Correo Electr&oacute;nico: </th>';
	            echo '<td>'.form_input($formulario['correo']).'</td></tr>';
	            echo '<tr><th class="text_form" width="50">Usuario: </th>';
	            echo '<td>'.form_input($formulario['usuario']).'</td></tr>';
	            echo '<tr><th class="text_form" width="50">Contase&ntilde;a: </th>';
	            echo '<td>'.form_input($formulario['contrasena']).'<input type="button" onclick="genera_pass(\'contrasena\')" id="generar" name="generar" value="Generar Automaticamente" class="in_button" style="width:250px; padding:5px; height:35px; margin-left:10px; font-size:12px" /></td></tr>';
	            echo '</table><br />';
	            echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
	            echo form_close();
	            ?>
	        </div>
	    </div>