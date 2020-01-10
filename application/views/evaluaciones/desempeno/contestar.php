<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/desempeno/contestar.php
*
*		Descripción:
*			Vista para contestar la evaluación al desempeño laboral
*
*		Fecha de Creación:
*			06/Enero/2011
*
*		Ultima actualización:
*			06/Enero/2011
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
					// * Boton revisar
		            'boton_revisar' => array (
		                'id'		=> 'revisar',
		                'name'		=> 'revisar',
		                'class'		=> 'in_button',
		                'onfocus'	=> 'hover(\'revisar\')',
						'onclick'	=> 'revisar_preguntas()',
						'style'		=> 'width:150px; height:55px; margin-left:10px'
		            ),			
				);
		
				$i = 1;
				echo '<table class="tabla_form" width="700">';
				echo '<tr><th class="titulo_tabla" style="font-size:24px">Persona a Evaluar:</th><td style="font-size:18px; text-align:center">'.$nombre_usuario.'</td></tr>';
				echo '</table><br />';
				
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_opciones" width="700">';
				echo '<tr style="border:1px solid #CCC; border-bottom:none; text-align:center"><th></th><th colspan="10" ><strong style="font-size:22px; text-align:center" class="menu_item">Grados</strong></th></tr>';
				echo '<tr style="border:1px solid #CCC; border-top:none;"><th></th>';
				for( $x = 1; $x <= 10; $x++ )
					echo '<th><strong style="font-size:28px" class="menu_item">'.$x.'</strong></th>';
				echo '</tr>';
				foreach( $consulta as $pregunta => $opciones ) {					
					echo '<tr class="desempeno">';
					echo '<th valign="middle">'.$pregunta.'</th>';
					foreach( $opciones as $opc ) {
						echo '<td><input type="radio" name="'.$opc['name'].'" value="'.$opc['value'].'" class="'.$opc['class'].'" /> <br /><br /></td>';
					}
					$i++;
					echo '</tr>';
				}
				echo '</table>';
				echo '<br /><div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();                
				?>
				<br />
                <table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>/presentacion" onmouseover="tip('Regresa, sin guardar, al listado de secciones')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>/presentacion" onmouseover="tip('Regresa, sin guardar, al listado de secciones')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>