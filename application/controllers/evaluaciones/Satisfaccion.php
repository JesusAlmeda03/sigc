<?php 
/****************************************************************************************************
*
*	CONTROLLERS/evaluaciones/satisfaccion.php
*
*		Descripción:
*			Evaluación a la Satisfacción de Usuarios
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			25/Septiembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satisfaccion extends CI_Controller {
	
/** Atributos **/
	private $id_evaluacion;
	private $nom_evaluacion;
	private $nombre_evaluacion;

/** Propiedades **/	
	public function set_id( $id ) { $this->id_evaluacion = $id; }
	public function set_nom( $nom ) { $this->nom_evaluacion = $nom; }
	public function set_nombre( $nombre ) { $this->nombre_evaluacion = $nombre; }
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
		// si no se ha identificado correctamente
		if( !$this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
		else {
			// Modelo
			$this->load->model('evaluaciones/satisfaccion_model','',TRUE);
			$this->set_id( 3 );
			$this->set_nom( 'satisfaccion' );
			$this->set_nombre( 'Evaluaci&oacute;n a la Satisfacci&oacute;n de Usuarios SIGC' );
		}
	}
	
/** Funciones **/
	//
	// index(): Opciones de la evaluación
	//
	function index() {
		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(4) ) {
			$edo = $this->uri->segment(4); 
		}
		else {
			$edo = '';
		}
		
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;

		$datos['preguntas'] = true;
		$datos['avance'] = false;
		
		// Revisa si existen resultados guardados para poder mostrar la opción de gráficas
		$grafica = $this->db->get( 'en_total_satisfaccion_sigc' );
		if( $grafica->num_rows > 0 ) {
			$datos['grafica'] = true;
		}
		else {
			$datos['grafica'] = false;
		}
		
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide, 'en_evaluacion.Estado' => '1'),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				$idv = $row->IdEvaluacion;
			}
			$resultados = $this->db->get_where('en_total_satisfaccion_sigc',array('IdEvaluacion' => $idv,'IdArea' => $this->session->userdata('id_area')));
			if( $resultados->num_rows() == 2 ) {
				$resp = false;
			}
			else {
				$resp = true;
			}
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// Revisa si hay evaluaciones activas
		$encuesta = $this->db->order_by('en_evaluacion.Fecha','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide, 'Estado' => '1'),1);		
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				$datos['nombre'] = $row->Nombre;
				$datos['evalua'] = $row->Estado; 							
					
				// si esta activa pero ya terminó
				if( $edo == 'termino' ) {
					$datos['evalua'] = false;					
					// msj
					$datos['mensaje_titulo'] = "Evaluaci&oacute;n Terminada";
					$datos['mensaje'] = "Has terminado de evaluar esta encuesta.<br /><strong>Gracias por tu participaci&oacute;n!</strong>";				
					$this->load->view('mensajes/ok',$datos);					
				}

				// si ya no tiene nada que evaluar
				if( !$resp || $this->session->userdata('id_sistema') == 2 ){
					$datos['evalua'] = false;
				}
			}
		}
		else {
			$datos['evalua'] = false;
		}	
				
		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/comun/inicio',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// preguntas(): Muestra el listado de las preguntas de la evaluación
	//
	function preguntas() {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;

		// Preguntas
		$datos['preguntas'] = $this->db->order_by('IdSeccion')->get_where('en_preguntas',array('en_preguntas.IdEncuesta' => $ide));
		
		// Secciones
		$datos['secciones'] = $this->db->order_by('IdSeccion')->get_where('en_secciones',array('en_secciones.IdEncuesta' => $ide));
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/comun/preguntas',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// presentacion(): Presentación de la evaluación (si es que tiene)	
	//
	function presentacion() {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		
		// Información de la evaluación
		$main = '';
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide, 'en_evaluacion.Estado' => '1'),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {
				$idv = $row->IdEvaluacion;				
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = $row->Encuesta.":<br /> <label style='font-size:14px'>".$row->Fecha."</label>";
				$main .= '<div style="width:680px; height:auto; padding:10px; font-size:12px; border:1px solid #F0F0F0;">'.$row->Presentacion.'</div><br />';
			}
		}
						
		$resultados = $this->db->get_where('en_total_satisfaccion_sigc',array('IdEvaluacion' => $idv, 'IdArea' => $this->session->userdata('id_area')));
		
		// si no ha contestado
		switch( $resultados->num_rows() ) {
			// muestra para contestar
			case 0 :						
				$sec = $this->db->get_where('en_secciones',array('IdEncuesta'=>$ide));
				if( $sec->num_rows() > 0 ) {
					$main .= '<table class="tabla_form" width="700">';
					foreach( $sec->result() as $row ) {
						$main .= '<tr><td width="15"><a href="'.base_url().'index.php/evaluaciones/satisfaccion/contestar/'.$row->IdSeccion.'/'.$idv.'" onmouseover="tip(\'Click para alimentar<br />los datos de estos usuarios\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
						$main .= '<td><a href="'.base_url().'index.php/evaluaciones/satisfaccion/contestar/'.$row->IdSeccion.'/'.$idv.'" onmouseover="tip(\'Click para alimentar<br />los datos de estos usuarios\')" onmouseout="cierra_tip()" style="color:#333">'.$row->Seccion.'</a></td></tr>';
					}
					$main .= '</table>';
				}
				break;
			
			// ya contesto una, muestra la otra
			case 1 :
				foreach( $resultados->result() as $row_r ) {						
					$sec = $this->db->get_where('en_secciones',array('IdEncuesta'=>$ide, 'IdSeccion <>' => $row_r->IdSeccion));
					if( $sec->num_rows() > 0 ) {
						$main .= '<table class="tabla_form" width="700">';
						foreach( $sec->result() as $row ) {
							$main .= '<tr><td width="15"><a href="'.base_url().'index.php/evaluaciones/satisfaccion/contestar/'.$row->IdSeccion.'/'.$idv.'" onmouseover="tip(\'Click para alimentar<br />los datos de estos usuarios\')" onmouseout="cierra_tip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></td>';
							$main .= '<td><a href="'.base_url().'index.php/evaluaciones/satisfaccion/contestar/'.$row->IdSeccion.'/'.$idv.'" onmouseover="tip(\'Click para alimentar<br />los datos de estos usuarios\')" onmouseout="cierra_tip()" style="color:#333">'.$row->Seccion.'</a></td></tr>';
						}
						$main .= '</table>';
				}
				}
				break;
				
			// numero máximo de grupo respuestas por evaluación 	
			case 2 :
				redirect('evaluaciones/satisfaccion/index/termino');
				break;						
		}        
		$datos['main'] = $main;
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/satisfaccion/preguntas',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// contestar( $ids, $idv ): Contesta una sección de opciones multiples de la evaluaci�n 
	//
	function contestar( $ids, $idv ) {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		$datos['ids'] = $ids;
				
		// nombre de la vista para contestar
		$pagina_contestar = 'contestar_satisfaccion_sigc';										
		
		// obtiene la info de la encuesta
		$secciones = $this->db->get_where('en_secciones', array('en_secciones.IdEncuesta' => $ide, 'IdSeccion' => $ids));
		if( $secciones->num_rows() > 0 ) {
			foreach( $secciones->result() as $row ) {
				$datos['seccion'] = $row->Seccion;
			}
		}
		$preguntas = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_preguntas.IdEncuesta')->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide, 'en_preguntas.IdSeccion' => $ids));
		$datos['preguntas'] = $preguntas;
		if( $preguntas->num_rows() > 0 ) {
			foreach( $preguntas->result() as $row ) {
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = $row->Encuesta;
				$datos['opciones'] = $this->db->get_where('en_opciones', array('en_opciones.IdOpcionTipo' => $row->IdOpcionTipo));
			}
		}				
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		
		$resp = false;
		// Guarda las Respuestas
		if( $_POST ) {		
			// todas las preguntas					
			$preguntas = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_preguntas.IdEncuesta')->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide,'en_preguntas.IdSeccion' => $ids));

			$i = 0;
			$val = true;
			$sum = true;
			$inserta = array();
										
			$this -> form_validation -> set_rules('sec_'.$ids, 'N&uacute;mero total de usuarios encuestados', 'required|trim');							
			$this -> form_validation -> set_message('required', 'Debes introducir el campo <strong>%s</strong>');					
			// envia mensaje de error si no se cumple con alguna regla
			if ($this -> form_validation -> run() == FALSE) {								
				$val = false;
				$this -> load -> view('mensajes/error_validacion', $datos);
			}
			else {									
				$inserta_total = array(							
					'IdEvaluacion' 	=> $idv,
					'IdArea'		=> $this->session->userdata('id_area'),	
					'IdSeccion' 	=> $ids, 
					'Total' 		=> $this->input->post('sec_'.$ids)
				);
				$num_total = $this->input->post('sec_'.$ids);
				$resp = $this->db->insert('en_total_satisfaccion_sigc', $inserta_total);
				
				if( $resp ) {
					$total = $this->db->order_by('IdTotalSatisfaccionSigc','DESC')->get_where('en_total_satisfaccion_sigc', $inserta_total);
					foreach( $total->result() as $row_t )
						$idt = $row_t->IdTotalSatisfaccionSigc; 
					if( $preguntas->num_rows() > 0 ) {
						foreach( $preguntas->result() as $row_p ) {
							$opciones = $this->db->get_where('en_opciones', array('en_opciones.IdOpcionTipo' => $row_p->IdOpcionTipo));									
							if( $opciones->num_rows() > 0 ) {
								$sum_total = 0;
								foreach( $opciones->result() as $row_o ) {												
									$inserta[$i] = array(
										'IdTotalSatisfaccionSigc' 	=> $idt,														
										'IdPregunta'				=> $row_p->IdPregunta,
										'IdOpcion'					=> $row_o->IdOpcion,
										'Numero'					=> $this->input->post($ids.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion),
									);
									$sum_total = $sum_total + $this->input->post($ids.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion);
									$i++;
								}
							}							
						}
					}								
				}
				$resp = $this->db->insert_batch('en_respuestas_satisfaccion_sigc', $inserta);
				if( $resp ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al guardar";
					$datos['mensaje'] = "Los datos se han guardado correctamente";
					$datos['enlace'] = "evaluaciones/satisfaccion/presentacion";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, la informaci&oacute;n no se ha guardado, porfavor intentalo de nuevo";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('evaluaciones/satisfaccion/contestar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// resultados(): Muestra el formulario para generar la gráfica
	//
	function resultados() {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		
		// Revisa si existen resultados guardados para poder mostrar la opción de gráficas
		$grafica = $this->db->get( 'en_total_satisfaccion_sigc' );
		if( $grafica->num_rows == 0 ) {
			redirect( 'evaluaciones/satisfaccion' );
		}
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {			
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = "Gr&aacute;ficas de Resultados: ".$row->Encuesta;				
			}
		}		
		
		// Evaluaciones
		$evaluaciones = $this->db->order_by('IdEvaluacion', 'DESC')->get_where('en_evaluacion', array('IdEncuesta' => $ide));
		if ($evaluaciones -> num_rows() > 0) {
			$datos['eva'] = array();
			foreach ($evaluaciones->result() as $row)
				$datos['eva'][$row->IdEvaluacion] = $row->Nombre;
		}
		
		// Áreas
		$areas = $this->db->order_by('Area')->not_like('Area','Sistema Bibliotecario')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get('ab_areas');
		if ($areas -> num_rows() > 0) {
			$datos['areas'] = array();
			$datos['areas']['all'] = " - Todas las &Aacute;reas - ";
			foreach ($areas->result() as $row)
				$datos['areas'][$row -> IdArea] = $row -> Area;
		}
			
		// Secciones
		$sec = $this -> db -> order_by('IdSeccion') -> get_where('en_secciones', array('IdEncuesta' => $ide));
		if ($sec -> num_rows() > 0) {
			$datos['sec'] = array();
			$datos['sec']['all'] = " - Todas las Secciones - ";
			foreach ($sec->result() as $row)
				$datos['sec'][$row -> IdSeccion] = $row -> Seccion;
		}

		// Muestra la gráfica
		if( $_POST ) {
			$this->grafica( $this->input->post('area'), $this->input->post('seccion'), $this->input->post('evaluacion'));
		}
		else {
			// estructura de la página
			$this->load->view('_estructura/header',$datos);	
			$this->load->view('_estructura/top',$datos);
			$this->load->view('evaluaciones/comun/resultados',$datos);
			$this->load->view('_estructura/right');
			$this->load->view('_estructura/footer');
		}
	}
	
	//
	// grafica( $ida, $ids, $idu ): Muestra la grafica
	//
	function grafica( $ida, $ids, $idv ) {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		
		// Información de la encuesta
		$encuesta = $this->db->order_by('en_evaluacion.IdEvaluacion','DESC')->join('en_evaluacion','en_evaluacion.IdEncuesta = en_encuestas.IdEncuesta')->get_where('en_encuestas',array('en_encuestas.IdEncuesta' => $ide),1);
		if( $encuesta->num_rows() > 0 ) {
			foreach( $encuesta->result() as $row ) {			
				$datos['titulo'] = $row->Encuesta;
				$datos['titulo_encuesta'] = "Gr&aacute;ficas de Resultados: ".$row->Encuesta;				
			}
		}
		
		$consulta = array();
		
		// areas
		if( $ida != "all") {
			$consulta['ab_usuarios.IdArea'] = $ida;
			$consulta_area = $this->db->get_where('ab_areas',array('IdArea' => $ida));
			foreach( $consulta_area->result() as $row )
				$datos['area'] = $row->Area;
		}
		else {
			$datos['area'] = 'Todas las &Aacute;reas';
		}
		
		// secciones
		if( $ids != "all") {
			$consulta['en_preguntas.IdSeccion'] = $ids;
			$consulta_seccion = $this->db->get_where('en_secciones',array('IdSeccion' => $ids));
			foreach( $consulta_seccion->result() as $row )
				$datos['seccion'] = $row->Seccion;
		}
		else {
			$datos['seccion'] = 'Todas las Secciones';
		}		
		
		$alto = '50';
	// Resultados Generales( todas las áreas y todas las secciones)		
		if( $ida == 'all' && $ids == 'all' ) {
			$concepto = '';
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';
			$tabla_header_evaluaciones = '';
			$tabla_header_secciones = '';
			$tabla_header_opciones = '';
			$total_resultados_a = 0;
			$total_resultados_b = 0;
			$array_resultados_a = array(0, 0, 0, 0, 0, 0);
			$array_resultados_b = array(0, 0, 0, 0, 0, 0);
			$opc = array('MB','B','R','M','P','NA');					
			$tags_opciones = array('Muy Bueno','Bueno','Regular','Malo','Pesimo','No Aplica');
															
			// evaluaciones
			$evaluaciones = $this->db->order_by('IdEvaluacion','DESC')->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
			if( $evaluaciones->num_rows() > 0 ) {						
				foreach( $evaluaciones->result() as $row_eva ) {
					$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';
					//areas
					$areas = $this->db->order_by('Area')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get('ab_areas');
					if( $areas->num_rows() > 0 ) {
						foreach( $areas->result() as $row_are ) {
							$tabla_renglones .= '<tr><td style="font-weight:normal; font-size:11px; color:#000; text-align:center">'.$row_are->Area.'</td>';
							// usuarios totales
							$usuarios_totales = $this->db->group_by('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc')->select('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc, en_total_satisfaccion_sigc.Total, en_total_satisfaccion_sigc.IdSeccion, en_preguntas.IdOpcionTipo, ab_areas.Area, en_secciones.Seccion')->join('ab_areas','ab_areas.IdArea = en_total_satisfaccion_sigc.IdArea')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sigc.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sigc',array('en_total_satisfaccion_sigc.IdArea' => $row_are->IdArea, 'en_total_satisfaccion_sigc.IdEvaluacion' => $row_eva->IdEvaluacion));							
							if( $usuarios_totales->num_rows() > 0 ) {
								$tabla_header_secciones = '';
								$tabla_header_opciones = '';
								$total_captura = 0;																
								foreach( $usuarios_totales->result() as $row_usu ) {																			
									$tabla_header_secciones .= '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_usu->Seccion.'</th>';											
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									$total_captura = $total_captura + $opciones->num_rows(); 											
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$opc[$i].'</th>';
											// resultados
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sigc.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sigc.IdPregunta')->get_where('en_respuestas_satisfaccion_sigc',array('en_respuestas_satisfaccion_sigc.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sigc.IdTotalSatisfaccionSigc' => $row_usu->IdTotalSatisfaccionSigc));													
											if( $resultados->num_rows() > 0 ) {																							
												$total_opcion = 0;																									
												foreach( $resultados->result() as $row_res ) {															
													$total_opcion = $total_opcion + $row_res->Numero;
												}
												if( $resultados->num_rows() * $row_usu->Total )
													$total_opcion = round( ( $total_opcion * 100 ) / ( $resultados->num_rows() * $row_usu->Total ) * 100) / 100;
												else
													$total_opcion = 0;
												$k = $i + 1;
												if( $k == $opciones->num_rows() )
													$tabla_renglones .= '<td  style="border-right:1px solid #CCC">'.$total_opcion.'%</td>';
												else
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
												
												if( $total_captura == 6 ) {
													$array_resultados_a[$i] = $array_resultados_a[$i] + $total_opcion;
													$total_resultados_a = $total_resultados_a + $total_opcion;
												}
												
												if( $total_captura == 12 ) {
													$array_resultados_b[$i] = $array_resultados_b[$i] + $total_opcion;
													$total_resultados_b = $total_resultados_b + $total_opcion;	
												}														
											}
											$i++;
										}
									}											
									if( $usuarios_totales->num_rows() == 1 ) {
										$tabla_header_evaluaciones = '<th colspan="12">'.$row_eva->Nombre.'</th>';
									} 									
								}
								if( $total_captura == 6 ) {
									$tabla_renglones .= '<td>0%</td><td>0%</td><td>0%</td><td>0%</td><td>0%</td><td>0%</td>';
								}
							}
							else {
								for( $i = 0; $i < 12; $i++ ) {
									if( $i == 5 || $i == 11 )
										$tabla_renglones .= '<td style="border-right:1px solid #CCC">0%</td>';
									else
										$tabla_renglones .= '<td>0%</td>';
								}
							}
							$tabla_renglones .= '</tr>';
						}
					}
				}
				$tabla_header = '<tr><th rowspan="3" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">&Aacute;rea</th>'.$tabla_header_evaluaciones.'</tr><tr>'.$tabla_header_secciones.'</tr><tr>'.$tabla_header_opciones.'</tr>';
			}
			$footer_a = '';
			$footer_b = ''; 
			$tabla_footer = '<tr style="font-weight:normal; font-size:14px; color:#FFF; text-align:center"><th style="font-size:18px; color:#FFF; text-align:center">Total</th>';					
			for ( $i = 0; $i < sizeof( $array_resultados_a ); $i++) {						
				$res_a = round( ( ( ( $array_resultados_a[$i] * 100 ) / $total_resultados_a ) * 100 ) / 100 );
				$res_b = round( ( ( ( $array_resultados_b[$i] * 100 ) / $total_resultados_b ) * 100 ) / 100 );
				$footer_a .= '<th style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$res_a.'%</th>';
				$footer_b .= '<th style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$res_b.'%</th>';
				$res_a = ( $res_a + $res_b ) / 2;
				$grafica_resultado .= '["'.$tags_opciones[$i].'",'.$res_a.'],';
			}
			$tabla_footer .= $footer_a.$footer_b.'</tr>';			
		}
		
	// Resultados generales del área
		if( $ida != 'all' && $ids == 'all') {
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
					$evaluaciones = $this->db->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
					if( $evaluaciones->num_rows() > 0 ) {						
						foreach( $evaluaciones->result() as $row_eva ) {
							$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">'.$row_eva->Nombre.'</th>';
							// usuarios totales
							$usuarios_totales = $this->db->group_by('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc')->select('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc, en_total_satisfaccion_sigc.Total, en_total_satisfaccion_sigc.IdSeccion, en_preguntas.IdOpcionTipo, ab_areas.Area, en_secciones.Seccion')->join('ab_areas','ab_areas.IdArea = en_total_satisfaccion_sigc.IdArea')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sigc.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sigc',array('en_total_satisfaccion_sigc.IdArea' => $row_are->IdArea, 'en_total_satisfaccion_sigc.IdEvaluacion' => $idv));
							if( $usuarios_totales->num_rows() > 0 ) {																
								foreach( $usuarios_totales->result() as $row_usu ) {											
									//$tabla_header_secciones .= '<th colspan="6" style="font-weight:normal; font-size:14px; color:#666; text-align:center; border:1px solid #666">'.$row_usu->Seccion.'</th>';
									$tabla_renglones .= '<td style="text-align:left;">'.$row_usu->Seccion.'</td>';
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										$tabla_header_opciones = '';
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:12px; color:#FFF; text-align:center;">'.$opc[$i].'</th>';
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
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
												else
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
													
												$array_resultados[$i] = $array_resultados[$i] + $total_opcion;  														
											}
											$i++;
										}																		
									}
									$tabla_renglones .= '</tr><tr>';
									if( $usuarios_totales->num_rows() == 1 ) {
										$tabla_header_evaluaciones = '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';
									} 									
								}
							}
							else {
								$tabla_renglones .= '<td style="font-style:italic; font-size:10px;">sin resultados por el momento</td>';
							}
						}
						$tabla_header = '<tr><th rowspan="3" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">&Aacute;rea</th>'.$tabla_header_evaluaciones.'</tr><tr>'.$tabla_header_secciones.'</tr><tr>'.$tabla_header_opciones.'</tr>';
					}
				}
			}
			$tabla_footer = '<tr><th>Total</th>';					
			for ( $i = 0; $i < sizeof( $array_resultados ); $i++) {
				if( $usuarios_totales->num_rows() > 0 )
					$res = $array_resultados[$i] / $usuarios_totales->num_rows();
				else 
					$res = 0; 
				$tabla_footer .= '<th>'.$res.'%</th>';
				$grafica_resultado .= '["'.$tags_opciones[$i].'",'.$res.'],';
			}						
			$tabla_footer .= '</tr>';
		}	

	// Resultados generales de una seccion
		if( $ida == 'all' && $ids != 'all' ) {
			$concepto = '';
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';
			$tabla_header_evaluaciones = '';
			$tabla_header_secciones = '';
			$tabla_header_opciones = '';		
			$total_resultados = 0;			
			$opc = array('MB','B','R','M','P','NA');
			$array_resultados = array(0, 0, 0, 0, 0, 0);
			$tags_opciones = array('Muy Bueno','Bueno','Regular','Malo','Pesimo','No Aplica');
															
			// evaluaciones
			$evaluaciones = $this->db->order_by('IdEvaluacion','DESC')->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
			if( $evaluaciones->num_rows() > 0 ) {						
				foreach( $evaluaciones->result() as $row_eva ) {
					$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';
					//areas
					$areas = $this->db->order_by('Area')->not_like('Area','Sistema Bibliotecario')->not_like('Area','Invitado')->not_like('Area','Coordinación de Calidad')->get('ab_areas');
					if( $areas->num_rows() > 0 ) {
						foreach( $areas->result() as $row_are ) {
							$tabla_renglones .= '<tr><td style="font-weight:normal; font-size:14px; color:#666; text-align:center">'.$row_are->Area.'</td>';
							// secciones
							$secciones_totales = $this->db->group_by('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc')->select('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc, en_total_satisfaccion_sigc.Total, en_total_satisfaccion_sigc.IdSeccion, en_preguntas.IdOpcionTipo, ab_areas.Area, en_secciones.Seccion')->join('ab_areas','ab_areas.IdArea = en_total_satisfaccion_sigc.IdArea')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sigc.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sigc',array('en_total_satisfaccion_sigc.IdArea' => $row_are->IdArea, 'en_total_satisfaccion_sigc.IdEvaluacion' => $row_eva->IdEvaluacion, 'en_total_satisfaccion_sigc.IdSeccion' => $ids));							
							if( $secciones_totales->num_rows() > 0 ) {																
								foreach( $secciones_totales->result() as $row_usu ) {																			
									$tabla_header_secciones = '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_usu->Seccion.'</th>';											
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										$tabla_header_opciones = '';
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$opc[$i].'</th>';													
											// resultados
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sigc.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sigc.IdPregunta')->get_where('en_respuestas_satisfaccion_sigc',array('en_respuestas_satisfaccion_sigc.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sigc.IdTotalSatisfaccionSigc' => $row_usu->IdTotalSatisfaccionSigc));													
											if( $resultados->num_rows() > 0 ) {																																				
												$total_opcion = 0;																									
												foreach( $resultados->result() as $row_res ) {															
													$total_opcion = $total_opcion + $row_res->Numero;
												}														
												if( $resultados->num_rows() > 0 && $row_usu->Total > 0 ) {
													$total_opcion = round( ( $total_opcion * 100 ) / ( $resultados->num_rows() * $row_usu->Total ) * 100) / 100;
												}
												else {
													$total_opcion = 0;
												}
												$k = $i + 1;													
												if( $k == $opciones->num_rows() )
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
												else
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
													
												$array_resultados[$i] = $array_resultados[$i] + $total_opcion;
												$total_resultados = $total_resultados + $total_opcion;
											}
											$i++;
										}
									}											
									if( $secciones_totales->num_rows() == 1 ) {
										$tabla_header_evaluaciones = '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';
									} 									
								}
							}
							else {
								for( $i = 0; $i < 6; $i++ ) {
									if( $i == 5 )
										$tabla_renglones .= '<td>0%</td>';
									else
										$tabla_renglones .= '<td>0%</td>';
								}											
							}
							$tabla_renglones .= '</tr>';
						}
					}
				}
				$tabla_header = '<tr><th rowspan="3" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">&Aacute;rea</th>'.$tabla_header_evaluaciones.'</tr><tr>'.$tabla_header_secciones.'</tr><tr>'.$tabla_header_opciones.'</tr>';
			}
			$tabla_footer = '<tr><th style="font-size:18px; color:#FFF; text-align:center">Total</th>';
			for ( $i = 0; $i < sizeof( $array_resultados ); $i++) {						
				$res = round( ( ( ( $array_resultados[$i] * 100 ) / $total_resultados ) * 100 ) / 100 );
				$tabla_footer .= '<th>'.$res.'%</th>';
				$grafica_resultado .= '["'.$tags_opciones[$i].'",'.$res.'],';
			}						
			$tabla_footer .= '</tr>';
		}
		
	// Resultados de un área y de una sección
		if( $ida != 'all' && $ids != 'all' ) {
			$concepto = '';
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';
			$tabla_header_evaluaciones = '';
			$tabla_header_secciones = '';
			$tabla_header_opciones = '';
			$generar_grafica = 1;
			$opc = array('MB','B','R','M','P','NA');
			$tags_opciones = array('Muy Bueno','Bueno','Regular','Malo','Pesimo','No Aplica');
			
			// areas
			$areas = $this->db->get_where('ab_areas',array('IdArea' => $ida),1);
			if( $areas->num_rows() > 0 ) {
				foreach( $areas->result() as $row_are ) {
					$tabla_renglones .= '<td style="text-align:left;">'.$row_are->Area.'</td>';
					// evaluaciones
					$evaluaciones = $this->db->order_by('IdEvaluacion','DESC')->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
					if( $evaluaciones->num_rows() > 0 ) {						
						foreach( $evaluaciones->result() as $row_eva ) {
							$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">'.$row_eva->Nombre.'</th>';
							// usuarios totales
							$usuarios_totales = $this->db->group_by('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc')->select('en_total_satisfaccion_sigc.IdTotalSatisfaccionSigc, en_total_satisfaccion_sigc.Total, en_total_satisfaccion_sigc.IdSeccion, en_preguntas.IdOpcionTipo, ab_areas.Area, en_secciones.Seccion')->join('ab_areas','ab_areas.IdArea = en_total_satisfaccion_sigc.IdArea')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sigc.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sigc',array('en_total_satisfaccion_sigc.IdArea' => $row_are->IdArea, 'en_total_satisfaccion_sigc.IdEvaluacion' => $row_eva->IdEvaluacion, 'en_total_satisfaccion_sigc.IdSeccion' => $ids));
							if( $usuarios_totales->num_rows() > 0 ) {																
								foreach( $usuarios_totales->result() as $row_usu ) {											
									$tabla_header_secciones .= '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center;">'.$row_usu->Seccion.'</th>';											
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:12px; color:#FFF; text-align:center;">'.$opc[$i].'</th>';																						
											// resultados
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sigc.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sigc.IdPregunta')->get_where('en_respuestas_satisfaccion_sigc',array('en_respuestas_satisfaccion_sigc.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sigc.IdTotalSatisfaccionSigc' => $row_usu->IdTotalSatisfaccionSigc));
											if( $resultados->num_rows() > 0 ) {																							
												$total_opcion = 0;																									
												foreach( $resultados->result() as $row_res ) {															
													$total_opcion = $total_opcion + $row_res->Numero;
												}
																									
												// obtiene el resultado																											
												if( $resultados->num_rows() * $row_usu->Total ) {
													$total_opcion = round( ( $total_opcion * 100 ) / ( $resultados->num_rows() * $row_usu->Total ) * 100) / 100;
												}
												else {
													$total_opcion = 0;
													$generar_grafica++;
												}
												
												// general la gráfica con el resultado
												$k = $i + 1 ;																										
												if( $k == $opciones->num_rows() )
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
												else
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
												
												$grafica_resultado .= '["'.$tags_opciones[$i].'",'.$total_opcion.'],';
											}	
											$i++;
										}																		
									}											
									if( $usuarios_totales->num_rows() == 1 ) {
										$tabla_header_evaluaciones = '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';
									} 									
								}
							}
						}
						$tabla_header = '<tr><th rowspan="3" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">&Aacute;rea</th>'.$tabla_header_evaluaciones.'</tr><tr>'.$tabla_header_secciones.'</tr><tr>'.$tabla_header_opciones.'</tr>';
					}
				}
			}
			$grafica_resultado = substr($grafica_resultado,0,-1);					
			if( $generar_grafica == 7 ){
				$alto = '';
				$alto_grafica = '';
			}
		}
				
		// se llena la tabla con la información
		$datos['tabla'] = '<table class="tabla_form" width="700">'.$tabla_header.'</th>'.$tabla_renglones.'<tr>'.$tabla_footer.'</tr></table>';
				
		// Gráfica
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

		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
		$this->load->view('evaluaciones/satisfaccion/grafica',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
}