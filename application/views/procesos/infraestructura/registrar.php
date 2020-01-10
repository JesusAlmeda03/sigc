<?php
/****************************************************************************************************
*
*	VIEWS/procesos/infraestructura/registrar.php
*
*		Descripción:
*			Genera la lista de mantenimiento de equipo de cómputo
*
*		Fecha de Creación:
*			23/Octubre/2013
*
*		Ultima actualización:
*			31/Octubre/2013
*				-Se cambiaron los valores del dropdown de los periodos
*
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*			@c
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
						'onfocus'	=> 'hover(\'aceptar\')',
					),

					// Año
					'ano' => array (
						'2012' => '2012',
						'2013' => '2013',
						'2014' => '2014',
						'2015' => '2015',
					),
					// Fecha

				);
				$estado= array(
					'Conforme' => 'Conforme',
					'Inconforme'=> 'Inconforme',
				);

				$recursos= array(
					'Ninguno' => 'Ninguno',
					'Propios' => 'Propios',
					'Solicitar'=> 'Solicitar',
				);






				$inconformes = array(
				'Periodo' => array(
		              'name'		=> 'Periodo',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),

				'Muro1' => array(
		              'name'		=> 'Muro1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
	             'Pisos1' => array(
		              'name'		=> 'Pisos1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),

				'Puertas1' => array(
		              'name'		=> 'Puertas1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Ventanas1' => array(
		              'name'		=> 'Ventanas1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Muebles1' => array(
		              'name'		=> 'Muebles1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),

				'Limpieza1' => array(
		              'name'		=> 'Limpieza1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Orden1' => array(
		              'name'		=> 'Orden1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Extintores1' => array(
		              'name'		=> 'Extintores1',
		             'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Rutas1' => array(
		              'name'		=> 'Rutas1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Depositos1' => array(
		              'name'		=> 'Depositos1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Control1' => array(
		              'name'		=> 'Control1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Iluminacion1' => array(
		              'name'		=> 'Iluminacion1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Temperatura1' => array(
		              'name'		=> 'Temperatura1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Humedad1' => array(
		              'name'		=> 'Humedad1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Ruido1' => array(
		              'name'		=> 'Ruido1',
		              'maxlength'   => '100',
		              'size'        => '30',
					 ),
				'Arco1' => array(
	 		              'name'		=> 'Arco1',
	 		              'maxlength'   => '100',
	 		              'size'        => '30',
	 					 ),
				'Acciones' => array(
		              'name'		=> 'Acciones',
		              'cols'   		=> '30',

					 ),
				 );
				$area_extras = 'id="area" onfocus="hover(\'area\')"';

				foreach ($periodo->result() as $row);



				// Nuevo Reporte

				echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
				echo '<table class="tabla_form" width="700">';
					echo '<tr><th>Departamento: </th><td colspan="2"><select name="Departamento" style="width: auto;">';

					if($departamentos ->num_rows() > 0 ){
						foreach($departamentos->result() as $dep){
							echo "<option  value='".$dep->IdDepartamento."'>".$dep->Departamento."</option>'";
						}
					}else{
						echo "Sin informacion";
					}
					echo '</select></td></tr>';
					echo '<tr><th>Periodo</th><td colspan="2">'.form_hidden('Periodo', $row->IdEvaluacion). $row->Nombre.'</td></tr>';
					echo '<tr><th>Elementos</th><th width="100%">Estado</th><th>Descripcion de la inconformidad</th><th width="100%">Recurso</th></tr>';
					echo '<tr><th>Muros</th><td>'.form_dropdown('Muros',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Muro1']).'</td><td>'.form_dropdown('Muros_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';
					echo '<tr><th>Pisos</th><td>'.form_dropdown('Pisos',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Pisos1']).'</td><td>'.form_dropdown('Pisos_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Puertas</th><td>'.form_dropdown('Puertas',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Puertas1']).'</td><td>'.form_dropdown('Puertas_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Ventanas</th><td>'.form_dropdown('Ventanas',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Ventanas1']).'</td><td>'.form_dropdown('Ventanas_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Muebles</th><td>'.form_dropdown('Muebles',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Muebles1']).'</td><td>'.form_dropdown('Muebles_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Limpieza</th><td>'.form_dropdown('Limpieza',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Limpieza1']).'</td><td>'.form_dropdown('Limpieza_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Orden</th><td>'.form_dropdown('Orden',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Orden1']).'</td><td>'.form_dropdown('Orden_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Extintores</th><td>'.form_dropdown('Extintores',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Extintores1']).'</td><td>'.form_dropdown('Extintores_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Rutas de evacuacion</th><td>'.form_dropdown('Rutas',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Rutas1']).'</td><td>'.form_dropdown('Rutas_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Depositos de basura</th><td>'.form_dropdown('Depositos',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Depositos1']).'</td><td>'.form_dropdown('Depositos_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Control de plagas</th><td>'.form_dropdown('Control',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Control1']).'</td><td>'.form_dropdown('Control_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Iluminacion</th><td>'.form_dropdown('Iluminacion',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Iluminacion1']).'</td><td>'.form_dropdown('Iluminacion_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Temperatura</th><td>'.form_dropdown('Temperatura',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Temperatura1']).'</td><td>'.form_dropdown('Temperatura_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Humedad</th><td>'.form_dropdown('Humedad',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Humedad1']).'</td><td>'.form_dropdown('Humedad_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';;
					echo '<tr><th>Ruido</th><td>'.form_dropdown('Ruido',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Ruido1']).'</td><td>'.form_dropdown('Ruido_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';
					$area=$this->session->userdata('id_area');
					if($area == 9){
							echo '<tr><th>Arco de Seguridad</th><td>'.form_dropdown('Arco',$estado,set_value(''), 'style="width: 100%;"').'</td><td>'.form_input($inconformes['Arco1']).'</td><td>'.form_dropdown('Arco_r',$recursos,set_value(''), 'style="width: 100%;"').'</td></tr>';
					}
					echo '<tr><th>Acciones a Tomar:</th><td colspan="3">'.form_textarea('Acciones').'</td></tr>';
				echo '</table><br />';
				echo '<div style="width:700px; text-align:center;">'.form_submit($formulario['boton'],'Aceptar').'</div>';
				echo form_close();
                ?>
        </div>
    </div>
