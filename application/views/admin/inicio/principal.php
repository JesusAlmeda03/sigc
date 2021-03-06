<?php
/****************************************************************************************************
*
*	VIEWS/admin/_estructura/content.php
*
*		Descripción:  		  
*			Vista del contenido de la pagina de inicio del Panel de Amdinistrador
*			Accesos Rápidos
*
*		Fecha de Creación:
*			13/Octubre/2011
*
*		Ultima actualización:
*			6/Febrero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
?>          
    <div class="cont_admin">
        <div class="titulo">Bienvenido al Panel de Administrador</div>
        <div class="texto">
        	<div style="float:left">
        		<?php
        		if( !$this->session->userdata( 'ADI' ) ) {
	        		// Solicitudes
		    		if( $solicitudes > 0 ) {
						echo '<div style="width:240px; border:1px solid #EEE; padding:20px; text-align:center; font-style:italic; font-size:16px">';
		            	echo '<a href="'.base_url().'index.php/admin/solicitudes/autorizar/todos/todos"><img src="'.base_url().'includes/img/icons/admin/documentos.png" width="48" height="48" /></a><br />';
		            	echo '<a href="'.base_url().'index.php/admin/solicitudes/autorizar/todos/todos" style="color:#000">Autorizar Solicitudes ('.$solicitudes.')</a>';
		            	echo '</div><br />';
						$not_sol = true;
					}
					else {
						$not_sol = false;
					}
					
					// Contacto
					if( $contacto > 0 ) {
						echo '<div style="width:240px; border:1px solid #EEE; padding:20px; text-align:center; font-style:italic; font-size:16px">';
		            	echo '<a href="'.base_url().'index.php/admin/varios/contacto/0"><img src="'.base_url().'includes/img/icons/admin/varios.png" width="48" height="48" /></a><br />';
		            	echo '<a href="'.base_url().'index.php/admin/varios/contacto/0" style="color:#000">Contacto ('.$contacto.')</a>';
		            	echo '</div><br>';
						$not_con = true;
					}
					else {
						$not_con = false;
					}
					
					if( !$not_sol && !$not_con ){ 
						echo '<div style="width:240px; border:1px solid #EEE; padding:20px; text-align:center; font-style:italic; font-size:18px">';
		            	echo 'Por el momento no hay notificaciones';
		            	echo '</div><br>';
						
					}
						echo '<div style="width:240px; border:1px solid #EEE; padding:20px; text-align:center; font-style:italic; font-size:16px">';
		            	echo '<a href="'.base_url().'index.php/admin/inicio/manuales"><img src="'.base_url().'includes/img/icons/admin/documentos.png" width="48" height="48" /></a><br />';
		            	echo '<a href="'.base_url().'index.php/admin/inicio/manuales" style="color:#000">Manuales de Usuario</a>';
		            	echo '</div><br />';
				}
	    		?>
        	</div>
        	<link rel="stylesheet" type="text/css" href="<?=base_url()?>includes/css/innerfade.css" />
			<script type="text/javascript" src="<?=base_url()?>includes/js/innerfade/jquery.innerfade.js"></script>
			<script type="text/javascript" src="<?=base_url()?>includes/js/innerfade/config.js"></script>      
			
			<div id="innerfade-holder" class="container_16" style="margin:0 0 0 285px;">
			    <div id="slider" class="grid_16">
			        <div class="grid_10 alpha">
			          <ul id="imagenes">
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/C1.jpg" width="685" /></li>
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/C2.jpg" width="685" /></li>
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/D1.jpg" width="685" /></li>
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/D2.jpg" width="685" /></li>
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/D3.jpg" width="685" /></li>
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/D4.jpg" width="685" /></li>
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/D5.jpg" width="685" /></li>
				            <li style="border:1px solid #EEE"><img src="<?=base_url()?>includes/img/pix/D6.jpg" width="685" /></li>
				          </ul>
			        </div>
			    </div>
			</div>
        </div>
    </div>