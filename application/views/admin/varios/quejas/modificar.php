<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/quejas/modificar.php
*
*		Descripción:
*			Vista para modificar una queja
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
			// Area		
			$area_extras = 'id="area" onfocus="hover(\'area\')" ';
			
			// Seccion
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
					'onclick'	=> "location.href='".base_url()."index.php/admin/varios/quejas/".$area."/".$estado."'",
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
				// Nombre
				'nombre' => array (
					'name'		=> 'nombre',
					'id'		=> 'nombre',
					'value'		=> $nom,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('nombre')",
				),
				// Correo
				'correo' => array (
					'name'		=> 'correo',
					'id'		=> 'correo',
					'value'		=> $cor,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('correo')",
				),
				// Telefono
				'telefono' => array (
					'name'		=> 'telefono',
					'id'		=> 'telefono',
					'value'		=> $tel,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('telefono')",
				),
				// Queja
				'queja' => array (
					'name'		=> 'queja',
					'id'		=> 'queja',
					'value'		=> $que,
					'onfocus'	=> "hover('queja')",
				),
				
				// SEGUIMIENTO
				// Fecha del seguimiento
				'fecha_seguimiento' => array (
					'name'		=> 'fecha_seguimiento',
					'id'		=> 'fecha_seguimiento',
					'value'		=> $fes,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('fecha_seguimiento')",
					'style'		=> 'width:200px'

				),
				// Responsable
				'responsable' => array (
					'name'		=> 'responsable',
					'id'		=> 'responsable',
					'value'		=> $res,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('responsable')",
				),
				// Descripcion
				'descripcion' => array (
					'name'		=> 'descripcion',
					'id'		=> 'descripcion',
					'value'		=> $des,
					'onfocus'	=> "hover('descripcion')",
				),
				// Queja
				'observaciones' => array (
					'name'		=> 'observaciones',
					'id'		=> 'observaciones',
					'value'		=> $obs,
					'onfocus'	=> "hover('observaciones')",
				),
			);
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo '<table class="tabla_form" width="980">';
			echo '<tr><th class="text_form" width="50">&Aacute;rea: </th>';
			echo '<td>'.form_dropdown('area',$area_options,$ida,$area_extras).'</td></tr>';
			echo '<tr><th class="text_form">Departamento: </th>';
			echo '<td><div id="dep_cont" style="font-style:italic; letter-spacing:1px">'.form_dropdown('departamento',$departamento_options,$idd,$departamento_extras).'</div><img src="'.base_url().'includes/img/ajax-loader.gif" style="display:none;" alt="Cargando" id="imgloader"/></td></tr>';
			echo '<tr><th class="text_form">Fecha: </th>';
			echo '<td>'.form_input($formulario['fecha']).'</td>';
			echo '<tr><th class="text_form" width="50">Nombre: </th>';
			echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
			echo '<tr><th class="text_form" width="50">Correo: </th>';
			echo '<td>'.form_input($formulario['correo']).'</td></tr>';
			echo '<tr><th class="text_form">Tel&eacute;fono: </th>';
			echo '<td>'.form_input($formulario['telefono']).'</td>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Queja y/o Sugerencia: </th>';
			echo '<td>'.form_textarea($formulario['queja']).'</td></tr>';
			echo '</table><br />';
			// si ya se le ha dado seguimiento a la queja
			if( $edo ){
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th colspan="2"><span class="titulo_tabla">Datos del seguimiento</span></th>';
				echo '<tr><th class="text_form">Fecha: </th>';
				echo '<td>'.form_input($formulario['fecha_seguimiento']).'</td>';
				echo '<tr><th class="text_form" width="50">Responsable: </th>';
				echo '<td>'.form_input($formulario['responsable']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripci&oacute;n: </th>';
				echo '<td>'.form_textarea($formulario['descripcion']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Observaciones: </th>';
				echo '<td>'.form_textarea($formulario['observaciones']).'</td></tr>';
				echo '</table><br />';
			}
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
			echo form_close();
			?>
        </div>
	</div>