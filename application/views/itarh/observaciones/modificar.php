<?php
/****************************************************************************************************
*
*	VIEWS/itarh/usuarios/anadir.php
*
*		Descripción:
*			Vista para añadir usuarios
*
*		Fecha de Creación:
*			09/Octubre/2011
*
*		Ultima actualización:
*			09/Octubre/2011
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
            // Quincena
            $quincena_options = array( 'Primera' => 'Primera', 'Segunda' => 'Segunda' );
            $quincena_extras = 'id="quincena" onfocus="hover(\'quincena\')" style="width:90px; float:left"';
			
			// Mes
            $mes_options = array(
            	'Enero'		 => 'Enero',
            	'Febrero'	 => 'Febrero',
            	'Marzo' 	 => 'Marzo',
            	'Abril'		 => 'Abril',
            	'Mayo'		 => 'Enero',
            	'Junio'		 => 'Junio',
            	'Julio'		 => 'Julio',
            	'Agosto'	 => 'Agosto',
            	'Septiembre' => 'Septiembre',
            	'Octubre'	 => 'Octubre',
            	'Noviembre'	 => 'Noviembre',
            	'Diciembre'	 => 'Diciembre'
			);
            $mes_extras = 'id="mes" onfocus="hover(\'mes\')"  style="width:110px; margin: 0 10px; float:left"';
			
			// Ano
			$ano_options = array();
			for( $i = date('Y')-1; $i < date('Y')+4; $i++ ) {
				$ano_options[$i] = $i;
			}
            $ano_extras = 'id="ano" onfocus="hover(\'ano\')"  style="width:65px; float:left"';
			
			// Empleado
			$empleado_options = array( 'Administrativo' => 'Administrativo', 'Acad&eacute;mico' => 'Acad&eacute;mico', 'Confianza' => 'Confianza' );
            $empleado_extras = 'id="empleado" onfocus="hover(\'empleado\')" style="width:200px"';
			
			// Permanencia
			$permanencia_options = array( 'Base' => 'Base', 'Temporal' => 'Temporal' );
            $permanencia_extras = 'id="area" onfocus="hover(\'area\')" style="width:200px"';
			
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
                    'onfocus'	=> 'hover(\'cancelar\')',
                    'style'		=> 'width:120px; height:45px; font-size:16px; letter-spacing:3px; margin-left:10px',
                    'onclick'	=> 'location=\''.base_url().'index.php/itarh/observaciones/listado/'.$enlace.'\'',
                ),
                // Matricula
                'matricula' => array (
                    'name'		=> 'matricula',
                    'id'		=> 'matricula',
                    'value'		=> $matricula,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('matricula')",
                    'style'		=> 'width:80px'
                ),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> $nombre,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
                ),
                // Unidad
                'unidad' => array (
                    'name'		=> 'unidad',
                    'id'		=> 'unidad',
                    'value'		=> $unidad,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('unidad')",
                ),
                // Contrato
                'contrato' => array (
                    'name'		=> 'contrato',
                    'id'		=> 'contrato',
                    'value'		=> $contrato,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('contrato')",
                ),
                // Sistema
                'sistema' => array (
                    'name'		=> 'sistema',
                    'id'		=> 'sistema',
                    'value'		=> $sistema,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('sistema')",
                ),
                // Contraloria
                'contraloria' => array (
                    'name'		=> 'contraloria',
                    'id'		=> 'contraloria',
                    'value'		=> $contraloria,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('contraloria')",
                ),
                // Observacion
                'observacion' => array (
                    'name'		=> 'observacion',
                    'id'		=> 'observacion',
                    'value'		=> $observacion,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('observacion')",
                ),
                // Accion
                'accion' => array (
                    'name'		=> 'accion',
                    'id'		=> 'accion',
                    'value'		=> $accion,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('accion')",
                ),
            );
            echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
	        echo '<table class="tabla_form" width="980">';
			if( $id_usuario == $this->session->userdata( 'id_usuario' ) ) {
	            echo '<tr><th class="text_form" width="150">Quincena: </th>';
	            echo '<td>';
				echo form_dropdown('quincena',$quincena_options,$quincena,$quincena_extras);
	            echo form_dropdown('mes',$mes_options,$mes,$mes_extras);
				echo form_dropdown('ano',$ano_options,$ano,$ano_extras);
	            echo '</td></tr>';
	            echo '<tr><th class="text_form">Matricula: </th>';
	            echo '<td>'.form_input($formulario['matricula']).'</td></tr>';
	            echo '<tr><th class="text_form">Nombre: </th>';
	            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
				echo '<tr><th class="text_form">Unidad Responsable: </th>';
	            echo '<td>'.form_input($formulario['unidad']).'</td></tr>';
	            echo '<tr><th class="text_form">Tipo de Empleado: </th>';
	            echo '<td>'.form_dropdown('empleado',$empleado_options,$empleado,$empleado_extras).'</td></tr>';
	            echo '<tr><th class="text_form">Permanencia: </th>';
	            echo '<td>'.form_dropdown('permanencia',$permanencia_options,$permanencia,$permanencia_extras).'</td></tr>';
	            echo '<tr><th class="text_form">Horas Contrato: </th>';
	            echo '<td>'.form_input($formulario['contrato']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top">Sistema: </th>';
	            echo '<td>'.form_input($formulario['sistema']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top">Contraloria: </th>';
	            echo '<td>'.form_input($formulario['contraloria']).'</td></tr>';
				echo '<tr><th class="text_form" valign="top">Observaci&oacute;n: </th>';
	            echo '<td>'.form_textarea($formulario['observacion']).'</td></tr>';
            }
			if( $estado == 1 ) {
	            echo '<tr><th class="text_form" valign="top">Acci&oacute;n Correctiva: </th>';
	            echo '<td>'.form_textarea($formulario['accion']).'</td></tr>';
            }
            echo '</table><br />';
            echo '</table><br />';
            echo '<div style="width:980px; text-align:center;">'.form_submit($formulario['boton'],'Modificar').form_button($formulario['boton_cancelar'],'Cancelar').'</div>';
            echo form_close();
            ?>
        </div>
    </div>