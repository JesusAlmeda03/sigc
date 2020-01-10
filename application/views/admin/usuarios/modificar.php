<?php
/****************************************************************************************************
*
*	VIEWS/admin/usuarios/modificar.php
*
*		Descripci�n:
*			Vista para modificar usuarios
*
*		Fecha de Creaci�n:
*			03/Noviembre/2011
*
*		Ultima actualizaci�n:
*			03/Noviembre/2011
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
			<script>
			var act_con = 0;
			
			// funciones
			function modifica_contrasena() {
				if( !act_con ) {
					document.getElementById('modifica_contrasena').style.display = 'block';
					document.getElementById('contrasena_old').style.display = 'none';
					act_con = 1;
				}
				else {
					document.getElementById('modifica_contrasena').style.display = 'none';
					document.getElementById('contrasena_old').style.display = 'block';
					act_con = 0;
				}
			}
			</script>
			<?php	
            // Area		
            $area_extras = 'id="area" onfocus="hover(\'area\')" ';
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
					'onclick'	=> "location.href='".base_url()."index.php/admin/usuarios/".$uri."'",
                ),
				// * Modificar Contrase�a
				'mod_contrasena' => array (
					'name'		=> 'mod_contrasena[]',
					'id'		=> 'mod_contrasena[]',
					'value'		=> '0',
					'onclick'	=> 'modifica_contrasena()',
				),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> $nom,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
                ),
                // Paterno
                'paterno' => array (
                    'name'		=> 'paterno',
                    'id'		=> 'paterno',
                    'value'		=> $pat,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('paterno')",
                ),
                // Materno
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
                    'value'		=> set_value('contrasena'),
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('contrasena')",
					'style'		=> 'width:550px; font-weight:bold; font-style:italic; letter-spacing:1px',
                ),
            );
            echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="980">';
            echo '<tr><th class="text_form" width="50">&Aacute;rea: </th>';
            echo '<td>'.form_dropdown('area',$area_options,$ida,$area_extras).'</td></tr>';
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
            echo '<tr><th class="text_form" width="50">Contase&ntilde;a: <br /><span style="letter-spacing:0; text-align:left; font-size:11px">'.form_checkbox($formulario['mod_contrasena']).' Modificar</span></th>';
            echo '<td><span id="contrasena_old">******</span><span id="modifica_contrasena" style="display:none">'.form_input($formulario['contrasena']).'<input type="button" onclick="genera_pass(\'contrasena\')" id="generar" name="generar" value="Generar Automaticamente" class="in_button" style="width:250px; padding:5px; height:35px; margin-left:10px; font-size:12px" /></span></td></tr>';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>