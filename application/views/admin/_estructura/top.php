<?php
/****************************************************************************************************
*
*	VIEWS/admin/_estructura/top.php
*
*		Descripción:  		  
*			Vista del contenido de la parte de arriba de la pagina del Panel de Administrador
*			Incluye código necesario para el ToolTip, el banner principal y el menu
*
*		Fecha de Creación:
*			13/Octubre/2011
*
*		Ultima actualización:
*			13/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>
		<body>
			<div id="dhtmltooltip"></div>
			<!-- tooltip -->
			<script type="text/javascript" src="<?=base_url()?>includes/js/tooltip.js"></script>		
			<div class="wrapper">
                <div class="banner">
                	<table style="width:990px; margin:auto; padding-top:3px;">
                		<tr>
                			<td width="70">
                				<div style="width:40px; height:40px; background-color:#FFF; border:1px solid #EEE; margin-left:8px; padding:5px;">
                					<img src="<?=base_url()?>includes/img/sigc.png" />
                				</div>
                			</td>
                			<td>
								<div id="nombre_titulo" style="font-size:30px; color:#FFF;">
			                		PANEL DE ADMINISTRADOR<br />
			               			SISTEMA DE GESTI&Oacute;N DE CALIDAD
			               		</div>
                			</td>                			
                		</tr>
                	</table>                	
                </div>
                <div class="menu"><div style="width:980px; margin:auto">
					<?php
					if( $this->session->userdata('admin') )
	                    echo $menu;
					?>
				</div>
                </div><div class="btm_sh" style="width:100%; margin-bottom:5px;"></div>		