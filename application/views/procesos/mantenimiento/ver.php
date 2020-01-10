<?php
/****************************************************************************************************
*
*	VIEWS/procesos/mantenimiento/programa.php
*
*		Descripción:
*			Programa de mantenimiento de equipo de computo
*
*		Fecha de Creación:
*			16/Abril/2011
*
*		Ultima actualización:
*			21/Septiembre/2012
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
				if($evidencia->num_rows() > 0){
					echo '<table class="tabla_form" id="tabla" width="700">';
					echo '	<thead>';
					echo '		<tr><th>Periodo</th><th>Año</th><th>Fecha</th></tr>';
					echo '	</thead>';
					echo '	<tbody>';
					echo '		<tr>';
						foreach($evidencia->result() as $des){
					echo '			<td>'.$des->Periodo.'</t>';
					echo '			<td>'.$des->Ano.'</td>';
					echo '			<td>'.$des->Fecha.'</t>';
					echo '			<td width="10"><a href="'.base_url().'includes/evidencias/'.$des->Ruta.'"/><img src="'.base_url().'includes/img/icons/ver.png" /> </a></td>';
					echo '		</tr>';
					echo '  </tbody>';
						}
					echo '</table>';	
				}else{
					echo 'Sin informacion';
				}
				
												  
				?>
				
				
        </div>
    </div>