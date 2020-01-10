<?php
/****************************************************************************************************
*
*	VIEWS/admin/varios/habilidades.php
*
*		Descripci�n:
*			Vista que muestra los usuarios y sus habiliades
*
*		Fecha de Creaci�n:
*			28/Octubre/2014
*
*		Ultima actualizaci�n:
*			28/Octubre/2014
*
*		Autor:
*			ISC Jesus Carlos Almeda Macias
*			iscalmeda@gmail.com
*
*
****************************************************************************************************/
?>
    <div class="cont_admin">
    	<div class="titulo"><?=$titulo?></div>
        <div class="text">
			<?php
			$area_extras = 'id="area" onfocus="hover(\'area\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			$estado_extras = 'id="estado" onfocus="hover(\'estado\')"  style="width:350px; margin:0 0 0 5px; float:left" onchange="form.submit()"';
			echo form_open();
			echo '
	        	<table class="tabla_form" width="980">
	            	<tr><th width="100">&Aacute;rea</th><td>'.form_dropdown("area",$area_options,$area,$area_extras).'</td></tr>
                    <tr><th width="100">&Aacute;rea</th><td>'.form_dropdown("estado",$estado_options,$estado,$estado_extras).'</td></tr>
	            
	         	</table><br />
         	';
            echo form_close();
            echo '<table class="tabla" id="tabla" width="980">';
            echo '<thead><tr><th></th>';
			echo '<th style="width: auto;">Nombre</th>';
			echo '<th style="width: auto;">Apellido Paterno</th>';
			echo '<th style="width: auto;">Apellido Materno</th>';
            echo '<th style="width: auto;">Puesto</th>';
            echo '<th style="width: auto;"></th>';
            
			echo '<tbody>';

            if(empty($usuarios)){
                echo '<tr><td colspan="4" width="15">Selecciona un Area</td></tr>';     
            }elseif($usuarios -> num_rows() > 0){
                    $i=0;
                    foreach($usuarios -> result() as $row){
                        $i++;
                        echo '<tr><td>'.$i.'</td>';

                        echo '<td>'.$row->Nombre.'</td>';
                        echo '<td>'.$row->Paterno.'</td>';
                        echo '<td>'.$row->Materno.'</td>';
                        echo '<td>'.$row->Puesto.'</td>';
                        
                        if(empty($row->Puesto)){

                            echo "<td>" ;
                            echo "<a href='habilidades_puesto/".$row->IdArea."/".$row->IdUsuario."'>";
                                echo "<img src='".base_url()."includes/img/icons/agregar.png' />";
                            echo "</a>";
                            echo "</td></tr>";
                        }elseif(isset($row->Puesto)){
                            echo '<td>'; 
                        echo "<a href='habilidades_agregar/".$row->IdUsuario."'><img src='".base_url()."includes/img/icons/ver.png' /></a>";
                        echo '</td></tr>';
                        }
                        
                    }
                }else{
                    echo '<tr><td colspan="4" width="15">No hay ningun Usuario</td></tr>';     
                }
            
             
            echo '</tbody>';
            echo '</table>';
            ?>
        </div>
    </div>
