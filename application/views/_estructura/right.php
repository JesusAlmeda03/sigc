<?php
/****************************************************************************************************
*
*	VIEWS/pagina/content.php
*
*	Descripci�n:  		  
*		Vista de la columna derecha del sistema
*
*	Fecha de Creaci�n:
*		06/Octubre/2011
*
*	Ultima actualizaci�n:
*		06/Octubre/2011
*
*	Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/
?>  
		<div class="right_col">
            <div id="box_user_des" style="padding:0">
            	<?php
            	// si ya esta logueado muestra sus datos de usuario
				if( $this->session->userdata('id_usuario') ) {
					if( $usuario['alerta'] )
						$a = "alerta.gif";
					else
						$a = "account.png";
					?>
                    <div class="titulo">
						<table><tr>
							<td width="25">
								<a href="#" rel="toggle[box_user_act]" data-openimage="<?=base_url()?>includes/img/icons/small/<?=$a?>" data-closedimage="<?=base_url()?>includes/img/icons/small/<?=$a?>" onMouseover="tip('Despliega el menu del usuario')" onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/small/<?=$a?>" /></a>
							</td>
							<td style="font-size:16px">
								<a href="javascript:animatedcollapse.toggle('box_user_act')" ><?php echo $this->session->userdata('nombre'); ?></a>
							</td>
						</tr></table>
					</div>
					<div id="box_user_act" style="padding-bottom:5px"><?=$usuario['usuario']?></div>
					<?php
				}
				// si no esta logueado muestra el formulario de login
				else {
					?>
					<div class="titulo" style="font-size: 20px">				
						<table><tr><td width="25"><a href="javascript:animatedcollapse.toggle('box_user_act')" onMouseover="tip('Ingresa con tus datos de usuario')"; onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/login.png" width="15" /></a></td><td><a href="javascript:animatedcollapse.toggle('box_user_act')" onMouseover="tip('Ingresa con tus datos de usuario')"; onMouseout="cierra_tip()">INGRESAR</a></td></tr></table>
					</div>
                   	<?php
					if( isset( $display ) ) 
						echo '<div id="box_user_act" style="display:normal;">';
					else
						echo '<div id="box_user_act" style="display:none;">';
							$formulario = array(
								// * Etiquetas					
								'etiqueta' => array (
									'class'		=> 'text_form'
								),
								// * Boton submit
								'boton' => array (
									'name'		=> 'enviar',
									'class'		=> 'in_button'
								),
								// Usuario
								'in_usuario' => array (
									'name'		=> 'usuario',
									'id'		=> 'usuario',
									'value'		=> set_value('usuario'),
									'class'		=> 'in_text',
									'onfocus'	=> "hover('usuario')",
									'style'		=> "width:140px;",
								),
								// Contrase�a
								'in_contrasena' => array (
									'name'		=> 'contrasena',
									'id'		=> 'contrasena',
									'class'		=> 'in_text',
									'onfocus'	=> "hover('contrasena')",
									'style'		=> "width:140px;",
								)
							);
							echo form_open('inicio/login');
							echo '<table class="tabla_form" style="width:270px;"><tr>';
							echo '<td width="80">'.form_label('Usuario:','usuario',$formulario['etiqueta']).'</td>';
							echo '<td>'.form_input($formulario['in_usuario']).'</td></tr><tr>';
							echo '<td>'.form_label('Contrase&ntilde;a:','contrasena',$formulario['etiqueta']).'</td>';
							echo '<td>'.form_password($formulario['in_contrasena']).'</td></tr>';
							echo '</table><br />';
							echo '<div style="width:270px; text-align:center">'.form_submit($formulario['boton'],'Aceptar').'</div>';
							echo form_close();
						?><br />
					</div>
					<?php
				}
				?>
				</div>
                <div class="ban_box" style="width:37px; height:30px; padding-bottom:0; float:left; text-align:center; border-top-right-radius : 0px; border-bottom-right-radius : 0px;"><a href="<?=base_url()?>index.php/inicio" onMouseover="tip('Ir al inicio')" onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/home.png" /></a></div>
                <div class="ban_box" style="width:37px; height:30px; padding-bottom:0; margin-left:6px; float:left; text-align:center; border-top-right-radius : 0px; border-bottom-right-radius : 0px;"><a href="<?=base_url()?>index.php/inicio/contacto" onMouseover="tip('Envia un mensaje al administrador')" onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/mail.png" wodth="32" height="36" /></a></div>
                <div class="ban_box" style="width:37px; height:30px; padding-bottom:0; margin-left:6px; float:left; text-align:center; border-top-right-radius : 0px; border-bottom-right-radius : 0px;"><a href="<?=base_url()?>index.php/inicio/noticias" onMouseover="tip('Noticias')" onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/news.png" /></a></div>
                <div class="ban_box" style="width:37px; height:30px; padding-bottom:0; margin-left:6px; float:left; text-align:center; border-top-right-radius : 0px; border-bottom-right-radius : 0px;"><a href="<?=base_url()?>index.php/inicio/calendario/<?php echo date('m')."/".date('Y'); ?>" onMouseover="tip('Calendario')" onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/calendar.png" /></a></div>
                <div class="ban_box" style="width:37px; height:30px; padding-bottom:0; margin-left:6px; float:left; text-align:center"><a href="<?=base_url()?>index.php/inicio/enlaces" onMouseover="tip('Enlaces de interes')" onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/link.png" /></a></div>
            </div>
            <div style="clear: both"></div>
		</div>
	</div>