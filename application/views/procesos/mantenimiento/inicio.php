<?php
/****************************************************************************************************
*
*	VIEWS/procesos/mantenimiento/inicio.php
*
*		Descripción:
*			Genera la lista de mantenimiento de equipo de cómputo
*
*		Fecha de Creación:
*			16/Abril/2011
*
*		Ultima actualización:
*			21/Septiembre/2012
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
				<?php
				$formulario = array(
					// * Boton submit
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')'
					),
					// Origen
					'periodo' => array (
						'A' => array (
							'name'		=> 'periodo',
							'id'		=> 'a',
							'value'		=> 'Enero - Junio',
							'class'		=> 'in_radio',
						),
						'B' => array (
							'name'		=> 'periodo',
							'id'		=> 'b',
							'value'		=> 'Julio - Diciembre',
							'class'		=> 'in_radio',
						),
					),
					// Año
					'ano' => array (
						'2012' => '2012',
						'2013' => '2013',
						'2014' => '2014',
						'2015' => '2015',
						'2016' => '2016',
						'2017' => '2017',
						'2018' => '2018',
						'2019' => '2019',
						'2020' => '2020',

					),
					// Fecha
					'fecha' => array (
						'id'		=> 'fecha',
						'name'		=> 'fecha',
						'class'		=> 'in_text',
						'onfocus'	=> 'hover(\'fecha\')'
					),
				);
				$ano_extras = 'id="ano" onfocus="hover(\'ano\')" style="width:80px"';
				$area_extras = 'id="area" onfocus="hover(\'area\')"';

				// Nueva minuta
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige los datos de la programaci&oacute;n que vas a realizar</td></tr></table><br />';
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">&Aacute;rea: </th>';
				echo '<td>'.form_dropdown('area',$area_options,set_value('area'),$area_extras).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px" width="70">Periodo: </th>';
				echo '<td>';
				echo form_radio($formulario['periodo']['A'],'',true)." Enero - Junio<br />";
				echo form_radio($formulario['periodo']['B']).' Julio - Diciembre<br />';
				echo '</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">A&ntilde;o: </th>';
				echo '<td>'.form_dropdown('ano',$formulario['ano'],set_value('ano'),$ano_extras).'</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Fecha: </th>';
				echo '<td>'.form_input($formulario['fecha']);
				echo '<br /><span style="font-style:italic; font-size:11px">D&iacute;as en los que se estara dando mantenimiento a los equipos del &aacute;rea seleccionada.<br />Ejemplo: <strong>del lunes 16 de abril al viernes 20 de abril</strong></span>';
				echo '</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
                ?>
        </div>
    </div>
