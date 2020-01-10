<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/minutas.php
*
*		Descripción:
*			Controlador para las minutas
*
*		Fecha de Creación:
*			19/Noviembre/2011
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

class Minutas extends CI_Controller {
	
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
			$this->load->model('procesos/minutas_model','',TRUE);
		}
	}
		

/** Funciones **/
	//
	// index(): Inicia una minuta
	//
	function index() {
		// variables necesarias para la página
		$datos['titulo'] = 'Minuta';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
				
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/minutas/inicio',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
		
		if( $_POST ) {
			// revisa si no se ha generado ya esta minuta
			$consulta = $this->minutas_model->get_datos_minuta();
			if( $consulta->num_rows() > 0 ) {
				foreach( $consulta->result() as $row ) {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = 'Ya se ha generado esta minuta, pero si lo deseas puedes modificar los datos';
					$datos['enlace_si'] = 'procesos/minutas/ver_modificar/'.$row->IdMinuta.'/'.$row->IdMinutaPuntos;
					$datos['enlace_no'] = 'procesos/minutas';
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
			}
			// Inserta
			else {
				$resp = $this->minutas_model->inserta_minuta();
				if( $resp ) {
					redirect( $resp );
				}			
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = 'Ha ocurrido un error al tratar de comenzar la minuta, intentalo de nuevo o ponte en contacto con el web master';
					$this->load->view('mensajes/ok',$datos);
				}
			}
		}
	}

	//
	// puntos( $idm, $idp, $idmp, $modificar ): Puntos de la minuta - para modificar
	//
	function puntos( $idm, $idp, $idmp, $modificar ) {
		// regresa si no trae las variables
		if( $this->uri->segment(7) === false ) {
			redirect( "listados/minutas" );
		}
		
		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(8) ) {
			$datos['estado'] = $this->uri->segment(8); 
		}
		else {
			$datos['estado'] = '';
		}
		
		$siguiente_punto = $idp + 1;
		$resp = 3;
		
		// variables necesarias para la página
		$datos['titulo'] = 'Minuta';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['idm'] = $idm;
		$datos['idp'] = $idp;
		$datos['idmp'] = $idmp;
		$datos['texto_2'] = '';
		$datos['texto_contenido'] = '';
		$datos['texto_contenido_2'] = '';
		$campo_2 = '';
		$input_2 = '';
				
		switch ( $idp ) {
			// Lugar
			case 10 :
				$campo = 'Lugar';
				$input = 'lugar';
				$datos['titulo_punto'] = "Lugar y Fecha";
				$datos['texto'] = $input;
				$siguiente_punto = 0;
				break;
							
			// Participantes
			case 0 :
				$campo = 'Participantes';
				$input = 'participantes';
				$datos['titulo_punto'] = "Participantes";
				$datos['texto'] = $input;
				break;
				
			// I. Puntos Pendientes
			case 1 :
				$campo = 'PuntosPendientes';
				$input = 'puntos_pendientes';
				$datos['titulo_punto'] = "I. Puntos Pendientes de la Reuni&oacute;n Anterior";
				$datos['texto'] = $input;
				break;
				
			// II. Objetivos de Calidad
			case 2 :
				$campo = 'ObjetivosCalidad';
				$input = 'objetivos_calidad';
				$datos['titulo_punto'] = "II. Objetivos de Calidad";
				$datos['texto'] = $input;
				break;
				
			// III. Procesos
			case 3 :
				$campo = 'Procesos';
				$input = 'procesos';
				$datos['titulo_punto'] = "III. Procesos";
				$datos['texto'] = $input;
				$siguiente_punto = 41;
				break;
				
			// IV. Desempeño - Infraestructura y Ambiente de Trabajo
			case 41 :
				$campo = 'DesInfraestructuraAtendidas';
				$campo_2 = 'DesInfraestructuraNoAtendidas';
				$input = 'infraestructura';
				$input_2 = 'infraestructura_2';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Infraestructura y Ambiente de Trabajo";
				$datos['texto'] = $input;
				$datos['texto_2'] = $input_2;
				$siguiente_punto = 42;
				break;
				
			// IV. Desempeño - Clima Organizacional	
			case 42 :
				$campo = 'DesClima';
				$input = 'clima_organizacional';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Clima Organizacional	";
				$datos['texto'] = $input;
				$siguiente_punto = 43;
				break;
				
			// IV. Desempe�o - Satisfacci�n de Usuarios
			case 43 :
				$campo = 'DesSatisfaccion';
				$input = 'satisfaccion_usuarios';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Satisfacci&oacute;n de Usuarios";
				$datos['texto'] = $input;
				$siguiente_punto = 44;
				break;
				
			// IV. Desempe�o - Auditor�a Interna
			case 44 :
				$campo = 'DesAuditoria';
				$input = 'auditoria_interna';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Auditor&iacute;a Interna";
				$datos['texto'] = $input;
				$siguiente_punto = 45;
				break;
				
			// IV. Desempe�o - Capacitaci�n
			case 45 :
				$campo = 'DesCapacitacion';
				$input = 'capacitacion';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Capacitaci&oacute;n";
				$datos['texto'] = $input;
				$siguiente_punto = 46;
				break;
				
			// IV. Desempe�o - Mejora Continua
			case 46 :
				$campo = 'DesMejora';
				$input = 'mejora_continua';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Mejora Continua";
				$datos['texto'] = $input;
				$siguiente_punto = 47;
				break;
				
			// IV. Desempe�o - Quejas
			case 47 :
				$campo = 'DesQuejas';
				$input = 'infraestructura';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Quejas";
				$datos['texto'] = $input;
				$siguiente_punto = 48;
				break;
				
			// IV. Desempe�o - Evaluaci�n al Desempe�o
			case 48 :
				$campo = 'DesDesempeno';
				$input = 'desempeno';
				$datos['titulo_punto'] = "IV. Desempe&ntilde;o - Evaluaci&oacute;n al Desempe&ntilde;o";
				$datos['texto'] = $input;
				$siguiente_punto = 5;
				break;
				
			// V. Acciones Correctivas y Preventivas
			case 5 :
				$campo = 'Acciones';
				$input = 'acciones';
				$datos['titulo_punto'] = "V. Acciones Correctivas y Preventivas";
				$datos['texto'] = $input;
				break;
				
			// VI. Cambios que podrian afectar al SIGC
			case 6 :
				$campo = 'Cambios';
				$input = 'cambios';
				$datos['titulo_punto'] = "VI. Cambios que podrian afectar al SIGC";
				$datos['texto'] = $input;
				break;
				
			// VII. Recomendaciones para la mejora (Mejora Continua)
			case 7 :
				$campo = 'Recomendaciones';
				$input = 'recomendaciones';
				$datos['titulo_punto'] = "VII. Recomendaciones para la mejora (Mejora Continua)";
				$datos['texto'] = $input;
				break;	
				
			// VIII. Asuntos Generales
			case 8 :
				$campo = 'AsuntosGenerales';
				$input = 'asuntos_generales';
				$datos['titulo_punto'] = "VIII. Asuntos Generales";
				$datos['texto'] = $input;
				break;	
				
			// IX. Tareas
			case 9 :
				$campo = 'Tareas';
				$input = 'tareas';
				$datos['titulo_punto'] = "IX. Tareas";
				$datos['texto'] = $input;
				$siguiente_punto = 11;
				break;	
				
			default :				
				redirect('inicio/principal');
				break;
		}

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Actualiza
		if( $_POST ) {
			if( $this->minutas_model->modifica_punto( $idp, $idmp, $campo, $campo_2, $input, $input_2) ) {
				$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
				$datos['mensaje'] = 'Datos guardados correctamente';				
				if( $modificar ) {					
					$datos['enlace'] = 'procesos/minutas/ver_modificar/'.$idm.'/'.$idmp;
				}
				else {					
					if( $siguiente_punto == 11 ) {						
						$datos['enlace'] = "listados/minutas/1/0";
					}
					else {						
						$datos['enlace'] = 'procesos/minutas/puntos/'.$idm.'/'.$siguiente_punto.'/'.$idmp.'/0';
					}
				}

				$this->load->view('mensajes/ok_redirec',$datos);
			}
			else{
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = 'Ha ocurrido un error al tratar de guardar, intentalo de nuevo o ponte en contacto con el web master';
				$this->load->view('mensajes/ok',$datos);
			}
		}

		// Obtiene los datos que se van guardando
		$consulta = $this->minutas_model->get_puntos( $idm );
		foreach( $consulta->result() as $row ) {
			$datos['periodo'] = $row->Periodo." ".$row->Ano;
				$datos['lug'] = $row->Lugar;
				$datos['par'] = $row->Participantes;
				$datos['pun'] = $row->PuntosPendientes;
				$datos['obj'] = $row->ObjetivosCalidad;
				$datos['pro'] = $row->Procesos;
				$datos['inf'] = $row->DesInfraestructuraAtendidas;
				$datos['cli'] = $row->DesClima;
				$datos['sat'] = $row->DesSatisfaccion;
				$datos['aud'] = $row->DesAuditoria;
				$datos['cap'] = $row->DesCapacitacion;
				$datos['mej'] = $row->DesMejora;
				$datos['que'] = $row->DesQuejas;
				$datos['des'] = $row->DesDesempeno;
				$datos['acc'] = $row->Acciones;
				$datos['cam'] = $row->Cambios;
				$datos['rec'] = $row->Recomendaciones;
				$datos['asu'] = $row->AsuntosGenerales;
				$datos['tar'] = $row->Tareas;
		}

		// Contenido por default
		$consulta = $this->minutas_model->get_puntos( $idm );
		foreach( $consulta->result() as $row ) {
			$datos['texto_contenido'] = $row->$campo;
			// IV. Desempeño - Infraestructura y Ambiente de Trabajo
			if( $idp == 41 )
				$datos['texto_contenido_2'] = $row->$campo_2;
		}
				
		// estructura de la página (2)	
		$this->load->view('_estructura/top',$datos);
		if( $modificar )
			$this->load->view('procesos/minutas/modificar',$datos);
		else
			$this->load->view('procesos/minutas/puntos',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// ver( $idm ): Muestra toda la minuta en web
	//
	function ver( $idm ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "listados/minutas" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Minuta';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['idm'] = $idm;
		
		// información de la minuta		
		$consulta = $this->minutas_model->get_puntos( $idm );		
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :
				$ida = $row->IdArea;
				switch( $row->Periodo ) {
					case "Enero - Marzo" : 		 $per_ini = $row->Ano."-01-01"; $per_fin = $row->Ano."-03-31"; break;
					case "Abril - Junio" : 		 $per_ini = $row->Ano."-04-01"; $per_fin = $row->Ano."-06-30"; break;
					case "Julio - Septiembre" :  $per_ini = $row->Ano."-07-01"; $per_fin = $row->Ano."-09-30"; break;
					case "Octubre - Diciembre" : $per_ini = $row->Ano."-10-01"; $per_fin = $row->Ano."-12-31"; break;
				}
				$datos['periodo'] = $row->Periodo.' '.$row->Ano;
				$datos['lug'] = $row->Lugar;
				$datos['par'] = $row->Participantes;
				$datos['pun'] = $row->PuntosPendientes;
				$datos['obj'] = $row->ObjetivosCalidad;
				$datos['pro'] = $row->Procesos;
				$datos['ina'] = $row->DesInfraestructuraAtendidas;
				$datos['inn'] = $row->DesInfraestructuraNoAtendidas;
				$datos['cli'] = $row->DesClima;
				$datos['sat'] = $row->DesSatisfaccion;
				$datos['aud'] = $row->DesAuditoria;
				$datos['cap'] = $row->DesCapacitacion;
				$datos['mej'] = $row->DesMejora;
				$datos['que'] = $row->DesQuejas;
				$datos['des'] = $row->DesDesempeno;
				$datos['acc'] = $row->Acciones;
				$datos['cam'] = $row->Cambios;
				$datos['rec'] = $row->Recomendaciones;
				$datos['asu'] = $row->AsuntosGenerales;
				$datos['tar'] = $row->Tareas;
			endforeach;
		}
		else {
			redirect( "listados/minutas" );
		}

		
		// todos los demas indicadores		
		$indicadores = $this->db->get_where('pa_indicadores',array('pa_indicadores.Estado' => '1','pa_indicadores.IdArea' => $ida));
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
					
			
					// gráfica
	
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

		// satisfacción de usuarios
		if( $this->session->userdata('id_area') != 9 ) {
			$ide = 3;
			$ida = $this->session->userdata("id_area");
			$concepto = '';
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';
			$tabla_header_evaluaciones = '';
			$tabla_header_secciones = '';
			$tabla_header_opciones = '';
			$opc = array('MB','B','R','M','P','NA');
			$array_resultados = array(0, 0, 0, 0, 0, 0);
			$tags_opciones = array('Muy Bueno','Bueno','Regular','Malo','Pesimo','No Aplica');
			
			// areas
			$areas = $this->db->get_where('ab_areas',array('IdArea' => $ida),1);
			if( $areas->num_rows() > 0 ) {
				foreach( $areas->result() as $row_are ) {							
					// evaluaciones
					$evaluaciones = $this->db->get_where('en_evaluacion',array('IdEncuesta' => $ide, 'Fecha >=' => $per_ini, 'Fecha <=' => $per_fin),1);
					if( $evaluaciones->num_rows() > 0 ) {						
						foreach( $evaluaciones->result() as $row_eva ) {
							$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:18px; color:#666; text-align:center; border:1px solid #666">'.$row_eva->Fecha.'</th>';
							// usuarios totales
							$usuarios_totales = $this->db->group_by('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc')->select('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc, en_total_satisfaccion_sigc.Total, en_total_satisfaccion_sigc.IdSeccion, en_preguntas.IdOpcionTipo, ab_areas.Area, en_secciones.Seccion')->join('ab_areas','ab_areas.IdArea = en_total_satisfaccion_sigc.IdArea')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sigc.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sigc',array('en_total_satisfaccion_sigc.IdArea' => $row_are->IdArea, 'en_total_satisfaccion_sigc.IdEvaluacion' => $row_eva->IdEvaluacion));
							if( $usuarios_totales->num_rows() > 0 ) {																
								foreach( $usuarios_totales->result() as $row_usu ) {											
									//$tabla_header_secciones .= '<th colspan="6" style="font-weight:normal; font-size:14px; color:#666; text-align:center; border:1px solid #666">'.$row_usu->Seccion.'</th>';
									$tabla_renglones .= '<td style="text-align:left; border-right:1px solid #666">'.$row_usu->Seccion.'</td>';
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										$tabla_header_opciones = '';
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:12px; color:#666; text-align:center; border:1px solid #666">'.$opc[$i].'</th>';
											// resultados
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sigc.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sigc.IdPregunta')->get_where('en_respuestas_satisfaccion_sigc',array('en_respuestas_satisfaccion_sigc.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sigc.IdTotalSatisfaccionSigc' => $row_usu->IdTotalSatisfaccionSigc));
											if( $resultados->num_rows() > 0 ) {																							
												$total_opcion = 0;																									
												foreach( $resultados->result() as $row_res ) {															
													$total_opcion = $total_opcion + $row_res->Numero;
												}		
												
												// obtiene el resultado
												if( $resultados->num_rows() * $row_usu->Total )
													$total_opcion = round( ( $total_opcion * 100 ) / ( $resultados->num_rows() * $row_usu->Total ) * 100) / 100;
												else 
													$total_opcion = 0;
													
												// genera la tabla en base al resultado
												if( $i == $opciones->num_rows() )
													$tabla_renglones .= '<td style="border-right:1px solid #666">'.$total_opcion.'%</td>';
												else
													$tabla_renglones .= '<td style="border:1px solid #EEE">'.$total_opcion.'%</td>';
													
												$array_resultados[$i] = $array_resultados[$i] + $total_opcion;  														
											}
											$i++;
										}																		
									}
									$tabla_renglones .= '</tr><tr>';
									if( $usuarios_totales->num_rows() == 1 ) {
										$tabla_header_evaluaciones = '<th colspan="6" style="font-weight:normal; font-size:14px; color:#666; text-align:center">'.$row_eva->Fecha.'</th>';
									} 									
								}
							}
							else {
								$tabla_renglones .= '<td style="font-style:italic; font-size:10px;">sin resultados por el momento</td>';
							}
						}
						$tabla_header = '<tr><th rowspan="3" style="font-weight:normal; font-size:18px; color:#666; text-align:center; border:1px solid #666">&Aacute;rea</th>'.$tabla_header_evaluaciones.'</tr><tr>'.$tabla_header_secciones.'</tr><tr>'.$tabla_header_opciones.'</tr>';
						
						$evluacion_grafica = true; 
					}
					else {
						$evluacion_grafica = false; 
					}
				}
			}
	
			if( $evluacion_grafica ) {
				$tabla_footer = '<tr style="border:1px solid #666"><th>Total</th>';					
				for ( $i = 0; $i < sizeof( $array_resultados ); $i++) {
					if( $usuarios_totales->num_rows() > 0 )
						$res = $array_resultados[$i] / $usuarios_totales->num_rows();
					else 
						$res = 0; 
					$tabla_footer .= '<th style="border:1px solid #666">'.$res.'%</th>';
					$grafica_resultado .= '["'.$tags_opciones[$i].'",'.$res.'],';
				}						
				$tabla_footer .= '</tr>';
				// se llena la tabla con la información
				$datos['tabla'] = '<table class="tabla" style="border:1px solid #666" width="670">'.$tabla_header.'</th>'.$tabla_renglones.'<tr>'.$tabla_footer.'</tr></table>';
						
				// Gráfica
				// Si es Satisfacción de usuario se genera grafica de pastel
				if( $ide == 3 || $ide == 4 ){
					$datos['grafica'] = '
						<script type="text/javascript" src="https://www.google.com/jsapi"></script>
						<script type="text/javascript">			
						  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
						  google.setOnLoadCallback(drawChart);			  
						  function drawChart() {		
						  var data = new google.visualization.DataTable();
						  data.addColumn("string", "'.$concepto.'");
						  data.addColumn("number", "Porcentaje");
						  data.addRows(['.$grafica_resultado.']);
						  var options = {
							  width: 672,
							  height: 400,
						  };
						  
						  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
						  formatter.format(data, 1); // Apply formatter to second column
			  
						  var chart = new google.visualization.PieChart(document.getElementById("chart_div"));
						  chart.draw(data, options);
						}
						</script>
			            <div id="chart_div"></div>
					';
				}
			}
			else {
				$datos['tabla'] = $datos['grafica'] = '';
			}
		}		
			
		// quejas
		$datos['quejas'] = $this->db->select('ab_departamentos.Departamento,pa_quejas.Estado,pa_quejas.Nombre,pa_quejas.Fecha,pa_quejas.Queja,pa_quejas_seguimiento.Responsable,pa_quejas_seguimiento.Descripcion,pa_quejas_seguimiento.Fecha as FechaSeguimiento,pa_quejas_seguimiento.Observacion')->join('ab_departamentos','ab_departamentos.IdDepartamento = pa_quejas.IdDepartamento')->join('pa_quejas_seguimiento','pa_quejas_seguimiento.IdQueja = pa_quejas.IdQueja')->get_where('pa_quejas', array('pa_quejas.IdArea' => $ida, 'pa_quejas.Estado !=' => '2', 'pa_quejas.Fecha >=' => $per_ini, 'pa_quejas.Fecha <=' => $per_fin));
		
		// no conformidades
		$datos['conformidades'] = $this->db->select('ab_departamentos.Departamento,ab_areas.Area,ab_usuarios.Nombre,ab_usuarios.Paterno,ab_usuarios.Materno,pa_conformidades.Estado,pa_conformidades.Fecha,pa_conformidades.Origen,pa_conformidades.Tipo,pa_conformidades.Descripcion,pa_conformidades_seguimiento.Causa')->join('ab_usuarios','ab_usuarios.IdUsuario = pa_conformidades.IdUsuario')->join('ab_areas','ab_areas.IdArea = pa_conformidades.IdArea')->join('ab_departamentos','ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento')->join('pa_conformidades_seguimiento','pa_conformidades_seguimiento.IdConformidad = pa_conformidades.IdConformidad')->get_where('pa_conformidades', array('pa_conformidades.IdArea' => $ida, 'pa_conformidades.Estado !=' => '3', 'pa_conformidades.Fecha >=' => $per_ini, 'pa_conformidades.Fecha <=' => $per_fin));			
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('procesos/minutas/ver',$datos);
	}

	//
	// modificar( $idm, $idmp ): Ve los puntos para elegir cual modificar
	//
	function ver_modificar( $idm, $idmp ) {
		// regresa si no trae las variables
		if( $this->uri->segment(5) === false ) {
			redirect( "listados/minutas" );
		}
		
		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(6) ) {
			$datos['estado'] = $this->uri->segment(6); 
		}
		else {
			$datos['estado'] = '';
		}

		// variables necesarias para la página
		$datos['titulo'] = 'Modificar Minuta';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['idm'] = $idm;
		$datos['idmp'] = $idmp;
		
		$consulta = $this->db->join('mn_minutas_puntos','mn_minutas_puntos.IdMinuta = mn_minutas.IdMinuta')->get_where('mn_minutas',array('mn_minutas.IdMinuta' => $idm),1);
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :
				$datos['periodo'] = $row->Periodo.' '.$row->Ano;
				$datos['lug'] = $row->Lugar;
				$datos['par'] = $row->Participantes;
				$datos['pun'] = $row->PuntosPendientes;
				$datos['obj'] = $row->ObjetivosCalidad;
				$datos['pro'] = $row->Procesos;
				$datos['ina'] = $row->DesInfraestructuraAtendidas;
				$datos['inn'] = $row->DesInfraestructuraNoAtendidas;
				$datos['cli'] = $row->DesClima;
				$datos['sat'] = $row->DesSatisfaccion;
				$datos['aud'] = $row->DesAuditoria;
				$datos['cap'] = $row->DesCapacitacion;
				$datos['mej'] = $row->DesMejora;
				$datos['que'] = $row->DesQuejas;
				$datos['des'] = $row->DesDesempeno;
				$datos['acc'] = $row->Acciones;
				$datos['cam'] = $row->Cambios;
				$datos['rec'] = $row->Recomendaciones;
				$datos['asu'] = $row->AsuntosGenerales;
				$datos['tar'] = $row->Tareas;
			endforeach;
		}
		else {
			redirect( "listados/minutas" );
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/minutas/ver_modificar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}	
}