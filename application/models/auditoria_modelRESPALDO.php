<?php 
/****************************************************************************************************
*
*	MODELS/auditoria_model.php
*
*		Descripción:  		  
*			Modelo para el controlador de la auditoría
*
*		Fecha de Creación:
*			31/Octubre/2012
*
*		Ultima actualización:
*			31/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Auditoria_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_auditoria_id(): Obtiene la id de la auditoría activa
	//
	function get_auditoria_id() {
		$id = 0;
		
		$condicion = array(
			'au_equipos_usuarios.IdUsuario' => $this->session->userdata('id_usuario'),
			'au_auditorias.Estado'			=> '1'
		);
		$this->db->where('au_equipos_usuarios.IdUsuario = '.$this->session->userdata('id_usuario').' AND au_auditorias.Estado = 1');
		$this->db->join('au_equipos','au_equipos.IdEquipo = au_equipos_usuarios.IdEquipo');
		$this->db->join('au_auditorias','au_auditorias.IdAuditoria = au_equipos.IdAuditoria');
		$consulta = $this->db->get_where( 'au_equipos_usuarios', $condicion, 1 );
		
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$id = $row->IdAuditoria;
			}
		} 
		
		return $id;
	}
	
	//
	// get_auditoria( $id ): Obtiene los datos de la auditoría
	//
	function get_auditoria( $id ) {
		$condicion = array(
			'IdAuditoria'	=> $id,
		);
		
		$consulta = $this->db->get_where( 'au_auditorias', $condicion, 1 );
		foreach( $consulta->result() as $row ) {
			$auditoria = 'Auditor&iacute;a del '.$this->Inicio_model->set_fecha($row->Inicio).' al '.$this->Inicio_model->set_fecha($row->Termino);
		}
		
		return $auditoria;
	}
	
	//
	// get_auditoria_info( $id ): Obtiene la información de la auditoria en base a una id
	//	
	function get_auditoria_info( $id ) {
		$condicion = array(
			'IdAuditoria' => $id
		);
		
		$consulta = $this->db->get_where( 'au_auditorias', $condicion );
		
		return $consulta;
	}
	
	//
	// get_lista_verificacion( $id ): Obtiene la lista de verificación de un usuario para una auditoría
	//
	function get_lista_verificacion( $id ) {
		$condicion = array(
			'IdAuditoria'	=> $id,
			'IdUsuario'		=> $this->session->userdata( 'id_usuario' ),
		);
		
		$consulta = $this->db->get_where( 'au_lista_verificacion_usuario', $condicion );
		
		return $consulta;
	}
	
	//
	// get_lista( $id ): Obtiene la lista de verificación por default
	//
	function get_lista( $id ) {
		$condicion = array(
			'Estado'	=> '1',
		);
		
		$consulta_lista = $this->get_lista_usuario( $id );
		$lista_no = array();
		if( $consulta_lista->num_rows() > 0 ) {
			$i = 0;
			foreach( $consulta_lista->result() as $row ) {
				$lista_no[$i] = $row->IdListaVerificacion;
				$i++;
			}
			$this->db->where_not_in( 'IdListaVerificacion', $lista_no );
		}
		$consulta = $this->db->get_where( 'au_lista_verificacion', $condicion );
		
		return $consulta;
	}

	//
	// get_lista_usuario( $id ): Obtiene la lista de verificación del usuario para la auditoría
	//
	function get_lista_usuario( $id ) {
		$condicion = array(
			'IdUsuario'		=> $this->session->userdata('id_usuario'),
			'IdAuditoria'	=> $id,
		);
		
		$this->db->join( 'au_lista_verificacion', 'au_lista_verificacion.IdListaVerificacion = au_lista_verificacion_usuario.IdListaVerificacion' );
		$consulta = $this->db->get_where( 'au_lista_verificacion_usuario', $condicion );
		
		return $consulta;
	}
	
	//
	// get_lista_usuario_proceso( $id_auditoria, $id_proceso ): Obtiene la lista de verificación del usuario para la auditoría del procesos especificado
	//
	function get_lista_usuario_proceso( $id_auditoria, $id_proceso ) {
		$condicion = array(
			'au_lista_verificacion_usuario.IdUsuario'		=> $this->session->userdata('id_usuario'),
			'au_lista_verificacion_usuario.IdAuditoria'		=> $id_auditoria,
		);
		
		$this->db->join( 'au_lista_verificacion', 'au_lista_verificacion.IdListaVerificacion = au_lista_verificacion_usuario.IdListaVerificacion' );
		$consulta = $this->db->get_where( 'au_lista_verificacion_usuario', $condicion );
		
		return $consulta;
	}
	
	//
	// get_respuestas_lista( $id_auditoria, $id_proceso ): Obtiene las respuestas del usuario
	//
	function get_respuestas_lista( $id_auditoria, $id_proceso ) {
		if( $this->session->userdata( 'id_area') != 9 ) {
			$condicion = array(
				'au_lista_verificacion_usuario.IdUsuario'		=> $this->session->userdata('id_usuario'),
				'au_lista_verificacion_usuario.IdAuditoria'		=> $id_auditoria,
			);
			if( $id_proceso != 'todos' ) {
				$condicion['au_respuestas_lista.IdProceso'] = $id_proceso;
			}
			
			$this->db->order_by( 'au_respuestas_lista.Tipo', 'DESC' );		
			$this->db->join( 'au_procesos', 'au_procesos.IdProcesos = '.'au_respuestas_lista.IdProceso' );
			$this->db->join( 'au_lista_verificacion_usuario', 'au_lista_verificacion_usuario.IdListaVerificacionUsuario = au_respuestas_lista.IdListaVerificacionUsuario' );
			$this->db->select( 'au_respuestas_lista.IdRespuestaLista, au_respuestas_lista.IdListaVerificacionUsuario, au_respuestas_lista.IdProceso, au_respuestas_lista.Tipo, au_respuestas_lista.Hallazgo, au_procesos.Proceso' );
			$consulta = $this->db->get_where( 'au_respuestas_lista', $condicion );
		}
		else {
			$condicion = array(
				'au_lista_verificacion_usuario.IdUsuario'		=> $this->session->userdata('id_usuario'),
				'au_lista_verificacion_usuario.IdAuditoria'		=> $id_auditoria,
			);
			if( $id_proceso != 'todos' ) {
				$condicion['au_respuestas_lista_sibib.IdBiblioteca'] = $id_proceso;
			}
			
			$this->db->order_by( 'au_respuestas_lista_sibib.Tipo', 'DESC' );		
			$this->db->join( 'ab_bibliotecas', 'ab_bibliotecas.IdBiblioteca = '.'au_respuestas_lista_sibib.IdBiblioteca' );
			$this->db->join( 'au_lista_verificacion_usuario', 'au_lista_verificacion_usuario.IdListaVerificacionUsuario = au_respuestas_lista_sibib.IdListaVerificacionUsuario' );
			$this->db->select( 'au_respuestas_lista_sibib.IdRespuestaLista, au_respuestas_lista_sibib.IdListaVerificacionUsuario, au_respuestas_lista_sibib.IdBiblioteca, au_respuestas_lista_sibib.Tipo, au_respuestas_lista_sibib.Hallazgo, ab_bibliotecas.Biblioteca AS Proceso' );
			$consulta = $this->db->get_where( 'au_respuestas_lista_sibib', $condicion );
		}
		
		return $consulta;
	}
	
	//
	// get_lista_hallazgo( $id ): Obtiene un hallazgo de la lista de distribucion en base a una id
	//
	function get_lista_hallazgo( $id ) {
		if( $this->session->userdata( 'id_area') != 9 ) {
			$tabla_respuestas = 'au_respuestas_lista';
			$tipo = 'IdProceso';
		}
		else {
			$tabla_respuestas = 'au_respuestas_lista_sibib';
			$tipo = 'IdBiblioteca';
		}
		$condicion = array(
			'IdRespuestaLista' => $id,
		);

		$this->db->join( 'au_lista_verificacion_usuario', 'au_lista_verificacion_usuario.IdListaVerificacionUsuario = '.$tabla_respuestas.'.IdListaVerificacionUsuario' );
		$this->db->join( 'au_lista_verificacion', 'au_lista_verificacion.IdListaVerificacion = au_lista_verificacion_usuario.IdListaVerificacion' );
		
		$this->db->join( 'au_procesos_instructivos', 'au_procesos_instructivos.IdProceso = '.$tabla_respuestas.'.'.$tipo );
		$this->db->join( 'bc_documentos', 'bc_documentos.IdDocumento = au_procesos_instructivos.IdInstructivo' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = bc_documentos.IdArea' );
		$consulta = $this->db->get_where( $tabla_respuestas, $condicion, 1 );
		
		return $consulta;
	}
	
	//
	// get_procesos_auditoria( $id ): Obtiene los procesos de una auditoria
	//	
	function get_procesos_auditoria( $id ) {
		$condicion = array(
			'IdAuditoria' => $id
		);
		
		$this->db->join( 'au_procesos', 'au_procesos.IdProcesos = au_auditorias_procesos.IdProceso' );
		$consulta = $this->db->get_where( 'au_auditorias_procesos', $condicion );
		
		return $consulta;
	}
	
	//
	// get_equipos( $id ): Obtiene los equipos de una auditoria
	//	
	function get_equipos( $id ) {
		$condicion = array(
			'IdAuditoria' => $id
		);
		
		$this->db->order_by( 'Nombre' );
		$consulta = $this->db->get_where( 'au_equipos', $condicion );
		
		return $consulta;
	}
		
	//
	// get_equipos_procesos( $id ): Obtiene la relacion los equipos y los procesos que van a auditar de una auditoria
	//	
	function get_equipos_procesos( $id ) {
		$condicion = array(
			'au_equipos.IdAuditoria' => $id
		);
		
		$this->db->join('au_equipos', 'au_equipos.IdEquipo = au_equipos_procesos.IdEquipo');
		$consulta = $this->db->get_where( 'au_equipos_procesos', $condicion );
		
		return $consulta;
	}

	//
	// get_equipos_procesos_auditoria( $id_auditoria ): Obtiene los procesos de un equipo para una auditoria
	//	
	function get_equipos_procesos_auditoria( $id_auditoria ) {
		// obtiene el equipo del usuario
		$id_equipo = $this->get_usuario_equipo( $id_auditoria );
		
		$condicion = array(
			'au_equipos.IdAuditoria' => $id_auditoria,
			'au_equipos.IdEquipo' 	 => $id_equipo
		);
		
		$this->db->join('au_equipos', 'au_equipos.IdEquipo = au_equipos_procesos.IdEquipo');
		$this->db->join('au_procesos', 'au_procesos.IdProcesos = au_equipos_procesos.IdProceso');
		$consulta = $this->db->get_where( 'au_equipos_procesos', $condicion );
		
		return $consulta;
	}
	
	//
	// get_bibliotecas(): Obtiene las bibliotecas
	//	
	function get_bibliotecas() {
		$consulta = $this->db->get( 'ab_bibliotecas' );
		
		return $consulta;
	}
	
	//
	// get_biblioteca( $id ): Obtiene una biblioteca en base a la id
	//	
	function get_biblioteca( $id ) {
		$condicion = array(
			'IdBiblioteca' => $id,
		);
		
		$consulta = $this->db->get_where( 'ab_bibliotecas', $condicion );
		
		return $consulta;
	}
	
	//
	// get_usuario_equipo( $id_auditoria ): Obtiene el equipo del usuario
	//	
	function get_usuario_equipo( $id_auditoria ) {
		$condicion = array(
			'au_equipos.IdAuditoria' 		=> $id_auditoria,
			'au_equipos_usuarios.IdUsuario' => $this->session->userdata( 'id_usuario' )
		);
		
		$this->db->join('au_equipos_usuarios', 'au_equipos_usuarios.IdEquipo = au_equipos.IdEquipo');
		$consulta = $this->db->get_where( 'au_equipos', $condicion, 1 );
		foreach( $consulta->result() as $row ) {
			$id_equipo = $row->IdEquipo;
		}
		
		return $id_equipo;
	}
	
	//
	// get_proceso( $id ): Obtiene un proceso
	//	
	function get_proceso( $id ) {
		$condicion = array(
			'au_procesos.IdProcesos' => $id
		);
		$consulta = $this->db->get_where( 'au_procesos', $condicion, 1 );
		
		return $consulta;
	}

	//
	// get_procesos_documentos( $id ): Obtiene las relaciones procesos-documentos
	//	
	function get_procesos_documentos( $id ) {
		$this->db->join( 'bc_documentos', 'bc_documentos.IdDocumento = au_procesos_instructivos.IdInstructivo' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = bc_documentos.IdArea' );
		$consulta = $this->db->get( 'au_procesos_instructivos' );
		
		return $consulta;
	}
	
	//
	// get_auditores_equipo( $id ): Obtiene a los auditores que ya tienen equipo de una auditoria
	//	
	function get_auditores_equipo( $id ) {
		// obtiene a los auditores que ya tienen equipo para formar un array
		$condicion = array(
			'au_equipos.IdAuditoria' => $id,
		);
		
		$this->db->order_by( 'au_equipos.Nombre ASC, au_equipos_usuarios.Tipo DESC' );
		$this->db->join( 'au_equipos_usuarios', 'au_equipos_usuarios.IdUsuario = ab_usuarios.IdUsuario' );
		$this->db->join( 'au_equipos', 'au_equipos.IdEquipo = au_equipos_usuarios.IdEquipo' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = ab_usuarios.IdArea' );
		$this->db->select( 'au_equipos.Nombre as Equipo, au_equipos.IdEquipo, au_equipos_usuarios.Tipo, ab_areas.Area, ab_usuarios.IdUsuario, ab_usuarios.Nombre, ab_usuarios.Paterno, ab_usuarios.Materno');
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion );
		
		return $consulta;
	}

	//
	// get_instructivos( $id ): Obtiene los instructivos de trabajo para la auditoria
	//
	function get_instructivos( $id ) {
		$condicion = array(
			'au_equipos_usuarios.IdUsuario'			=> $this->session->userdata( 'id_usuario' ),
			'au_auditorias_procesos.IdAuditoria'	=> $id,
		);

		$this->db->join('au_procesos_instructivos', 'au_procesos_instructivos.IdInstructivo = bc_documentos.IdDocumento');
		$this->db->join('au_equipos_procesos', 'au_equipos_procesos.IdProceso = au_procesos_instructivos.IdProceso');
		$this->db->join('au_equipos_usuarios', 'au_equipos_usuarios.IdEquipo = au_equipos_procesos.IdEquipo');
		$this->db->join('au_auditorias_procesos', 'au_auditorias_procesos.IdProceso = au_procesos_instructivos.IdProceso');
		$this->db->join('au_procesos', 'au_procesos.IdProcesos = au_procesos_instructivos.IdProceso');
		$this->db->join('ab_areas', 'ab_areas.IdArea = bc_documentos.IdArea');
		$this->db->join('bc_documentos_word','bc_documentos_word.IdDocumento = bc_documentos.IdDocumento','LEFT OUTER');
		$consulta = $this->db->get_where( 'bc_documentos', $condicion );
		
		return $consulta;
	}
	
	//
	// inserta_lista_verificacion( $id ): Inserta la lista de verificacion del usuario
	//
	function inserta_lista_verificacion( $id ) {
		$i = 0;
		$inserta = array();				
		foreach( $this->input->post('lista') as $id_lista ) {
			$inserta[$i] = array(
			   'IdListaVerificacion'	=> $id_lista,
			   'IdUsuario'				=> $this->session->userdata( 'id_usuario' ),
			   'IdAuditoria'			=> $id,
			);
			$i++;
		}
		$resp = $this->db->insert_batch( 'au_lista_verificacion_usuario', $inserta );

		return $resp;
	}
	
	//
	// inserta_actualiza_respuestas( $id ): Inserta o Actualiza las respuestas la lista de verificacion del usuario en esta auditoría
	//
	function inserta_actualiza_respuestas( $id ) {
		// SIGC
		if( $this->session->userdata( 'id_area') != 9 ) {				
			// revisa si hay que actualizar o insertar
			$consulta = $this->get_respuestas_lista( $id, $this->input->post( 'proceso_hidden' ) );
			$this->db->trans_start(); 
			if( $consulta->num_rows() > 0 ) {
				$i = 0;
				$inserta = array();
				$lista = $this->get_lista_usuario( $id );
				foreach( $lista->result() as $row ) {
					foreach( $consulta->result() as $row_res ) {
						if( $row_res->IdListaVerificacionUsuario == $row->IdListaVerificacionUsuario && $row_res->IdProceso == $this->input->post( 'proceso_hidden' ) ) {
							$inserta[$i] = array(
								'IdRespuestaLista'				=> $row_res->IdRespuestaLista,
							   	'IdListaVerificacionUsuario'	=> $row->IdListaVerificacionUsuario,
							   	'IdProceso'						=> $this->input->post( 'proceso_hidden' ),
							   	'Tipo'							=> $this->input->post( 'tipo_'.$row->IdListaVerificacionUsuario ),
							   	'Hallazgo'						=> $this->input->post( 'respuesta_'.$row->IdListaVerificacionUsuario ),
							);
							$i++;
						}
					}
				}
				$this->db->update_batch( 'au_respuestas_lista', $inserta, 'IdRespuestaLista' );
			}
			else {
				$i = 0;
				$inserta = array();
				$lista = $this->get_lista_usuario( $id );
				foreach( $lista->result() as $row ) {
					$inserta[$i] = array(
					   'IdListaVerificacionUsuario'	=> $row->IdListaVerificacionUsuario,
					   'IdProceso'					=> $this->input->post( 'proceso_hidden' ),
					   'Tipo'						=> $this->input->post( 'tipo_'.$row->IdListaVerificacionUsuario ),
					   'Hallazgo'					=> $this->input->post( 'respuesta_'.$row->IdListaVerificacionUsuario ),
					);
					$i++;
				}
				$this->db->insert_batch( 'au_respuestas_lista', $inserta );
			}
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE) {
			     return false;
			}
			else {
			    return true;
			}
		}
		// SIBIB
		else {
			// revisa si hay que actualizar o insertar
			$consulta = $this->get_respuestas_lista( $id, $this->input->post( 'proceso_hidden' ) );
			$this->db->trans_start(); 
			if( $consulta->num_rows() > 0 ) {
				$i = 0;
				$inserta = array();
				$lista = $this->get_lista_usuario( $id );
				foreach( $lista->result() as $row ) {
					foreach( $consulta->result() as $row_res ) {
						if( $row_res->IdListaVerificacionUsuario == $row->IdListaVerificacionUsuario && $row_res->IdBiblioteca == $this->input->post( 'proceso_hidden' ) ) {
							$inserta[$i] = array(
							   	'IdRespuestaLista'			=> $row_res->IdRespuestaLista,
							   	'IdListaVerificacionUsuario'=> $row->IdListaVerificacionUsuario,
							   	'IdBiblioteca'				=> $this->input->post( 'proceso_hidden' ),
							   	'Tipo'						=> $this->input->post( 'tipo_'.$row->IdListaVerificacionUsuario ),
							   	'Hallazgo'					=> $this->input->post( 'respuesta_'.$row->IdListaVerificacionUsuario ),
							);
							$i++;
						}
					}
				}
				$this->db->update_batch( 'au_respuestas_lista_sibib', $inserta, 'IdRespuestaLista' );
			}
			else {
				$i = 0;
				$inserta = array();
				$lista = $this->get_lista_usuario( $id );
				foreach( $lista->result() as $row ) {
					$inserta[$i] = array(
						'IdListaVerificacionUsuario'=> $row->IdListaVerificacionUsuario,
						'IdBiblioteca'				=> $this->input->post( 'proceso_hidden' ),
						'Tipo'						=> $this->input->post( 'tipo_'.$row->IdListaVerificacionUsuario ),
						'Hallazgo'					=> $this->input->post( 'respuesta_'.$row->IdListaVerificacionUsuario ),
					);
					$i++;
				}
				$this->db->insert_batch( 'au_respuestas_lista_sibib', $inserta );
			}
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE) {
			     return false;
			}
			else {
			    return true;
			}
		}
	}
}
?>