<?php
/****************************************************************************************************
*
*	VIEWS/procesos/infraestructura/registrar.php
*
*		Descripción:
*			Genera lista de reportes de infraestructura de un area
*
*		Fecha de Creación:
*			31/Octubre/2013
*
*		Ultima actualización:
*			05/Octubre/2013
*				-Se inicializo
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*			@c
*
****************************************************************************************************/
$formulario = array(
					// * Boton submit
					'boton' => array (
						'id'		=> 'aceptar',
						'name'		=> 'aceptar',
						'class'		=> 'in_button',
						'onfocus'	=> 'hover(\'aceptar\')',
					),);
	$area_extras = 'id="area" onfocus="hover(\'area\')"';
?>
	<div class="content">
		<div class="cont">
			<div class="titulo">Reporte de Infraestructura: <?php if(isset($departamento)){foreach($departamento->result() as $tit){echo $tit->Departamento;}}?>
			</div>
            <div class="texto">
				<?php


		/*		echo '<table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por favor especifica en cada uno de los rubros si es necesaria la aprovacion por parte de Coordinaci&oacute;n de Calidad, indicarlo seleccionando "Solicitar" </td></tr></table><br />';*/
				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
						echo '<tr><th>Departamento: </th><td colspan="2"><select name="Departamento" style="width: auto;">';
						if($departamentos -> num_rows() >0 ){
							foreach($departamentos->result() as $dep){
								echo "<option  value='".$dep->IdDepartamento."'>".$dep->Departamento."</option>'";
							}
						}else{
							echo "Sin informacion";
						}
						echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
						echo form_close();
						echo '  </tbody>';
						echo '</table>';
						echo '<br>';
					if(isset($consulta)){
						if($consulta -> num_rows() > 0){
							echo '	<table class="tabla" width="700">';
							echo '	<thead>';
							echo '		<tr>';

							echo '			<th>Nombre</th>';
							echo '			<th width="10">Fecha</th>';
							echo '		</tr>';
							echo '	</thead>';
							echo '	<tbody>';

							if($consulta-> num_rows() > 0){
								foreach($consulta->result() as $dep){}
								foreach($reportes->result() as $rep){
							echo '		<tr>';

							echo '			<td>'.$rep->Nombre.'</td>';
							echo '			<td width="10">'.$rep->Fecha.'</td>';
							echo '			<td width="10"><a href="'.base_url().'index.php/procesos/infraestructura/ver/'.$rep->IdEvaluacion.'/'.$dep->Departamento.'"/><img src="'.base_url().'includes/img/icons/ver.png" /> </a></td>';
							echo '		</tr>';
							}
							echo '	</tbody>';
							echo '</table>';
						}
					}
				}
				?>


        </div>
    </div>
 </div>
