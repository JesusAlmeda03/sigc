<?php
/****************************************************************************************************
*
*	VIEWS/admin/minutas/minuta.php
*
*		Descripción:
*			Vista que muestra toda la minuta del comite de calidad
*
*		Fecha de Creación:
*			31/Enero/2012
*
*		Ultima actualización:
*			9/Marzo/2012
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
        
        <script type="text/javascript">
        
        var offsetxpoint=0 //Customize x offset of tooltip
        var offsetypoint=20 //Customize y offset of tooltip
        var ie=document.all
        var ns6=document.getElementById && !document.all
        var enabletip=false
        if (ie||ns6)
        var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""
        
        function ietruebody(){
        return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
        }
        
        function ddrivetip(thetext, thecolor, thewidth){
        if (ns6||ie){
        if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
        if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
        tipobj.innerHTML=thetext
        enabletip=true
        return false
        }
        }
        
        function positiontip(e){
        if (enabletip){
        var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
        var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
        //Find out how close the mouse is to the corner of the window
        var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
        var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20
        
        var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000
        
        if (rightedge<tipobj.offsetWidth)
        tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
        else if (curX<leftedge)
        tipobj.style.left="5px"
        else
        tipobj.style.left=curX+offsetxpoint+"px"
        
        if (bottomedge<tipobj.offsetHeight)
        tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
        else
        tipobj.style.top=curY+offsetypoint+"px"
        tipobj.style.visibility="visible"
        }
        }
        
        function hideddrivetip(){
        if (ns6||ie){
        enabletip=false
        tipobj.style.visibility="hidden"
        tipobj.style.left="-1000px"
        tipobj.style.backgroundColor=""
        tipobj.style.width=""
        }
        }
        
        document.onmousemove=positiontip        
        </script>
    
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
							<div id="nombre" style="font-size:42px; color:#FFF; padding-top:5px">			                	
		               			SISTEMA INTEGRAL DE GESTI&Oacute;N DE CALIDAD UJED
		               		</div>
            			</td>                			
            		</tr>
            	</table>
            </div>
            <div class="btm_sh" style="width:100%; margin:0 0 5px 0"></div>
            
            <div class="content" style="width:960px">
                <div class="cont" style="width:950px; min-height:200px">
                    <div class="title">Minuta: <?=$periodo?></div>
                    <div class="text">
                        <?php
						// Lugar
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>Lugar</th></thead>';
                        echo '<tr><td>';
                        if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->Lugar != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->Lugar.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}								
							}							
						}
                        echo '</td></tr></table><br /><br />';
						                                
                        // Participantes
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>Participantes</th></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 )
							foreach( $minuta->result() as $row )
								if( $row->Participantes != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #EEE" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->Participantes.'</td></tr>';
									echo '</table>';
								}
                        echo '</td></tr></table><br /><br />';
  
  						// Acuerdos de la reunión anterior
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>Acuerdos de la Reuni&oacute;n Anterior</th></thead>';
                        echo '<tr><td>';						
						if( $acuerdos_anteriores->num_rows() > 0 )
							foreach( $acuerdos_anteriores->result() as $row )
								echo $row->Acuerdo;
                        echo '</td></tr></table><br /><br />';
						
                        // I. Puntos Pendientes
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>I. Puntos Pendientes</th></tr></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->PuntosPendientes != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->PuntosPendientes.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}								
							}
						}
                        echo '</td></tr></table><br /><br />';
                
                        // II. Objetivos de Calidad
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>II. Objetivos de Calidad</th></tr></thead>';
                        echo '<tr><td>';
                        if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->ObjetivosCalidad != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->ObjetivosCalidad.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}								
							}
						}
						if( $consulta_objetivos->num_rows() > 0 ) {							
		                    foreach( $consulta_objetivos->result() as $row_obj ) :
								echo '<table class="tabla_form" id="tabla" width="920"><tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row_obj->Objetivo.'</th></tr></table>';								
								if( $objetivos->num_rows() > 0 ) {
									$i = 0;																				
				                  	foreach( $objetivos->result() as $row ) {
				                   		if( $row_obj->IdObjetivo == $row->IdObjetivo ) {
					                    	echo '<table style="border:1px solid #EEE"><tr><td width="460">';
											echo '<table class="tabla_form">';
											echo '<tr><th>Indicador</th><td>'.$row->Indicador.'</td></tr>';
											echo '<tr><th>Meta</th><td>'.$row->Meta.'</td></tr>';
											echo '<tr><th>Calculo</th><td>'.$row->Calculo.'</td></tr>';
											echo '<tr><th>Frecuencia</th><td>'.$row->Frecuencia.'</td></tr>';
											echo '</table>';								
											echo '</td><td width="460" valign="top">';
											echo $grafica_objetivos[$i];
											echo '</td></tr></table>';											
										}
										$i++;
									}
									echo '<br />';
								}
							endforeach;
						}
                        echo '</td></tr></table><br /><br />';
                        
                        // III. Procesos
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>III. Procesos</th></tr></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row_ind ) {								
								echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
								echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row_ind->Area.'</th></tr>';
								if( $row_ind->Procesos != "" )
									echo '<tr><td>'.$row_ind->Procesos.'</td></tr>';
								echo '<tr><td>';
								if( $indicadores->num_rows() > 0 ) {
									$i = 0;
				                	foreach( $indicadores->result() as $row ) {				                		
				                		if( $row_ind->IdArea == $row->IdArea ) {
					                    	echo '<table><tr><td width="460">';
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
										}
										$i++;
									}
								}
								echo '</td></tr>';
								echo '</table>';
							}
						}
                        echo '</td></tr></table><br /><br />';
                
                        // IV.1 Desempeño - Infraestructura y Ambiente de Trabajo
                        echo '<table class="tabla_form" width="930" style="border:2px solid #CCC"><thead><tr><th colspan="2">IV. Desempe&ntilde;o</th></tr></thead>';
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal">Infraestructura y Ambiente de Trabajo: </th>';
                        echo '<td style="border-bottom:2px solid #CCC">';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->DesInfraestructuraAtendidas != "" || $row->DesInfraestructuraNoAtendidas != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr>';
									echo '<tr><td><strong>Atendidas:</strong>'.$row->DesInfraestructuraAtendidas.'</td></tr>';
									echo '<tr><td><strong>No Atendidas:</strong>'.$row->DesInfraestructuraNoAtendidas.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}								
							}
						}
						echo "</td></tr>";
                        // IV.2 Desempeño - Clima Organizacional
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal">Clima Organizacional: </th>';
                        echo '<td style="border-bottom:2px solid #CCC">';
						if( $minuta->num_rows() > 0 )
							foreach( $minuta->result() as $row )
								if( $row->DesClima != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr>';
									echo '<tr><td>'.$row->DesClima.'</td></tr>';									
									echo '</table>';
								}
                        echo '</td></tr>';
                        // IV.3 Desempeño - Satisfacción de Usuarios
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal">Satisfacci&oacute;n de Usuarios: </th>';
                        echo '<td style="border-bottom:2px solid #CCC">';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->DesSatisfaccion != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr>';
									echo '<tr><td>'.$row->DesSatisfaccion.'</td></tr>';									
									echo '</table>';
									echo '<br />';
								}								
							}
						}
                        echo '</td></tr>';
                        // IV.4 Desempeño - Auditoría Interna
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal">Auditor&iacute;a Interna: </th>';
                        echo '<td style="border-bottom:2px solid #CCC">';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->DesAuditoria != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr>';
									echo '<tr><td>'.$row->DesAuditoria.'</td></tr>';									
									echo '</table>';
									echo '<br />';
								}								
							}
						}
                        echo '</td></tr>';
                        // IV.5 Desempeño - Capacitación
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal">Capacitaci&oacute;n: </th>';
                        echo '<td style="border-bottom:2px solid #CCC">';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->DesCapacitacion != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr>';
									echo '<tr><td>'.$row->DesCapacitacion.'</td></tr>';									
									echo '</table>';
									echo '<br />';
								}								
							}
						}
                        echo '</td></tr>';
                        // IV.6 Desempeño - Mejora Continua
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal">Mejora Continua: </th>';
                        echo '<td style="border-bottom:2px solid #CCC">';
						if( $minuta->num_rows() > 0 ) { 
							foreach( $minuta->result() as $row ) {
								if( $row->DesMejora != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr>';
									echo '<tr><td>'.$row->DesMejora.'</td></tr>';									
									echo '</table>';
									echo '<br />';
								}								
							}
						}
                        echo '</td></tr>';
                        // IV.7 Desempeño - Quejas
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal" valign="top">Quejas: </th>';
                        echo '<td style="border-bottom:2px solid #CCC">';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row_que ) {
								echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
								echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row_que->Area.'</th></tr>';
								if( $row_que->DesQuejas != "" )																
									echo '<tr><td>'.$row_que->DesQuejas.'</td></tr>';																
								echo '<tr><td>';
								$j = false;
								if( $quejas->num_rows() > 0 ) {
									$i = 0;									
				                	foreach( $quejas->result() as $row ) {
				                		if( $row_que->IdArea == $row->IdArea ) {
				                			if( $row->Estado == 1 && $row->Fecha >= $per_ini && $row->Fecha <= $per_fin) {
				                				$j = true;											
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
									}
								}
								else {
									$j = true;
									echo '<table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron quejas en este periodo</td></tr></table>';
								}
								if( !$j )
									echo '<table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron quejas en este periodo</td></tr></table>';
									
								echo '</td></tr>';
								echo '</table>';
							}
						}								
                        echo '<br /></td></tr>';
                        // IV.8 Desempeño - Evaluación al Desempeño
                        echo '<tr><th class="text_form" width="80" style="border-bottom:2px solid #CCC; font-weight:normal">Evaluaci&oacute;n al Desempe&ntilde;o: </th>';
                        echo '<td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->DesDesempeno != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr>';
									echo '<tr><td>'.$row->DesDesempeno.'</td></tr>';									
									echo '</table>';
									echo '<br />';
								}								
							}
						}
                        echo '</td></tr>';
						echo '</table><br /><br />';
                    
                        // V. Acciones Correctivas y Preventivas
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>V. Acciones Correctivas y Preventivas</th></tr></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row_con ) {								
								echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
								echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row_con->Area.'</th></tr>';
								if( $row_con->Acciones != "" )
									echo '<tr><td>'.$row_con->Acciones.'</td></tr>';
								echo '<tr><td>';
								$j = false;
								if( $conformidades->num_rows() > 0 ) {
									foreach( $conformidades->result() as $row ) {
										if( $row_con->IdArea == $row->IdArea ) {
											if( $row->Estado == 2 && $row->Fecha >= $per_ini && $row->Fecha <= $per_fin) {
												$j = true;
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
									}
								}
								else {
									$j = true;
									echo '<table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron acciones correctivas y /o preventivas en este periodo</td></tr></table>';
								}
								if( !$j )
									echo '<table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron acciones correctivas y /o preventivas en este periodo</td></tr></table>';
								echo '</td></tr>';
								echo '</table>';
							}
						}
                        echo '</td></tr></table><br /><br />';
                        
                        // VI. Cambios que podrian afectar al SIGC
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>VI. Cambios que podrian afectar al SIGC</th></tr></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->Cambios != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->Cambios.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}
							}
						}
                        echo '</td></tr></table><br /><br />';
                        
                        // VII. Recomendaciones para la mejora (Mejora Continua)
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>VII. Recomendaciones para la mejora (Mejora Continua)</th></tr></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->Recomendaciones != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->Recomendaciones.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}
							}
						}
                        echo '</td></tr></table><br /><br />';
                        
                        // VIII. Asuntos Generales
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>VIII. Asuntos Generales</th></tr></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->AsuntosGenerales != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->AsuntosGenerales.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}
							}
						}
                        echo '</td></tr></table><br /><br />';
                        
                        // IX. Tareas
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>IX. Tareas</th></tr></thead>';
                        echo '<tr><td>';
						if( $minuta->num_rows() > 0 ) {
							foreach( $minuta->result() as $row ) {
								if( $row->Tareas != "" ) {
									echo '<table class="tabla_form" style="border:1px solid #CCC" width="910">'; 
									echo '<tr><th class="text_form" style="font-size:16px; background-color:#EEE; text-align:center">'.$row->Area.'</th></tr><tr><td>'.$row->Tareas.'</td></tr>';
									echo '</table>';
									echo '<br />';
								}
							}
						}
                        echo '</td></tr></table><br /><br />';
						
						// Acuerdos de esta reunión
                        echo '<table class="tabla_form" width="930" style="border:1px solid #CCC"><thead><tr><th>Acuerdos esta Reuni&oacute;n</th></thead>';
                        echo '<tr><td>';						
						if( $acuerdos_anteriores->num_rows() > 0 )
							foreach( $acuerdos_anteriores->result() as $row )
								echo $row->Acuerdo;
                        echo '</td></tr></table><br /><br />';
						                        
                        echo '</table>';
                        ?>
	                </div>
    	        </div><div class="btm_sh" style="width:962px; margin:0 0 5px 0"></div>
			</div>
		</div>           
    </body>
</html>