<?php
/****************************************************************************************************
*
*	VIEWS/procesos/minutas/ver.php
*
*		Descripción:
*			Vista que muestra toda la minuta
*
*		Fecha de Creación:
*			22/Noviembre/2011
*
*		Ultima actualización:
*			22/Noviembre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>   
    <body>
    	<div id="dhtmltooltip"></div>
		<!-- tooltip -->
		<script type="text/javascript" src="<?=base_url()?>includes/js/tooltip.js"></script>
           
        <div class="wrapper">

            <div class="banner">
				<table style="width:955px; margin:auto; padding-top:5px;">
            		<tr>
            			<td width="68">
            				<div style="width:40px; height:40px; background-color:#FFF; border:1px solid #EEE; margin-left:8px; padding:5px;">
            					<img src="<?=base_url()?>includes/img/sigc.png" />
            				</div>
            			</td>
            			<td valign="middle">
							<div id="nombre_titulo" style="font-size:42px; color:#FFF; padding-top:5px">			                	
		               			SISTEMA INTEGRAL DE GESTI&Oacute;N DE CALIDAD
		               		</div>
            			</td>                			
            		</tr>
            	</table>
            </div>
            <div class="btm_sh" style="width:100%; margin:0 0 5px 0"></div>
            
            <div class="content">
                <div class="cont" style="width:970px; min-height:200px">
                    <div class="titulo">Minuta: <?=$periodo?></div>
                    <div class="texto">
                        <?php
						// Lugar
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>Lugar</th></thead>';
                        echo '<tr><td>'.$lug.'<br /><br /></td></tr></table><br /><br />';
						                                
                        // Participantes
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>Participantes</th></thead>';
                        echo '<tr><td>'.$par.'<br /><br /></td></tr></table><br /><br />';
  
                        // I. Puntos Pendientes
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>I. Puntos Pendientes</th></tr></thead>';
                        echo '<tr><td>'.$pun.'<br /><br /></td></tr></table><br /><br />';
                        
                        // III. Procesos
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>III. Procesos</th></tr></thead>';
                        echo '<tr><td>';
                        echo $pro.'<br />';						
						if( $indicadores->num_rows() > 0 ) {
							$i = 0;									
										
		                   foreach( $indicadores->result() as $row ) {
		                   	
		                   	
		                    	echo '<table style="border:1px solid #EEE"><tr><td width="460">';
								echo '<table class="tabla_form">';
								echo '<tr><th>Indicador</th><td>'.$row->Indicador.'</td></tr>';
								echo '<tr><th>Meta</th><td>'.$row->Meta.'</td></tr>';
								echo '<tr><th>Calculo</th><td>'.$row->Calculo.'</td></tr>';
								echo '<tr><th>Frecuencia</th><td>'.$row->Frecuencia.'</td></tr>';
								echo '<tr><th>Responsable</th><td>'.$row->Responsable.'</td></tr>';
								echo '</table>';								
								echo '</td><td width="460" valign="top">';
								echo $grafica_indicadores[$i];
								echo '</td></tr></table><br />';
							
								$i++;
							}
						}
                        echo '<br /><br /></td></tr></table><br /><br />';
                
                        // IV.1 Desempeño - Infraestructura y Ambiente de Trabajo
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th colspan="2">IV. Desempe&ntilde;o</th></tr></thead>';
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal">Infraestructura y Ambiente de Trabajo: </th>';
                        echo '<td style="border-bottom:1px solid #EEE"><strong>Atendidas:</strong><br />'.$ina.'<br /><br /><strong>No Atendidas:</strong><br />'.$inn.'<br /><br /></td></tr>';
                        // IV.2 Desempeño - Clima Organizacional
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal">Clima Organizacional: </th>';
                        echo '<td style="border-bottom:1px solid #EEE">'.$cli.'<br /><br /></td></tr>';
                        // IV.3 Desempeño - Satisfacción de Usuarios
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal">Satisfacci&oacute;n de Usuarios: </th>';
                        echo '<td style="border-bottom:1px solid #EEE">'.$sat.'<br /><br />'.$grafica.'<br />'.$tabla.'</td></tr>';
                        // IV.4 Desempeño - Auditoría Interna
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal">Auditor&iacute;a Interna: </th>';
                        echo '<td style="border-bottom:1px solid #EEE">'.$aud.'<br /><br /></td></tr>';
                        // IV.5 Desempeño - Capacitación
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal">Capacitaci&oacute;n: </th>';
                        echo '<td style="border-bottom:1px solid #EEE">'.$cap.'<br /><br /></td></tr>';
                        // IV.6 Desempeño - Mejora Continua
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal">Mejora Continua: </th>';
                        echo '<td style="border-bottom:1px solid #EEE">'.$mej.'<br /><br /></td></tr>';
                        // IV.7 Desempeño - Quejas
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Quejas: </th>';
                        echo '<td style="border-bottom:1px solid #EEE">';
                        echo $que.'<br />'; 
						if( $quejas->num_rows() > 0 ) {
							foreach( $quejas->result() as $row ) {
								switch( $row->Estado ) {
									case 0 : $edo = '<img src="'.base_url().'includes/img/icons/pend.gif" /> Pendiente';	break;
									case 1 : $edo = '<img src="'.base_url().'includes/img/icons/ok.gif" /> Terminada';	break;																	
								}
								echo '<table style="border:1px solid #EEE"><tr><td width="760">';
								echo '<table class="tabla_form">';
								echo '<tr><th valign="middle">Estado</th><td>'.$edo.'</td></tr>';
								echo '<tr><th>Departamento</th><td>'.$row->Departamento.'</td></tr>';
								echo '<tr><th>Nombre</th><td>'.$row->Nombre.'</td></tr>';
								echo '<tr><th>Fecha</th><td>'.$row->Fecha.'</td></tr>';
								echo '<tr><th valign="top">Queja</th><td>'.$row->Queja.'</td></tr>';
								echo '<tr><th>Responsable</th><td>'.$row->Responsable.'</td></tr>';
								echo '<tr><th valign="top">Descripci&oacute;n</th><td>'.$row->Descripcion.'</td></tr>';
								echo '<tr><th>Fecha de Respuesta</th><td>'.$row->FechaSeguimiento.'</td></tr>';
								echo '<tr><th valign="top">Observaci&oacute;n</th><td>'.$row->Observacion.'</td></tr>';
								echo '</table>';
								echo '</td></tr></table><br />';								
							}
						}
						else {
							echo '<table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron quejas en este periodo</td></tr></table>';
						}
                        echo '<br /></td></tr>';
                        // IV.8 Desempeño - Evaluación al Desempeño
                        echo '<tr><th class="text_form" width="80" style="font-weight:normal">Evaluaci&oacute;n al Desempe&ntilde;o: </th>';
                        echo '<td>'.$des.'<br /><br /></td></tr>';
						echo '</table><br /><br />';
                    
                        // V. Acciones Correctivas y Preventivas
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>V. Acciones Correctivas y Preventivas</th></tr></thead>';
                        echo '<tr><td>';
                        echo $acc.'<br />';
						if( $conformidades->num_rows() > 0 ) {
							foreach( $conformidades->result() as $row ) {
								switch( $row->Estado ) {
									case 0 : $edo = '<img src="'.base_url().'includes/img/icons/pend.gif" /> Sin Atender';	break;
									case 1 : $edo = '<img src="'.base_url().'includes/img/icons/ok.gif" /> Atendida';	break;
									case 2 : $edo = '<img src="'.base_url().'includes/img/icons/ok2.gif" /> Cerrada';	break;									
								}
								
								echo '<table style="border:1px solid #EEE"><tr><td width="870">';
								echo '<table class="tabla_form">';
								echo '<tr><th width="150"  valign="middle">Estado</th><td>'.$edo.'</td></tr>';								
								echo '<tr><th>Usuario que levant&oacute; la No Conformidad</th><td>'.$row->Nombre.' '.$row->Paterno.' '.$row->Materno.' ('.$row->Area.')</td></tr>';
								echo '<tr><th>Departamento</th><td>'.$row->Departamento.'</td></tr>';
								echo '<tr><th>Fecha</th><td>'.$row->Fecha.'</td></tr>';
								echo '<tr><th>Origen</th><td>'.$row->Origen.'</td></tr>';
								echo '<tr><th>Tipo</th><td>'.$row->Tipo.'</td></tr>';
								echo '<tr><th valign="top">Descripci&oacute;n</th><td>'.$row->Descripcion.'</td></tr>';
								echo '<tr><th valign="top">Causa</th><td>'.$row->Causa.'</td></tr>';
								echo '</table>';
								echo '</td></tr></table><br />';
							}
						}
						else {
							echo '<table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron acciones correctivas y /o preventivas en este periodo</td></tr></table>';
						}
                        echo '<br /><br /></td></tr></table><br /><br />';
                        
                        // VI. Cambios que podrian afectar al SIGC
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>VI. Cambios que podrian afectar al SIGC</th></tr></thead>';
                        echo '<tr><td>'.$cam.'<br /><br /></td></tr></table><br /><br />';
                        
                        // VII. Recomendaciones para la mejora (Mejora Continua)
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>VII. Recomendaciones para la mejora (Mejora Continua)</th></tr></thead>';
                        echo '<tr><td>'.$rec.'<br /><br /></td></tr></table><br /><br />';
                        
                        // VIII. Asuntos Generales
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>VIII. Asuntos Generales</th></tr></thead>';
                        echo '<tr><td>'.$asu.'<br /><br /></td></tr></table><br /><br />';
                        
                        // IX. Tareas
                        echo '<table class="tabla_form" width="970" style="border:1px solid #CCC"><thead><tr><th>IX. Tareas</th></tr></thead>';
                        echo '<tr><td>'.$tar.'<br /><br /></td></tr></table><br /><br />';
                        
                        echo '</table>';
                        ?>
	                </div>
    	        </div>
    	        <div style="clear:both"></div>
			</div>
		</div>           
    </body>
</html>