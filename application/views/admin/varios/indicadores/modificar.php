<?php
/****************************************************************************************************
*
*	VIEWS/procesos/indicadores/modificar.php
*
*		Descripci�n:
*			Vista para modificar la informaci�n de un indicador
*
*		Fecha de Creaci�n:
*			16/Noviembre/2011
*
*		Ultima actualizaci�n:
*			16/Noviembre/2011
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
            <?php
			$formulario = array(
				// * Boton submit
				'boton' => array (
					'id'		=> 'aceptar',
					'name'		=> 'aceptar',
					'class'		=> 'in_button',
					'onfocus'	=> 'hover(\'aceptar\')'
				),
				// * Boton submit
				'boton_cancelar' => array (
					'id'		=> 'cancelar',
					'name'		=> 'cancelar',
					'class'		=> 'in_button',
					'onfocus'	=> 'hover(\'cancelar\')',
					'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',
					'onclick'	=> 'location.href=\''.base_url().'index.php/admin/varios/indicadores/'.$area.'/'.$estado.'\'',
				),
				// Indicador
				'indicador' => array (
					'name'		=> 'indicador',
					'id'		=> 'indicador',
					'value'		=> $ind,
					'onfocus'	=> "hover('indicador')",
					'style'		=> 'height:50px',
				),
				// Meta
				'meta' => array (
					'name'		=> 'meta',
					'id'		=> 'meta',
					'value'		=> $met,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('meta')",
				),
				// Calculo
				'calculo' => array (
					'name'		=> 'calculo',
					'id'		=> 'calculo',
					'value'		=> $cal,
					'onfocus'	=> "hover('calculo')",
					'style'		=> 'height:50px',						
				),
				// Frecuencia
				'frecuencia' => array (
					'name'		=> 'frecuencia',
					'id'		=> 'frecuencia',
					'value'		=> $fre,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('frecuencia')",
				),
				// Responsable
				'responsable' => array (
					'name'		=> 'responsable',
					'id'		=> 'responsable',
					'value'		=> $res,
					'class'		=> 'in_text',
					'onfocus'	=> "hover('responsable')",
				),
				// Observaciones
				'observaciones' => array (
					'name'		=> 'observaciones',
					'id'		=> 'observaciones',
					'value'		=> $obs,
					'onfocus'	=> "hover('observaciones')",
					'style'		=> 'height:50px',						
				)
			);
            ?>	          
			<?php 
			// Formulario de modificacion del indicador
			echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
			echo '<table width="980" class="tabla_form">';
			echo '<tr><th class="text_form" width="70" valign="top" style="padding-top:10px;">Indicador</th><td>'.form_textarea($formulario['indicador']).'</td></tr>';
			echo '<tr><th class="text_form">Meta</th><td>'.form_input($formulario['meta']).'</td></tr>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Calculo</th><td>'.form_textarea($formulario['calculo']).'</td></tr>';
			echo '<tr><th class="text_form">Frecuencia</th><td>'.form_input($formulario['frecuencia']).'</td></tr>';
			echo '<tr><th class="text_form">Responsable</th><td>'.form_input($formulario['responsable']).'</td></tr>';
			echo '<tr><th class="text_form" valign="top" style="padding-top:10px">Observaciones</th><td>'.form_textarea($formulario['observaciones']).'</td></tr>';
			echo '</table><br />';
			echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
			echo form_close();
			
			// Listado de mediciones
			echo '<br /><br />';
            if( $mediciones->num_rows() > 0 ) {
				echo '<table class="tabla_form" width="980">';
				echo '<tr><th>Fecha</th><th>Medici&oacute;n</th><th width="20"></th></tr>';
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
					echo '<td>'.$fecha.'</td><td>'.$row->Medicion.'%</td>';
					echo '<td><a onclick="pregunta_cambiar(\'indicadores_medicion\','.$row->IdIndicadorMedicion.',0,\'&iquest;Deseas eliminar esta medici&oacute;n?\',\'varios-indicadores_modificar-'.$id.'-'.$area.'-'.$estado.'\')" onmouseover="tip(\'Eliminar medici&oacute;n\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
				endforeach;
				echo '</table>';
			}
            ?>
            <br />
            <table><tr><td><a href="<?=base_url() ?>index.php/admin/varios/indicadores/<?=$area?>/<?=$estado?>" onmouseover="tip('Regresa al listado de<br />indicadores')" onmouseout="cierra_tip()"><img src="<?=base_url() ?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url() ?>index.php/admin/varios/indicadores/<?=$area?>/<?=$estado?>" onmouseover="tip('Regresa al listado de<br />no conformidades')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>                
    	</div>
	</div>