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
        <div class="titulo">Manuales de Usuario del SIGC</div>
        <div class="texto">
        	<table id='tabla'>
        		
        		<tbody>
        			<tr>
	        			<th><?= '<img src="'.base_url().'includes/img/icons/admin/documentos.png" width="48" height="48" />'?></th>
	        			<td><a href='<?=base_url()?>includes/documentos/manual_alta_usuarios.pdf'>Manual Alta de Usuarios</a><br></td>
        			</tr>
        			<tr>
	        			<th><?= '<img src="'.base_url().'includes/img/icons/admin/documentos.png" width="48" height="48" />'?></th>
	        			<td><a href='<?=base_url()?>includes/documentos/manual_permisos_usuarios.pdf'>Manual Para Otorgar Permisos a Usuarios</a><br></td>
        			</tr>
        			<tr>
	        			<th><?= '<img src="'.base_url().'includes/img/icons/admin/documentos.png" width="48" height="48" />'?></th>
	        			<td><a href='<?=base_url()?>includes/documentos/manual_auditoria.pdf'>Manual de Auditorias</a></td>
        			</tr>
        		</tbody>
        	</table>
        	<link rel="stylesheet" type="text/css" href="<?=base_url()?>includes/css/innerfade.css" />
			<script type="text/javascript" src="<?=base_url()?>includes/js/innerfade/jquery.innerfade.js"></script>
			<script type="text/javascript" src="<?=base_url()?>includes/js/innerfade/config.js"></script>      
			
			
        </div>
    </div>