<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/conformidades/modificar.php
*
*		Descripci�n:  		  
*			Vista para modificar una no conformidad
*
*		Fecha de Creaci�n:
*			06/Diciembre/2011
*
*		Ultima actualizaci�n:
*			15/Diciembre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>	
	<div class="cont_admin">
		<div class="titulo"><?=$titulo?></div>
        <div class="texto">            
			<script>
			$(function() {
                $( "#fecha" ).datepicker({
					changeMonth: true,
					changeYear: true,
				});
				$('#fecha').datepicker($.datepicker.regional['es']);
				$('#fecha').datepicker('option', {dateFormat: 'yy-mm-dd'});
				var queryDate = '<?=$fec?>',
				dateParts = queryDate.match(/(\d+)/g)
				realDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
				$('#fecha').datepicker('setDate', realDate);
			});
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
								url:"<?=base_url()?>index.php/procesos/quejas/ajax_departamentos",
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
			// Tipo
			$tip_a = $tip_b = false;
			switch( $tip ) {
				case "No Conformidad" : $tip_a = true; break;
				case "No Conformidad Potencial" : $tip_b = true; break;					
			}
			
			// Origen
			$ori_a = $ori_b = $ori_c = $ori_d = false;
			switch( $ori ) {
				case "Sistema" : $ori_a = true; break;
				case "Producto" : $ori_b = true; break;
				case "Proceso" : $ori_c = true; break;
				case "Satisfaccion" : $ori_d = true; break;
			}
			
			// Area		
			$area_extras = 'id="area" onfocus="hover(\'area\')" ';
			
			// Departamento
			$departamento_extras = 'id="departamento" onfocus="hover(\'departamento\')" ';				
			
			// Formulario				
			$formulario = array(
				// * Boton submit
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
					'onclick'	=> "location.href='".base_url()."index.php/admin/varios/conformidades/".$area."/".$estado."'",
                ),
				// Fecha
				'fecha' => array (
					'name'		=> 'fecha',
					'id'		=> 'fecha',
					'value'		=> $fec,
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
				// Descripci�n
				'descripcion' => array (
					'name'		=> 'descripcion',
					'id'		=> 'descripcion',
					'value'		=> $des,
					'onfocus'	=> "hover('descripcion')",
				),
				// * Seguimiento
				// Causa
				'causa' => array (
					'name'		=> 'causa',
					'id'		=> 'causa',
					'value'		=> $cau,
					'onfocus'	=> "hover('causa')",
				),
				'auditor' => array (
					'name'		=> 'auditor',
					'id'		=> 'auditor',
					'value'		=> $aud,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('auditor')",
				)  
			);
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			if( $this->session->userdata('CON') || $idu == $this->session->userdata('id_usuario') ) {
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th class="text_form" width="50">&Aacute;rea: </th>';
				echo '<td>'.form_dropdown('area',$area_options,$ida,$area_extras).'</td></tr>';
				echo '<tr><th class="text_form">Departamento: </th>';
				echo '<td><div id="dep_cont" style="font-style:italic; letter-spacing:1px">'.form_dropdown('departamento',$departamento_options,$idd,$departamento_extras).'</div><img src="'.base_url().'includes/img/ajax-loader.gif" style="display:none;" alt="Cargando" id="imgloader"/></td></tr>';
				echo '<tr><th class="text_form">Fecha: </th>';
				echo '<td>'.form_input($formulario['fecha']).'</td>';
				echo '<tr><th class="text_form" width="50">Tipo: </th>';
				echo '<td>';
				echo form_radio($formulario['tipo']['no_conformidad'],'',$tip_a)." No Conformidad<br />";
				echo form_radio($formulario['tipo']['no_conformidad_potencial'],'',$tip_b).' No Conformidad Potencial';
				echo '</td></tr>';
				echo '<tr><th class="text_form" width="50">Origen: </th>';
				echo '<td>';
				echo form_radio($formulario['origen']['sistema'],'',$ori_a)." Sistema (no conformidades derivadas de auditoria)<br />";
				echo form_radio($formulario['origen']['producto'],'',$ori_b).' Producto (no conformidades detectadas de un producto)<br />';
				echo form_radio($formulario['origen']['proceso'],'',$ori_c)." Proceso (incumplimiento de un instructivo)<br />";
				echo form_radio($formulario['origen']['satisfaccion'],'',$ori_d).' Satisfacci&oacute;n (quejas del usuario)';
				echo '</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripci&oacute;n: </th>';
				echo '<td>'.form_textarea($formulario['descripcion']).'</td></tr>';
				echo '</table><br />';
			}
			// si ya se le ha dado seguimiento a la queja
			if( $edo ){
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th class="text_form" colspan="2"><span class="titulo_tabla">Datos del seguimiento</span></th>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px; width:50px">Causa Ra&iacute;z: </th>';
				echo '<td>'.form_textarea($formulario['causa']).'</td>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Nombre y Puesto del Auditor Responsable de vigilar el cumplimiento: </th>';
				echo '<td>'.form_input($formulario['auditor']).'</td>';
				echo '</table><br />';
				
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" colspan="2"><span class="titulo_tabla">Diagrama de Pescado</span></th></tr>';
				if( $diagrama->num_rows() > 0 ) {
					$i = 1;					
					foreach( $diagrama->result() as $row ) :
						echo '<tr><th class="text_form" width="80" style="font-weight:normal">Categoria: </th>';
						echo '<td><input id="categoria_diagrama_'.$i.'" class="in_text" type="text" style="width:200px" onfocus="hover(\'categoria_diagrama_'.$i.'\')" value="'.$row->Categoria.'" name="categoria_diagrama_'.$i.'"></td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top" style="padding-top:10px">Causa: </th>';
						echo '<td><textarea name="causa_diagrama_'.$i.'" id="causa_diagrama_'.$i.'">'.$row->Causa.'</textarea></td></tr>';
						$i++;
					endforeach;
				}
				echo '</table><br />';

				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" colspan="2"><span class="titulo_tabla">Acciones Correctivas</span></th></tr>';
				if( $contencion->num_rows() > 0 ) {
					$i = 1;					
					foreach( $contencion->result() as $row ) :
						echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top" style="padding-top:10px">Acciones: </th>';
						echo '<td><textarea name="Acciones" id="accion_contension'.$i.'">'.$row->Acciones.'</textarea></td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top" style="padding-top:10px">Evidencia: </th>';
						echo '<td><textarea name="Evidencia" id="accion_contension'.$i.'">'.$row->Evidencia.'</textarea></td></tr>';
						$i++;
					endforeach;
				}
				echo '</table><br />';
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th class="text_form" colspan="2"><span class="titulo_tabla">Acciones a Tomar</span></th>';
				if( $acciones->num_rows() > 0 ) {
					$i = 1;					
					foreach( $acciones->result() as $row ) :
						echo '<tr><th class="text_form" width="80" style="font-weight:normal">Numero: </th>';
						echo '<td>'.$i.'</td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal">Fecha: <br /><label style="font-size:10px">aaaa-mm-dd</label></th>';
						echo '<td><input id="fecha_accion_'.$i.'" class="in_text" type="text" style="width:200px" onfocus="hover(\'fecha_accion_'.$i.'\')" value="'.$row->Fecha.'" name="fecha_accion_'.$i.'"></td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Tipo: </th>';
						echo '<td>';
						if( $row->Tipo == "Correctiva" ) {
							echo '<input id="tipo_accion_'.$i.'" type="radio" value="Correctiva" name="tipo_accion_'.$i.'" checked="checked"> Correctiva<br />';
							echo '<input id="tipo_accion_'.$i.'" type="radio" value="Preventiva" name="tipo_accion_'.$i.'"> Preventiva';
						}
						else {
							echo '<input id="tipo_accion_'.$i.'" type="radio" value="Correctiva" name="tipo_accion_'.$i.'"> Correctiva<br />';
							echo '<input id="tipo_accion_'.$i.'" type="radio" value="Preventiva" name="tipo_accion_'.$i.'" checked="checked"> Preventiva';
						}
						echo '</td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal">Responsable: </th>';
						echo '<td><input id="responsable_accion_'.$i.'" class="in_text" type="text" style="width:200px" onfocus="hover(\'responsable_accion_'.$i.'\')" value="'.$row->Responsable.'" name="responsable_accion_'.$i.'"></td></tr>';
						echo '<tr><th class="text_form" width="80" style="font-weight:normal" valign="top">Acci&oacute;n: </th>';
						echo '<td><textarea name="accion_accion_'.$i.'" id="accion_accion_'.$i.'">'.$row->Accion.'</textarea></td></tr>';
						$i++;
					endforeach;
				}
				echo '</table><br />';
			}
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
			echo form_close();
			?>
        </div>
	</div>