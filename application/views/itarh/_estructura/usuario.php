<?php
/****************************************************************************************************
*
*	VIEWS/admin/_estructura/usuario.php
*
*		Descripci�n:  		  
*			Datos del usuario y ruta actual
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
			<div class="usuario_admin">
            	<table width="970">
                	<tr>
                    	<td width="700"><?=$barra?></td>                        
                        <td style="text-align:right" valign="top">
							<?php echo '<a href="'.base_url().'" target="_blank" onmouseover="tip(\'Ir a la pantalla de usuario\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/small/account.png" /> '.$this->session->userdata('nombre').'</a> '; ?>
							<a href="#" id="cerrar_sesion" onMouseover="tip('Cerrar tu sesi&oacute;n de<br />Administrador / Usuario')"; onMouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/small/logout.png" /></a>
						</td>
                    </tr>
                </table>
			</div>