<?php 
/****************************************************************************************************
*
*	MODELS/procesos/solicitudes_model.php
*
*		Descripción:  		  
*			Solicitudes de Documentos 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			11/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Solicitudes_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/	
	//
	// get_secciones(): Obtiene las secciones para las solicitudes
	//
	function get_secciones() {
		// obtiene las secciones para las solicitudes			
		//$where = "Seccion LIKE 'Instructivos de Trabajo' AND Comun = 0 OR Seccion LIKE 'Planes de Trabajo' AND Comun = 0 OR Seccion LIKE 'Indicadores' AND Comun = 0 OR Seccion LIKE 'Matriz de Criterios de Conformidad del Producto' AND Comun = 0 ";
		
	
		$this->db->order_by('bc_secciones.Seccion');
		$this->db->join('cd_sistemas', 'cd_sistemas.IdSistema=bc_secciones.IdSistema');
		$consulta=$this->db->get_where('bc_secciones', array('bc_secciones.Estado' => '1', 'bc_secciones.Listado' =>'1', 'bc_secciones.IdSistema !=' =>'1'));
		//$consulta = $this->db->where($where)->get('bc_secciones');
		
		return $consulta;
	}
	
	//
	// get_documentos( $id ): Obtiene los documentos de la seccion solicitada
	//
	function get_documentos( $id ) {
		$condicion = array(
			
			'IdSeccion'	=> $id,
			'IdArea'	=>$this->session->userdata('id_area'),
			'Estado' 	=> '1',
			
		);
				
		$this->db->group_by('bc_documentos.IdDocumento')->order_by("bc_documentos.Codigo", "ASC");
		$this->db->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
		$this->db->join('bc_documentos_registros','bc_documentos_registros.IdDocumento = bc_documentos.IdDocumento','left');
		$this->db->select('bc_documentos_registros.Retencion, bc_documentos_registros.Disposicion, bc_documentos.IdDocumento, bc_documentos.IdArea, bc_documentos.IdSeccion, bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta, bc_documentos.Fecha, bc_documentos.Estado, bc_documentos_word.Ruta AS RutaWord, bc_documentos_word.FechaElaboracion');
		$consulta=$this->db->get_where('bc_documentos',array('bc_documentos.Estado' => '1', 'bc_documentos.IdSeccion' => $id, 'bc_documentos.IdArea' => $this->session->userdata('id_area')));
		
		
		return $consulta;
	}
	
	//
	// get_usuarios(): Obtiene todos los usuarios activos del area
	//
	function get_usuarios() {
		$condicion = array(
			'ab_usuarios.IdArea' => $this->session->userdata('id_area'),
			'ab_usuarios.Estado' => '1'
		);
		$this->db->order_by('Nombre');
		$consulta = $this->db->get_where('ab_usuarios', $condicion);
		
		return $consulta;
	}

	//
	// get_lista_distribucion_usuarios( $id ): Obtiene la lista de distribucion de la solicitud
	//
	function get_lista_distribucion_usuarios( $id ) {
		$condicion = array(
			'ab_usuarios.Estado' 						=> '1',
			'pa_solicitudes_distribucion.IdSolicitud' 	=> $id
		);
		$this->db->order_by('pa_solicitudes_distribucion.Tipo','DESC');
		$this->db->join('pa_solicitudes_distribucion','ab_usuarios.IdUsuario = pa_solicitudes_distribucion.IdUsuario');		
		$consulta = $this->db->get_where('ab_usuarios', $condicion);
		
		return $consulta;
	}
	
	//
	// get_lista_distribucion( $id ): Obtiene la lista de distribucion de la solicitud con los nombres de usuarios
	//
	function get_lista_distribucion( $id ) {
		$condicion = array(
			'pa_solicitudes_distribucion.IdSolicitud' => $id
		);
		$consulta = $this->db->get_where('pa_solicitudes_distribucion', $condicion);
		
		return $consulta;
	}
	
	//
	// get_documento( $id ): Obtiene los datos del documentos
	//
	function get_documento( $id ) {
		$condicion = array(
			'IdDocumento' => $id
		);
		$this->db->join('bc_secciones','bc_secciones.IdSeccion = bc_documentos.IdSeccion');
		$consulta = $this->db->get_where('bc_documentos', $condicion);
		
		return $consulta;
	}
	
	//
	// get_solicitud( $id ): Obtiene los datos del documentos
	//
	function get_solicitud( $id ) {
		$condicion = array(
			'IdSolicitud' => $id
		);
		$this->db->select('bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.IdDocumento,bc_documentos.Codigo,bc_documentos.Nombre,bc_documentos.IdSeccion,bc_documentos.Ruta,pa_solicitudes.IdSolicitud,pa_solicitudes.Observaciones,pa_solicitudes.Fecha,pa_solicitudes.Causas,pa_solicitudes.Solicitud');
		$this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento');
		$consulta = $this->db->get_where('pa_solicitudes', $condicion);
		
		return $consulta;
	}
	
	//
	// get_solicitud_modificacion( $id ): Obtiene los datos del documento y de la solicitud de modificacion
	//
	function get_solicitud_modificacion( $id ) {
		$condicion = array(
			'IdSolicitud' => $id
		);
		$this->db->select('bc_documentos.Codigo, bc_documentos.Edicion, bc_documentos.Nombre, bc_documentos.Ruta');
		$this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes_modificacion.IdDocumento');
		$consulta = $this->db->get_where('pa_solicitudes_modificacion', $condicion);
		
		return $consulta;
	}

	//
	// get_solicitudes( $tipo, $estado ): Obtiene las solicitudes segun el tipo de autorizacion
	//
	function get_solicitudes( $tipo, $estado ) {
		$condicion = array(
			'Aceptado'			 	 => '0',
			'Tipo' 					 => $tipo,
			'IdUsuario' 			 => $this->session->userdata('id_usuario'),
			'pa_solicitudes.Estado'  => $estado
		);
		$this->db->select('pa_solicitudes.IdSolicitud,pa_solicitudes.Observaciones,pa_solicitudes.Fecha,pa_solicitudes.Causas,pa_solicitudes.Solicitud,bc_documentos.IdDocumento,bc_documentos.Codigo,bc_documentos.Nombre');
		$this->db->join('pa_solicitudes','pa_solicitudes.IdSolicitud = pa_solicitudes_distribucion.IdSolicitud');
		$this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento');
		$consulta = $this->db->get_where('pa_solicitudes_distribucion', $condicion);
		
		return $consulta;
	}

	//
	// get_rechazadas(): Obtiene las solicitudes rechazadas
	//
	function get_rechazadas() {
		$condicion = array(
			'pa_solicitudes.IdArea' => $this->session->userdata('id_area'),
			'pa_solicitudes.Estado' => '4'
		);
		$this->db->select('bc_documentos.IdDocumento,bc_documentos.Codigo,pa_solicitudes.IdSolicitud,pa_solicitudes.Estado,pa_solicitudes.Rechazo,bc_documentos.Fecha,pa_solicitudes.Causas,pa_solicitudes.Solicitud,pa_solicitudes.Observaciones');
		$this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento');
		$consulta = $this->db->get_where('pa_solicitudes', $condicion );
		
		return $consulta;
	}
	
	//
	// get_revisar(): Obtiene las solicitudes que la lista de distribución debe de revisar
	//
	function get_revisar() {
		$condicion = array( 
			'Aceptado' 				=> '0', 
			'Tipo' 					=> '0', 
			'IdUsuario' 			=> $this->session->userdata('id_usuario'), 
			'pa_solicitudes.Estado' => '3' 
		);
		$this->db->select('pa_solicitudes.IdSolicitud,pa_solicitudes.Observaciones,pa_solicitudes.Fecha,pa_solicitudes.Causas,pa_solicitudes.Solicitud,bc_documentos.IdDocumento,bc_documentos.Codigo,bc_documentos.Nombre');
		$this->db->join('pa_solicitudes','pa_solicitudes.IdSolicitud = pa_solicitudes_distribucion.IdSolicitud');
		$this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento');
		$consulta = $this->db->get_where('pa_solicitudes_distribucion', $condicion);
		
		return $consulta;
	}

	//
	// eliminar_lista_distribucion( $id_solicitud, $id_usuario ): Cambia de estado los registros
	//
	function eliminar_lista_distribucion( $id_solicitud, $id_usuario ) {
		$condicion = array(
			'pa_solicitudes_distribucion.IdSolicitud' 	=> $id_solicitud,
			'pa_solicitudes_distribucion.IdUsuario' 	=> $id_usuario,
		);
		
		$resp = $this->db->delete( 'pa_solicitudes_distribucion', $condicion );
		
		return $resp;
	}

	//
	// inserta_alta( $nom_doc ): Inserta la solicitud de alta
	//
	function inserta_alta( $nom_doc ) {
		$this->db->trans_start();
		// array para insertar en la bd
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
		
		// realiza la inserción
		if( $this->db->insert('bc_documentos', $inserta_documento) ) {
			$id_doc = $this->db->insert_id();
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
			if( $this->db->insert('pa_solicitudes', $inserta_solicitud) ) {
				$id_solicitud = $this->db->insert_id();
				$this->db->trans_complete();
				return $id_solicitud;
			}
			else {
				$this->db->trans_complete();
				return false;
			}
		}
		else {
			$this->db->trans_complete();
			return false;
		}
	}	

	//
	// inserta_baja( $id ): Inserta la solicitud de baja
	//
	function inserta_baja( $id ) {
		$this->db->trans_start();
		// array para insertar en la bd
		$inserta = array(
		   'IdDocumento'	=> $id,
		   'IdArea'			=> $this->session->userdata('id_area'),
		   'Fecha'			=> $this->input->post('fecha'),
		   'Causas'			=> $this->input->post('causas'),
		   'Solicitud'		=> 'Baja',
		   'Estado'			=> '0', // solicitud pendiente
		   'Rechazo'		=> '0', // solicitud no rechazada
		);
		
		// realiza la inserción
		if( $this->db->insert('pa_solicitudes', $inserta) ) {
			$id_solicitud = $this->db->insert_id();
			$this->db->trans_complete();
			return $id_solicitud;
		}
		else {
			$this->db->trans_complete();
			return false;
		}
	}
	
	//
	// inserta_modificacion( $id_documento, $nom_doc ): Inserta la solicitud de modificación
	//
	function inserta_modificacion( $id_documento, $nom_doc ) {
		$this->db->trans_start();
		// array para insertar en la bd
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
		
		// realiza la inserción
		if( $this->db->insert('bc_documentos', $inserta_documento) ) {
			$id_doc = $this->db->insert_id();
			// array para insertar la solicitud
			$inserta_solicitud = array(
			   'IdDocumento'	=> $id_documento,
			   'IdArea'			=> $this->session->userdata('id_area'),
			   'Fecha'			=> $this->input->post('fecha'),
			   'Causas'			=> $this->input->post('causas'),
			   'Edicion'		=> $this->input->post('edicion'),
			   'Solicitud'		=> 'Modificacion',
			   'Estado'			=> '0', // solicitud pendiente
			   'Rechazo'		=> '0', // solicitud no rechazada 
			);
			if( $this->db->insert('pa_solicitudes', $inserta_solicitud) ) {
				$id_sol = $this->db->insert_id();
				// array para insertar la solicitud
				$inserta_solicitud_modificacion = array(
					'IdSolicitud'	=> $id_sol,
					'IdDocumento'	=> $id_doc,
				);
				if( $this->db->insert('pa_solicitudes_modificacion', $inserta_solicitud_modificacion) ) {
					$this->db->trans_complete();
					return $id_sol;
				}
				else {
					$this->db->trans_complete();
					return false;
				}
			}
			else {
				$this->db->trans_complete();
				return false;
			}
		}
		else {
			$this->db->trans_complete();
			return false;
		}
	}

	//
	// inserta_lista_distribucion( $id ): Inserta la lista de distribución de la solicitud
	//
	function inserta_lista_distribucion( $id_solicitud ) {
		$i = 0;
		$inserta = array();				
		foreach( $this->input->post('distribucion') as $lista ) {
			// si el mismo usuario es solicitador y autorizador, inserta primero como solicitador
			if( $lista == $this->input->post('autorizador') && $lista == $this->input->post('solicitador') ) {						
				$tipo = '1';
				$inserta[$i] = array(
				   'IdSolicitud'	=> $id_solicitud,
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
			   'IdSolicitud'	=> $id_solicitud,
			   'IdUsuario'		=> $lista,
			   'Tipo'			=> $tipo,
			   'Aceptado'		=> '0', // solicitud no aceptada
			);
			$i++;
		}
		$resp = $this->db->insert_batch('pa_solicitudes_distribucion', $inserta);

		return $resp;
	}

	//
	// modifica_solicitud( $tipo ): Actualiza los datos de las revisiones de la solicitud y de la lista de distribución 
	//
	function modifica_solicitud( $tipo ) {
		$this->db->trans_start();
		// Solicitador
		if( $tipo == 1 ) {		
			// Aceptar solicitudes
			if( $this->input->post('boton_aceptar') != "" ) {				
				$actualiza_distribucion = array( 'Aceptado' => '1' );
				$actualiza_solicitud = array( 'Estado' => '1' );
				$tipo_observacion = "Observación Solicitador: ";
				$estado_solicitud = '1';
			}
			// Rechazar solicitudes
			elseif( $this->input->post('boton_rechazar') != "" ) {
				$actualiza_distribucion = array( 'Aceptado' => '2' );
				$actualiza_solicitud = array( 'Estado' => '4', 'Rechazo' => '1' );
				$tipo_observacion = "Observación Solicitador: ";
				$estado_solicitud = '4';
			}
		}
		// Autorizador
		elseif( $tipo == 2 ) {
			// Aceptar solicitudes
			if( $this->input->post('boton_aceptar') != "" ) {				
				$actualiza_distribucion = array( 'Aceptado' => '1' );
				$actualiza_solicitud = array( 'Estado' => '2' );
				$tipo_observacion = "Observación Autorizador: ";
				$estado_solicitud = '2';
			}
			// Rechazar solicitudes
			elseif( $this->input->post('boton_rechazar') != "" ) {
				$actualiza_distribucion = array( 'Aceptado' => '2' );				
				$actualiza_solicitud = array( 'Estado' => '4', 'Rechazo' => '2' );
				$tipo_observacion = "Observación Autorizador: ";
				$estado_solicitud = '4';
			}
		}
		
		$resp = true;
		foreach( $this->input->post('solicitud') as $lista ) {
			$this->db->where('pa_solicitudes_distribucion.Tipo', $tipo);
			$this->db->where('pa_solicitudes_distribucion.IdSolicitud',$lista);
			$this->db->where('pa_solicitudes_distribucion.IdUsuario',$this->session->userdata('id_usuario'));
			$resp = $this->db->update('pa_solicitudes_distribucion', $actualiza_distribucion );

			if( $resp ) {
				if( $this->input->post('observaciones_old_'.$lista) != "" ) {
					$obs_old = $this->input->post('observaciones_old_'.$lista)."<br />- - - - - - - - - - - - - - -<br />";
				}
				else { 
					$obs_old = "";
				}
				
				if( $this->input->post('observaciones_'.$lista) != "" ) {
					$actualiza_solicitud['Observaciones'] = $obs_old."<strong>".$tipo_observacion."</strong>".$this->input->post('observaciones_'.$lista);
				} 
				$this->db->where('pa_solicitudes.IdSolicitud',$lista);
				$resp = $this->db->update('pa_solicitudes', $actualiza_solicitud);							
			}
		}
		
		$this->db->trans_complete();
		return $resp;
	}

	//
	// modificar( $id_solicitud, $id_documento, $tipo, $nom_doc ): 
	//Modifica los datos de una solicitud 
	//
	function modificar( $id_solicitud, $id_documento, $tipo, $nom_doc ) {
		$this->db->trans_start();
		$id_doc = $id_documento;
		// array para insertar el documento
		$modifica_documento = array(
		   'Codigo'		=> $this->input->post('codigo'),
		   'Nombre'		=> $this->input->post('nombre'),
		   'Edicion'	=> $this->input->post('edicion'),
		   'IdSeccion'	=> $this->input->post('seccion'),					   
		);
		
		// si es modificación modifica 
		//el documento a modificar (que trabalenguas)
		if( $tipo == 'Modificacion' ) {
			$documento = $this->db->get_where('pa_solicitudes_modificacion',array('IdSolicitud' => $id_solicitud));
			foreach( $documento->result() as $row_dm ) {
				$id_doc = $row_dm->IdDocumento;
			}
		}

		// nombre del documento
		if( $nom_doc != '' ) {
			$modifica_documento['Ruta']	= $nom_doc;
		}
		
		// modifica el documento
		$this->db->where('IdDocumento',$id_doc);
		$resp = $this->db->update('bc_documentos', $modifica_documento);
		
		// modifica la solicitud
		if( $resp ) {
			$modifica_solicitud = array(				   
			   'Fecha'			=> $this->input->post('fecha'),
			   'Causas'			=> $this->input->post('causas'),				   
			);
			$this->db->where('IdSolicitud',$id_solicitud);
			$resp = $this->db->update('pa_solicitudes', $modifica_solicitud);
		}
		
		$this->db->trans_complete();
		return $resp;
	}

	//
	// rechazar(): Rechaza las solicitudes
	//
	function rechazar() {
		$this->db->trans_start();
		$resp = true;
		foreach( $this->input->post('solicitud') as $lista ) {
			$sol = $this->db->get_where('pa_solicitudes', array('IdSolicitud' => $lista));
			if( $sol->num_rows() > 0 ) {					
				foreach( $sol->result() as $row ) { 
					$edo_rec = $row->Rechazo;
				}
			}					
			
			// El estado de la solicitud es el estado del rechazo menos uno
			$edo_sol = $edo_rec - 1;
			
			if( $resp ) {
				if( $this->input->post('observaciones_old_'.$lista) != "" )
					$obs_old = $this->input->post('observaciones_old_'.$lista)."<br />- - - - - - - - - - - - - - -<br />";
				else 
					$obs_old = "";
				$actualiza_solicitud = array(
				   'Observaciones'	=> $obs_old."<strong>Observaci&oacute;n del Controlador de Documentos: </strong>".$this->input->post('observaciones_'.$lista),
				   'Estado'			=> $edo_sol,
				   'Rechazo'		=> '0', // solicitud no rechazada
				);
				$this->db->where('pa_solicitudes.IdSolicitud',$lista);
				$resp = $this->db->update('pa_solicitudes', $actualiza_solicitud);
				if( $resp ) {
					$actualiza_distribucion = array( 'Aceptado' => '0' );
					switch( $edo_rec ) {
						// rechazo del solicitador
						case 1 :
							$resp = $this->db->where('pa_solicitudes_distribucion.Tipo','1')->where('pa_solicitudes_distribucion.IdSolicitud',$lista)->update('pa_solicitudes_distribucion', $actualiza_distribucion);
							break;
							
						// rechazo del autorizador
						case 2 :
							$resp = $this->db->where('pa_solicitudes_distribucion.Tipo','2')->where('pa_solicitudes_distribucion.IdSolicitud',$lista)->update('pa_solicitudes_distribucion', $actualiza_distribucion);
							break;
					} 						
				}
			}				
		}
		
		$this->db->trans_complete();
		return $resp;
	}
	
	//
	// revisar(): La lista de distribución revisa las solicitudes terminadas
	//
	function revisar() {
		$this->db->trans_start();
		$resp = true;
		foreach( $this->input->post('solicitud') as $lista ) {
			$condicion = array( 
				'Aceptado' => '1'
			);
			$this->db->where('pa_solicitudes_distribucion.Tipo','0');
			$this->db->where('pa_solicitudes_distribucion.IdSolicitud',$lista);
			$this->db->where('pa_solicitudes_distribucion.IdUsuario',$this->session->userdata('id_usuario'));
			$resp = $this->db->update('pa_solicitudes_distribucion', $condicion);
		}
		
		$this->db->trans_complete();
		return $resp;
	}
}
?>
