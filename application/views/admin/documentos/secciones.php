<?php
/****************************************************************************************************
*
*	VIEWS/admin/documentos/secciones.php
*
*		Descripci�n:
*			Vista de la lista de todas las secciones
*
*		Fecha de Creaci�n:
*			25/Octubre/2011
*
*		Ultima actualizaci�n:
*			25/Octubre/2011
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
            if( $consulta->num_rows() > 0 ) {
                echo '<table class="tabla" width="980">';
                echo '<thead><tr><th>Nombre de la Secci&oacute;n</th><th>Sistema</th><th width="30">Uso Com&uacute;n</th><th colspan="3" style="text-align:center"></th></tr></thead>';
				$i = 1;
                foreach( $consulta->result() as $row ) :
					if( $i ) {
	                    echo '<tr>';
						$i = 0;
					}
					else {
						echo '<tr class="odd">';
						$i = 1;
					}
                    echo '<td>'.$row->Seccion.'</td>';
                    echo '<td>'.$row->Sistema.'</td>';
					if( $row->Comun )
	                    echo '<td>Si</td>';
					else 
						echo '<td>No</td>';
					echo '<td width="24"><a href="'.base_url().'index.php/admin/documentos/modificar_seccion/'.$row->IdSeccion.'/secciones" onMouseover="tip(\'Modificar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/modificar.png" /></a></td>';
					if( $row->Estado )
						echo '<td width="24"><a onclick="pregunta_cambiar( \'secciones\', '.$row->IdSeccion.', 0, \'&iquest;Deseas eliminar esta secci&oacute;n? al realizar esta acci&oacute;n todos los archivos relacionados ya no seran visibles?\', \'documentos-secciones\')"  onMouseover="tip(\'Eliminar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/eliminar.png" /></a></td>';
					else
						echo '<td width="24"><a onclick="pregunta_cambiar( \'secciones\', '.$row->IdSeccion.', 1, \'&iquest;Deseas activar esta secci&oacute;n?\', \'documentos-secciones\')" onMouseover="tip(\'Activar\')"; onMouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/activar.png" /></a></td>';
                    echo '</tr>';
                endforeach;
                echo '</table>';
            }
            else {
                echo '<table class="tabla" width="980"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento no hay secciones</td></tr></table>';
            }
            ?>
			<script type="text/javascript" charset="utf-8">
                $(document).ready(function() {
                    var dontSort = [];
                    $('#tabla thead th').each( function () {
                        if ( $(this).hasClass( 'no_sort' )) {
                            dontSort.push( { "bSortable": false } );
                        } else {
                            dontSort.push( null );
                        }
                    } );
                    $('#tabla').dataTable({
                        "aoColumns": dontSort,
                        "iDisplayLength": 25,
                        "aLengthMenu": [[-1, 10, 25, 50, 100], [ " - Todos los registros - ", "10 registros", "25 registros", "50 registros", "100 registros"]]
                    });
                } );
            </script>
        </div>
    </div>