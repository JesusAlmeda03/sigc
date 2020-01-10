<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/buscar.php
*
*		Descripci�n:
*			Vista para buscar documentos
*
*		Fecha de Creaci�n:
*			27/Octubre/2011
*
*		Ultima actualizaci�n:
*			27/Octubre/2011
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
			<script>
            $(document).ready(function(){
                $("#documentos").click(function(){
                    if($(this).val()!=""){
                        var dato=$(this).val();
                        $("#tipo_documento").empty();								
                        $("#imgloader").show();
                        $("#tipo_documento").css("padding","0");
                        $("#imgloader").css("padding-bottom","10px");
                        $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?=base_url()?>index.php/admin/documentos/ajax_secciones",
                            data:"id_seccion="+dato,
                            success:function(msg){
                                $("#tipo_documento").empty().removeAttr("disabled").append(msg);
                                $("#imgloader").hide();										
                            }
                        });
                    }else{
                        $("#dep_cont").empty().attr("disabled","disabled");
                    }
                });
                $("#comun").click(function(){
                    if($(this).val()!=""){
                        var dato=$(this).val();
                        $("#tipo_documento").empty();								
                        $("#imgloader").show();
                        $("#tipo_documento").css("padding","0");
                        $("#imgloader").css("padding-bottom","10px");
                        $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?=base_url()?>index.php/admin/documentos/ajax_secciones",
                            data:"id_seccion="+dato,
                            success:function(msg){
                                $("#tipo_documento").empty().removeAttr("disabled").append(msg);
                                $("#imgloader").hide();										
                            }
                        });
                    }else{
                        $("#dep_cont").empty().attr("disabled","disabled");
                    }
                });
            });
            </script>
			<?php
			$style_are = $style_cod = $style_edi = $style_nom = $style_fec = "";
			$style = 'border:1px solid #C62223;';
			if( $are != "" ) $style_are = $style;
			if( $cod != "" ) $style_cod = $style;
			if( $edi != "" ) $style_edi = $style;
			if( $nom != "" ) $style_nom = $style;
			if( $fec != "" ) $style_fec = $style;
			
            // Area		
            $area_extras = 'id="area" onfocus="hover(\'area\')" style="width:300px; '.$style_are.'"';
            $formulario = array(
                // Boton submit
                'boton' => array (
                    'id'		=> 'aceptar',
                    'name'		=> 'aceptar',
                    'class'		=> 'in_button',
                    'onfocus'	=> 'hover(\'aceptar\')',					
                ),
				// Secci�n
				'seccion' => array (
					'documentos' => array (
						'name'		=> 'seccion_tipo',
						'id'		=> 'documentos',
						'value'		=> '1',
					),
					'comun' => array (
						'name'		=> 'seccion_tipo',
						'id'		=> 'comun',
						'value'		=> '2',
					),
				),
                // C�digo
                'codigo' => array (
                    'name'		=> 'codigo',
                    'id'		=> 'codigo',
                    'value'		=> $cod,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('codigo')",
					'style'		=> $style_cod,
                ),
                // Edici�n
                'edicion' => array (
                    'name'		=> 'edicion',
                    'id'		=> 'edicion',
                    'value'		=> $edi,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('edicion')",
					'style'		=> $style_edi,
                ),
                // Nombre
                'nombre' => array (
                    'name'		=> 'nombre',
                    'id'		=> 'nombre',
                    'value'		=> $nom,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('nombre')",
					'style'		=> $style_nom,
                ),
                // Fecha
                'fecha' => array (
                    'name'		=> 'fecha',
                    'id'		=> 'fecha',
                    'value'		=> $fec,
                    'class'		=> 'in_text',
                    'onfocus'	=> "hover('fecha')",
					'style'		=> $style_fec,
                ),
            );
			echo '<table width="980"><tr><td width="350" valign="top">';
            echo form_open('',array('name' => 'formulario', 'id' => 'formulario'));
            echo '<table class="tabla_form" width="340">';
            echo '<tr><th class="text_form" width="50">&Aacute;rea: </th>';
            echo '<td>'.form_dropdown('area',$area_options,$are,$area_extras).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Secci&oacute;n: </th>';
            echo '<td>';
			echo '<img src="'.base_url().'includes/img/ajax-loader.gif" style="display:none;" alt="Cargando" id="imgloader"/>';
			echo '<div id="tipo_documento">';
			echo form_radio($formulario['seccion']['documentos'])." Documentos<br />";
			echo form_radio($formulario['seccion']['comun']).' Documentos de Uso Com&uacute;n<br />';			
			echo '</div>';
			echo '</td></tr>';			
            echo '<tr><th class="text_form" width="50">C&oacute;digo: </th>';
            echo '<td>'.form_input($formulario['codigo']).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Edici&oacute;n: </th>';
            echo '<td>'.form_input($formulario['edicion']).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Nombre: </th>';
            echo '<td>'.form_input($formulario['nombre']).'</td></tr>';
            echo '<tr><th class="text_form" width="50">Fecha: </th>';
            echo '<td>'.form_input($formulario['fecha']).'</td></tr>';			
            echo '</table><br />';
            echo '<div style="width:350px; text-align:center;">'.form_submit($formulario['boton'],'Buscar').'<input type="button" name="limpiar" value="Limpiar" id="limpiar" class="in_button" onfocus="hover(\'limpiar\')" style="margin-left:10px" onclick="location.href=\''.base_url().'index.php/admin/documentos/buscar\'"  /></div>';
            echo form_close();
			echo '</td>';
			echo '<td valign="top">';
			if( $busqueda ) {
				if( $consulta->num_rows() > 0 ) {
					echo '<table class="tabla" id="tabla" width="585">';
					echo '<thead><tr>';
					if( $are == 'all')
						echo '<th>&Aacute;rea</th>';
					echo '<th>C&oacute;digo</th><th>Edici&oacute;n</th><th>Nombre</th><th>Fecha</th><th class="no_sort"></th><th class="no_sort"></th></tr></thead><tbody>';
					foreach( $consulta->result() as $row ) {
						echo '<tr>';
						if( $are == 'all' )
							echo '<td>'.$row->Area.'</td>';
						echo '<td>'.$row->Codigo.'</td><td>'.$row->Edicion.'</td><td>'.$row->Nombre.'</td><td>'.$row->Fecha.'</td>';
						echo '<td width="24"><a href="'.base_url().'index.php/admin/documentos/modificar_documento/'.$row->IdDocumento.'/buscar" onMouseover="tip(\'Modificar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
						echo '<td width="24"><a onclick="pregunta_cambiar( \'documentos\', '.$row->IdDocumento.', 0, \'&iquest;Deseas eliminar este documento?\', \'documentos-buscar\')" onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
						echo '</tr>';
					}
					echo '</tbody></table>';
					echo $sort_tabla;
				}
				else {
                	echo '<table class="tabla" width="585"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>No se encontraron coincidencias con la b&uacute;squeda</td></tr></table>';
				}
			}
			echo '</td></tr></table>';
            ?>
        </div>
    </div>