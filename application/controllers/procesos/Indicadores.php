<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/indicadores.php
*
*		Descripción:
*			Indicadores de proceso
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			14/Noviembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicadores extends CI_Controller {
	
/** Atributos **/

/** Propiedades **/	
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
		// si no se ha identificado correctamente
		if( !$this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
		else {
			// Modelo
			$this->load->model('procesos/indicadores_model','',TRUE);
		}
	}
	
/** Funciones **/
	//
	// index(): Muestra los indicadores del área
	//
	function index() {		
		// variables necesarias para la página
		$datos['titulo'] = 'Indicadores';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// obtiene los indicadores del área
		$datos['consulta'] = $this->indicadores_model->get_indicadores();
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/indicadores/listado',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// grafica( $id, $ano ): Analiza que tipo de grafica mostrar para el inidcador
	//
	function grafica( $id, $ano ) {
		// regresa si no trae las variables
		if( $this->uri->segment(5) === false ) {
			redirect( "procesos/indicadores" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Gr&aacute;fica del Indicador';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['ano'] = $ano;
		$grafica = true;

		// datos del indicador
		$indicador = $this->indicadores_model->get_indicador( $id );
		$datos['indicador'] = $indicador;
		if( $indicador->num_rows() > 0 ) { 
			foreach( $indicador->result() as $row ) {
				if( $row->Tipo == 'DIA' ) {
					$tipo = ' dias';
				}
				else {
					$tipo = '%';
				}
			}
		}
						
		// obtiene las mediciones del indicador
		$mediciones = $this->indicadores_model->get_mediciones( $id );
		$datos['mediciones'] = $mediciones;
		$mediciones_indicador = '';
		if( $mediciones->num_rows() > 0 ) {
			$alto = 150 + ( $mediciones->num_rows() * 40 );
			$alto_grafica = $alto - 100;
			$ano_array = array();
			$i = 0;
			foreach( $mediciones->result() as $row ) {							
				$ano = substr($row->Fecha,0,4);
				$ano_array[$i] = $ano;
				$i++;
				if( $ano == $datos['ano'] || $datos['ano'] == 'todos' ) {
					$num = $row->Medicion;
					switch( substr($row->Fecha,5,2) ) {
						case "01" : $mes = "Ene"; break;
						case "02" : $mes = "Feb"; break;
						case "03" : $mes = "Mar"; break;
						case "04" : $mes = "Abr"; break;
						case "05" : $mes = "May"; break;
						case "06" : $mes = "Jun"; break;
						case "07" : $mes = "Jul"; break;
						case "08" : $mes = "Ago"; break;
						case "09" : $mes = "Sep"; break;
						case "10" : $mes = "Oct"; break;
						case "11" : $mes = "Nov"; break;
						case "12" : $mes = "Dic"; break;
					}
					$mediciones_indicador .= '["'.$mes.' '.$ano.'", '.$num.'],';
				}
			}
			$mediciones_indicador = substr($mediciones_indicador,0,-1);
			
			// años
			$anos  = '<br /><table class="tabla_form" style="border-collapse:separate"><tr><th>Elige el a&ntilde;o:</th>';
			if( $datos['ano'] == 'todos' ) {
				$anos .= '<td style="background-color:#CC0000;"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/todos" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">Todos</a></td>';
				$ano_tag = 'Todos los años'; 
			}
			else {
				$anos .= '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/todos" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">Todos</a></td>';
				$ano_tag = $datos['ano'];
			}
			$ano_temp = 0;
			for( $i = 0; $i < sizeof($ano_array); $i++) {
				if( $ano_temp != $ano_array[$i] ) {
					if( $datos['ano'] == $ano_array[$i] )
						$anos .= '<td style="background-color:#CC0000;"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/'.$ano_array[$i].'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">'.$ano_array[$i].'</a></td>';
					else
						$anos .= '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/'.$ano_array[$i].'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">'.$ano_array[$i].'</a></td>';
					$ano_temp = $ano_array[$i];
				}
			}
			$anos .= '</tr></table>';
			$datos['anos'] = $anos;
		}
		else {
			$grafica = false;
			$ano = 0;
			$alto = 0;
			$alto_grafica = 0;
			$datos['anos'] = '';
			$ano_tag = '';
		}
			
		// gráfica
		$datos['grafica'] = '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">			
			  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
			  google.setOnLoadCallback(drawChart);			  
			  function drawChart() {		
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "Fecha");
			  data.addColumn("number", "Avance");
			  data.addRows(['.$mediciones_indicador.']);
			  var options = {
				  width: 700,
				  height: '.$alto.',
				  colors: ["#CC0000"],
				  fontSize: "12",
				  fontName: "Tahoma",
				  legend: "none",
				  vAxis: { title: "Mediciones '.$ano_tag.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: 100
							 }
						  },
				  chartArea: { top: 30, left: 100, width: 550, height: '.$alto_grafica.' },
				  tooltipTextStyle: { fontSize: "16" },
			  };
			  
			  var formatter = new google.visualization.NumberFormat({suffix: "'.$tipo.'",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column
  
			  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div>
		';
		if( !$grafica ) {
			$datos['grafica'] = '<br /><br /><table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento este indicador no tiene mediciones</td></tr></table>';
		}
			
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/indicadores/grafica',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		// Guarda una nueva medición
		if( $_POST ) {
			if( $this->indicadores_model->inserta_medicion( $id ) ) {
				$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
				$datos['mensaje'] = "La medici&oacute;n se ha guardado correctamente";
				$datos['enlace'] = "procesos/indicadores/grafica/".$id."/todos";
				$this->load->view('mensajes/ok_redirec',$datos);
			}
		}
	}

function imprimir( $id, $ano ) {
		// regresa si no trae las variables
		if( $this->uri->segment(5) === false ) {
			redirect( "procesos/indicadores" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Gr&aacute;fica del Indicador';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['ano'] = $ano;
		$grafica = true;

		// datos del indicador
		$indicador = $this->indicadores_model->get_indicador( $id );
		$datos['indicador'] = $indicador;
		if( $indicador->num_rows() > 0 ) { 
			foreach( $indicador->result() as $row ) {
				if( $row->Tipo == 'DIA' ) {
					$tipo = ' dias';
				}
				else {
					$tipo = '%';
				}
			}
		}
						
		// obtiene las mediciones del indicador
		$mediciones = $this->indicadores_model->get_mediciones( $id );
		$datos['mediciones'] = $mediciones;
		$mediciones_indicador = '';
		if( $mediciones->num_rows() > 0 ) {
			$alto = 150 + ( $mediciones->num_rows() * 40 );
			$alto_grafica = $alto - 100;
			$ano_array = array();
			$i = 0;
			foreach( $mediciones->result() as $row ) {							
				$ano = substr($row->Fecha,0,4);
				$ano_array[$i] = $ano;
				$i++;
				if( $ano == $datos['ano'] || $datos['ano'] == 'todos' ) {
					$num = $row->Medicion;
					switch( substr($row->Fecha,5,2) ) {
						case "01" : $mes = "Ene"; break;
						case "02" : $mes = "Feb"; break;
						case "03" : $mes = "Mar"; break;
						case "04" : $mes = "Abr"; break;
						case "05" : $mes = "May"; break;
						case "06" : $mes = "Jun"; break;
						case "07" : $mes = "Jul"; break;
						case "08" : $mes = "Ago"; break;
						case "09" : $mes = "Sep"; break;
						case "10" : $mes = "Oct"; break;
						case "11" : $mes = "Nov"; break;
						case "12" : $mes = "Dic"; break;
					}
					$mediciones_indicador .= '["'.$mes.' '.$ano.'", '.$num.'],';
				}
			}
			$mediciones_indicador = substr($mediciones_indicador,0,-1);
			
			// años
			$anos  = '<br /><table class="tabla_form" style="border-collapse:separate"><tr><th>Elige el a&ntilde;o:</th>';
			if( $datos['ano'] == 'todos' ) {
				$anos .= '<td style="background-color:#CC0000;"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/todos" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">Todos</a></td>';
				$ano_tag = 'Todos los años'; 
			}
			else {
				$anos .= '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/todos" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">Todos</a></td>';
				$ano_tag = $datos['ano'];
			}
			$ano_temp = 0;
			for( $i = 0; $i < sizeof($ano_array); $i++) {
				if( $ano_temp != $ano_array[$i] ) {
					if( $datos['ano'] == $ano_array[$i] )
						$anos .= '<td style="background-color:#CC0000;"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/'.$ano_array[$i].'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">'.$ano_array[$i].'</a></td>';
					else
						$anos .= '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/'.$ano_array[$i].'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">'.$ano_array[$i].'</a></td>';
					$ano_temp = $ano_array[$i];
				}
			}
			$anos .= '</tr></table>';
			$datos['anos'] = $anos;
		}
		else {
			$grafica = false;
			$ano = 0;
			$alto = 0;
			$alto_grafica = 0;
			$datos['anos'] = '';
			$ano_tag = '';
		}
			
		// gráfica
		$datos['grafica'] = '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">			
			  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
			  google.setOnLoadCallback(drawChart);			  
			  function drawChart() {		
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "Fecha");
			  data.addColumn("number", "Avance");
			  data.addRows(['.$mediciones_indicador.']);
			  var options = {
				  width: 900,
				  height: '.$alto.',
				  colors: ["#CC0000"],
				  fontSize: "12",
				  fontName: "Tahoma",
				  legend: "none",
				  vAxis: { title: "Mediciones '.$ano_tag.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: 100
							 }
						  },
				  chartArea: { top: 30, left: 100, width: 800, height: '.$alto_grafica.' },
				  tooltipTextStyle: { fontSize: "16" },
			  };
			  
			  var formatter = new google.visualization.NumberFormat({suffix: "'.$tipo.'",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column
  
			  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div>
		';
		if( !$grafica ) {
			$datos['grafica'] = '<br /><br /><table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento este indicador no tiene mediciones</td></tr></table>';
		}
			
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		
		$this->load->view('procesos/indicadores/imprimir',$datos);
		
		
		
		// Guarda una nueva medición
		if( $_POST ) {
			if( $this->indicadores_model->inserta_medicion( $id ) ) {
				$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
				$datos['mensaje'] = "La medici&oacute;n se ha guardado correctamente";
				$datos['enlace'] = "procesos/indicadores/grafica/".$id."/todos";
				$this->load->view('mensajes/ok_redirec',$datos);
			}
		}
	}

	
	//
	// grafica_especiales( $id, $ano ): Analiza que tipo de grafica mostrar para el inidcador
	//
	function grafica_especiales( $id, $fecha_grafica ) {
		// regresa si no trae las variables
		if( $this->uri->segment(5) === false ) {
			redirect( "procesos/indicadores" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Gr&aacute;fica del Indicadores';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['fecha_grafica'] = $fecha_grafica;
		$datos['parciales'] = true;
		$datos['id'] = $id;
		$grafica = true;

		// datos del indicador
		$indicador = $this->indicadores_model->get_indicador( $id );
		$datos['indicador'] = $indicador;
		if( $indicador->num_rows() > 0 ) { 
			foreach( $indicador->result() as $row ) {
				if( $row->Tipo == 'DIA' ) {
					$tipo = ' dias';
				}
				else {
					$tipo = '%';
				}
			}
		}
		else {
			redirect( "procesos/indicadores" );
		}

		$etiquetas = array(
			'185' => array( 'Observado', 'Solventado' ),
			'186' => array( 'Observado', 'Solventado' ),
			'107' => array( 'No. Lamparas Instaladas', 'No. Lamparas Reemplazadas' ),
			'146' => array( 'Observado', 'Solventado' ),
			'147' => array( 'Observado', 'Atendido' ),
			'148' => array( 'Observado', 'Solventado' ),
			'149' => array( 'Observado', 'Solventado' ),
			'150' => array( 'URES por Auditar', 'URES Auditadas' ),
			'152' => array( 'Bienes Localizados', 'Bienes Faltantes' ),
			'154' => array( 'Meta', 'Medicion Mensual' ),
			'155' => array( 'Porcentaje de Uso de Sistema' ),
			'156' => array( 'Solicitado', 'Revisado' ),
			'182' => array( 'Total URES', 'URES Revisadas' ),
		);

		$i = 0;
		$etiquetas_string = '';
		$etiquetas_array = array();
		foreach ($etiquetas as $ids =>$indicadores ) {
			foreach ($indicadores as $k => $texto ) {
				if( $id == $ids ) {
					$etiquetas_string .= 'data.addColumn("number", "'.$texto.'");';
					$etiquetas_array[$i] = $texto;
					$i++;
				}
			}
		}
		$datos['etiquetas_array'] = $etiquetas_array;
		
		$mediciones_group = $this->db->group_by('Fecha')->order_by('Fecha','DESC')->get_where('pa_indicadores_medicion_especiales',array('IdIndicador' => $id));
		$datos['mediciones_group'] = $mediciones_group;
		
		$mediciones = $this->db->order_by('Fecha','DESC')->get_where('pa_indicadores_medicion_especiales',array('IdIndicador' => $id));
		$datos['mediciones'] = $mediciones;
		
		// gráfica
		switch( $id ) {
			case '146' : $tipo_indicador = 'A'; break;
			case '150' : $tipo_indicador = 'C'; break;
			case '154' : $tipo_indicador = 'D'; break;
			case '155' : $tipo_indicador = 'E'; break;
			case '107' : $tipo_indicador = 'F'; break;
			default : $tipo_indicador = 'B'; break;
		}
		
		/**88**/
		// genera la grafica segun el tipo de indicador
		$mediciones_indicador = '';
		switch( $tipo_indicador ) {
			case "A" :
				if( $mediciones->num_rows() > 0 ) {			
					$alto = 5 + ( $mediciones->num_rows() * 50 );
					$alto_grafica = $alto;
					$num_obs = 0;
					$num_sol = 0;
					foreach( $mediciones->result() as $row ) {
						// establece el valor de la Fecha del grafico a mostrar, si no trae nada
						// le asigna la primera fecha, si viene de post así deja la variable
						if( $fecha_grafica == 'todos' ) {
							$fecha_grafica = $row->Fecha;
							$datos['fecha_grafica'] = $row->Fecha;
						} 				
						
						/*if( $row->Fecha == $fecha_grafica ) {
							$num_obs = $row->MedUno;
							$num_sol = $row->MedDos;
							$ano = substr($row->Fecha,0,4);
							$concepto = $row->Concepto;
							$mediciones_indicador .= '["'.$concepto.'", '.$num_obs.', '.$num_sol.'],';					
						}*/
						if( $row->Fecha == $fecha_grafica ) {
							$num_obs = $num_obs + $row->MedUno;
							$num_sol = $num_sol + $row->MedDos;
							$ano = substr($row->Fecha,0,4);
							$concepto = $row->Concepto;									
						}
					}			
					$datos['fecha_grafica'] = $fecha_grafica;
					switch( substr($fecha_grafica,5,2) ) {
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
					$fecha_grafica = substr($fecha_grafica,8,2)." / ".$mes." / ".substr($fecha_grafica,0,4);
					//$mediciones_indicador = substr($mediciones_indicador,0,-1);
					$mediciones_indicador = '["Total",'.$num_obs.', '.$num_sol.']';			
					if( $num_obs > $num_sol ) {				
						$max_height = $num_obs + 10;
					}
					else {
						$max_height = $num_sol + 10;
					} 
					if( $max_height < 100 ) {
						$max_height = 100;
					}
				}
				else {
					$grafica = false;
					$ano = 0;
					$alto = 0;
					$alto_grafica = 0;
					$max_height = 0;
				}
				
				// gráfica
				$grafica = '
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">			
					  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
					  google.setOnLoadCallback(drawChart);			  
					  function drawChart() {		
					  var data = new google.visualization.DataTable();
					  data.addColumn("string", "Fecha");
					  '.$etiquetas_string.'
					  data.addRows(['.$mediciones_indicador.']);			  
					  var options = {
						  width: 580,
						  height: 400,
						  colors: ["#33A1DE","#C62223"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "'.$fecha_grafica.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: '.$max_height.'
							 }
						  },
						  chartArea: { top: 30, left: 100, width: 380, height: 300 },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1); // Apply formatter to second column
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
					  chart.draw(data, options);
					}
					</script>
					<div id="chart_div"></div>
				';
				break;
				
			case "B" :
				if( $mediciones->num_rows() > 0 ) {			
					$alto = 5 + ( $mediciones->num_rows() * 50 );
					$alto_grafica = $alto;
					$num_obs = 0;
					$num_sol = 0;
					foreach( $mediciones->result() as $row ) {
						// establece el valor de la Fecha del grafico a mostrar, si no trae nada
						// le asigna la primera fecha, si viene de post así deja la variable
						if( $fecha_grafica == 'todos' ) {
							$fecha_grafica = $row->Fecha;
							$datos['fecha_grafica'] = $row->Fecha;
						} 				
						
						if( $row->Fecha == $fecha_grafica ) {
							$num_obs = $num_obs + $row->MedUno;
							$num_sol = $num_sol + $row->MedDos;
							$ano = substr($row->Fecha,0,4);
							$concepto = $row->Concepto;									
						}
					}
					
					// se generan los porcentjes en base a lo observado y lo solventado  
					$num_sol = round( ( ( $num_sol * 100 ) / $num_obs ) * 100 ) / 100; // regla de 3 para sacar el porcentaje en base al 100
					$num_obs = 100; // lo observado siempre va a ser el 100%
					
					$datos['fecha_grafica'] = $fecha_grafica;
					switch( substr($fecha_grafica,5,2) ) {
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
					$fecha_grafica = substr($fecha_grafica,8,2)." / ".$mes." / ".substr($fecha_grafica,0,4);
					//$mediciones_indicador = substr($mediciones_indicador,0,-1);
					$mediciones_indicador = '["Total",'.$num_obs.', '.$num_sol.']';			
					if( $num_obs > $num_sol ) {				
						$max_height = $num_obs + 10;
					}
					else {
						$max_height = $num_sol + 10;
					} 
					if( $max_height < 100 ) {
						$max_height = 100;
					}
				}
				else {
					$grafica = false;
					$ano = 0;
					$alto = 0;
					$alto_grafica = 0;
					$max_height = 0;
				}
				
				// gráfica
				$grafica = '
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">			
					  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
					  google.setOnLoadCallback(drawChart);			  
					  function drawChart() {		
					  var data = new google.visualization.DataTable();
					  data.addColumn("string", "Fecha");
					  '.$etiquetas_string.'
					  data.addRows(['.$mediciones_indicador.']);			  
					  var options = {
						  width: 580,
						  height: 400,
						  colors: ["#33A1DE","#C62223"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "'.$fecha_grafica.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: '.$max_height.'
							 }
						  },
						  chartArea: { top: 30, left: 100, width: 380, height: 300 },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1);
					  formatter.format(data, 2);
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
					  chart.draw(data, options);
					}
					</script>
					<div id="chart_div"></div>
				';
				break;
				
			case "C" :
				if( $mediciones->num_rows() > 0 ) {			
					$alto = 5 + ( $mediciones->num_rows() * 50 );
					$alto_grafica = $alto;
					$num_obs = 0;
					$num_sol = 0;
					foreach( $mediciones->result() as $row ) {
						// establece el valor de la Fecha del grafico a mostrar, si no trae nada
						// le asigna la primera fecha, si viene de post así deja la variable
						if( $fecha_grafica == 'todos' ) {
							$fecha_grafica = $row->Fecha;
							$datos['fecha_grafica'] = $row->Fecha;
						} 				
						
						if( $row->Fecha == $fecha_grafica ) {
							$observado_total = $row->MedUno + $row->MedDos;
							if( $observado_total ) {
								$num_obs = round( ( ( $row->MedUno * 100 ) / $observado_total ) * 100 ) / 100;
								$num_sol = round( ( ( $row->MedDos * 100 ) / $observado_total ) * 100 ) / 100;
							}
							else {
								$num_obs = 0;
								$num_sol = 0;
							}
							$ano = substr($row->Fecha,0,4);
							//$concepto = $row->Concepto;
							$mediciones_indicador .= '["'.$row->Concepto.'",'.$num_obs.', '.$num_sol.'],';
						}
					}
					$mediciones_indicador = substr($mediciones_indicador,0,-1);
					
					$datos['fecha_grafica'] = $fecha_grafica;
					switch( substr($fecha_grafica,5,2) ) {
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
					$fecha_grafica = substr($fecha_grafica,8,2)." / ".$mes." / ".substr($fecha_grafica,0,4);
					//$mediciones_indicador = substr($mediciones_indicador,0,-1);
//					$mediciones_indicador = '["Total",'.$num_obs.', '.$num_sol.']';			
					if( $num_obs > $num_sol ) {				
						$max_height = $num_obs + 10;
					}
					else {
						$max_height = $num_sol + 10;
					} 
					if( $max_height < 100 ) {
						$max_height = 100;
					}
				}
				else {
					$grafica = false;
					$ano = 0;
					$alto = 0;
					$alto_grafica = 0;
					$max_height = 0;
				}		
				
				// gráfica
				$grafica = '
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">			
					  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
					  google.setOnLoadCallback(drawChart);			  
					  function drawChart() {		
					  var data = new google.visualization.DataTable();
					  data.addColumn("string", "Fecha");
					  '.$etiquetas_string.'
					  data.addRows(['.$mediciones_indicador.']);			  
					  var options = {
						  width: 580,
						  height: 400,
						  colors: ["#33A1DE","#C62223"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "'.$fecha_grafica.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: '.$max_height.'
							 }
						  },
						  chartArea: { top: 30, left: 100, width: 380, height: 300 },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1);
					  formatter.format(data, 2);
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
					  chart.draw(data, options);
					}
					</script>
					<div id="chart_div"></div>
				';
				break;
				
			case "D" :
				if( $mediciones->num_rows() > 0 ) {			
					$alto = 5 + ( $mediciones->num_rows() * 50 );
					$alto_grafica = $alto;
					$num_obs = 0;
					$num_sol = 0;
					foreach( $mediciones->result() as $row ) {
						// establece el valor de la Fecha del grafico a mostrar, si no trae nada
						// le asigna la primera fecha, si viene de post así deja la variable
						if( $fecha_grafica == 'todos' ) {
							$fecha_grafica = $row->Fecha;
							$datos['fecha_grafica'] = $row->Fecha;
						} 				
						
						if( $row->Fecha == $fecha_grafica ) {
							$num_obs = $row->MedUno;
							if( $row->MedDos ) {
								$num_sol = round( ( ( $row->MedUno * 100 ) / $row->MedDos ) * 100 ) / 100;
							}
							else {
								$num_sol = 0;
							}
							$num_obs = 100;
							$ano = substr($row->Fecha,0,4);
							//$concepto = $row->Concepto;
							$mediciones_indicador .= '["'.$row->Concepto.'",'.$num_obs.', '.$num_sol.'],';
						}
					}
					$mediciones_indicador = substr($mediciones_indicador,0,-1);
					
					$datos['fecha_grafica'] = $fecha_grafica;
					switch( substr($fecha_grafica,5,2) ) {
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
					$fecha_grafica = substr($fecha_grafica,8,2)." / ".$mes." / ".substr($fecha_grafica,0,4);
					//$mediciones_indicador = substr($mediciones_indicador,0,-1);
//					$mediciones_indicador = '["Total",'.$num_obs.', '.$num_sol.']';			
					if( $num_obs > $num_sol ) {				
						$max_height = $num_obs + 10;
					}
					else {
						$max_height = $num_sol + 10;
					} 
					if( $max_height < 100 ) {
						$max_height = 100;
					}
				}
				else {
					$grafica = false;
					$ano = 0;
					$alto = 0;
					$alto_grafica = 0;
					$max_height = 0;
				}			

				// gráfica
				$grafica = '
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">			
					  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
					  google.setOnLoadCallback(drawChart);			  
					  function drawChart() {		
					  var data = new google.visualization.DataTable();
					  data.addColumn("string", "Fecha");
					  '.$etiquetas_string.'
					  data.addRows(['.$mediciones_indicador.']);			  
					  var options = {
						  width: 580,
						  height: 400,
						  colors: ["#33A1DE","#C62223"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "'.$fecha_grafica.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: '.$max_height.'
							 }
						  },
						  chartArea: { top: 30, left: 100, width: 380, height: 300 },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1);
					  formatter.format(data, 2);
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
					  chart.draw(data, options);
					}
					</script>
					<div id="chart_div"></div>
				';				
				break;
				
			case "E" :
				if( $mediciones->num_rows() > 0 ) {			
					$alto = 5 + ( $mediciones->num_rows() * 50 );
					$alto_grafica = $alto;
					$num_obs = 0;
					$num_sol = 0;
					$num_items = 0;
					$num_total = 0;
					foreach( $mediciones->result() as $row ) {
						// establece el valor de la Fecha del grafico a mostrar, si no trae nada
						// le asigna la primera fecha, si viene de post así deja la variable
						if( $fecha_grafica == 'todos' ) {
							$fecha_grafica = $row->Fecha;
							$datos['fecha_grafica'] = $row->Fecha;
						} 				
						
						if( $row->Fecha == $fecha_grafica ) {
							$num_items++;
							$num_total = $num_total + $row->MedUno;
							$ano = substr($row->Fecha,0,4);						
						}
					}
					$num_obs  = round( ( $num_total / $num_items )  * 100 ) / 100;
					$mediciones_indicador .= '["Promedio",'.$num_obs.']';
					
					$datos['fecha_grafica'] = $fecha_grafica;
					switch( substr($fecha_grafica,5,2) ) {
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
					$fecha_grafica = substr($fecha_grafica,8,2)." / ".$mes." / ".substr($fecha_grafica,0,4);
					//$mediciones_indicador = substr($mediciones_indicador,0,-1);
//					$mediciones_indicador = '["Total",'.$num_obs.', '.$num_sol.']';			
					if( $num_obs > $num_sol ) {				
						$max_height = $num_obs + 10;
					}
					else {
						$max_height = $num_sol + 10;
					} 
					if( $max_height < 100 ) {
						$max_height = 100;
					}
				}
				else {
					$grafica = false;
					$ano = 0;
					$alto = 0;
					$alto_grafica = 0;
					$max_height = 0;
				}			

				// gráfica
				$grafica = '
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">			
					  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
					  google.setOnLoadCallback(drawChart);			  
					  function drawChart() {		
					  var data = new google.visualization.DataTable();
					  data.addColumn("string", "Fecha");
					  data.addColumn("number", "'.$datos['med_uno'].'");
					  data.addRows(['.$mediciones_indicador.']);			  
					  var options = {
						  width: 580,
						  height: 400,
						  colors: ["#33A1DE","#C62223"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "'.$fecha_grafica.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: '.$max_height.'
							 }
						  },
						  chartArea: { top: 30, left: 100, width: 380, height: 300 },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1);
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
					  chart.draw(data, options);
					}
					</script>
					<div id="chart_div"></div>
				';				
				break;
				
			// indicador de contraloria
			case "F" :
				if( $mediciones->num_rows() > 0 ) {			
					$alto = 5 + ( $mediciones->num_rows() * 50 );
					$alto_grafica = $alto;
					$num_obs = 0;
					$num_sol = 0;
					foreach( $mediciones->result() as $row ) {
						// establece el valor de la Fecha del grafico a mostrar, si no trae nada
						// le asigna la primera fecha, si viene de post así deja la variable
						if( $fecha_grafica == 'todos' ) {
							$fecha_grafica = $row->Fecha;
							$datos['fecha_grafica'] = $row->Fecha;
						} 				
						
						/*if( $row->Fecha == $fecha_grafica ) {
							$num_obs = $row->MedUno;
							$num_sol = $row->MedDos;
							$ano = substr($row->Fecha,0,4);
							$concepto = $row->Concepto;
							$mediciones_indicador .= '["'.$concepto.'", '.$num_obs.', '.$num_sol.'],';					
						}*/
						if( $row->Fecha == $fecha_grafica ) {
							$reemplazo = round( ( ( ( $row->MedDos * 100 ) / $row->MedUno ) * 100 ) / 100 );
							$ano = substr($row->Fecha,0,4);
							$concepto = $row->Concepto;
							$mediciones_indicador .= '["'.$concepto.'",'.$reemplazo.'],';
						}
					}			
					$datos['fecha_grafica'] = $fecha_grafica;
					switch( substr($fecha_grafica,5,2) ) {
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
					$fecha_grafica = substr($fecha_grafica,8,2)." / ".$mes." / ".substr($fecha_grafica,0,4);
					//$mediciones_indicador = substr($mediciones_indicador,0,-1);							
					if( $num_obs > $num_sol ) {				
						$max_height = $num_obs + 10;
					}
					else {
						$max_height = $num_sol + 10;
					} 
					if( $max_height < 100 ) {
						$max_height = 100;
					}
				}
				else {
					$grafica = false;
					$ano = 0;
					$alto = 0;
					$alto_grafica = 0;
					$max_height = 0;
				}
				
				// gráfica
				$grafica = '
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">			
					  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
					  google.setOnLoadCallback(drawChart);			  
					  function drawChart() {		
					  var data = new google.visualization.DataTable();
					  data.addColumn("string", "Fecha");
					  data.addColumn("number", "% de Reemplazo");
					  data.addRows(['.$mediciones_indicador.']);			  
					  var options = {
						  width: 580,
						  height: 400,
						  colors: ["#33A1DE","#C62223"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "'.$fecha_grafica.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: '.$max_height.'
							 }
						  },
						  chartArea: { top: 30, left: 100, width: 380, height: 300 },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1); // Apply formatter to second column
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
					  chart.draw(data, options);
					}
					</script>
					<div id="chart_div"></div>
				';
				break;
		}
		/**88**/
		$datos['grafica'] = $grafica;
				
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_eliminar_medicion',$datos);
		$this->load->view('procesos/indicadores/grafica_especiales',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		// Guarda una nueva medición
		if( $_POST ) {
			if( $this->indicadores_model->inserta_medicion_especiales( $id ) ) {
				$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
				$datos['mensaje'] = "La medici&oacute;n se ha guardado correctamente";
				$datos['enlace'] = "procesos/indicadores/grafica_especiales/".$id."/".$fecha_grafica;
				$this->load->view('mensajes/ok_redirec',$datos);
			}
		}
	}
	
	//
	// modificar( $id, $ano ): Modifica el indicador
	//
	function modificar( $id, $ano ) {
		// regresa si no trae las variables
		if( $this->uri->segment(5) === false ) {
			redirect( "procesos/indicadores" );
		}
		
		// variable para regresar si son graficas especiales o normales
		if( $this->uri->segment(6) ) {
			$datos['var'] = $this->uri->segment(6);
		}
		else {
			$datos['var'] = '';
		}
		$datos['ano'] = $ano;
		
		// variables necesarias para la página
		$datos['titulo'] = 'Modificar Indicadores';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id'] = $id;
		$datos['cambiar_tipo'] = 'indicador';
		
		// obtiene los datos del indicador
		$consulta = $this->indicadores_model->get_indicador( $id );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :
				$datos['ind'] = $row->Indicador;
				$datos['met'] = $row->Meta;
				$datos['cal'] = $row->Calculo;
				$datos['fre'] = $row->Frecuencia;
				$datos['res'] = $row->Responsable;
				$datos['obs'] = $row->Observaciones;
			endforeach;
		}
		else {
			redirect( "procesos/indicadores" );
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/indicadores/modificar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		if( $_POST ){		
			// reglas de validaci�n
			$this->form_validation->set_rules('indicador', 'Indicador', 'required|trim');
			$this->form_validation->set_rules('meta', 'Meta', 'required|trim');
			$this->form_validation->set_rules('calculo', 'Calculo', 'required|trim');
			$this->form_validation->set_rules('frecuencia', 'Frecuencia', 'required|trim');
			$this->form_validation->set_rules('responsable', 'Responsable', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{				
				if( $this->indicadores_model->modifica_indicador( $id ) ) {
					// msj de �xito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La informaci&oacute;n del indicador se ha modificado correctamente";
					if( $datos['var'] == 'especiales' ) {
						$datos['enlace'] = "procesos/indicadores/grafica_especiales/".$id."/".$ano;
					}
					else {
						$datos['enlace'] = "procesos/indicadores/grafica/".$id."/".$ano;
					} 
					$this->load->view('mensajes/ok_redirec',$datos);
				}									
			}
		}
	}

	//
	// mediciones( $id ): Elimina una medición del indicador	
	//
	function mediciones( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/indicadores" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Mediciones del Indicador';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id'] = $id;
		
		// obtiene las mediciones
		$datos['mediciones'] = $this->indicadores_model->get_mediciones( $id );
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_eliminar_medicion',$datos);
		$this->load->view('procesos/indicadores/mediciones',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// eliminar_medicion( $id_indicador, $id_medicion, $tipo ): Elimina una medición 
	//
	function eliminar_medicion( $id_indicador, $id_medicion, $tipo ) {
		// regresa si no trae las variables
		if( $this->uri->segment(6) === false ) {
			redirect( "procesos/indicadores" );
		}
		
		// especiales
		if( $tipo == 'indicadores_especiales' ) {
			if( $this->indicadores_model->eliminar_medicion_especiales( $id_medicion ) ) {
				redirect( 'procesos/indicadores/grafica_especiales/'.$id_indicador.'/todos' );
			}
		}
		// normales
		else {
			if( $this->indicadores_model->eliminar_medicion( $id_medicion ) ) {
				redirect( 'procesos/indicadores/mediciones/'.$id_indicador );
			}
		} 
	}
	
	//
	// documento(): Muestra la queja en pdf
	//
	function documento( $id , $ano) {
        $this->load->library('pdf');
			
	// Documento ---------------------------------------------------------	
		// crea el documento
		$this->pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);	
			
		// informacion del documento
		$this->pdf->SetCreator('SIGC2.0');
		$this->pdf->SetAuthor('ISC Jesús Carlos Almeda Macias');
		$this->pdf->SetTitle('Mediciones del Indicador');
		
		
		// header
		$this->pdf->SetHeaderData('../../../../includes/img/logo.jpg', '40', 'Sistema Integral de Gestion de Calidad UJED', 'Queja');
		
		// fuentes del header y el footer
		$this->pdf->setHeaderFont(Array('Helvetica', '', 18));
		$this->pdf->setFooterFont(Array('Helvetica', '', 11));
		
		// margenes
		$this->pdf->SetMargins(5, 50, 5);
		$this->pdf->SetHeaderMargin(0);
		$this->pdf->SetFooterMargin(10);
		
		// saltos de pagina automaticos
		$this->pdf->SetAutoPageBreak(TRUE, 10);
		
		/*
		// lenguaje	
		$this->pdf->setLanguageArray($l);
		*/
		
	// Contenido ---------------------------------------------------------
		// agrega la pagina
		$this->pdf->AddPage();
			
		
		
		// variables necesarias para la página
		$datos['titulo'] = 'Gr&aacute;fica del Indicadores';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['ano'] = $ano;
		$grafica = true;

		// datos del indicador
		$indicador = $this->indicadores_model->get_indicador( $id );
		$datos['indicador'] = $indicador;
		if( $indicador->num_rows() > 0 ) { 
			foreach( $indicador->result() as $row ) {
				if( $row->Tipo == 'DIA' ) {
					$tipo = ' dias';
				}
				else {
					$tipo = '%';
				}
			}
		}
						
		// obtiene las mediciones del indicador
		$mediciones = $this->indicadores_model->get_mediciones( $id );
		$datos['mediciones'] = $mediciones;
		$mediciones_indicador = '';
		if( $mediciones->num_rows() > 0 ) {
			$alto = 150 + ( $mediciones->num_rows() * 40 );
			$alto_grafica = $alto - 100;
			$ano_array = array();
			$i = 0;
			foreach( $mediciones->result() as $row ) {							
				$ano = substr($row->Fecha,0,4);
				$ano_array[$i] = $ano;
				$i++;
				if( $ano == $datos['ano'] || $datos['ano'] == 'todos' ) {
					$num = $row->Medicion;
					switch( substr($row->Fecha,5,2) ) {
						case "01" : $mes = "Ene"; break;
						case "02" : $mes = "Feb"; break;
						case "03" : $mes = "Mar"; break;
						case "04" : $mes = "Abr"; break;
						case "05" : $mes = "May"; break;
						case "06" : $mes = "Jun"; break;
						case "07" : $mes = "Jul"; break;
						case "08" : $mes = "Ago"; break;
						case "09" : $mes = "Sep"; break;
						case "10" : $mes = "Oct"; break;
						case "11" : $mes = "Nov"; break;
						case "12" : $mes = "Dic"; break;
					}
					$mediciones_indicador .= '["'.$mes.' '.$ano.'", '.$num.'],';
				}
			}
			$mediciones_indicador = substr($mediciones_indicador,0,-1);
			
			// años
			$anos  = '<br /><table class="tabla_form" style="border-collapse:separate"><tr><th>Elige el a&ntilde;o:</th>';
			if( $datos['ano'] == 'todos' ) {
				$anos .= '<td style="background-color:#CC0000;"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/todos" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">Todos</a></td>';
				$ano_tag = 'Todos los años'; 
			}
			else {
				$anos .= '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/todos" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">Todos</a></td>';
				$ano_tag = $datos['ano'];
			}
			$ano_temp = 0;
			for( $i = 0; $i < sizeof($ano_array); $i++) {
				if( $ano_temp != $ano_array[$i] ) {
					if( $datos['ano'] == $ano_array[$i] )
						$anos .= '<td style="background-color:#CC0000;"><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/'.$ano_array[$i].'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()" style="color:#FFF">'.$ano_array[$i].'</a></td>';
					else
						$anos .= '<td><a href="'.base_url().'index.php/procesos/indicadores/grafica/'.$id.'/'.$ano_array[$i].'" onmouseover="tip(\'Revisar las mediciones<br />de este a&ntilde;o\')" onmouseout="cierra_tip()">'.$ano_array[$i].'</a></td>';
					$ano_temp = $ano_array[$i];
				}
			}
			$anos .= '</tr></table>';
			$datos['anos'] = $anos;
		}
		else {
			$grafica = false;
			$ano = 0;
			$alto = 0;
			$alto_grafica = 0;
			$datos['anos'] = '';
			$ano_tag = '';
		}
			
		// gráfica
		$datos['grafica'] = '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">			
			  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
			  google.setOnLoadCallback(drawChart);			  
			  function drawChart() {		
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "Fecha");
			  data.addColumn("number", "Avance");
			  data.addRows(['.$mediciones_indicador.']);
			  var options = {
				  width: 700,
				  height: '.$alto.',
				  colors: ["#CC0000"],
				  fontSize: "12",
				  fontName: "Tahoma",
				  legend: "none",
				  vAxis: { title: "Mediciones '.$ano_tag.'", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "explicit",
							 viewWindow: {
								 min: 1,
								 max: 100
							 }
						  },
				  chartArea: { top: 30, left: 100, width: 550, height: '.$alto_grafica.' },
				  tooltipTextStyle: { fontSize: "16" },
			  };
			  
			  var formatter = new google.visualization.NumberFormat({suffix: "'.$tipo.'",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column
  
			  var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div>
		';
		if( !$grafica ) {
			$datos['grafica'] = '<br /><br /><table class="tabla" width="700"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento este indicador no tiene mediciones</td></tr></table>';
		}
			
		// estructura de la página
				
		
		$this->pdf->SetY(30);
		
		// Datos de la queja
	    $this->pdf->SetFont('Helvetica','B',14);
		$this->pdf->SetDrawColor(204,204,204);		
		$this->pdf->SetFillColor(198,34,35);
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->SetX(10);
		$this->pdf->Cell(195,10,'Mediciones del Indicador',1,1,'C',true,'','','','','C');
		$this->pdf->SetX(10);

		// Area
		$this->pdf->Ln(1,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Area',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$datos['grafica'],1,0,'L',true);

		/*// Departamento
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Departamento',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$dep,1,0,'L',true);

		// Nombre
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Nombre',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$nom,1,0,'L',true);
		
		// Fecha
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Fecha',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);		
		$this->pdf->Cell(160,10,$fec,1,0,'L',true);

		// Correo
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Correo',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);		
		$this->pdf->Cell(160,10,$cor,1,0,'L',true);
		
		// Telefono
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Telefono',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$tel,1,0,'L',true);
		
		// Queja
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Queja',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->writeHTMLCell(160, 500, 45, '', $que, 1, 0, 1, true, 'J', true);
		/*
		$this->pdf->MultiCell(160,10,'',1,'J',true,1,'','',true,0,true,true);
		$this->pdf->SetFillColor(0,0,0);
		$this->pdf->writeHTML($que,false,true,false,true,'L');*/

		// cierra y muestra el documento		
		$this->pdf->Output('queja.pdf', 'I');
	}

}
