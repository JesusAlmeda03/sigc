<?php
/****************************************************************************************************
*
*	VIEWS/evaluaciones/clima/contestar.php
*
*		Descripción:
*			Vista para contestar la evaluación al clima laboral
*
*		Fecha de Creación:
*			23/Noviembre/2011
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
	<script>
	j = 0;
	function desaparece_pregunta( i ) {
		document.getElementById( 'pregunta_' + i ).style.display = 'none';
		j++;
	}
	
	function revisar_preguntas() {
		for( i = 1; i <= j; i++ )
			document.getElementById( 'pregunta_' + i ).style.display = 'block';
	}
	</script>
	<div class="content">
		<div class="cont">
			<div class="titulo"><?=$titulo?><br /><span style="font-size:22px"><?=$titulo_seccion?></span></div>
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
						'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px'
		            ),			
				);
		
				$i = 1;
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				foreach( $consulta as $pregunta => $opciones ) {
					echo '<table class="tabla_opciones" id="pregunta_'.$i.'" width="700">';
					echo '<tr style="border-bottom:1px solid #EEE"><th width="10"><strong style="font-size:28px" class="menu_item">'.$i.'.</strong></td><th valign="middle">'.$pregunta.'</th></tr>';					
					foreach( $opciones as $opc ) {
						echo '<tr><td></td><td><input type="radio" name="'.$opc['name'].'" value="'.$opc['value'].'" class="'.$opc['class'].'" onclick="desaparece_pregunta('.$i.')" /> '.$opc['nombre'].'<br /><br /></td></tr>';
					}
					$i++;
					echo '</table>';
				}
				echo '<br /><div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Guardar').form_button($formulario['boton_revisar'],'Revisar').'</div>';
				echo form_close();
				?>
				<br />
                <table><tr><td><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>/presentacion" onmouseover="tip('Regresa, sin guardar, al listado de secciones')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/evaluaciones/<?=$evaluacion?>/presentacion" onmouseover="tip('Regresa, sin guardar, al listado de secciones')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
			</div>
		</div>