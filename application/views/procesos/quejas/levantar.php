<?php
/****************************************************************************************************
*
*	VIEWS/procesos/quejas/levantar.php
*
*		Descripción:
*			Vista para la creación de una queja
*
*		Fecha de Creación:
*			17/Octubre/2011
*
*		Ultima actualización:
*			18/Octubre/2011
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
			<div class="titulo">Quejas</div>
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
					// Nombre
					'nombre_queja' => array (
						'name'		=> 'nombre_queja',
						'id'		=> 'nombre_queja',
						'value'		=> set_value('nombre_queja'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('nombre_queja')",
					),
					// Correo
					'correo' => array (
						'name'		=> 'correo',
						'id'		=> 'correo',
						'value'		=> set_value('correo'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('correo')",
					),
					// Telefono
					'telefono' => array (
						'name'		=> 'telefono',
						'id'		=> 'telefono',
						'value'		=> set_value('telefono'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('telefono')",
					),
					// Queja
					'queja' => array (
						'name'		=> 'queja',
						'id'		=> 'queja',
						'value'		=> set_value('queja'),
						'onfocus'	=> "hover('queja')",
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
				echo '<td>'.form_input($formulario['fecha']).'</td></tr>';
				echo '<tr><th class="text_form" width="50">Nombre: </th>';
				echo '<td>'.form_input($formulario['nombre_queja']).'</td></tr>';
				echo '<tr><th class="text_form" width="50">Correo: </th>';
				echo '<td>'.form_input($formulario['correo']).'</td></tr>';
				echo '<tr><th class="text_form">Tel&eacute;fono: </th>';
				echo '<td>'.form_input($formulario['telefono']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Queja y/o Sugerencia: </th>';
				echo '<td>'.form_textarea($formulario['queja']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
				?>
            </div>
		</div>