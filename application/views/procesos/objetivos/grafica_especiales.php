<?php
/****************************************************************************************************
*
*	VIEWS/procesos/indicadores/grafica_contraloria.php
*
*		Descripción:
*			Vista de la grafica de los indicadores
*
*		Fecha de Creación:
*			22/Febrero/2012
*
*		Ultima actualización:
*			26/Abril/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			 @rogelio_cas
*			rogeliocas@gmail.com
*
****************************************************************************************************/
	
$med_uno = $etiquetas_array[0];
$med_dos = $etiquetas_array[1];
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<script>
                $(function() {
					var fecha    = $( "#fecha" ),
						concepto = $( "#concepto" ),
						med_uno  = $( "#med_uno" ),
						med_dos  = $( "#med_dos" ),						
						allFields = $( [] ).add( fecha ).add( concepto ).add( med_uno ).add( med_dos ),
						tips = $( ".validateTips" );
			
					function updateTips( t ) {
						tips.text( t ).addClass( "ui-state-highlight" );
						setTimeout(function() {
							tips.removeClass( "ui-state-highlight", 1500 );
						}, 500 );
					}		

					function checkLength( o, n, min, max ) {
						if ( o.val().length > max || o.val().length < min ) {
							o.addClass( "ui-state-error" );
							updateTips( "Debes llenar todos los campos" );
							return false;
						} else {
							return true;
						}
					}
		
					function checkRegexp( o, regexp, n ) {
						if ( !( regexp.test( o.val() ) ) ) {
							o.addClass( "ui-state-error" );
							updateTips( n );
							return false;
						} else {
							return true;
						}
					}
		
                    $( "#anadir_medicion" ).dialog({
                        autoOpen: false,
                        resizable: true,
                        width:380,
                        height:270,
                        modal: true,
                        position: "center",
                        buttons: {
                            "Aceptar": function() {
								$( "#formulario" ).submit();
								$( this ).dialog( "close" );
                            },
                            "Cancelar": function() {
                                $( this ).dialog( "close" );
                            }
                        },
						close: function() {
							allFields.val( "" ).removeClass( "ui-state-error" );
						}
                    });
				
					$( "#fecha" ).datepicker({
						changeMonth: true,
						changeYear: true,
					});
					$('#fecha').datepicker($.datepicker.regional['es']);
					$('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
					$("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
                });
                </script>
	            <?php
				$formulario = array(
					// Fecha
					'fecha' => array (
						'name'		=> 'fecha',
						'id'		=> 'fecha',
						'value'		=> set_value('fecha'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('fecha')",
						'style'		=> 'width:200px'
					),
					// Concepto
					'concepto' => array (
						'name'		=> 'concepto',
						'id'		=> 'concepto',
						'value'		=> set_value('concepto'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('concepto')",
						'style'		=> 'width:200px'
					),
					// Medicion Uno
					'med_uno' => array (
						'name'		=> 'med_uno',
						'id'		=> 'med_uno',
						'value'		=> set_value('med_uno'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('med_uno')",
						'style'		=> 'width:200px'
					),
					// Medicion Dos
					'med_dos' => array (
						'name'		=> 'med_dos',
						'id'		=> 'med_dos',
						'value'		=> set_value('med_dos'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('med_dos')",
						'style'		=> 'width:200px'
					),
				);

				// Datos del Indicador
				echo '<table><tr><td rowspan="3" width="650">';
                if( $indicador->num_rows() > 0 ) {
					echo '<table class="tabla_form" width="620">';
					$i = 0;
                    foreach( $indicador->result() as $row ) :
						$tipo = $row->Tipo;
						echo '<tr style="border-bottom:1px solid #EEE"><th width="70">Indicador</th><td>'.$row->Indicador.'</td></tr>';
						echo '<tr style="border-bottom:1px solid #EEE"><th>Meta</th><td>'.$row->Meta.'</td></tr>';
						echo '<tr style="border-bottom:1px solid #EEE"><th>Calculo</th><td>'.$row->Calculo.'</td></tr>';
						echo '<tr style="border-bottom:1px solid #EEE"><th>Frecuencia</th><td>'.$row->Frecuencia.'</td></tr>';
						echo '<tr style="border-bottom:1px solid #EEE"><th>Responsable</th><td>'.$row->Responsable.'</td></tr>';
						if( $row->Observaciones != "" )
							echo '<tr style="border-bottom:1px solid #EEE"><th>Observaciones</th><td>'.$row->Observaciones.'</td></tr>';
                    endforeach;
					echo '</tbody></table>';
                }
				echo '</td><td>';
				// Permisos
				if( $this->session->userdata('IND') ) {
					echo '<div class="select_icon"><a onclick="$(\'#anadir_medicion\').dialog(\'open\')" onmouseover="tip(\'A&ntilde;adir una nueva medici&oacute;n<br />al Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" width="24" /></a></div><br />';
					echo '<div class="select_icon"><a href="'.base_url().'index.php/procesos/indicadores/modificar/'.$row->IdIndicador.'/'.$fecha_grafica.'/especiales" onmouseover="tip(\'Modificar el Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" width="24" /></a></div>';
				}
				echo '</td></tr></table>';
								
				// Gráfica de Resultados Parciales
				if( $parciales ) {								
					echo '<table class="tabla_form" width="700" style="margin-top:5px">';
					echo '<tr><th colspan="3" style="font-size:18px; text-align:center">Gr&aacute;fica de Resultados</th></tr>';
					if( $mediciones_group->num_rows() > 0 ) {
						$i = 1;
						echo '</tr><td width="100" valign="top" style="padding:0 0 0 0"><table>';
						foreach( $mediciones_group->result() as $row ) {
							$dia = substr($row->Fecha,8,2);
							$mes = substr($row->Fecha,5,2);
							$ano = substr($row->Fecha,0,4);							
							echo '<tr><td style="padding:0 0 10px 5px"><input type="radio" name="fecha_grafica" id="fecha_grafica" value="'.$row->Fecha.'" style="float:left"';
							if( $row->Fecha == $fecha_grafica )
								echo 'checked="checked"';
							echo 'onclick="location.href=\''.base_url().'index.php/procesos/indicadores/grafica_especiales/'.$id.'/'.$row->Fecha.'\'" />';
							echo '</td><td style="padding:0 5px 10px 5px" width="100">'.$dia.'-'.$mes.'-'.$ano.'</td></tr>';							
						}
						echo '</table></td><td>'.$grafica.'</td></tr>';
					}
					else {
						echo '<tr><td>'.$grafica.'</td></tr>';	
					}
					echo '</table>';					
				}	
				// Gráfica de Resultados Generales
				else {
					echo '<br /><table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/grafica.png" /></th><td style="font-style:italic">Click aqui para ver los <strong>Resultados Parciales</strong> de este indicador</td></tr></table>';				
					echo '<table class="tabla_form" width="700" style="border:1px solid #EEE; margin-top:5px">';
					echo '<tr><th colspan="2" style="font-size:18px">Resultados Generales</th></tr>';		
					echo '<tr>'.$grafica.'</tr>';
					echo '</table>';
				}
				
				// Listado de mediciones
				switch( $id ) {
					// indicador obras
					case 107 :
						if( $mediciones->num_rows() > 0 ) {
							echo '<table class="tabla_form" width="700" style="border:1px solid #EEE; margin-top:5px">';
							echo '<tr><th>URES</th><th style="text-align:center"><div style="width:15px; height:15px; margin-right:5px; background-color:#33A1DE; float:left"></div>'.$med_uno.'</th><th style="text-align:center"><div style="width:15px; height:15px; margin-right:5px; background-color:#00C618; float:left"></div>'.$med_dos.'</th><th style="width:20px;">% Reemplazo</th><th style="width:20px;"></th></tr>';							
							$i = 1;
							foreach( $mediciones->result() as $row ) :
							if( $row->Fecha == $fecha_grafica ) {						
									if( $i ) {
										echo '<tr>';
										$i--;
									}
									else {
										echo '<tr class="odd">';
										$i++;
									}							
									echo '<td>'.$row->Concepto.'</td><td style="text-align:center">'.$row->MedUno.'</td><td style="text-align:center">'.$row->MedDos.'</td>';
									$reemplazo = round( ( ( ( $row->MedDos * 100 ) / $row->MedUno ) * 100 ) / 100 );
									echo '<td>'.$reemplazo.'%</td>';
									echo '<td><a onclick="pregunta_eliminar_medicion('.$id.','.$row->IdIndicadorMedicionEspeciales.',\'&iquest;Deseas eliminar esta medici&oacute;n?\',\'indicadores_especiales\')" onMouseover="tip(\'Eliminar medici&oacute;n\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
								}
							endforeach;
							echo '</table>';
						}
						break;
						
					case 155 :
						if( $mediciones->num_rows() > 0 ) {
							echo '<table class="tabla_form" width="700" style="border:1px solid #EEE; margin-top:5px">';
							echo '<tr><th>Concepto</th><th style="text-align:center"><div style="width:15px; height:15px; margin-right:5px; background-color:#33A1DE; float:left"></div>'.$med_uno.'</th><th style="width:20px;"></th></tr>';
							$i = 1;
							foreach( $mediciones->result() as $row ) :
							if( $row->Fecha == $fecha_grafica ) {						
									if( $i ) {
										echo '<tr>';
										$i--;
									}
									else {
										echo '<tr class="odd">';
										$i++;
									}							
									echo '<td>'.$row->Concepto.'</td><td style="text-align:center">'.$row->MedUno.'%</td>';
									echo '<td><a onclick="pregunta_eliminar_medicion('.$id.','.$row->IdIndicadorMedicionEspeciales.',\'&iquest;Deseas eliminar esta medici&oacute;n?\',\'indicadores_especiales\')" onMouseover="tip(\'Eliminar medici&oacute;n\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
								}
							endforeach;
							echo '</table>';
						}
						break;
						
					default:
						if( $mediciones->num_rows() > 0 ) {
							echo '<table class="tabla_form" width="700" style="border:1px solid #EEE; margin-top:5px">';
							echo '<tr><th>Concepto</th><th style="text-align:center"><div style="width:15px; height:15px; margin-right:5px; background-color:#33A1DE; float:left"></div>'.$med_uno.'</th><th style="text-align:center"><div style="width:15px; height:15px; margin-right:5px; background-color:#00C618; float:left"></div>'.$med_dos.'</th><th style="width:20px;"></th></tr>';
							$i = 1;
							foreach( $mediciones->result() as $row ) :
							if( $row->Fecha == $fecha_grafica ) {						
									if( $i ) {
										echo '<tr>';
										$i--;
									}
									else {
										echo '<tr class="odd">';
										$i++;
									}							
									echo '<td>'.$row->Concepto.'</td><td style="text-align:center">'.$row->MedUno.'</td><td style="text-align:center">'.$row->MedDos.'</td>';									
									echo '<td><a onclick="pregunta_eliminar_medicion('.$id.','.$row->IdIndicadorMedicionEspeciales.',\'&iquest;Deseas eliminar esta medici&oacute;n?\',\'indicadores_especiales\')" onMouseover="tip(\'Eliminar medici&oacute;n\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
								}
							endforeach;
							echo '</table>';
						}
						break;
				}
				?>
				<br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/procesos/objetivos" onmouseover="tip('Regresa al listado de indicadores')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/procesos/objetivos" onmouseover="tip('Regresa al listado de indicadores')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
	            <div id="anadir_medicion" title="A&ntilde;adir Medici&oacute;n">
	                <p class="validateTips"></p>
	                <?=form_open('',array('name' => 'formulario', 'id' => 'formulario'));?>
                        <table>
                            <tr><th class="text_form" style="font-weight:normal">Fecha: </th>
                            <td><?=form_input($formulario['fecha'])?></td></tr>
                            <tr><th class="text_form" style="font-weight:normal">Concepto: </th>
                            <td><?=form_input($formulario['concepto'])?></td></tr>
                            <tr><th class="text_form" style="font-weight:normal"><?=$med_uno?>: </th>
                            <td><?=form_input($formulario['med_uno'])?></td></tr>
                            <tr><th class="text_form" style="font-weight:normal"><?=$med_dos?>: </th>
                            <td><?=form_input($formulario['med_dos'])?></td></tr>
                        </table>
                	<?=form_close();?>
            	</div>
        	</div>
    	</div>