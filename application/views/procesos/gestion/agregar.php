<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="titulo"><?=$titulo2?></div>
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



					// Archivo
	                'archivo' => array (
	                    'name'		=> 'archivo',
	                    'id'		=> 'archivo',
	                    'value'		=> set_value('archivo'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('archivo')",
                       ),

                    'nombre' => array (
	                    'name'		=> 'archivo',
	                    'id'		=> 'archivo',
	                    'value'		=> set_value('archivo'),
	                    'class'		=> 'in_text',
	                    'onfocus'	=> "hover('archivo')",
	                   ),
				);
				$ano_extras = 'id="ano" onfocus="hover(\'ano\')" style="width:80px"';
				$area_extras = 'id="area" onfocus="hover(\'area\')"';

				// Nueva minuta
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Selecciona el documento que dejaras como evidencia</td></tr></table><br />';
				echo form_open_multipart('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Descripcion:</th>';
				echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
				echo '<tr><th class="text_form" width="80">Archivo: </th>';
	            echo '<td>'.form_upload($formulario['archivo']).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
                ?>
        </div>
    </div>
