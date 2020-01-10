<?php
/****************************************************************************************************
*
*	VIEWS/procesos/conformidades/seguimiento.php
*
*		Descripci�n:  		  
*			Vista para el seguimiento de una no conformidad
*
*		Fecha de Creaci�n:
*			30/Octubre/2011
*
*		Ultima actualizaci�n:
*			14/Noviembre/2011
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
				<script type="text/javascript">
                var nextinput = 1;
				
				// Categorias
				function QuitarCategoria( i ) {
                    $('#nueva_categoria_' + i).remove();
				}
				
                function AgregarCategoria( i ){
                    $("#nueva_categoria_" + i).empty();					
					j = i + 1;
					categoria  = '<div id="nueva_categoria_' + i + '">';
					categoria += '<table class="tabla_form">';
					categoria += '<th width="10"><input type="checkbox" checked="checked" onclick="QuitarCategoria(' + i + ')" value="" name=""></th><td width="20">Otra</td>';
					categoria += '<td><input id="otra_' + i + '" class="in_text" type="text" style="width:200px; height:15px; margin:0px; padding:2px;" onfocus="hover(\'otra_' + i + '\')" value="" name="categoria[]"></td>';
					categoria += '</tr></table>';
					categoria += '</div>';
					categoria += '<div id="nueva_categoria_' + j + '"></div>';
                    $("#nueva_categoria_" + i).append(categoria);
					                    
					categoria  = '<table class="tabla_form">';
					categoria += '<th class="text_form" width="10"><input type="checkbox" onclick="AgregarCategoria(' + j + ')" value="" name=""></th><td width="20">Otra</td>';
					categoria += '</tr></table>';
                    $("#nueva_categoria_" + j).append(categoria);
                }
				
				// Acciones
				function QuitarAccion( acc ) {
					cierra_tip(); // cierra el tip
                    $('#'+acc).remove();
					nextinput = nextinput - 1;
				}
				
                function AgregarAccion(){
                    nextinput++;
                    
                    document.getElementById('nextinput').value = nextinput;
                    
					accion  = '<br /><table class="tabla_form" width="700" id="accion_'+nextinput+'">';
					accion += '<tr><th colspan="2"><img onclick="QuitarAccion(\'accion_'+nextinput+'\')" onmouseover="tip(\'Quitar esta acci&oacute;n\')" onmouseout="cierra_tip()" src="<?=base_url()?>includes/img/icons/small/minus.gif" /> <span class="tabla_titulo">Acciones Correctivas ( '+nextinput+' ):</span> </th>';
					accion += '</th><tr><th class="text_form" width="150">Accion: </th><td>';
					accion += '<input type="radio" name="accion_'+nextinput+'" value="Correctiva" checked="checked" id="correctiva" class="in_radio"  /> No Conformidad<br />';
					accion += '<input type="radio" name="accion_'+nextinput+'" value="Preventiva" id="preventiva" class="in_radio" style="margin-bottom:10px"  /> No Conformidad Potencial';
					accion += '</td></tr>';
					accion += '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripci&oacute;n: </th>';
					accion += '<td><textarea name="descripcion_'+nextinput+'" cols="90" rows="12" id="descripcion_'+nextinput+'" onfocus="hover(\'descripcion_'+nextinput+'\')" ></textarea></td></tr>';
					accion += '<tr><th class="text_form">Responsable: </th>';
					accion += '<td><input type="text" name="responsable_'+nextinput+'" value="" id="responsable_'+nextinput+'" class="in_text" onfocus="hover(\'responsable_'+nextinput+'\')"  /></td></tr>';
					accion += '<tr><th class="text_form">Fecha: <br /><label style="font-size:10px">aaaa-mm-dd</label></th>';
					accion += '<td><input type="text" name="fecha_'+nextinput+'" value="" id="fecha_'+nextinput+'" class="in_text" onfocus="hover(\'fecha_'+nextinput+'\')" style="width:200px"  /></td></tr>';
					accion += '</table>';											
								
					// Fecha Datepicker
					$(function() {
						$( "#fecha_"+nextinput ).datepicker({
							changeMonth: true,
							changeYear: true,
						});
						$('#fecha_'+nextinput).datepicker($.datepicker.regional['es']);
						$('#fecha_'+nextinput).datepicker('option', {dateFormat: 'yy-mm-d'});
						$("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
						
					});
					
					$("#nueva_accion").append(accion);
                }
				
				$(function() {
					// Fecha Datepicker
                    $( "#fecha" ).datepicker({
						changeMonth: true,
						changeYear: true,
					});
					$('#fecha').datepicker($.datepicker.regional['es']);
					$('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
					$("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
					
					// Pescado
					$( "#ver_pescado" ).dialog({
						autoOpen: false,
						resizable: true,
						width:650,
						height:500,
						modal: true,
						position: "center",
						buttons: {
							"Aceptar": function() {
								$( this ).dialog( "close" );
							},
						},
					});
					
					// Eliminar Pescado
					$( "#eliminar_pescado" ).dialog({
						autoOpen: false,
						resizable: true,
						height:140,
						modal: true,
						position: "center",
						buttons: {
							"Si": function() {
								$( this ).dialog( "close" );
								location.href = "<?=base_url()?>index.php/procesos/conformidades/eliminar_pescado/<?=$id?>";
							},
							"No": function() {
								$( this ).dialog( "close" );
							}
						},
					});
				});
                </script>
				<div id="eliminar_pescado" title="Eliminar"><p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span><span id="eliminar_pregunta">&iquest;En realidad deseas eliminar el diagrama de pescado?</span></p></div>
	
				<div id="ver_pescado" title="Diagrama de Pescado">
					<?php
					if( $diagrama_pescado->num_rows() > 0 ) {
						$row_diagrama = '';
						$i = 1;
						foreach( $diagrama_pescado->result() as $row ) :
							$row_diagrama .= '<td><div style="border:1px solid #EEE; width:150px; height:auto; margin:auto; padding:15px;"><strong>'.$row->Categoria.'</strong><br />'.$row->Causa.'</div></td>';
							if( $i >= 3 ) {
								$row_diagrama .= '</tr><tr>';
								$i = 0;
							}
							$i++;
						endforeach;
					}
					else {
						$row_diagrama = '';
					}
                    ?>
                	<table width="700" style="position:absolute; z-index:1;">
                    	<tr><? echo $row_diagrama?></tr>
                    </table>
                	<div style="position:absolute; top:130px; left:170px; z-index:0;"><img src="<?=base_url()?>includes/img/pix/pescado.png" width="300" /></div>                    
                </div>
				<?php				
				$formulario = array(
					// * Botones
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')'						
					),					
					// * Boton cancelar
	                'boton_cancelar' => array (
	                    'id'		=> 'cancelar',
	                    'name'		=> 'cancelar',
	                    'class'		=> 'in_button',
						'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',
	                    'onfocus'	=> 'hover(\'cancelar\')',					
						'onclick'	=> "location.href='".base_url()."index.php/listados/conformidades/".$estado."'",
	                ),
					// Causa
					'causa' => array (
						'name'		=> 'causa',
						'id'		=> 'causa',
						'value'		=> set_value('causa'),
						'onfocus'	=> "hover('causa')",
					),
					// Accion
					'accion' => array (
						'correctiva' => array (
							'name'		=> 'accion',
							'id'		=> 'correctiva',
							'value'		=> 'Correctiva',
							'class'		=> 'in_radio',
						),
						'preventiva' => array (
							'name'		=> 'accion',
							'id'		=> 'preventiva',
							'value'		=> 'Preventiva',
							'class'		=> 'in_radio',
							'style'		=> 'margin-bottom:10px'
						),
					),
					// Descripci�n
					'descripcion' => array (
						'name'		=> 'descripcion',
						'id'		=> 'descripcion',
						'value'		=> set_value('descripcion'),
						'onfocus'	=> "hover('descripcion')",
					),
					// Responsable
					'responsable' => array (
						'name'		=> 'responsable',
						'id'		=> 'responsable',
						'value'		=> set_value('responsable'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('responsable')",
					),
					// Fecha
					'fecha' => array (
						'name'		=> 'fecha',
						'id'		=> 'fecha',
						'value'		=> set_value('fecha'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('fecha')",
						'style'		=> 'width:200px'

					),
					// Auditor Responsable
					'auditor' => array (
						'name'		=> 'auditor',
						'id'		=> 'auditor',
						'value'		=> set_value('auditor'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('auditor')",
					),
					// nextinput
					'nextinput' => array (
						'name'		=> 'nextinput',
						'id'		=> 'nextinput',
						'value'		=> '1',
						'class'		=> 'in_text',
						'onfocus'	=> "hover('nextinput')",
						'style'		=> 'width:200px; display:none;'

					),
					// Categorias del Pescado
					'categoria' => array (
						'cat_1' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Capacitación'),
						'cat_2' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Comunicación'),
						'cat_3' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Herramienta y Equipo'),
						'cat_4' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Actitud'),
						'cat_5' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Experiencia'),
						'cat_6' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Conocimiento'),
						'cat_7' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Habilidades'),
						'cat_8' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Complejdad'),
						'cat_9' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Factores Externos'),
						'cat_10' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Falta de Planeación'),
						'cat_11' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Recursos Humanos'),
						'cat_12' => array ('id' => 'categoria', 'name' => 'categoria[]', 'value' => 'Recursos Financieros'),
						'cat_13' => array ('onclick' => 'AgregarCategoria(0)'),
					),
				);

				$aCont = array(
						'name' => 'aCont',
						'id' => 'aCont',
						'class' => 'text_in',
						
					);
				$evidencia = array(
						'name' => 'evidencia',
						'id' => 'evidencia',
						'class' => 'text_in',
						
					);
				
				
				// Formulario de la No Conformidad
				echo form_open('procesos/conformidades/seguimiento/'.$id.'/'.$avance,array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="150">&Aacute;rea: </th>';
				echo '<td>'.$are.'</td></tr>';
				echo '<tr><th class="text_form">Departamento: </th>';
				echo '<td>'.$dep.'</td></tr>';
				echo '<tr><th class="text_form">Fecha: </th>';
				echo '<td>'.$fec.'</td></tr>';
				echo '<tr><th class="text_form">Origen: </th>';
				echo '<td>'.$ori.'</td></tr>';
				echo '<tr><th class="text_form">Tipo: </th>';
				echo '<td>'.$tip.'</td></tr>';
				echo '<tr><th class="text_form">Descripci&oacute;n: </th>';
				echo '<td>'.$des.'</td></tr>';
				echo '</table>';

				
				
				switch( $avance ) {
					// Parte 1: Espinas del pescado
					case 1 : 
						echo '<br />';
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" width="150">Correción </th>';
						echo '<td>'.form_textarea($aCont).'</td></tr>';
						echo '</table>';
						echo "<br></br>";
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" width="150">Evidencia Correción</th>';
						echo '<td>'.form_textarea($evidencia).'</td></tr>';
						echo '</table>';
						echo "<br></br>";
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th colspan="8"><span class="titulo_tabla">Diagrama de Pescado</span></th>';
						echo '<tr><th colspan="8">Selecciona las categorias a utilizar para hacer las espinas del pescado</th>';
						echo '<tr>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_1']).'</td><td>Capacitaci&oacute;n</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_2']).'</td><td>Comunicaci&oacute;n</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_3']).'</td><td>Herramienta y Equipo</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_4']).'</td><td>Actitud</td>';
						echo '</tr>';
						echo '<tr>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_5']).'</td><td>Experiencia</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_6']).'</td><td>Conocimiento</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_7']).'</td><td>Habilidades</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_8']).'</td><td>Complejdad</td>';
						echo '</tr>';
						echo '<tr>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_9']).'</td><td>Factores Externos</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_10']).'</td><td>Falta de Planeaci&oacute;n</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_11']).'</td><td>Recursos Humanos</td>';
						echo '<td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_12']).'</td><td>Recursos Financieros</td>';
						echo '</tr>';
						echo '</table>';
						echo '<div id="nueva_categoria_0">';
						echo '<table class="tabla_form">';
						echo '<tr><td class="text_form" width="10">'.form_checkbox($formulario['categoria']['cat_13']).'</td><td width="20">Otra</td>';
						echo '</tr></table>';
						echo '</div>';
						
						echo '<br /><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Continuar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
						break;

					// Parte 2: Causas en las espinas del pescado
					case 2 :
						echo '<br />';
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th colspan="2"><span class="titulo_tabla">Diagrama de Pescado</span></th>';
						// serializa el array
						$categorias_array = urlencode(serialize($categorias));
						echo '<tr><th colspan="2">Escribe las causas de cada categoria que elegiste<input type="hidden" name="array_categorias" value="'.$categorias_array.'"></th>';
						$i = 1;
						foreach( $categorias as $row ) :
							echo '<tr><th class="text_form" valign="top" style="padding-top:10px" width="150">'.$row.'</th>';						
							echo '<td><textarea id="causa_'.$i.'" onfocus="hover(\'causa_'.$i.'\')" rows="6" cols="90" name="causa_'.$i.'" style="height:40px"></textarea></td></tr>';
							$i++;
						endforeach;
						echo '</table><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Continuar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
						break;
								
					// Parte 3: Causa ra�z
					case 3 :
						echo '<br /><table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" width="150">Diagrama de Pescado: </th>';
						echo '<td>';
						echo '<a onclick="$(\'#ver_pescado\').dialog(\'open\')" onmouseover="tip(\'Click para ver el<br />Diagrama de Pescado\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/pix/pescado.png" /></a>';
						echo '<a style="margin-left:450px" onclick="$(\'#eliminar_pescado\').dialog(\'open\')" onmouseover="tip(\'Eliminar el<br />Diagrama de Pescado\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a>';
						echo '</td></tr>';
						echo '</table><br />';
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" valign="top" style="padding-top:10px" width="150">Causa Ra&iacute;z de la No Conformidad: </th>';
						echo '<td>'.form_textarea($formulario['causa']).'</td></tr>';
						echo '</table><br /><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Continuar').'</div>';
						break;
						
					// Parte 4: Acciones correctivas
					case 4 :
						echo '<br /><table class="tabla_form" width="700">';
						echo '<tr><th class="text_form" width="150">Diagrama de Pescado: </th>';
						echo '<td><a onclick="$(\'#ver_pescado\').dialog(\'open\')" onmouseover="tip(\'Click para ver el<br />Diagrama de Pescado\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/pix/pescado.png" /></a></td></tr>';
						echo '</table><br />';
						echo '<table class="tabla_form" width="700">';						
						echo '<tr><th class="text_form" width="150">Causa Ra&iacute;z de la No Conformidad: </th>';
						echo '<td>'.$cau.'</td></tr>';
						echo '</table><br />';
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th colspan="2">Nombre y Puesto del Auditor Responsable de vigilar el cumplimiento</th><tr>';
						echo '<tr><td colspan="2">'.form_input($formulario['auditor']).'</td></tr>';
						echo '</table><br />';
						echo '<table class="tabla_form" width="700">';
						echo '<tr><th colspan="2"><img onclick="AgregarAccion();" onmouseover="tip(\'Agregar otra acci&oacute;n\')" onmouseout="cierra_tip()" src="'.base_url().'includes/img/icons/small/plus.gif" /> <span class="titulo_tabla"> Acciones a Tomar</span></th>';
						echo '<tr><th class="text_form" width="150">Accion: </th>';
						echo '<td>';
						echo form_radio($formulario['accion']['correctiva'],'',true)." No Conformidad<br />";
						echo form_radio($formulario['accion']['preventiva']).' No Conformidad Potencial';
						echo '</td></tr>';
						echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripci&oacute;n: </th>';
						echo '<td>'.form_textarea($formulario['descripcion']).'</td></tr>';
						echo '<tr><th class="text_form">Responsable: </th>';
						echo '<td>'.form_input($formulario['responsable']).'</td></tr>';
						echo '<tr><th class="text_form">Fecha: </th>';
						echo '<td>'.form_input($formulario['fecha']).'</td></tr>';				
						echo '</table>';
						echo form_input($formulario['nextinput']);
						echo '<div id="nueva_accion" style="width:700px"></div><br />';
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						break;
				}
				
				echo form_close();
				?>
            </div>
		</div>
