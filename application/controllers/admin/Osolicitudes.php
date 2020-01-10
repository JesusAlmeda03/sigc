<?php 
/****************************************************************************************************
*
*	CONTROLLERS/admin_files/solicitudes.php
*
*		Descripción:
*			Controlador de las acciones de las solicitudes
*
*		Fecha de Creación:
*			30/Octubre/2011
*
*		Ultima actualización:
*			26/Enero/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solicitudes extends CI_Controller {
	
/** Atributos **/
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_admin_model->get_menu( 'solicitudes' );
	}
	
	public function get_barra( $enlaces ) {
		$this->barra = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';
		
		foreach( $enlaces as $enlace => $titulo ) {
			$this->barra .= '
				<img src="'.base_url().'includes/img/arrow_right.png"/>
				<a href="'.base_url().'index.php/admin/solicitudes/'.$enlace.'">'.$titulo.'</a>
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
				$this->load->model('admin/solicitudes_admin_model','',TRUE);
				$this->set_menu();
			}
		}
		else {
			redirect( 'inicio' );
		}
	}

/** Funciones **/
	//
	// autorizar(): Listado de solicitudes para autorizar
	//
	function autorizar() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$ida = $this->input->post('area');
			$tip = $this->input->post('tipo');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$ida = $this->uri->segment(4);
				$tip = $this->uri->segment(5);
			}
			else {
				$ida = "elige";
				$tip = "todos";
			}
		}
		$datos['area'] = $ida;
		$datos['tipo'] = $tip;
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Autorizar Solicitudes';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'autorizar' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);		
					
		// obtiene todas las areas
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		$datos['tipo_options'] = array(
			'todos'			=> ' - Todas - ', 
			'Alta' 			=> 'Alta', 
			'Baja' 			=> 'Baja', 
			'Modificacion' 	=> 'Modificaci&oacute;n',
		);

		// se obtiene el listado
		$this->db->order_by("Fecha", "ASC");
		$this->db->join("ab_areas", "ab_areas.IdArea = pa_solicitudes.IdArea");
		$this->db->join("bc_documentos", "bc_documentos.IdDocumento = pa_solicitudes.IdDocumento");
		$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
		$this->db->select('bc_secciones.Seccion,bc_secciones.Comun,pa_solicitudes.IdSolicitud,pa_solicitudes.IdDocumento,pa_solicitudes.IdArea,pa_solicitudes.Solicitud,pa_solicitudes.Fecha,pa_solicitudes.Observaciones,pa_solicitudes.Estado,ab_areas.Area,bc_documentos.Codigo,bc_documentos.Edicion,bc_documentos.Nombre,bc_documentos.Ruta');
		// muestra todo el listado
		if( $ida == 'todos' ) {
			if( $tip == 'todos' ) {
				$consulta = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.Estado' => '2'));
			}
			else {
				$consulta = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.Estado' => '2', 'Solicitud' => $tip));
			}
		}
		// muestra el listado del estado específico
		else {
			if( $tip == 'todos' ) {
				$consulta = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.IdArea' => $ida, 'pa_solicitudes.Estado' => '2'));
			}
			else {
				$consulta = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.IdArea' => $ida, 'pa_solicitudes.Estado' => '2', 'Solicitud' => $tip));
			}
		}

		$listado_solicitudes = array();
		if ( $consulta -> num_rows() > 0 ) {
			$i = 0;			
			foreach ( $consulta->result() as $row ) {
				if( $row->Solicitud == 'Modificacion' ) {
					$documento_mod = $this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes_modificacion.IdDocumento')->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion')->get_where('pa_solicitudes_modificacion',array('pa_solicitudes_modificacion.IdSolicitud' => $row->IdSolicitud),1);
					if( $documento_mod->num_rows() > 0 ) {
						foreach( $documento_mod->result() as $row_d ) {
							$listado_solicitudes[$i] = array(
								'Edicion'		=> $row_d->Edicion,
								'IdSolicitud' 	=> $row->IdSolicitud,
								'IdDocumento'	=> $row_d->IdDocumento,
								'IdArea'		=> $row_d->IdArea,
								'Solicitud'		=> $row->Solicitud,
								'Seccion'		=> $row_d->Seccion,
								'Comun'			=> $row_d->Comun,								
								'Fecha'			=> $row->Fecha,
								'Observaciones'	=> $row->Observaciones,
								'Estado'		=> $row->Estado,
								'Area'			=> $row->Area,
								'Codigo'		=> $row_d->Codigo,
								'Nombre'		=> $row_d->Nombre,
								'Ruta'			=> $row_d->Ruta,
							);
						}
					}									
				}
				else {
					$listado_solicitudes[$i] = array(
						'Edicion'		=> $row->Edicion,
						'IdSolicitud' 	=> $row->IdSolicitud,
						'IdDocumento'	=> $row->IdDocumento,
						'IdArea'		=> $row->IdArea,
						'Solicitud'		=> $row->Solicitud,
						'Seccion'		=> $row->Seccion,
						'Comun'			=> $row->Comun,
						'Fecha'			=> $row->Fecha,
						'Observaciones'	=> $row->Observaciones,
						'Estado'		=> $row->Estado,
						'Area'			=> $row->Area,
						'Codigo'		=> $row->Codigo,
						'Nombre'		=> $row->Nombre,
						'Ruta'			=> $row->Ruta,
					);
				}
				$i++;
				$datos['listado_solicitudes'] = $listado_solicitudes;
			}
		}
		else {
			$datos['listado_solicitudes'] = $listado_solicitudes;
		}
		
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$resp = true;
			
			// Aceptar solicitudes
			if( $this->input->post('boton_aceptar') ) {				
				$actualiza_solicitud = array( 'Estado' => '3' );
				$estado_solicitud = '3';				
			}
			// Rechazar solicitudes
			elseif( $this->input->post('boton_rechazar') ) {							
				$actualiza_solicitud = array( 'Estado' => '4', 'Rechazo' => '3' );
				$estado_solicitud = '4';				
			}
								
			// Todas las solicitudes pendientes
			if( $this->input->post('solicitud') ) {
				foreach( $this->input->post('solicitud') as $lista ) :								
					// modifica el documento
					if( $this->input->post('boton_aceptar') ) {
						switch( $this->input->post('tipo_solicitud_'.$lista) ) {
							case "Alta" :	
								$alta = $this->db->select('bc_documentos.IdDocumento,bc_documentos.IdSeccion,bc_documentos.Fecha,bc_documentos.IdArea,bc_documentos.Ruta')->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento')->get_where('pa_solicitudes', array('IdSolicitud' => $lista));
								if( $alta->num_rows() > 0 ) {
									foreach( $alta->result() as $row) {
										// configuración del archivo a subir
										$nom_doc = $row->IdArea."-".$row->IdSeccion."-".substr(md5(uniqid(rand())),0,6);
										$config['file_name'] = $nom_doc;
										$config['upload_path'] = './includes/docs/';
										$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|ppt|pptx';
										$config['max_size']	= '0';
								
										$this->load->library('upload', $config);
								
										if ( !$this->upload->do_upload('archivo_'.$lista) ) {											
											// msj de error
											$datos['mensaje_titulo'] = "Error";
											$datos['mensaje'] = $this->upload->display_errors();
											$this->load->view('mensajes/error',$datos);
											$resp = false;
										}
										else {
											// renombra el documento
											$upload_data = $this->upload->data();
											$ruta = $nom_doc.$upload_data['file_ext'];
												
											// actualiza
											$resp = $this->db->where('IdDocumento',$row->IdDocumento)->update('bc_documentos', array('Estado' => '1', 'Ruta' => $ruta ));
											
											if( $resp )
												// Inserta en la tabla de documentos_word
												$resp = $this->db->insert('bc_documentos_word', array('IdDocumento' => $row->IdDocumento, 'Ruta' => $row->Ruta, 'FechaElaboracion' => $row->Fecha ));
												
										}
									}
								}
								break;
								
							case "Baja" :
								$baja = $this->db->get_where('pa_solicitudes', array('IdSolicitud' => $lista));
								if( $baja->num_rows() > 0 ) {
									foreach( $baja->result() as $row) {
										$resp = $this->db->where('IdDocumento',$row->IdDocumento)->update('bc_documentos', array('Estado' => '0' ));
									}
								}
								break;
								
							case "Modificacion" :
								$this->db->order_by('bc_documentos.IdDocumento');
								
								$modificacion = $this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento')->get_where('pa_solicitudes', array('IdSolicitud' => $lista));
								if( $modificacion->num_rows() > 0 ) {
									foreach( $modificacion->result() as $row) {
										// configuración del archivo a subir
										$nom_doc = $row->IdArea."-".$row->IdSeccion."-".substr(md5(uniqid(rand())),0,6);
										$config['file_name'] = $nom_doc;
										$config['upload_path'] = './includes/docs/';
										$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|ppt|pptx';
										$config['max_size']	= '0';
								
										$this->load->library('upload', $config);
								
										if ( !$this->upload->do_upload('archivo_'.$lista) ) {											
											// msj de error
											$datos['mensaje_titulo'] = "Error";
											$datos['mensaje'] = $this->upload->display_errors();
											$this->load->view('mensajes/error',$datos);
											$resp = false;
										}
										else {
											// renombra el documento
											$upload_data = $this->upload->data();
											$ruta = $nom_doc.$upload_data['file_ext'];
											
											// obtiene los datos correctos para modificar el documento 
											$this->db->order_by('bc_documentos.IdDocumento');
											$documento_mod = $this->db->select('bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, pa_solicitudes.Fecha')->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes_modificacion.IdDocumento')->join('pa_solicitudes','pa_solicitudes.IdSolicitud = pa_solicitudes_modificacion.IdSolicitud')->get_where('pa_solicitudes_modificacion',array('pa_solicitudes_modificacion.IdSolicitud' => $row->IdSolicitud),1);
											if( $documento_mod->num_rows() > 0 ) {
												foreach( $documento_mod->result() as $row_d ) {
													$actualizar = array(
														'Edicion'		=> $this->input->post('edicion'),
														'Codigo'		=> $row_d->Codigo,
														'Fecha'			=> $row_d->Fecha,
														'Nombre'		=> $row_d->Nombre,
														'Ruta'			=> $ruta,
													);
												}
											}											
																
											// actualiza
											$resp = $this->db->where('IdDocumento',$row->IdDocumento)->update('bc_documentos', $actualizar);
											
											if( $resp ) {
												// Actualiza en la tabla de documentos_word
												$doc = $this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes_modificacion.IdDocumento')->get_where('pa_solicitudes_modificacion',array('pa_solicitudes_modificacion.IdSolicitud' => $lista));
												if( $doc->num_rows() > 0 )
													foreach( $doc->result() as $row_d)
														$resp = $this->db->where('IdDocumento',$row->IdDocumento)->update('bc_documentos_word', array('Ruta' => $row_d->Ruta ));
											}
										}
									}
								}
								break;
						}
					}

					if( $resp ) {
						if( $this->input->post('observaciones_old_'.$lista) != "" )
							$obs_old = $this->input->post('observaciones_old_'.$lista)."<br />- - - - - - - - - - - - - - -<br />";
						else 
							$obs_old = "";
						if( $this->input->post('observaciones_'.$lista) != "" )
							$actualiza_solicitud['Observaciones'] = $obs_old."<strong>Observación Coordinación de Calidad:</strong>".$this->input->post('observaciones_'.$lista); 
						$resp = $this->db->where('pa_solicitudes.IdSolicitud',$lista)->update('pa_solicitudes', $actualiza_solicitud);
					}
				endforeach;
			}
			elseif( $this->input->post('boton_aceptar') || $this->input->post('boton_rechazar') ) {				
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes elegir al menos una Solicitud";				
				$this->load->view('mensajes/error', $datos);				
			}			

			if( $this->input->post('solicitud') && ( $this->input->post('boton_aceptar') || $this->input->post('boton_rechazar') ) ) {
				// msj de guardado
				if( $resp ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Las actualizaciones en las solicitudes se han guardado correctamente, los cambios ya seran visibles para los usuarios<br />&iquest;Deseas autorizar mas solicitudes?";
					$datos['enlace_si'] = "admin/solicitudes/autorizar";
					$datos['enlace_no'] = "admin/inicio";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				// msj de error
				else {				
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error, no todas las solicitudes se han aceptado. Por favor intentalo de nuevo";
					$datos['enlace'] = "admin/solicitudes/autorizar/".$ida."/".$tip;
					$this->load->view('mensajes/ok_redirec',$datos);											
				}
			}			
		}
		
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/autorizar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// listado(): Listado de solicitudes
	//
	function listado() {
		// si los datos han sido enviados por post se sobre escribe la variable $ide
		if( $_POST ) {
			$ida = $this->input->post('area');
			$edo = $this->input->post('estado');
			$tip = $this->input->post('tipo');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) || $this->uri->segment(6) ) {
				$ida = $this->uri->segment(4);
				$edo = $this->uri->segment(5);
				$tip = $this->uri->segment(6);
			}
			else {
				$ida = "elige";
				$edo = "0";
				$tip = "todos";
			}
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;
		$datos['tipo'] = $tip;
		
		// obtiene todas las areas
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		$datos['estado_options'] = array(
			'todos'	=> ' - Todas - ', 
			'0' 	=> 'Pendientes', 
			'1' 	=> 'Aceptadas por el Solicitador', 
			'2' 	=> 'Aceptadas por el Autorizador',
			'3' 	=> 'Aceptadas por Coordinaci&oacute;n de Calidad',
			'4' 	=> 'Rechazadas',
			'5' 	=> 'Eliminadas'
		);
		
		$datos['tipo_options'] = array(
			'todos'			=> ' - Todas - ', 
			'Alta' 			=> 'Alta', 
			'Baja' 			=> 'Baja', 
			'Modificacion' 	=> 'Modificaci&oacute;n',
		);

		// se obtiene el listado
		
		$this->db->join("ab_areas", "ab_areas.IdArea = pa_solicitudes.IdArea");
		$this->db->join("bc_documentos", "bc_documentos.IdDocumento = pa_solicitudes.IdDocumento");
		$this->db->select('pa_solicitudes.IdSolicitud,pa_solicitudes.IdDocumento,pa_solicitudes.IdArea,pa_solicitudes.Fecha,pa_solicitudes.Solicitud,pa_solicitudes.Estado,ab_areas.Area,bc_documentos.Codigo,bc_documentos.Nombre, bc_documentos.Edicion');
		// muestra todo el listado
		if( $ida == "todos" ) {
			if( $edo == "todos" ) {
				if( $tip == "todos" ) {
					$datos['consulta'] = $this->db->get('pa_solicitudes');
				}
				else {
					$datos['consulta'] = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.Solicitud' => $tip));
				}
			}
			else {
				if( $tip == "todos" ) {
					$datos['consulta'] = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.Estado' => $edo));
				}
				else{
					$datos['consulta'] = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.Estado' => $edo, 'pa_solicitudes.Solicitud' => $tip));
				}
			}
		}
		// muestra el listado del estado específico
		else {
			if( $edo == "todos" ) {
				if( $tip == "todos" ) {
					$datos['consulta'] = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.IdArea' => $ida));
				}
				else {
					$datos['consulta'] = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.IdArea' => $ida, 'pa_solicitudes.Solicitud' => $tip));
				}
			}
			else {
				if( $tip == "todos" ) {
					$datos['consulta'] = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.IdArea' => $ida, 'pa_solicitudes.Estado' => $edo));
				}
				else {
					$datos['consulta'] = $this->db->get_where('pa_solicitudes',array('pa_solicitudes.IdArea' => $ida, 'pa_solicitudes.Estado' => $edo, 'pa_solicitudes.Solicitud' => $tip));
				}
			}
		}
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Listado de Solicitudes';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'listado' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// ver_lista_distribucion( $ids ): Muestra la lista de distribucion de la solicitud
	//
	function ver_lista_distribucion( $ids ) {
		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ida = $this->uri->segment(5);
			$edo = $this->uri->segment(6);
			$tip = $this->uri->segment(7);
		}
		else {
			$ida = "elige";
			$edo = "0";
			$tip = "todos";
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;
		$datos['tipo'] = $tip;
		
		// si viene dirigido de las solicitudes a autorizar
		if( $this->uri->segment(8) ) {
			$datos['autorizar'] = true;
			$enlaces['autorizar/'.$ida.'/'.$tip] = 'Autorizar Solicitudes';
		}
		else {
			$datos['autorizar'] = false;
			$enlaces['listado'] = 'Listado de Solicitudes';
		}
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Lista de Distribuci&oacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$enlaces['ver_listada_distribucion/'.$ids] = $titulo;
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;
		
		// obtiene la lista
		$datos['usuarios'] = $this->db->order_by('pa_solicitudes_distribucion.Tipo','DESC')->join('pa_solicitudes_distribucion','ab_usuarios.IdUsuario = pa_solicitudes_distribucion.IdUsuario')->get_where('ab_usuarios',array('ab_usuarios.Estado' => '1', 'pa_solicitudes_distribucion.IdSolicitud' => $ids)); 
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/ver_lista_distribucion',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// ver( $ids ): Muestra el resumen de la solicitud
	//
	function ver( $ids ) {
		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ida = $this->uri->segment(5);
			$edo = $this->uri->segment(6);
			$tip = $this->uri->segment(7);
		}
		else {
			$ida = "elige";
			$edo = "0";
			$tip = "todos";
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;
		$datos['tipo'] = $tip;
		
		// si viene dirigido de las solicitudes a autorizar
		if( $this->uri->segment(8) ) {
			$datos['autorizar'] = true;
			$enlaces['autorizar/'.$ida.'/'.$tip] = 'Autorizar Solicitudes';
		}
		else {
			$datos['autorizar'] = false;
			$enlaces['listado'] = 'Listado de Solicitudes';
		}
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Solicitud';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$enlaces['ver/'.$ids] = $titulo;
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;
		
		// obtiene la info de la solicitud
		$consulta = $this->db->select('bc_documentos.Edicion,bc_documentos.IdDocumento,bc_documentos.Fecha as FechaDocumento,bc_documentos.Codigo,bc_documentos.Nombre,bc_documentos.IdSeccion,bc_documentos.Ruta,pa_solicitudes.IdSolicitud,pa_solicitudes.Observaciones,pa_solicitudes.Fecha,pa_solicitudes.Causas,pa_solicitudes.Solicitud')->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento')->get_where('pa_solicitudes',array('IdSolicitud' => $ids)); 
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :
				if( $row->Solicitud == 'Modificacion' ) {
					$documento_mod = $this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes_modificacion.IdDocumento')->get_where('pa_solicitudes_modificacion',array('pa_solicitudes_modificacion.IdSolicitud' => $row->IdSolicitud),1);
					if( $documento_mod->num_rows() > 0 ) {
						foreach( $documento_mod->result() as $row_d ) {
							$datos['ids'] = $row_d->IdSolicitud;
							$datos['doc'] = $row_d->Ruta;
							$datos['edi'] = $row_d->Edicion;
							switch( substr($row_d->Fecha,5,2) ) {
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
							$datos['fed'] = substr($row_d->Fecha,8,2)." / ".$mes." / ".substr($row_d->Fecha,0,4);
							$datos['cod'] = $row_d->Codigo;
							$datos['nom'] = $row_d->Nombre;
						}
					}
				}
				else {
					$datos['ids'] = $row->IdSolicitud;
					$datos['doc'] = $row->Ruta;
					$datos['edi'] = $row->Edicion;
					switch( substr($row->FechaDocumento,5,2) ) {
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
					$datos['fed'] = substr($row->FechaDocumento,8,2)." / ".$mes." / ".substr($row->FechaDocumento,0,4);
					$datos['cod'] = $row->Codigo;
					$datos['nom'] = $row->Nombre;
				}
				switch( substr($row->Fecha,5,2) ) {
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
				$datos['fec'] = substr($row->Fecha,8,2)." / ".$mes." / ".substr($row->Fecha,0,4);
				$datos['tip'] = $row->Solicitud;
				$datos['cau'] = $row->Causas;
				if( $row->Observaciones == "" )
					$datos['obs'] = '<label style="font-size:11px; font-style:italic">No hay observaciones</label>';
				else
					$datos['obs'] = $row->Observaciones;				
			endforeach;
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/ver',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// modificar( $ids ): Modifica las solicitudes
	//
	function modificar( $ids ) {
		if( $this->uri->segment(5) || $this->uri->segment(6) || $this->uri->segment(7) ) {
			$ida = $this->uri->segment(5);
			$edo = $this->uri->segment(6);
			$tip = $this->uri->segment(7);
		}
		else {
			$ida = "elige";
			$edo = "0";
			$tip = "todos";
		}
		$datos['area'] = $ida;
		$datos['estado'] = $edo;
		$datos['tipo'] = $tip;
		
		// si viene dirigido de las solicitudes a autorizar
		if( $this->uri->segment(8) ) {
			$datos['autorizar'] = true;
			$enlaces['autorizar/'.$ida.'/'.$tip] = 'Autorizar Solicitudes';
		}
		else {
			$datos['autorizar'] = false;
			$enlaces['listado'] = 'Listado de Solicitudes';
		}
		
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Modificar Solicitud';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$enlaces['modificar/'.$ids] = $titulo;
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		// estructura de la p�gina (1)
		$this->load->view('_estructura/header',$datos);
		
		// obtiene la información de la solicitud	
		$this->db->order_by('bc_documentos.IdDocumento');	
		$this->db->select('bc_documentos.IdDocumento,bc_documentos.Ruta,bc_documentos.Codigo,bc_documentos.Edicion,bc_documentos.Nombre,bc_documentos.IdSeccion,pa_solicitudes.Fecha,pa_solicitudes.Causas,pa_solicitudes.Solicitud');
		$this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento');
		$solicitud=$this->db->get_where('pa_solicitudes', array('IdSolicitud' => $ids ));
		if( $solicitud->num_rows() > 0 ) {			
			foreach( $solicitud->result() as $row ) {
				$idd = $row->IdDocumento; 
				$tipo = $row->Solicitud;
				$datos['tipo_solicitud'] = $row->Solicitud;
				$datos['codigo'] = $row->Codigo;
				$datos['nombre'] = $row->Nombre;
				$datos['edicion']= $row->Edicion;
				$datos['id_seccion'] = $row->IdSeccion;				
				$datos['fecha'] = $row->Fecha;				
				$datos['causas'] = $row->Causas;
				switch( $row->Solicitud ) {
					case "Alta" :
						$datos['ruta'] = $row->Ruta;
						break;
						
					case "Baja" :
						$datos['ruta'] = $row->Ruta;
						break;
						
					case "Modificacion" :
						$doc_sol = $this->db->select('bc_documentos.Ruta')->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes_modificacion.IdDocumento')->get_where('pa_solicitudes_modificacion', array('IdSolicitud' => $ids ));
						if( $doc_sol->num_rows() > 0 ) {			
							foreach( $doc_sol->result() as $row_d ) {
								$datos['ruta'] = $row_d->Ruta;
								
							}
						}
						break;
				}							
			}
		}
		
		// obtiene las secciones para las solicitudes
		//$where = "Seccion LIKE 'Instructivos de Trabajo' AND Comun = 0 OR Seccion LIKE 'Planes de Trabajo' AND Comun = 0";
		$this->db->order_by('bc_secciones.Seccion');
		$this->db->join('cd_sistemas', 'cd_sistemas.IdSistema=bc_secciones.IdSistema');
		$consulta=$this->db->get_where('bc_secciones', array('bc_secciones.Estado' => '1', 'bc_secciones.Listado' =>'1'));
		if( $consulta->num_rows() > 0 ) {
			$datos['seccion_options'] = array();
			foreach( $consulta->result() as $row ) {
				
				
					$datos['seccion_options'][$row->IdSeccion] = $row->Seccion." (".$row->Abreviatura.")";
			}
		}

		// modifica la solicitud
		if( $_POST ){		
			// reglas de validación
			if( $tipo != 'Baja' ) {
				$this->form_validation->set_rules('codigo', 'C&oacute;digo', 'trim');
				$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			}
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else {
				$resp = true;
				// si se va a modificar el documento
				if( $this->input->post('mod_archivo') ) {
					// configuración de los archivos a subir				
					$nom_doc = $this->session->userdata('id_area')."-".$this->input->post('seccion')."-".substr(md5(uniqid(rand())),0,6);
					$config['file_name'] = $nom_doc;
					$config['upload_path'] = './includes/docs/';
					$config['allowed_types'] = '*';
					$config['max_size']	= '0';
			
					$this->load->library('upload', $config);
			
					if ( !$this->upload->do_upload('archivo') ) {
						// msj de error
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = $this->upload->display_errors();
						$this->load->view('mensajes/error',$datos);
					}
					else {											
						// renombra el documento
						$upload_data = $this->upload->data();
						$nom_doc = $nom_doc.$upload_data['file_ext'];
						
						// si es alta
						if( $tipo == 'Alta' ) {
							// array para insertar el documento
							$modifica_documento = array(					   
							   'Ruta'		=> $nom_doc,
							   'Codigo'		=> $this->input->post('codigo'),
							   'Nombre'		=> $this->input->post('nombre'),
							   'Edicion'	=> $this->input->post('edicion'),
							   'IdSeccion'	=> $this->input->post('seccion'),					   
							);
							
							$resp = $this->db->where('IdDocumento',$idd)->update('bc_documentos', $modifica_documento);
						}
							
						// si es modificación
						if( $tipo == 'Modificacion' ) {
							$documento = $this->db->get_where('pa_solicitudes_modificacion',array('IdSolicitud' => $ids));
							foreach( $documento->result() as $row_dm )
								$idm = $row_dm->IdDocumento;
							// array para insertar el documento
							$modifica_documento = array(
							   'Ruta'		=> $nom_doc,
							   'Codigo'		=> $this->input->post('codigo'),
							   'Edicion'	=> $this->input->post('edicion'),
							   'Nombre'		=> $this->input->post('nombre'),
							   'IdSeccion'	=> $this->input->post('seccion'),					   
							);
							
							$resp = $this->db->where('IdDocumento',$idm)->update('bc_documentos', $modifica_documento);
						}																														 		
					}										
				}
				else {
					// si es alta
					if( $tipo == 'Alta' ) {
						// array para modificar el documento
						$modifica_documento = array(
						   'Codigo'		=> $this->input->post('codigo'),
						   'Nombre'		=> $this->input->post('nombre'),
						   'IdSeccion'	=> $this->input->post('seccion'),	
						   'Edicion'	=> $this->input->post('edicion'),
						   				   
						);
						
						$resp = $this->db->where('IdDocumento',$idd)->update('bc_documentos', $modifica_documento);
					}
						
					// si es modificación
					if( $tipo == 'Modificacion' ) {
						$documento = $this->db->get_where('pa_solicitudes_modificacion',array('IdSolicitud' => $ids));
						foreach( $documento->result() as $row_dm )
							$idm = $row_dm->IdDocumento;
						// array para modificar el documento
						$modifica_documento = array(						   
						   'Codigo'		=> $this->input->post('codigo'),
						   'Nombre'		=> $this->input->post('nombre'),
						   'Edicion'	=> $this->input->post('edicion'),
						   'IdSeccion'	=> $this->input->post('seccion'),					   
						);
						$resp = $this->db->where('IdDocumento',$idm)->update('bc_documentos', $modifica_documento);
					}
				}
				if( $resp ) {
					// modifica la solicitud
					$modifica_solicitud = array(				   
					   'Fecha'			=> $this->input->post('fecha'),
					   'Causas'			=> $this->input->post('causas'),				   
					);
					$resp = $this->db->where('IdSolicitud',$ids)->update('pa_solicitudes', $modifica_solicitud);
					
					if( $resp ) {												
						// msj de éxito
						$datos['mensaje_titulo'] = "&Eacute;xito al Modificar";
						$datos['mensaje'] = "La solicitud se ha modificado correctamente";						
						$datos['enlace'] = "admin/solicitudes/autorizar";
						$this->load->view('mensajes/ok_redirec',$datos);
					}						
				}				
			}
		}
		
		// estructura de la p�gina (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/modificar',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// altas(): Inicia el proceso de solicitud de alta de documentos
	//
	function alta() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Solicitud de Alta de Documentos';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'alta' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		
		/***/
		// obtiene las secciones para las solicitudes			
		$where = "Seccion LIKE 'Instructivos de Trabajo' AND Comun = 0 OR Seccion LIKE 'Planes de Trabajo' AND Comun = 0 OR Seccion LIKE 'Indicadores' AND Comun = 0 OR Seccion LIKE 'Matriz de Criterios de Conformidad del Producto' AND Comun = 0 ";
		if( $this->session->userdata('id_sistema') == 2 )			
			$where .= " OR Seccion LIKE 'Manuales' AND Comun = 1";
		$secciones = $this->db->where($where)->get('bc_secciones');
		if( $secciones->num_rows() > 0 ) {
			$datos['seccion_options'] = array();
			foreach( $secciones->result() as $row ) $datos['seccion_options'][$row->IdSeccion] = $row->Seccion;
		}
		/***/
		
		// inserta la solicitud
		if( $_POST ){		
			// reglas de validación
			$this->form_validation->set_rules('codigo', 'C&oacute;digo', 'trim');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{				
				// configuraci�n de los archivos a subir				
				$nom_doc = $this->session->userdata('id_area')."-".$this->input->post('seccion')."-".substr(md5(uniqid(rand())),0,6);
				$config['file_name'] = $nom_doc;
				$config['upload_path'] = './includes/docs/';
				$config['allowed_types'] = '*';
				$config['max_size']	= '0';
		
				$this->load->library('upload', $config);
		
				if ( !$this->upload->do_upload('archivo') ) {
					// msj de error
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = $this->upload->display_errors();
					$this->load->view('mensajes/error',$datos);
				}
				else {						
					// renombra el documento
					$upload_data = $this->upload->data();
					$nom_doc = $nom_doc.$upload_data['file_ext'];

					// array para insertar el documento
					$inserta_documento = array(
					   'IdArea'			=> $this->session->userdata('id_area'),
					   'IdSeccion'		=> $this->input->post('seccion'),
					   'Codigo'			=> $this->input->post('codigo'),
					   'Edicion'		=> '1',
					   'Nombre'			=> $this->input->post('nombre'),
					   'Ruta'			=> $nom_doc,
					   'Fecha'			=> $this->input->post('fecha'),
					   'Estado'			=> '0', // documento inactivo
					);
					
					// realiza las inserciones
					$resp = $this->db->insert('bc_documentos', $inserta_documento); 
					if( $resp ) {
						// obtiene el id del documento
						$documento = $this->db->get('bc_documentos',array('Ruta' => $nom_doc, 'Estado' => '0' )); 
						if( $documento->num_rows() > 0 )
							foreach( $documento->result() as $row )
								$id_doc = $row->IdDocumento;
							
						// array para insertar la solicitud
						$inserta_solicitud = array(
						   'IdDocumento'	=> $id_doc,
						   'IdArea'			=> $this->session->userdata('id_area'),
						   'Fecha'			=> $this->input->post('fecha'),
						   'Causas'			=> $this->input->post('causas'),
						   'Solicitud'		=> 'Alta',
						   'Estado'			=> '0', // solicitud pendiente
						   'Rechazo'		=> '0', // solicitud no rechazada 
						);
						$resp = $this->db->insert('pa_solicitudes', $inserta_solicitud); 
						if( $resp ) {
							// obtiene el id de la solicitud
							$solicitud = $this->db->order_by('IdDocumento', 'DESC')->get_where('pa_solicitudes',array('IdDocumento' => $id_doc, 'Solicitud' => 'Alta', 'Fecha' => $this->input->post('fecha') )); 
							if( $solicitud->num_rows() > 0 )
								foreach( $solicitud->result() as $row )
									$id_sol = $row->IdSolicitud;
									
							// msj de �xito
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "La solicitud se ha guardado, ahora debes realizar la lista de distribuci&oacute;n";
							$datos['enlace'] = "admin/solicitudes/lista_distribucion/".$id_sol."/0";
							$this->load->view('mensajes/ok_redirec',$datos);
						}
					}
				}
			}
		}

		// estructura de la p�gina (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/alta',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// documento(): Inicia el proceso de solicitud de baja / modificacion eligiendo el documento
	//
	function documento( $solicitud ) {
		switch( $solicitud ) {
			// baja
			case "baja" :
				$titulo = "Solicitud de Baja de Documentos";
				break;
				
			// modificacion
			case "modificacion":
				$titulo = "Solicitud de Modificaci&oacute;n de Documentos";
				break;
				
			// error
			default :
				redirect("pagina/error_404");
				break;
		}
		
		// variables necesarias para la estructura de la p�gina
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'documento/'.$solicitud => $titulo ) );
		$datos['barra'] = $this->barra;
		
		$datos['solicitud'] = $solicitud;
		$datos['busqueda'] = false;
		$datos['cod'] = '';
		$datos['nom'] = '';
		$datos['sec'] = '';

		// obtiene las secciones para las solicitudes
		$condicion=array(
						'IdSistema' => '!=2',
					);
		$secciones=$this->db->get_where('bc_secciones', $condicion);		
		//$where = "Seccion LIKE 'Instructivos de Trabajo' AND Comun = 0 OR Seccion LIKE 'Planes de Trabajo' AND Comun = 0 OR Seccion LIKE 'Indicadores' AND Comun = 0 OR Seccion LIKE 'Matriz de Criterios de Conformidad del Producto' AND Comun = 0 ";
		//if( $this->session->userdata('id_sistema') = 2 ){
		//$where .= " OR Seccion LIKE 'Manuales' AND Comun = 1";
		//}
			
		$secciones = $this->db->where($where)->get('bc_secciones');
		if( $secciones->num_rows() > 0 ) {
			$datos['seccion_options'][0] = "";
			foreach( $secciones->result() as $row ) $datos['seccion_options'][$row->IdSeccion] = $row->Seccion;
		}
		
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			$del = 0;
			$datos['busqueda'] = true;			
			$datos['sec'] = $this->input->post('seccion');
			$this->Inicio_model->set_sort( 15 );
			$datos['sort_tabla'] = $this->Inicio_model->get_sort();
			
			$this->db->join('ab_areas','ab_areas.IdArea = bc_documentos.IdArea');
			if( $this->session->userdata('id_sistema') == 2 && $datos['sec'] == 25 )
				$datos['consulta'] = $this->db->where(array('IdSeccion' => $datos['sec'],'Estado' => '1'))->get('bc_documentos');
			else
				$datos['consulta'] = $this->db->where(array('bc_documentos.IdArea' => $this->session->userdata('id_area'),'IdSeccion' => $datos['sec'],'Estado' => '1'))->get('bc_documentos');
		}
		else {
			$datos['busqueda'] = false;
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/documento',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// baja( $idd ): Continua el proceso de solicitud de baja de documentos
	//
	function baja( $idd ) {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Solicitud de Baja de Documentos';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'documento/baja' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// obtiene los datos del documento
		$consulta = $this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion')->get_where('bc_documentos',array('IdDocumento' => $idd));
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :
				$datos['cod'] = $row->Codigo;
				$datos['nom'] = $row->Nombre;
				$datos['sec'] = $row->Seccion;
				$datos['fec'] = $this->Inicio_model->set_fecha( $row->Fecha );
			endforeach;
		}
					
		// inserta la solicitud
		if( $_POST ){		
			// reglas de validación
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{				
				// array para insertar el documento
				$inserta = array(
				   'IdDocumento'	=> $idd,
				   'IdArea'			=> $this->session->userdata('id_area'),
				   'Fecha'			=> $this->input->post('fecha'),
				   'Causas'			=> $this->input->post('causas'),
				   'Solicitud'		=> 'Baja',
				   'Estado'			=> '0', // solicitud pendiente
				   'Rechazo'		=> '0', // solicitud no rechazada 
				);
				
				// realiza las inserciones
				$resp = $this->db->insert('pa_solicitudes', $inserta); 
				if( $resp ) {
					// obtiene el id de la solicitud
					$solicitud = $this->db->order_by('IdDocumento', 'DESC')->get_where('pa_solicitudes',array('IdDocumento' => $idd, 'Solicitud' => 'Baja', 'Fecha' => $this->input->post('fecha'))); 
					if( $solicitud->num_rows() > 0 )
						foreach( $solicitud->result() as $row )
							$id_sol = $row->IdSolicitud;
							
					// msj de �xito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La solicitud se ha guardado, ahora debes realizar la lista de distribuci&oacute;n";
					$datos['enlace'] = "admin/solicitudes/lista_distribucion/".$id_sol."/0";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/baja',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// modificacion( $idd ): Continua el proceso de solicitud de modificacion de documentos
	//
	function modificacion( $idd ) {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Solicitud de Modificaci&oacute;n de Documentos';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'documento/baja' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		
		// obtiene los datos del documento
		
		$consulta = $this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion')->get_where('bc_documentos',array('IdDocumento' => $idd));
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) :
				$datos['cod'] = $row->Codigo;
				$datos['nom'] = $row->Nombre;
				$datos['sec'] = $row->Seccion;
				$datos['fec'] = $row->Fecha;
				$datos['edi'] = $row->Edicion;
				$datos['ids'] = $row->IdSeccion;
			endforeach;
		}
		
		// inserta la solicitud
		if( $_POST ){		
			// reglas de validaci�n
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('causas', 'Causas', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{				
				// configuraci�n de los archivos a subir				
				$nom_doc = $this->session->userdata('id_area')."-".$this->input->post('seccion')."-".substr(md5(uniqid(rand())),0,6);
				$config['file_name'] = $nom_doc;
				$config['upload_path'] = './includes/docs/';
				$config['allowed_types'] = '*';
				$config['max_size']	= '0';
		
				$this->load->library('upload', $config);
		
				if ( !$this->upload->do_upload('archivo') ) {
					// msj de error
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = $this->upload->display_errors();
					$this->load->view('mensajes/error',$datos);
				}
				else {						
					// renombra el documento
					$upload_data = $this->upload->data();
					$nom_doc = $nom_doc.$upload_data['file_ext'];

					// array para insertar el documento
					$inserta_documento = array(
					   'IdArea'			=> $this->session->userdata('id_area'),
					   'IdSeccion'		=> $this->input->post('seccion'),
					   'Codigo'			=> $this->input->post('codigo'),
					   'Edicion'		=> $this->input->post('edicion'),
					   'Nombre'			=> $this->input->post('nombre'),
					   'Ruta'			=> $nom_doc,
					   'Fecha'			=> $this->input->post('fecha_doc'),
					   'Estado'			=> '0', // documento inactivo
					);
					
					// realiza las inserciones
					$resp = $this->db->insert('bc_documentos', $inserta_documento); 
					if( $resp ) {
						// obtiene el id del documento
						$documento = $this->db->get('bc_documentos',array('Ruta' => $nom_doc, 'Estado' => '0' )); 
						if( $documento->num_rows() > 0 )
							foreach( $documento->result() as $row )
								$id_doc = $row->IdDocumento;							
						
						// array para insertar la solicitud
						$inserta_solicitud = array(
						   'IdDocumento'	=> $idd,
						   'IdArea'			=> $this->session->userdata('id_area'),
						   'Fecha'			=> $this->input->post('fecha'),
						   'Causas'			=> $this->input->post('causas'),
						   'Solicitud'		=> 'Modificacion',
						   'Estado'			=> '0', // solicitud pendiente
						   'Rechazo'		=> '0', // solicitud no rechazada 
						);
						$resp = $this->db->insert('pa_solicitudes', $inserta_solicitud); 
						if( $resp ) {
							// obtiene el id de la solicitud
							$solicitud = $this->db->order_by('IdDocumento', 'DESC')->get_where('pa_solicitudes',array('IdDocumento' => $idd, 'Solicitud' => 'Modificacion', 'Fecha' => $this->input->post('fecha') )); 
							if( $solicitud->num_rows() > 0 )
								foreach( $solicitud->result() as $row )
									$id_sol = $row->IdSolicitud;
									
							// array para insertar en la tabla de documentos modificacion
							$inserta_doc_mod = array(
							   'IdSolicitud'	=> $id_sol,
							   'IdDocumento'	=> $id_doc,
							);
							$resp = $this->db->insert('pa_solicitudes_modificacion', $inserta_doc_mod);
							if( $resp ) {
								// msj de �xito
								$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
								$datos['mensaje'] = "La solicitud se ha guardado, ahora debes realizar la lista de distribuci&oacute;n";
								$datos['enlace'] = "admin/solicitudes/lista_distribucion/".$id_sol."/0";
								$this->load->view('mensajes/ok_redirec',$datos);
							}
						}
					}
				}
			}
		}
		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/modificacion',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// lista_distribucion( $ids, $etapa ): Realiza la lista de distribucion de la solicitud
	//
	function lista_distribucion( $ids, $etapa ) {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Lista de Distribuci&oacute;n';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'alta' => $titulo ) );
		$datos['barra'] = $this->barra;
				
		$datos['id'] = $ids;
		$datos['etapa'] = $etapa;		
		
		// obtiene todos los usuarios activos del area
		$datos['usuarios'] = $this->db->order_by('Nombre')->get_where('ab_usuarios',array('ab_usuarios.IdArea' => $this->session->userdata('id_area'), 'ab_usuarios.Estado' => '1'));
		$lista_distribucion = $this->db->get_where('pa_solicitudes_distribucion',array('pa_solicitudes_distribucion.IdSolicitud' => $ids));
		$datos['lista_distribucion'] = $lista_distribucion;
		
		// revisa si la solicitud ya tiene soliciador o autoizador
		$datos['solicitador'] = false;
		$datos['autorizador'] = false;
		if( $lista_distribucion->num_rows() > 0 ) {
			foreach ( $lista_distribucion->result() as $row ) {
				if( $row->Tipo == 1 ) {
					$datos['solicitador'] = true;
				}
				if( $row->Tipo == 2 ) {
					$datos['autorizador'] = true;
				}
			}
		}
		
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);	
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/solicitudes/lista_distribucion',$datos);
		$this->load->view('admin/_estructura/footer');
		
		// realiza la insercion
		if( $_POST ) {
			// reglas de validaci�n
			$this->form_validation->set_rules('distribucion[]', 'la Lista de Distribuci&oacute;n', 'required|trim');
			// si la solicitud ya se ha generado y solo se esta agregando a alguien a la lista de distribución
			if( !$etapa ) {
				$this->form_validation->set_rules('solicitador[]', 'el Solicitador', 'required|trim');
				$this->form_validation->set_rules('autorizador[]', 'el Autorizador', 'required|trim');
			}			
			$this->form_validation->set_message('required', 'Debes elegir <strong>%s</strong>');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else {
				$i = 0;
				$inserta = array();				
				foreach( $this->input->post('distribucion') as $lista ) {
					// si el mismo usuario es solicitador y autorizador, inserta primero como solicitador
					if( $lista == $this->input->post('autorizador') && $lista == $this->input->post('solicitador') ) {						
						$tipo = '1';
						$inserta[$i] = array(
						   'IdSolicitud'	=> $ids,
						   'IdUsuario'		=> $lista,
						   'Tipo'			=> $tipo,
						   'Aceptado'		=> '0', // solicitud no aceptada
						);
						$i++;
						$tipo = '2';
					}
										
					// inserta al solicitador
					elseif( $lista == $this->input->post('solicitador') ) {
						$tipo = '1';
					}

					// inserta al autorizador
					elseif( $lista == $this->input->post('autorizador') ) {
						$tipo = '2';
					}					

					// común en lista de distribución
					else {
						$tipo = '0';
					}
						
					$inserta[$i] = array(
					   'IdSolicitud'	=> $ids,
					   'IdUsuario'		=> $lista,
					   'Tipo'			=> $tipo,
					   'Aceptado'		=> '0', // solicitud no aceptada
					);
					$i++;
				}
				$resp = $this->db->insert_batch('pa_solicitudes_distribucion', $inserta);
				if( $resp ) {
					// si la solicitud ya se ha generado y solo se esta agregando a alguien a la lista de distribución
					if( $etapa ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "Los cambios en la lista de distribuci&oacute;n se han guardado correctamente";
						$datos['enlace'] = "admin/solicitudes/ver_lista_distribucion/".$ids."/".$etapa;
						$this->load->view('mensajes/ok_redirec',$datos);
					}
					// si se esta generando la solicitud
					else {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La lista de distribuci&oacute;n se ha guardado correctamente";
						$datos['enlace'] = "admin/solicitudes/ver/".$ids."/lista";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}
	}
}
