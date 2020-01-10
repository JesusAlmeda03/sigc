<?php
/****************************************************************************************************
*
*	VIEWS/procesos/conformidades/levantar.php
*
*		Descripci�n:  		  
*			Vista para la creaci�n de una no conformidad
*
*		Fecha de Creaci�n:
*			20/Octubre/2011
*
*		Ultima actualizaci�n:
*			20/Octubre/2011
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
				<script>
				<?php
				// date picker
            	if( set_value('fecha') ) {
					?>
					$(function() {
	                    $( "#fecha" ).datepicker({
							changeMonth: true,
							changeYear: true,
						});
						$('#fecha').datepicker($.datepicker.regional['es']);
						$('#fecha').datepicker('option', {dateFormat: 'yy-mm-dd'});
						var queryDate = '<?=set_value('fecha')?>',
						dateParts = queryDate.match(/(\d+)/g)
						realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
						$('#fecha').datepicker('setDate', realDate);
					});
					<?php
				}
				else { 
					?>
					$(function() {
	                    $( "#fecha" ).datepicker({
							changeMonth: true,
							changeYear: true,
						});
						$('#fecha').datepicker($.datepicker.regional['es']);
						$('#fecha').datepicker('option', {dateFormat: 'yy-mm-d'});
						$("#startDate").datepicker({dateFormat: 'yy-mm-dd'});
					});
					<?php
				}
            	?>
                </script>
                <script>
				$(document).ready(function(){
						$("#area").change(function(){
							if($(this).val()!=""){
								var dato=$(this).val();
								$("#dep_cont").empty();								
								$("#imgloader").show();
								$("#dep_cont").css("padding","0");
								$("#imgloader").css("padding-bottom","10px");
								$.ajax({
									type:"POST",
									dataType:"html",
									url:"<?=base_url()?>index.php/inicio/ajax_departamentos",
									data:"id_area="+dato,
									success:function(msg){
										$("#dep_cont").empty().removeAttr("disabled").append(msg);
										$("#imgloader").hide();										
									}
								});
							}else{
								$("#dep_cont").empty().attr("disabled","disabled");
							}
						});		
					});				
				</script>
				<?php	
				// Area		
				$area_extras = 'id="area" onfocus="hover(\'area\')" ';
				
				$formulario = array(
					// * Boton submit
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')'
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
					// Tipo
					'tipo' => array (
						'no_conformidad' => array (
							'name'		=> 'tipo',
							'id'		=> 'no_conformidad',
							'value'		=> 'No Conformidad',
							'class'		=> 'in_radio',
						),
						'no_conformidad_potencial' => array (
							'name'		=> 'tipo',
							'id'		=> 'no_conformidad_potencial',
							'value'		=> 'No Conformidad Potencial',
							'class'		=> 'in_radio',
							'style'		=> 'margin-bottom:10px'
						),
					),
					// Origen
					'origen' => array (
						'sistema' => array (
							'name'		=> 'origen',
							'id'		=> 'sistema',
							'value'		=> 'Sistema',
							'class'		=> 'in_radio',
						),
						'producto' => array (
							'name'		=> 'origen',
							'id'		=> 'producto',
							'value'		=> 'Producto',
							'class'		=> 'in_radio',
						),
						'proceso' => array (
							'name'		=> 'origen',
							'id'		=> 'proceso',
							'value'		=> 'Proceso',
							'class'		=> 'in_radio',
						),
						'satisfaccion' => array (
							'name'		=> 'origen',
							'id'		=> 'satisfaccion',
							'value'		=> 'Satisfaccion',
							'class'		=> 'in_radio',
							'style'		=> 'margin-bottom:10px'
						),
					),
					// Descripción
					'descripcion' => array (
						'name'		=> 'descripcion',
						'id'		=> 'descripcion',
						'value'		=> set_value('descripcion'),
						'onfocus'	=> "hover('descripcion')",
					)
				);
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="50">&Aacute;rea: </th>';
				echo '<td>'.form_dropdown('area',$area_options,set_value('area'),$area_extras).'</td></tr>';
				echo '<tr><th class="text_form">Departamento: </th>';
				if( set_value('area') ) {
					echo '<td>';
					if( $departamentos->num_rows() > 0 ) {
						echo '<select name="departamento" id="departamento" onfocus="hover(\'departamento\')">';
						foreach( $departamentos->result() as $row ) :
							echo '<option value="'.$row->IdDepartamento.'">';
							echo $row->Departamento;
							echo '</option>';
						endforeach;
						echo "</select>";
					}
					else {
						echo '<div style="padding-bottom:10px">Por el momento no hay Departamentos de esta &Aacute;rea</div>';
					}
					echo '</td></tr>';
				}	
				else {
					echo '<td><div id="dep_cont" style="font-style:italic; padding:6px 0; letter-spacing:1px">Elige un &Aacute;rea</div><img src="'.base_url().'includes/img/ajax-loader.gif" style="display:none;" alt="Cargando" id="imgloader"/></td></tr>';
				}
				echo '<tr><th class="text_form">Fecha: </th>';
				echo '<td>'.form_input($formulario['fecha']).'</td>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Tipo: </th>';
				echo '<td>';
				echo form_radio($formulario['tipo']['no_conformidad'],'',true)." No Conformidad<br />";
				echo form_radio($formulario['tipo']['no_conformidad_potencial']).' No Conformidad Potencial';
				echo '</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Origen: </th>';
				echo '<td>';
				echo form_radio($formulario['origen']['sistema'],'',true)." Sistema (no conformidades derivadas de auditoria)<br />";
				echo form_radio($formulario['origen']['producto']).' Producto (no conformidades detectadas de un producto)<br />';
				echo form_radio($formulario['origen']['proceso'])." Proceso (incumplimiento de un instructivo)<br />";
				echo form_radio($formulario['origen']['satisfaccion']).' Satisfacci&oacute;n (quejas del usuario)';
				echo '</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripci&oacute;n: </th>';
				echo '<td>'.form_textarea($formulario['descripcion']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
				?>
            </div>
		</div>