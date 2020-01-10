<?php
/****************************************************************************************************
*
*	VIEWS/procesos/indicadores/grafica.php
*
*		Descripci�n:
*			Vista de la grafica de los indicadores
*
*		Fecha de Creaci�n:
*			16/Noviembre/2011
*
*		Ultima actualizaci�n:
*			16/Noviembre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			 @rogelio_cas
*			rogeliocas@gmail.com
*
****************************************************************************************************/


?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<script>
                $(function() {
					var fecha = $( "#fecha" ),
						medicion = $( "#medicion" ),
						allFields = $( [] ).add( fecha ).add( medicion),
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
                        width:300,
                        height:200,
                        modal: true,
                        position: "center",
                        buttons: {
                            "Aceptar": function() {
								var bValid = true;
								allFields.removeClass( "ui-state-error" );
			
								bValid = bValid && checkLength( fecha, "Fecha",9,10 );
								bValid = bValid && checkLength ( medicion, "Medicion",1,10 );
								bValid = bValid && checkRegexp( medicion, /[0-9]/, "La medicion solo puede ser un numero" );
								if ( bValid ) {
									$( "#formulario" ).submit();
									$( this ).dialog( "close" );
								}
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
					// Fecha
					'medicion' => array (
						'name'		=> 'medicion',
						'id'		=> 'medicion',
						'value'		=> set_value('medicion'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('medicion')",
						'style'		=> 'width:200px'
					),
				);
				
				// Datos del Indicador
				echo '<table width="700"><tr><td rowspan="2">';
                if( $indicador->num_rows() > 0 ) {
					echo '<table class="tabla_form" width="620">';
					$i = 0;
                    foreach( $indicador->result() as $row ) :
						echo '<tr><th class="text_form" style="font-size:16px; text-align:center; font-weight:normal" colspan="2">'.$row->Objetivo.'</th></tr>';
						echo '<tr><th class="text_form" style="font-weight:normal" width="70">Indicador</th><td>'.$row->Indicador.'</td></tr>';
						echo '<tr><th class="text_form" style="font-weight:normal">Meta</th><td>'.$row->Meta.'</td></tr>';
						echo '<tr><th class="text_form" style="font-weight:normal">Calculo</th><td>'.$row->Calculo.'</td></tr>';
						echo '<tr><th class="text_form" style="font-weight:normal">Frecuencia</th><td>'.$row->Frecuencia.'</td></tr>';
						echo '<tr><th class="text_form" style="font-weight:normal">Observaciones</th><td>'.$row->Observaciones.'</td></tr>';
                    endforeach;
					echo '</tbody></table>';
                }
				echo '</td><td>';
				// Permisos
				if( $this->session->userdata('IND') ) {
					echo '<div class="select_icon"><a onclick="$(\'#anadir_medicion\').dialog(\'open\')" onmouseover="tip(\'A&ntilde;adir una nueva medici&oacute;n<br />al Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" width="24" /></a></div>';
					echo '<div class="select_icon"><a href="'.base_url().'index.php/procesos/objetivos/modificar/'.$row->IdObjetivoIndicador.'/0" onmouseover="tip(\'Modificar el Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" width="24" /></a></div>';
					echo '<div class="select_icon"><a href="'.base_url().'index.php/procesos/objetivos/mediciones/'.$row->IdObjetivoIndicador.'" onmouseover="tip(\'Eliminar mediciones del Indicador\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" width="24" /></a></div>';
				}
				echo '</td></tr></table>';
				
				// Años
				echo $anos;
				
				// Gafica
                echo $grafica;
				
				// Listado de mediciones
                if( $mediciones->num_rows() > 0 ) {
					echo '<table class="tabla" width="700">';
					echo '<thead><tr><th>Fecha</th><th>Medici&oacute;n</th></tr></thead>';
					$i = 1;
                    foreach( $mediciones->result() as $row ) :
						if( $i ) {
							echo '<tr>';
							$i--;
						}
						else {
							echo '<tr class="odd">';
							$i++;
						}
						switch( substr($row->Fecha,5,2) ) {
							case "01" : $mes = "Enero"; break;
							case "02" : $mes = "Febrero"; break;
							case "03" : $mes = "Marzo"; break;
							case "04" : $mes = "Abril"; break;
							case "05" : $mes = "Mayo"; break;
							case "06" : $mes = "Junio"; break;
							case "07" : $mes = "Julio"; break;
							case "08" : $mes = "Agosto"; break;
							case "09" : $mes = "Septiembre"; break;
							case "10" : $mes = "Octubre"; break;
							case "11" : $mes = "Noviembre"; break;
							case "12" : $mes = "Diciembre"; break;
						}
						$fecha = substr($row->Fecha,8,2)." / ".$mes." / ".substr($row->Fecha,0,4);
						echo '<td>'.$fecha.'</td><td>'.$row->Medicion.'%</td></tr>';
					endforeach;
					echo '</table>';
				}				
				?>
                <br /><br />
				<table><tr><td><a href="<?=base_url()?>index.php/procesos/objetivos" onmouseover="tip('Regresa al listado de<br />objetivos de calidad')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/procesos/objetivos" onmouseover="tip('Regresa al listado de<br />objetivos de calidad')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
	            <div id="anadir_medicion" title="A&ntilde;adir Medici&oacute;n">
	                <p class="validateTips"></p>
                    <?=form_open('',array('name' => 'formulario', 'id' => 'formulario'))?>
                        <table>
                            <tr><th class="text_form" style="font-weight:normal">Fecha: </th>
                            <td><?=form_input($formulario['fecha'])?></td></tr>
                            <tr><th class="text_form" style="font-weight:normal">Medici&oacute;n</th>
                            <td><?=form_input($formulario['medicion'])?></td></tr>
                        </table>
                    <?=form_close();?>
            	</div>
        	</div>
    	</div>