<?php
/****************************************************************************************************
 *
 *	CONTROLLERS/admin/minutas.php
 *
 *	    Descripción:
 *		    Controlador de las acciones de las minutas
 *
 *	    Fecha de Creación:
 *		    30/Octubre/2011
 *
 *	    Ultima actualización:
 *	   	    22/Mayo/2013
 *
 *	    Autor:
 *		    ISC Rogelio Castañeda Andrade
 *		    rogeliocas@gmail.com
 *          @rogeliocas
 *
 ****************************************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Minutas extends CI_Controller {

/** Atributos **/
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_admin_model->get_menu( 'minutas' );
	}
	
	public function get_barra( $enlaces ) {
		$this->barra = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';
		
		foreach( $enlaces as $enlace => $titulo ) {
			$this->barra .= '
				<img src="'.base_url().'includes/img/arrow_right.png"/>
				<a href="'.base_url().'index.php/admin/documentos/'.$enlace.'">'.$titulo.'</a>
			';
		}
	}
		
/** Constructor **/	
	function __construct() {
		parent::__construct();
		
		// validacion de administrador
		if ( $this->session->userdata('id_usuario') ) {
			if ( !$this->session->userdata('admin') ) {
				redirect('admin/inicio/login');
			}
			else {
				$this->load->model('admin/inicio_admin_model','',TRUE);
				$this->load->model('admin/usuarios_admin_model','',TRUE);
				$this->set_menu();
			}
		}
		else {
			redirect( 'inicio' );
		}
	}

	/** Funciones **/
	//
	// minutas_comite(): Muestra el listado de las minutas generadas del Comite de Calidad
	//
	function minutas_comite() {
        $titulo = "Minutas del Comit&eacute; Generadas";
		$datos['titulo'] = $titulo;		
        $datos['menu'] = $this -> menu;
        $this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
        
		// genera la barra de dirección
		$this->get_barra( array( 'minutas_comite' => $titulo ) );
		$datos['barra'] = $this->barra;       		
		
		// obtiene las minutas 
        $this->db->order_by('Ano','DESC');
        $this->db->group_by( array('Periodo','Ano') );
		$datos['minutas'] = $this->db->get_where('mn_minutas', array('IdArea'=>1));		
		
		// estructura de la página
		$this -> load -> view('_estructura/header', $datos);
		$this -> load -> view('admin/_estructura/top', $datos);
		$this -> load -> view('admin/_estructura/usuario', $datos);
		$this -> load -> view('admin/minutas/minutas_comite', $datos);
		$this -> load -> view('admin/_estructura/footer');
	}	

    //
	// ver(): Muestra la minuta completa del Comite de Calidad
	//
	function ver( $per, $ano ) {
        $titulo = "Minuta del Comit&eacute; de Calidad";
		$datos['titulo'] = $titulo;
        $datos['menu'] = $this -> menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
        $Ano=$ano;
        // genera la barra de dirección
		$this->get_barra( array( 'puntos' => $titulo ) );
		$datos['barra'] = $this->barra;
        
        // informacion del periodo actual y anterior
        $ano_anterior = $ano;
		switch( $per ) {
			case 1 : 
                $periodo = "Enero - Marzo";
                $per_ini = $ano."01-01";
                $per_fin = $ano."03-31";
                $periodo_anterior = "Octubre - Diciembre";
                $ano_anterior = $ano - 1;
                break;
                
			case 2 : 
                $periodo = "Abril - Junio";
                $per_ini = $ano."04-01";
                $per_fin = $ano."06-30";
                $periodo_anterior = "Enero - Marzo";
                break;
                
			case 3 : 
                $periodo = "Julio - Septiembre";
                $per_ini = $ano."07-01";
                $per_fin = $ano."09-30";
                $periodo_anterior = "Abril - Junio";
                break;
                
			case 4 : 
                $periodo = "Octubre - Diciembre";
                $per_ini = $ano."10-01";
                $per_fin = $ano."12-31";
                $periodo_anterior = "Julio - Septiembre";
                break;
		}

		$datos['minuta_titulo'] = $periodo." ".$ano;
		$datos['per'] = $per;
		$datos['ano'] = $ano;
        $datos['per_ini'] = $per_ini;
        $datos['per_fin'] = $per_fin;
		
        // obtiene los puntos de esta reunión
        
        $this->db->join('mn_minutas','mn_minutas.IdMinuta = mn_minutas_puntos.IdMinuta');
        $this->db->join('ab_areas','ab_areas.IdArea = mn_minutas.IdArea');        
		$datos['minuta'] = $this->db->get_where('mn_minutas_puntos',array('mn_minutas.Periodo' => $periodo, 'mn_minutas.Ano' => $ano));		
        
        // obtiene los objetivos de calidad
        $datos['consulta_objetivos'] = $this->db->get_where( 'pa_objetivos', array( 'Estado' => '1' ) );
        
		//Inicio de prueba
		 // obtiene los indicadores
        
     	$objetivos= $this->db->get_where( 'pa_objetivos_indicadores', array( 'Estado' => '1' ) );
		
		
		
		$datos['objetivos'] = $objetivos;
		if( $objetivos->num_rows() > 0 ) {
			$gr = false;
			$i = 0;		
		
						$ano = 0;
						$alto = 0;
						$alto_grafica = 0;		
						$mediciones_objetivos=0;
			foreach( $objetivos->result() as $row ) {
				
				
			
				if ($objetivos=='0'){					
					$mediciones = $this->db->order_by('pa_objetivos_medicion.Fecha','DESC')->get_where('pa_objetivos_medicion',array('pa_objetivos_medicion.IdIndicador' => $row->IdObjetvio, 'Fecha <=' => $per_fin ),5);
					$mediciones_objetivos = '';
					if( $mediciones->num_rows() > 0 ) {
						$gr = true;						
						$alto = 150 + ( $mediciones->num_rows() * 40 );
						$alto_grafica = $alto - 100;
						foreach( $mediciones->result() as $row ) {
					
							$num = $row->Medicion;
							$ano = substr($row->Fecha,0,4);
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
							$mediciones_objetivos .= '["'.$mes.' '.$ano.'", '.$num.'],';
						}
						$mediciones_objetivos = substr($mediciones_objetivos,0,-1);
						
					}
					else{
						$gr = false;
						$ano = 0;
						$alto = 0;
						$alto_grafica = 0;
					}
					}
		
		$grafica_objetivos[$i] = '
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">			
					  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
					  google.setOnLoadCallback(drawChart);			  
					  function drawChart() {		
					  var data = new google.visualization.DataTable();
					  data.addColumn("string", "Fecha");
					  data.addColumn("number", "Avance");
					  data.addRows(['.$mediciones_objetivos.']);
					  var options = {
						  width: 430,
						  height: '.$alto.',
						  colors: ["#007799"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "Mediciones", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
						  	title: "Porcentaje de Avance", 
						  	viewWindowMode: "pretty", 
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
						  chartArea: { top: 30, left: 100, width: 380, height: '.$alto_grafica.' },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1); // Apply formatter to second column
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div_ind_'.$i.'"));
					  chart.draw(data, options);
					}
					</script>
		            <div id="chart_div_ind_'.$i.'"></div>
				';

				if( !$gr )
					$grafica_objetivos[$i] = '<br /><br /><table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento este indicador no tiene mediciones</td></tr></table>';
					
				$i++;
			}
			$datos['grafica_objetivos'] = $grafica_objetivos;
		}
        
        // obtiene los indicadores
        
        $indicadores = $this->db->get_where( 'pa_indicadores', array( 'Estado' => '1' ) );
		
		
		$datos['indicadores'] = $indicadores;
		if( $indicadores->num_rows() > 0 ) {
			$gr = false;
			$i = 0;				
			foreach( $indicadores->result() as $row ) {
				$indicador=$row->Especial;
				$tipo=$row->Tipo;
			
				if ($indicador=='0'){					
					$mediciones = $this->db->order_by('pa_indicadores_medicion.Fecha','DESC')->get_where('pa_indicadores_medicion',array('pa_indicadores_medicion.IdIndicador' => $row->IdIndicador, 'Fecha <=' => $per_fin ),5);
					$mediciones_indicador = '';
					if( $mediciones->num_rows() > 0 ) {
						$gr = true;						
						$alto = 150 + ( $mediciones->num_rows() * 40 );
						$alto_grafica = $alto - 100;
						foreach( $mediciones->result() as $row ) {
					
							$num = $row->Medicion;
							$ano = substr($row->Fecha,0,4);
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
						$mediciones_indicador = substr($mediciones_indicador,0,-1);
						
					}
					else{
						$gr = false;
						$ano = 0;
						$alto = 0;
						$alto_grafica = 0;
					}
				}elseif($indicador=='1'){
					$mediciones = $this->db->order_by('pa_indicadores_medicion_especiales.Fecha','DESC')->get_where('pa_indicadores_medicion_especiales',array('pa_indicadores_medicion_especiales.IdIndicador' => $row->IdIndicador, 'Fecha <=' => $per_fin ),5);
					$mediciones_indicador = '';
					if( $mediciones->num_rows() > 0 ) {
						$gr = true;						
						$alto = 150 + ( $mediciones->num_rows() * 40 );
						$alto_grafica = $alto - 100;
						foreach( $mediciones->result() as $row ) {
							
							if($tipo=='POR'){
								$num = ($row->MedDos/$row->MedUno) * 100;
							}elseif($tipo=='DIV'){
								$num = ($row->MedDos/$row->MedUno);
							}
							
												
							$ano = substr($row->Fecha,0,4);
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
						$mediciones_indicador = substr($mediciones_indicador,0,-1);
						
					}
					else {
						$gr = false;
						$ano = 0;
						$alto = 0;
						$alto_grafica = 0;
					}
				}
		
		$grafica_indicadores[$i] = '
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
						  width: 430,
						  height: '.$alto.',
						  colors: ["#007799"],
						  fontSize: "12",
						  fontName: "Tahoma",
						  legend: "none",
						  vAxis: { title: "Mediciones", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
						  hAxis: {
						  	title: "Porcentaje de Avance", 
						  	viewWindowMode: "pretty", 
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
						  chartArea: { top: 30, left: 100, width: 380, height: '.$alto_grafica.' },
						  tooltipTextStyle: { fontSize: "16" },
					  };
					  
					  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
					  formatter.format(data, 1); // Apply formatter to second column
		  
					  var chart = new google.visualization.BarChart(document.getElementById("chart_div_ind_'.$i.'"));
					  chart.draw(data, options);
					}
					</script>
		            <div id="chart_div_ind_'.$i.'"></div>
				';

				if( !$gr )
					$grafica_indicadores[$i] = '<br /><br /><table class="tabla" width="430"><tr><th width="20"><img src="'.base_url().'includes/img/icons/small/info.png" /></th><td>Por el momento este indicador no tiene mediciones</td></tr></table>';
					
				$i++;
			}
			$datos['grafica_indicadores'] = $grafica_indicadores;
		}
        
        // obtiene las quejas
        $datos['quejas'] = $this->db->get_where( 'pa_quejas', array( 'Estado <>' => '2' ) );
        
        // obtiene las no conformidades
        $datos['conformidades'] = $this->db->get_where( 'pa_conformidades', array( 'Estado <>' => '3' ) );
        
        // obtiene los acuerdos y los puntos de la reunión actual        
		$datos['acuerdos'] = $this->db->get_where('mn_minutas_comite_puntos',array('Periodo' => $periodo, 'Ano' => $Ano),1);		
       
        // obtiene los acuerdos de la ultima reunion
		$datos['acuerdos_anteriores'] = $this->db->get_where('mn_minutas_comite_puntos',array('Periodo' => $periodo_anterior, 'Ano' => $ano_anterior),1);
        
		// estructura de la página
		$this -> load -> view('_estructura/header', $datos);		
		$this -> load -> view('admin/minutas/ver', $datos);
	}
    
    //
	// acuerdos(): Acuerdos de la minuta del comite de calidad
	//
	function acuerdos( $per, $ano ) {
        $titulo = "Acuerdos de la Minuta";
		$datos['titulo'] = $titulo;	
        $datos['menu'] = $this -> menu;
		$datos['per'] = $per;
		$datos['ano'] = $ano;
		
        // genera la barra de dirección
        $this->get_barra( array( 'acuerdos' => $titulo ) );
        $datos['barra'] = $this->barra;
        		
		// estructura de la página (1)
		$this -> load -> view('_estructura/header', $datos);		
		$this -> load -> view('admin/_estructura/top', $datos);
		$this -> load -> view('admin/_estructura/usuario', $datos);
		
		// obtiene los periodos
		switch( $per ) {
			case 1 : $periodo = "Enero - Marzo"; $periodo_anterior = "Octubre - Diciembre"; $ano_anterior = $ano - 1; break;
			case 2 : $periodo = "Abril - Junio"; $periodo_anterior = "Enero - Marzo"; $ano_anterior = $ano; break;
			case 3 : $periodo = "Julio - Septiembre"; $periodo_anterior = "Abril - Junio"; $ano_anterior = $ano; break;
			case 4 : $periodo = "Octubre - Diciembre"; $periodo_anterior = "Julio - Septiembre"; $ano_anterior = $ano; break;
			case 0 : redirect('errores/error_404'); break;
		} 
					
		// obtiene los acuerdos de esta reunión
		$acuerdos = $this->db->get_where('mn_minutas_comite_puntos',array('Periodo' => $periodo, 'Ano' => $ano),1);
		if( $acuerdos->num_rows() > 0 ) {
			$inserta = false;
			foreach( $acuerdos->result() as $row)
				$datos['acuerdos'] = $row->Acuerdo;
		}		
		else {
			$inserta = true;
			$datos['acuerdos'] = '';
		}				
				
		// obtiene los acuerdos anteriores			
		$acuerdos = $this->db->get_where('mn_minutas_comite_puntos',array('Periodo' => $periodo_anterior, 'Ano' => $ano_anterior),1);
		if( $acuerdos->num_rows() > 0 ) {
			$inserta_anterior = false;
			foreach( $acuerdos->result() as $row)
				$datos['acuerdos_anteriores'] = $row->Acuerdo;
		}		
		else {
			$inserta_anterior = true;
			$datos['acuerdos_anteriores'] = '<span style="font-size:12px; font-style:italic;">No hay acuerdos guardados.</span>';			
		}
			
		// Guarda los acuerdos
		if( $_POST ) {			
			// inserta acuerdos actuales
			if( $inserta ) {
				// array para insertar en la bd
				$inserta = array(				   
				   'Ano'		=> $ano,
				   'Periodo'	=> $periodo,
				   'Acuerdo'	=> $this->input->post('acuerdos'),
				);					
				// realiza la inserción
				$resp = $this->db->insert('mn_minutas_comite_puntos', $inserta); 
			}
			// actualiza acuerdos actuales
			else {
				$actualiza = array(
					'Acuerdo'	=> $this->input->post('acuerdos')
				);
				$resp = $this->db->where(array('Ano' => $ano, 'Periodo' => $periodo))->update('mn_minutas_comite_puntos',$actualiza);
			}
			if( $resp ) {
				// inserta acuerdos anteriores
				if( $inserta_anterior ) {
					// array para insertar en la bd
					$inserta = array(				   
					   'Ano'		=> $ano_anterior,
					   'Periodo'	=> $periodo_anterior,
					   'Acuerdo'	=> $this->input->post('acuerdos_anteriores'),
					);					
					// realiza la inserción
					$resp = $this->db->insert('mn_minutas_comite_puntos', $inserta);
				}
				// actualiza acuerdos anteriores
				else {
					$actualiza = array(
					'Acuerdo'	=> $this->input->post('acuerdos_anteriores')
					);
					$resp = $this->db->where(array('Ano' => $ano_anterior, 'Periodo' => $periodo_anterior))->update('mn_minutas_comite_puntos',$actualiza);						
				}					
			}
				
			// msj de éxito
			if( $resp ) {					
				$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
				$datos['mensaje'] = "Los acuerdos se han guardado";
				$datos['enlace'] = "admin/minutas/minutas_comite";
				$this->load->view('mensajes/ok_redirec',$datos);
			}			
		}				
		
		$datos['minuta'] = $periodo." / ".$ano;			
		$datos['minuta_anterior'] = $periodo_anterior." / ".$ano_anterior;
		
		// estructura de la página (2)
		$this -> load -> view('admin/minutas/acuerdos', $datos);
		$this -> load -> view('admin/_estructura/footer');
	}
    
    //
	// puntos(): Listado de los puntos de las minutas
	//
	function puntos( $per, $ano ) {
        $titulo = "Puntos de la Minuta del Comit&eacute;";
		$datos['titulo'] = $titulo;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
        $datos['menu'] = $this -> menu;
        
        // genera la barra de dirección
		$this->get_barra( array( 'puntos' => $titulo ) );
		$datos['barra'] = $this->barra;
        
		switch( $per ) {
			case 1 : $periodo = "Enero - Marzo"; break;
			case 2 : $periodo = "Abril - Junio"; break;
			case 3 : $periodo = "Julio - Septiembre"; break;
			case 4 : $periodo = "Octubre - Diciembre"; break;
		}

		$datos['minuta'] = $periodo." ".$ano;
		$datos['per'] = $per;
		$datos['ano'] = $ano;
		
		// estructura de la página
		$this -> load -> view('_estructura/header', $datos);
		$this -> load -> view('admin/_estructura/top', $datos);
		$this -> load -> view('admin/_estructura/usuario', $datos);
		$this -> load -> view('admin/minutas/puntos', $datos);
		$this -> load -> view('admin/_estructura/footer');
	}
    
	//
	// puntos_comite(): Agrega / modifica información de un punto de la minuta del comité de calidad
	//
	function punto_comite( $pun, $per, $ano ) {
		switch( $pun ) {
			case 1  : $datos['titulo'] = "Lugar y Fecha"; $campo = "Lugar"; break;
			case 2  : $datos['titulo'] = "Participantes"; $campo = "Participantes"; break;
			case 3  : $datos['titulo'] = "I. Puntos Pendientes"; $campo = "PuntosPendientes"; break;
			case 4  : $datos['titulo'] = "II. Objetivos de Calidad"; $campo = "ObjetivosCalidad"; break;
			case 5  : $datos['titulo'] = "III. Procesos"; $campo = "Procesos"; break;
			case 6  : $datos['titulo'] = "IV. Desempe&ntilde;o"; $campo = "Desempeno"; break;
			case 7  : $datos['titulo'] = "V. Acciones Correctivas y Preventivas"; $campo = "Acciones"; break;
			case 8  : $datos['titulo'] = "VI. Cambios que podrian afectar al SIGC"; $campo = "Cambios";  break;
			case 9  : $datos['titulo'] = "VII. Recomendaciones para la mejora (Mejora Continua)"; $campo = "Recomendaciones"; break;
			case 10 : $datos['titulo'] = "VIII. Asuntos Generales"; $campo = "AsuntosGenerales"; break;
			case 11 : $datos['titulo'] = "IX. Tareas"; $campo = "Tareas"; break;
		}
				
		$datos['menu'] = $this -> menu;
		$datos['per'] = $per;
		$datos['ano'] = $ano;
		
        // genera la barra de dirección
        $this->get_barra( array( 'punto_comite' => $datos['titulo'] ) );
		$datos['barra'] = $this->barra;
        
		// estructura de la página (1)
		$this -> load -> view('_estructura/header', $datos);		
		$this -> load -> view('admin/_estructura/top', $datos);
		$this -> load -> view('admin/_estructura/usuario', $datos);
		
		// obtiene los periodos
		switch( $per ) {
			case 1 : $periodo = "Enero - Marzo"; $periodo_anterior = "Octubre - Diciembre"; $ano_anterior = $ano - 1; break;
			case 2 : $periodo = "Abril - Junio"; $periodo_anterior = "Enero - Marzo"; $ano_anterior = $ano; break;
			case 3 : $periodo = "Julio - Septiembre"; $periodo_anterior = "Abril - Junio"; $ano_anterior = $ano; break;
			case 4 : $periodo = "Octubre - Diciembre"; $periodo_anterior = "Julio - Septiembre"; $ano_anterior = $ano; break;
			case 0 : redirect('errores/error_404'); break;
		} 
					
		// obtiene los puntos de esta reunión
		$acuerdos = $this->db->get_where('mn_minutas_comite_puntos',array('Periodo' => $periodo, 'Ano' => $ano),1);
		if( $acuerdos->num_rows() > 0 ) {
			$inserta = false;
			foreach( $acuerdos->result() as $row) {
				//$datos['acuerdos'] = $row->Acuerdo;
				switch( $pun ) {
					case 1  : $datos['punto'] = $row->Lugar; break;
					case 2  : $datos['punto'] = $row->Participantes; break;
					case 3  : $datos['punto'] = $row->PuntosPendientes; break;
					case 4  : $datos['punto'] = $row->ObjetivosCalidad; break;
					case 5  : $datos['punto'] = $row->Procesos; break;
					case 6  : $datos['punto'] = $row->Desempeno; break;
					case 7  : $datos['punto'] = $row->Acciones; break;
					case 8  : $datos['punto'] = $row->Cambios; break;
					case 9  : $datos['punto'] = $row->Recomendaciones; break;
					case 10 : $datos['punto'] = $row->AsuntosGenerales; break;
					case 11 : $datos['punto'] = $row->Tareas; break;
				}
			}
		}		
		else {
			$inserta = true;
			$datos['punto'] = '';
		}
			
		// Guarda el punto
		if( $_POST ) {			
			// inserta el punto
			if( $inserta ) {
				// array para insertar en la bd
				$inserta = array(				   
				   'Ano'		=> $ano,
				   'Periodo'	=> $periodo,
				   $campo		=> $this->input->post('punto'),
				);					
				// realiza la inserción
				$resp = $this->db->insert('mn_minutas_comite_puntos', $inserta); 
			}
			// actualiza acuerdos actuales
			else {
				$actualiza = array(
					$campo	=> $this->input->post('punto')
				);
				$resp = $this->db->where(array('Ano' => $ano, 'Periodo' => $periodo))->update('mn_minutas_comite_puntos',$actualiza);
			}			
				
			// msj de éxito
			if( $resp ) {					
				$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
				$datos['mensaje'] = "Cambios guardados";
				$datos['enlace'] = "admin/minutas/puntos/".$per."/".$ano;
				$this->load->view('mensajes/ok_redirec',$datos);
			}			
		}				
		
		$datos['minuta'] = $periodo." / ".$ano;
		
		// estructura de la página (2)
		$this -> load -> view('admin/minutas/punto_comite', $datos);
		$this -> load -> view('admin/_estructura/footer');
	}

    //
	// minutas_areas(): Listado de minutas por área
	//
	//function minutas_areas($ida, $edo, $del) {
	//	// si los datos han sido enviados por post se sobre escribe la variable $ide
	//	if ($_POST) {
	//		$ida = $this -> input -> post('area');
	//		$edo = $this -> input -> post('estado');
	//		$datos['area'] = $ida;
	//		$datos['estado'] = $edo;
	//		$del = 0;
	//	} else {
	//		$datos['area'] = "all";
	//		$datos['estado'] = "all";
	//	}

	//	// obtiene todas las areas
	//	$areas = $this -> db -> order_by('Area') -> get_where('ab_areas', array('Area !=' => 'Invitado'));
	//	if ($areas -> num_rows() > 0) {
	//		$datos['area_options'] = array();
	//		$datos['area_options']['all'] = " - Todas las &Aacute;reas - ";
	//		foreach ($areas->result() as $row)
	//			$datos['area_options'][$row -> IdArea] = $row -> Area;
	//	}
	//	$datos['estado_options'] = array('all' => ' - Todas - ', '1' => 'Activas', '0' => 'Eliminadas');

	//	// se obtiene el listado
	//	$this -> db -> order_by("ab_areas.Area", "ASC");
	//	$this -> db -> join("ab_areas", "ab_areas.IdArea = mn_minutas.IdArea");
	//	$this -> db -> join("mn_minutas_puntos", "mn_minutas_puntos.IdMinuta = mn_minutas.IdMinuta");
	//	// muestra todo el listado
	//	if ($ida == "all") {
	//		$datos['area'] = 'all';
	//		if ($edo == "all") {
	//			$datos['selec'] = 'all';
	//			$datos['consulta'] = $this -> db -> get('mn_minutas');
	//		} else {
	//			$datos['selec'] = $edo;
	//			$datos['consulta'] = $this -> db -> get_where('mn_minutas', array('mn_minutas.Estado' => $edo));
	//		}
	//	}
	//	// muestra el listado del estado específica
	//	else {
	//		$datos['area'] = $ida;
	//		if ($edo == "all") {
	//			$datos['selec'] = 'all';
	//			$datos['consulta'] = $this -> db -> get_where('mn_minutas', array('mn_minutas.IdArea' => $ida));
	//		} else {
	//			$datos['estado'] = $edo;
	//			$datos['consulta'] = $this -> db -> get_where('mn_minutas', array('mn_minutas.IdArea' => $ida, 'mn_minutas.Estado' => $edo));
	//		}
	//	}

	//	// variables necesarias para la estructura de la página
 //       $titulo = "Minutas de las &Aacute;reas";
	//	$datos['titulo'] = $titulo;
	//	$this->inicio_admin_model->set_sort( 20 );
	//	$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
	//	// genera la barra de dirección
	//	$this->get_barra( array( 'minutas_areas' => $titulo ) );
	//	$datos['barra'] = $this->barra;
        
 //       // estructura de la página
	//	$this -> load -> view('_estructura/header', $datos);
	//	$this -> load -> view('admin/_estructura/top', $datos);
	//	$this -> load -> view('admin/_estructura/usuario', $datos);
	//	$this -> load -> view('admin/minutas/minutas_areas', $datos);
	//	$this -> load -> view('admin/_estructura/footer');		
		
	//	// si se modifico alguna minuta
	//	switch( $del ) {
	//		case 1 :
	//			$datos['mensaje_titulo'] = 'Minuta Eliminada';
	//			$datos['mensaje'] = 'La minuta ha sido eliminada</strong>';
	//			$this -> load -> view('_msj/ok', $datos);
	//			break;
	//		case 2 :
	//			$datos['mensaje_titulo'] = 'Minuta Restaurada';
	//			$datos['mensaje'] = 'La minuta ha sido restaurada</strong>';
	//			$this -> load -> view('_msj/ok', $datos);
	//			break;
	//		case 3 :
	//			$datos['mensaje_titulo'] = 'Minutas';
	//			$datos['mensaje'] = 'Ha ocurrido un error y la minuta no se ha podido eliminar, intentalo de nuevo o ponte en contacto con el web master';
	//			$this -> load -> view('_msj/ok', $datos);

	//			break;
	//	}
	//}  
}
