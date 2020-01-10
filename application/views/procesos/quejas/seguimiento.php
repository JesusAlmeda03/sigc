<?php
/****************************************************************************************************
*
*	VIEWS/procesos/quejas/levantar.php
*
*		Descripción:
*			Vista para el seguimiento de una queja
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
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<script>
				$(function() {
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
						'onclick'	=> "location.href='".base_url()."index.php/listados/quejas/".$estado."'",
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
					// Responsable
					'responsable' => array (
						'name'		=> 'responsable',
						'id'		=> 'responsable',
						'value'		=> set_value('responsable'),
						'class'		=> 'in_text',
						'onfocus'	=> "hover('responsable')",
					),
					// Descripci�n
					'descripcion' => array (
						'name'		=> 'descripcion',
						'id'		=> 'descripcion',
						'value'		=> set_value('descripcion'),
						'onfocus'	=> "hover('descripcion')",
					),
					// Observaci�n
					'observacion' => array (
						'name'		=> 'observacion',
						'id'		=> 'observacion',
						'value'		=> set_value('observacion'),
						'onfocus'	=> "hover('observacion')",
					)
				);
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" width="50">&Aacute;rea: </th>';
				echo '<td>'.$are.'</td></tr>';
				echo '<tr><th class="text_form" width="50">Departamento: </th>';
				echo '<td>'.$dep.'</td></tr>';
				echo '<tr><th class="text_form" width="50">Nombre: </th>';
				echo '<td>'.$nom.'</td></tr>';
				echo '<tr><th class="text_form" width="50">Fecha: </th>';
				echo '<td>'.$fec.'</td></tr>';
				echo '<tr><th class="text_form" width="50">Correo: </th>';
				echo '<td>'.$cor.'</td></tr>';
				echo '<tr><th class="text_form" width="50">Tel&eacute;fono: </th>';
				echo '<td>'.$tel.'</td></tr>';
				echo '<tr><th class="text_form" width="50">Queja: </th>';
				echo '<td valign="top" style="padding-top:10px">'.$que.'</td></tr>';
				echo '<tr><th class="text_form">Fecha: </th>';
				echo '<td>'.form_input($formulario['fecha']).'</td>';
				echo '<tr><th class="text_form" width="50">Responsable: </th>';
				echo '<td>'.form_input($formulario['responsable']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripci&oacute;n: </th>';
				echo '<td>'.form_textarea($formulario['descripcion']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Observaci&oacute;n: </th>';
				echo '<td>'.form_textarea($formulario['observacion']).'</td></tr>';
				echo '</table>';
				echo '<div style="width:700px; text-align:center; margin-top:10px">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
				echo form_close();
				?>
            </div>
		</div>
