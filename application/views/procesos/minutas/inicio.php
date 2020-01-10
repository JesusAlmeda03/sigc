<?php
/****************************************************************************************************
*
*	VIEWS/procesos/minutas/inicio.php
*
*		Descripci�n:
*			Listado de todos los indicadores
*
*		Fecha de Creaci�n:
*			19/Noviembre/2011
*
*		Ultima actualizaci�n:
*			19/Noviembre/2011
*
*		Autor:
*			ISC Rogelio Casta�eda Andrade
*			HERE (http://www.webHERE.com.mx)
*			rogeliocas@gmail.com
*
****************************************************************************************************/
?>
	<div class="content">		
		<div class="cont">
			<div class="titulo"><?=$titulo?></div>
            <div class="texto">
				<?php 
				// Establece el periodo por default
				$mes = date('n');
				$per_a = $per_b = $per_c = $per_d = false;
				if( $mes >= 1 && $mes <= 3 ) $per_d = true;
				if( $mes >= 4 && $mes <= 6 ) $per_a = true;
				if( $mes >= 7 && $mes <= 9 ) $per_b = true;
				if( $mes >= 10 && $mes <= 12 ) $per_c = true;
				
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
							'value'		=> 'Enero - Marzo',
							'class'		=> 'in_radio',
						),
						'B' => array (
							'name'		=> 'periodo',
							'id'		=> 'b',
							'value'		=> 'Abril - Junio',
							'class'		=> 'in_radio',
						),
						'C' => array (
							'name'		=> 'periodo',
							'id'		=> 'c',
							'value'		=> 'Julio - Septiembre',
							'class'		=> 'in_radio',
						),
						'D' => array (
							'name'		=> 'periodo',
							'id'		=> 'd',
							'value'		=> 'Octubre - Diciembre',
							'class'		=> 'in_radio',
							'style'		=> 'margin-bottom:10px'
						),
					),
					// A�o
					'ano' => array (
						'2011' => '2011',
						'2012' => '2012',
						'2013' => '2013',
						'2014' => '2014',
						'2015' => '2015',
						'2016' => '2016',
						'2017' => '2017',
                                                '2018' => '2018', 
						'2019' => '2019', 
						'2020' => '2020'
					),
				);
				$ano_extras = 'id="ano" onfocus="hover(\'ano\')" style="width:80px"';
				
				// Nueva minuta
				echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Elige los datos para crear una nueva minuta</td></tr></table><br />';
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px" width="70">Periodo: </th>';
				echo '<td>';
				echo form_radio($formulario['periodo']['A'],'',$per_a)." Enero - Marzo<br />";
				echo form_radio($formulario['periodo']['B'],'',$per_b).' Abril - Junio<br />';
				echo form_radio($formulario['periodo']['C'],'',$per_c)." Julio - Septiembre<br />";
				echo form_radio($formulario['periodo']['D'],'',$per_d).' Octubre - Diciembre';
				echo '</td></tr>';
				echo '<tr><th class="text_form" valign="top" style="padding-top:10px">A&ntilde;o: </th>';
				echo '<td>'.form_dropdown('ano',$formulario['ano'],set_value('ano'),$ano_extras).'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
                ?>
        </div>
    </div>
