<?php 
/****************************************************************************************************
*
*	CONTROLLERS/evaluaciones/satisfaccion_sibib.php
*
*		Descripción:
*			Evaluación a la Satisfacción de Usuarios del SIBIB
*
*		Fecha de Creación:
*			15/Octubre/2012
*
*		Ultima actualización:
*			15/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satisfaccion_sibib extends CI_Controller {
	
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
			$this->load->model('evaluaciones/satisfaccion_sibib_model','',TRUE);
			$this->set_id( 4 );
			$this->set_nom( 'satisfaccion_sibib' );
			$this->set_nombre( 'Evaluaci&oacute;n a la Satisfacci&oacute;n de Usuarios SIBIB' );
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
		$grafica = $this->db->get( 'en_total_satisfaccion_sibib' );
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
				// si ya no tiene nada que evaluar
				if( !$resp ){
					$datos['evalua'] = false;
				}
			}
		}
		else {
			// si esta activa pero ya terminó
			if( $edo == 'termino' ) {
				$datos['evalua'] = false;					
				// msj
				$datos['mensaje_titulo'] = "Evaluaci&oacute;n Terminada";
				$datos['mensaje'] = "Has terminado de capturar los resultados.<br /><strong>Gracias por tu participaci&oacute;n!</strong>";				
				$this->load->view('mensajes/ok',$datos);					
			}
			
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
		
		$consulta = $this->db->get_where( 'ab_bibliotecas', array('Estado' => '1') );
		if( $consulta->num_rows() > 0 ) {
			$main .= '<table class="tabla" width="670">';
			$resp = false;								
			$i = 0;
			
			// agrega las bibliotecas a evaluar
			foreach( $consulta->result() as $row ) {						
				$preguntas = $this->db->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide));
				$respuestas = $this->db->join('en_total_satisfaccion_sibib', 'en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib = en_respuestas_satisfaccion_sibib.IdTotalSatisfaccionSibib')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sibib.IdPregunta')->get_where('en_respuestas_satisfaccion_sibib', array('en_preguntas.IdEncuesta' => $ide, 'en_total_satisfaccion_sibib.IdEvaluacion' => $idv, 'en_total_satisfaccion_sibib.IdBiblioteca' => $row->IdBiblioteca));
				
				// revisa los usuarios que ya se evaluaron						
				if( $preguntas->num_rows() > $respuestas->num_rows() ) {
					$resp = true;
																	
					if( $i ) {
						$main .= '<tr class="odd">';
						$i = 0;
					}
					else {
						$main .= '<tr>';
						$i = 1;
					}
					$main .= '<th width="15"><a href="'.base_url().'index.php/evaluaciones/satisfaccion_sibib/contestar/'.$row->IdBiblioteca.'/'.$idv.'" onmouseover="ddrivetip(\'Click para alimentar<br />los datos de esta biblioteca\')" onmouseout="hideddrivetip()"><img src="'.base_url().'includes/img/icons/seguimiento.png" /></a></th><td><a href="'.base_url().'index.php/evaluaciones/satisfaccion_sibib/contestar/'.$row->IdBiblioteca.'/'.$idv.'" onmouseover="tip(\'Click para alimentar<br />los datos de esta biblioteca\')" onmouseout="cierra_tip()" style="color:#333">'.$row->Biblioteca.'</a></td></tr>';
				}
			}
		
			// si ya no hay usuarios para evaluar
			if( !$resp ) {
				$this->db->where('IdEvaluacion', $idv);
				$this->db->update('en_evaluacion', array('Estado' => '0'));
				redirect('evaluaciones/satisfaccion_sibib/index/termino');
			}
					
			$main .= '</table>';
		}
		else {
			// si no debe evaluar
			if( !$resp )
				redirect('evaluaciones/satisfaccion_sibib');
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
	function contestar( $idb, $idv ) {
		// variables necesarias para la página
		$datos['titulo'] = $this->nombre_evaluacion;
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['evaluacion'] = $this->nom_evaluacion;
		$ide = $this->id_evaluacion;
		$datos['ids'] = $idb;
		
		// obtiene el nombre de la bilbioteca
		$biblioteca = $this->db->get_where('ab_bibliotecas',array('ab_bibliotecas.IdBiblioteca' => $idb),1);				
		foreach( $biblioteca->result() as $row ) {
			$datos['biblioteca'] = $row->Biblioteca;
		}
		
		// obtiene la info de la encuesta
		// Solo BCU realiza satisfacción usuarios externos
		if( $idb == '7' ) {
			$secciones = $this->db->get_where('en_secciones', array('en_secciones.IdEncuesta' => $ide));
		}
		else {
			$secciones = $this->db->get_where('en_secciones', array('en_secciones.IdEncuesta' => $ide, 'en_secciones.IdSeccion <>' => '36'));
		}
		$preguntas = $this->db->join('en_encuestas','en_encuestas.IdEncuesta = en_preguntas.IdEncuesta')->get_where('en_preguntas', array('en_preguntas.IdEncuesta' => $ide));
		$datos['secciones'] = $secciones;
		$datos['preguntas'] = $preguntas;
		if( $preguntas->num_rows() > 0 ) {
			foreach( $preguntas->result() as $row ) {
				$datos['titulo_encuesta'] = $row->Encuesta;
				$datos['opciones'] = $this->db->get_where('en_opciones', array('en_opciones.IdOpcionTipo' => $row->IdOpcionTipo));
			}
		}
				
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('_estructura/top',$datos);
			
		// Guarda las resupuestas
		if( $_POST ) {
			if( $secciones->num_rows() > 0 ) {
				$i = 0;
				$val = true;
				$sum = true;
				$inserta = array();
				foreach( $secciones->result() as $row ) {							
					$this->form_validation->set_rules('sec_'.$row->IdSeccion, 'N&uacute;mero total de usuarios encuestados', 'required|trim');							
					$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
					
					// envia mensaje de error si no se cumple con alguna regla
					if ($this -> form_validation -> run() == FALSE) {								
						$val = false;
					}
					else {									
						$inserta_total = array(
							'IdBiblioteca' 	=> $idb, 
							'IdEvaluacion' 	=> $idv,
							'IdSeccion' 	=> $row->IdSeccion, 
							'Total' 		=> $this->input->post('sec_'.$row->IdSeccion)
						);
						$num_total = $this->input->post('sec_'.$row->IdSeccion);
						$resp = $this->db->insert('en_total_satisfaccion_sibib', $inserta_total);
						
						if( $resp ) {
							$total = $this->db->order_by('IdTotalSatisfaccionSibib','DESC')->get_where('en_total_satisfaccion_sibib', $inserta_total);
							foreach( $total->result() as $row_t )
								$idt = $row_t->IdTotalSatisfaccionSibib; 
							if( $preguntas->num_rows() > 0 ) {									
								foreach( $preguntas->result() as $row_p ) {
									$opciones = $this->db->get_where('en_opciones', array('en_opciones.IdOpcionTipo' => $row_p->IdOpcionTipo));
									if( $row->IdSeccion == $row_p->IdSeccion ) {
										if( $opciones->num_rows() > 0 ) {
											$sum_total = 0;
											foreach( $opciones->result() as $row_o ) {												
												$inserta[$i] = array(
													'IdTotalSatisfaccionSibib' 	=> $idt,														
													'IdPregunta'				=> $row_p->IdPregunta,
													'IdOpcion'					=> $row_o->IdOpcion,
													'Numero'					=> $this->input->post($row->IdSeccion.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion),
												);
												$sum_total = $sum_total + $this->input->post($row->IdSeccion.'_'.$row_p->IdPregunta.'_'.$row_o->IdOpcion);
												$i++;
											}
										}
									}
									if( $num_total != $sum_total )
										$sum = false;
								}
							}								
						}
					}
				}
				
				// valida si se inserta o si falta algun dato
				if( $val ) {
					$resp = $this->db->insert_batch('en_respuestas_satisfaccion_sibib', $inserta);
					if( $resp ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al guardar";
						$datos['mensaje'] = "Los datos se han guardado correctamente";
						$datos['enlace'] = "evaluaciones/satisfaccion_sibib/presentacion";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
					else {
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = "Ha ocurrido un error, la informaci&oacute;n no se ha guardado, porfavor intentalo de nuevo";
						$this->load->view('mensajes/error',$datos);
					}
				}
				else 
					$this->load->view('mensajes/error_validacion', $datos);
			}
		}
		// estructura de la página (2)
		$this->load->view('evaluaciones/satisfaccion_sibib/contestar',$datos);
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
		
		// Bibliotecas
		$bibliotecas = $this->db->order_by('Biblioteca')->get_where('ab_bibliotecas', array('Estado' => '1'));
		if ($bibliotecas -> num_rows() > 0) {
			$datos['areas'] = array();
			$datos['areas']['all'] = " - Todas las Bibliotecas - ";
			foreach ($bibliotecas->result() as $row)
				$datos['areas'][$row->IdBiblioteca] = $row->Biblioteca;
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
		
		// bibliotecas
		if( $ida != "all") {
			$consulta_biblioteca = $this->db->get_where('ab_bibliotecas',array('IdBiblioteca' => $ida));
			foreach( $consulta_biblioteca->result() as $row )
				$datos['biblioteca'] = $row->Biblioteca;
		}
		else {
			$datos['biblioteca'] = 'Todas las Bibliotecas';
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
		
	// Resultados Generales( todas las bibliotecas y todas las secciones)		
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
			$array_resultados_a = array(0, 0, 0, 0);
			$array_resultados_b = array(0, 0, 0, 0);
			$opc = array('Bastante','Si','Dificilmente','No');
			$tags_opciones = array('Bastante','Si','Dificilmente','No');					
															
			// evaluaciones
			$evaluaciones = $this->db->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
			if( $evaluaciones->num_rows() > 0 ) {						
				foreach( $evaluaciones->result() as $row_eva ) {
					$tabla_header_evaluaciones .= '<th colspan="8" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">'.$row_eva->Nombre.'</th>';
					//areas
					$areas = $this->db->order_by('Biblioteca')->get_where('ab_bibliotecas',array('Estado' => 1));
					if( $areas->num_rows() > 0 ) {
						foreach( $areas->result() as $row_are ) {
							$tabla_renglones .= '<tr><td style="text-align:left;">'.$row_are->Biblioteca.'</td>';
							// usuarios totales
							$usuarios_totales = $this->db->group_by('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib')->select('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib, en_total_satisfaccion_sibib.Total, en_total_satisfaccion_sibib.IdSeccion, en_preguntas.IdOpcionTipo, ab_bibliotecas.Biblioteca, en_secciones.Seccion')->join('ab_bibliotecas','ab_bibliotecas.IdBiblioteca = en_total_satisfaccion_sibib.IdBiblioteca')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sibib.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sibib',array('en_total_satisfaccion_sibib.IdBiblioteca' => $row_are->IdBiblioteca, 'en_total_satisfaccion_sibib.IdEvaluacion' => $row_eva->IdEvaluacion));							
							if( $usuarios_totales->num_rows() > 0 ) {
								$tabla_header_secciones = '';
								$tabla_header_opciones = '';
								$total_captura = 0;																
								foreach( $usuarios_totales->result() as $row_usu ) {																			
									$tabla_header_secciones .= '<th colspan="4" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center;">'.$row_usu->Seccion.'</th>';											
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									$total_captura = $total_captura + $opciones->num_rows(); 											
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:12px; color:#FFF; text-align:center">'.$opc[$i].'</th>';
											// resultados
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sibib.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sibib.IdPregunta')->get_where('en_respuestas_satisfaccion_sibib',array('en_respuestas_satisfaccion_sibib.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sibib.IdTotalSatisfaccionSibib' => $row_usu->IdTotalSatisfaccionSibib));													
											if( $resultados->num_rows() > 0 ) {																							
												$total_opcion = 0;																									
												foreach( $resultados->result() as $row_res ) {															
													$total_opcion = $total_opcion + $row_res->Numero;
												}
												if( $resultados->num_rows() * $row_usu->Total  )														
													$total_opcion = round( ( $total_opcion * 100 ) / ( $resultados->num_rows() * $row_usu->Total ) * 100) / 100;
												else
													$total_opcion = 0;
												
												$k = $i + 1;
												if( $k == $opciones->num_rows() )
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
												else
													$tabla_renglones .= '<td>'.$total_opcion.'%</td>';
												
												if( $total_captura == 4 ) {
													$array_resultados_a[$i] = $array_resultados_a[$i] + $total_opcion;
													$total_resultados_a = $total_resultados_a + $total_opcion;
												}
												
												if( $total_captura == 8 ) {
													$array_resultados_b[$i] = $array_resultados_b[$i] + $total_opcion;
													$total_resultados_b = $total_resultados_b + $total_opcion;	
												}														
											}
											$i++;
										}
									}											
									if( $usuarios_totales->num_rows() == 1 ) {
										$tabla_header_evaluaciones = '<th colspan="8" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_eva->Nombre.'</th>';
									} 									
								}
								if( $total_captura == 4 ) {
									$tabla_renglones .= '<td style="border:1px solid #EEE">0%</td><td>0%</td><td>0%</td><td style="border:1px solid #EEE">0%</td>';
								}
							}
							else {
								for( $i = 0; $i < 8; $i++ ) {
									if( $i == 3 || $i == 7 )
										$tabla_renglones .= '<td>0%</td>';
									else
										$tabla_renglones .= '<td>0%</td>';
								}
							}
							$tabla_renglones .= '</tr>';
						}
					}
				}
				$tabla_header = '<tr><th rowspan="3" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">&Aacute;rea</th>'.$tabla_header_evaluaciones.'</tr><tr>'.$tabla_header_secciones.'</tr><tr>'.$tabla_header_opciones.'</tr>';
			}
			$footer_a = '';
			$footer_b = ''; 
			$tabla_footer = '<tr><th>Total</th>';					
			for ( $i = 0; $i < sizeof( $array_resultados_a ); $i++) {
				if( $total_resultados_a )						
					$res_a = round( ( ( ( $array_resultados_a[$i] * 100 ) / $total_resultados_a ) * 100 ) / 100 );
				else
					$res_a = 0;
				
				if( $total_resultados_b )
					$res_b = round( ( ( ( $array_resultados_b[$i] * 100 ) / $total_resultados_b ) * 100 ) / 100 );
				else
					$res_b = 0;
				
				$footer_a .= '<th>'.$res_a.'%</th>';
				$footer_b .= '<th>'.$res_b.'%</th>';
				$grafica_resultado .= '["'.$tags_opciones[$i].'",'.$res_a.'],';
			}					
			$tabla_footer .= $footer_a.$footer_b.'</tr>';
		}
		
	// Resultados generales de la biblioteca
		if( $ida != 'all' && $ids == 'all') {
			$concepto = '';
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';
			$tabla_header_evaluaciones = '';
			$tabla_header_secciones = '';
			$tabla_header_opciones = '';					
			$opc = array('Bastante','Si','Dificilmente','No');
			$tags_opciones = array('Bastante','Si','Dificilmente','No');
			$array_resultados = array(0, 0, 0, 0, );
			
			// bibliotecas
			$bibliotecas = $this->db->get_where('ab_bibliotecas',array('IdBiblioteca' => $ida),1);
			if( $bibliotecas->num_rows() > 0 ) {
				foreach( $bibliotecas->result() as $row_are ) {							
					// evaluaciones
					$evaluaciones = $this->db->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
					if( $evaluaciones->num_rows() > 0 ) {						
						foreach( $evaluaciones->result() as $row_eva ) {
							$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">'.$row_eva->Nombre.'</th>';
							// usuarios totales
							$usuarios_totales = $this->db->group_by('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib')->select('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib, en_total_satisfaccion_sibib.Total, en_total_satisfaccion_sibib.IdSeccion, en_preguntas.IdOpcionTipo, ab_bibliotecas.Biblioteca, en_secciones.Seccion')->join('ab_bibliotecas','ab_bibliotecas.IdBiblioteca = en_total_satisfaccion_sibib.IdBiblioteca')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sibib.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sibib',array('en_total_satisfaccion_sibib.IdBiblioteca' => $row_are->IdBiblioteca, 'en_total_satisfaccion_sibib.IdEvaluacion' => $row_eva->IdEvaluacion));
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
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sibib.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sibib.IdPregunta')->get_where('en_respuestas_satisfaccion_sibib',array('en_respuestas_satisfaccion_sibib.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sibib.IdTotalSatisfaccionSibib' => $row_usu->IdTotalSatisfaccionSibib));
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
			$tabla_footer = '<tr style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;"><th>Total</th>';					
			for ( $i = 0; $i < sizeof( $array_resultados ); $i++) {
				$res = $array_resultados[$i] / $usuarios_totales->num_rows(); 
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
			$opc = array('Bastabte','Si','Dificilmente','No');
			$tags_opciones = array('Bastante','Si','Dificilmente','No');
			$array_resultados = array(0, 0, 0, 0, );
															
			// evaluaciones
			$evaluaciones = $this->db->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
			if( $evaluaciones->num_rows() > 0 ) {						
				foreach( $evaluaciones->result() as $row_eva ) {
					$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">'.$row_eva->Nombre.'</th>';
					//areas
					$areas = $this->db->order_by('Biblioteca')->get_where('ab_bibliotecas',array('Estado' => 1));
					if( $areas->num_rows() > 0 ) {
						foreach( $areas->result() as $row_are ) {
							$tabla_renglones .= '<tr><td style="text-align:left;">'.$row_are->Biblioteca.'</td>';
							// secciones
							$secciones_totales = $this->db->group_by('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib')->select('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib, en_total_satisfaccion_sibib.Total, en_total_satisfaccion_sibib.IdSeccion, en_preguntas.IdOpcionTipo, ab_bibliotecas.Biblioteca, en_secciones.Seccion')->join('ab_bibliotecas','ab_bibliotecas.IdBiblioteca = en_total_satisfaccion_sibib.IdBiblioteca')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sibib.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sibib',array('en_total_satisfaccion_sibib.IdBiblioteca' => $row_are->IdBiblioteca, 'en_total_satisfaccion_sibib.IdEvaluacion' => $row_eva->IdEvaluacion, 'en_total_satisfaccion_sibib.IdSeccion' => $ids));							
							if( $secciones_totales->num_rows() > 0 ) {																
								foreach( $secciones_totales->result() as $row_usu ) {																			
									$tabla_header_secciones = '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center;">'.$row_usu->Seccion.'</th>';											
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										$tabla_header_opciones = '';
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:12px; color:#FFF; text-align:center;">'.$opc[$i].'</th>';													
											// resultados
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sibib.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sibib.IdPregunta')->get_where('en_respuestas_satisfaccion_sibib',array('en_respuestas_satisfaccion_sibib.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sibib.IdTotalSatisfaccionSibib' => $row_usu->IdTotalSatisfaccionSibib));													
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
								for( $i = 0; $i < 4; $i++ ) {
									if( $i == 3 )
										$tabla_renglones .= '<td>0%</td>';
									else
										$tabla_renglones .= '<td>0%</td>';
								}											
							}
							$tabla_renglones .= '</tr>';
						}
					}
				}
				$tabla_header = '<tr><th rowspan="3" style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;">&Aacute;rea</th>'.$tabla_header_evaluaciones.'</tr><tr>'.$tabla_header_secciones.'</tr><tr>'.$tabla_header_opciones.'</tr>';
			}
			$tabla_footer = '<tr style="font-weight:normal; font-size:18px; color:#FFF; text-align:center;"><th>Total</th>';					
			for ( $i = 0; $i < sizeof( $array_resultados ); $i++) {						
				$res = round( ( ( ( $array_resultados[$i] * 100 ) / $total_resultados ) * 100 ) / 100 );
				$tabla_footer .= '<th>'.$res.'%</th>';
				$grafica_resultado .= '["'.$tags_opciones[$i].'",'.$res.'],';
			}						
			$tabla_footer .= '</tr>';
		}
		
	// Resultados de un biblioteca y de una sección
		if( $ida != 'all' && $ids != 'all' ) {
			$concepto = '';
			$tabla_renglones = '';
			$grafica_resultado = '';
			$tabla_footer = '';
			$tabla_header_evaluaciones = '';
			$tabla_header_secciones = '';
			$tabla_header_opciones = '';
			$generar_grafica = 1;
			$opc = array('Bastante','Si','Dificilmente','No');
			$tags_opciones = array('Bastante','Si','Dificilmente','No');
			
			// areas
			$areas = $this->db->get_where('ab_bibliotecas',array('IdBiblioteca' => $ida),1);
			if( $areas->num_rows() > 0 ) {
				foreach( $areas->result() as $row_are ) {
					$tabla_renglones .= '<td style="text-align:left;">'.$row_are->Biblioteca.'</td>';
					// evaluaciones
					$evaluaciones = $this->db->get_where('en_evaluacion',array('IdEvaluacion' => $idv),1);
					if( $evaluaciones->num_rows() > 0 ) {						
						foreach( $evaluaciones->result() as $row_eva ) {
							$tabla_header_evaluaciones .= '<th colspan="12" style="font-weight:normal; font-size:18px; color:#FFF;">'.$row_eva->Nombre.'</th>';
							// usuarios totales
							$usuarios_totales = $this->db->group_by('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib')->select('en_total_satisfaccion_sibib.IdTotalSatisfaccionSibib, en_total_satisfaccion_sibib.Total, en_total_satisfaccion_sibib.IdSeccion, en_preguntas.IdOpcionTipo, ab_bibliotecas.Biblioteca, en_secciones.Seccion')->join('ab_bibliotecas','ab_bibliotecas.IdBiblioteca = en_total_satisfaccion_sibib.IdBiblioteca')->join('en_secciones','en_secciones.IdSeccion = en_total_satisfaccion_sibib.IdSeccion')->join('en_preguntas','en_preguntas.IdSeccion = en_secciones.IdSeccion')->get_where('en_total_satisfaccion_sibib',array('en_total_satisfaccion_sibib.IdBiblioteca' => $row_are->IdBiblioteca, 'en_total_satisfaccion_sibib.IdEvaluacion' => $row_eva->IdEvaluacion, 'en_total_satisfaccion_sibib.IdSeccion' => $ids));
							if( $usuarios_totales->num_rows() > 0 ) {																
								foreach( $usuarios_totales->result() as $row_usu ) {											
									$tabla_header_secciones .= '<th colspan="6" style="font-weight:normal; font-size:14px; color:#FFF; text-align:center">'.$row_usu->Seccion.'</th>';											
									// opciones
									$opciones = $this->db->order_by('Valor','DESC')->get_where('en_opciones', array('IdOpcionTipo' => $row_usu->IdOpcionTipo));
									if( $opciones->num_rows() > 0 ) {
										$i = 0;
										foreach( $opciones->result() as $row_opc) {
											$tabla_header_opciones .= '<th style="font-weight:normal; font-size:12px; color:#FFF; text-align:center;">'.$opc[$i].'</th>';																						
											// resultados
											$resultados = $this->db->join('en_opciones','en_opciones.IdOpcion = en_respuestas_satisfaccion_sibib.IdOpcion')->join('en_preguntas','en_preguntas.IdPregunta = en_respuestas_satisfaccion_sibib.IdPregunta')->get_where('en_respuestas_satisfaccion_sibib',array('en_respuestas_satisfaccion_sibib.IdOpcion' => $row_opc->IdOpcion, 'en_preguntas.IdSeccion' => $row_usu->IdSeccion, 'en_respuestas_satisfaccion_sibib.IdTotalSatisfaccionSibib' => $row_usu->IdTotalSatisfaccionSibib));
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
				  width: 700,
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
		$this->load->view('evaluaciones/satisfaccion_sibib/grafica',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
}
