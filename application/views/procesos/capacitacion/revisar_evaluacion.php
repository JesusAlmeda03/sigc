<div class="content">
		<div class="cont">
			<div class="titulo">Resultados de Usuario</div>
            <div class="titulo"><?=$titulo?></div>
            	<?php
            		
            	?>
                <div class="texto">
                    <?php
                    echo $grafica;
                    
                    if( $autoevaluados->num_rows() > 0 ) {                        
            	        echo '<table class="tabla" id="tabla" width="700">';
				        echo '<thead><tr><th width="15" class="no_sort"></th><th></th><th width="15" class="no_sort"></thead>';
				        echo '<tbody>';
            	        foreach( $autoevaluados->result() as $row ) {
					        echo '<tr>';
					        echo '	<th></th>';
					        echo '	<td>'.$row->Habilidad.'</td>';
                            echo '	<td>'.$row->Valor.'</td>';
					        echo '</tr>';
            	        }
				        echo '</tbody>';
				        echo '</table>';
				        echo $sort_tabla;
                        echo '</div>';
                    }				
                    ?>
                    
                    <!--
                   <div class="titulo">Evaluacion al Desempeño</div> 
                   <div class="texto">
                    <?php
                    
                    
                    if( $desempeno->num_rows() > 0 ) {                        
            	        echo '<table class="tabla" id="tabla" width="700">';
				        echo '<thead><tr><th width="15" class="no_sort"></th><th></th><th width="15" class="no_sort"></thead>';
				        echo '<tbody>';
            	        foreach( $desempeno->result() as $row ) {
					        echo '<tr>';
					        echo '	<th></th>';
					        echo '	<td>'.$row->Pregunta.'</td>';
                            echo '	<td>'.$row->Valor.'</td>';
					        echo '</tr>';
            	        }
				        echo '</tbody>';
				        echo '</table>';
				        echo $sort_tabla;
                        echo '</div>';
                    }				
                    ?>
                    <br /><br />
        	        <table><tr><td><a href="<?=base_url()?>index.php/procesos/capacitacion/autoevaluados" onmouseover="tip('Regresa al listado de autoevaluados')" onmouseout="cierra_tip()"><img src="<?=base_url()?>includes/img/icons/back2.png"/></a></td><td valign="middle"><a href="<?=base_url()?>index.php/procesos/capacitacion/autoevaluados" onmouseover="tip('Regresa al listado de autoevaluados')" onmouseout="cierra_tip()" style="letter-spacing:2px; padding-left:5px;">Regresar</a></td></tr></table>
             </div>-->
                
                
</div>