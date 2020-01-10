<?php 
/****************************************************************************************************
*
*	MODELS/admin/auditorias_admin_model.php
*
*		Descripción:  		  
*			Auditorias del sistema 
*
*		Fecha de Creación:
*			23/Octubre/2012
*
*		Ultima actualización:
*			23/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Auditorias_admin_model extends CI_Model {
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/			
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
/** Funciones **/
	//
	// get_programa_especifico( $ano, $auditoria, $estado ): Obtiene los programas en base al año
	//	
	function get_programa_especifico( $ano, $auditoria, $estado  ) {
		$condicion = array();
		// Años
		switch( $ano ) {
			case 'anos' :
				$this->db->group_by( 'au_auditorias.Ano' );
				break;
				
			default :
				$this->db->group_by( 'au_auditorias.IdAuditoria' );
				$condicion['au_auditorias.Ano'] = $ano;
				break;
		}
		
		// Auditorias
		switch( $auditoria ) {
			case 'todos' :
				break;
				
			default :
				$condicion['au_auditorias.Auditoria'] = $auditoria;
				break;
		}
		
		// Estados
		switch( $estado ) {
			case 'todos' :
				break;
				
			default :
				$condicion['au_auditorias.Estado'] = $estado;
				break;
		}
		
		$this->db->join( 'au_auditorias_procesos', 'au_auditorias_procesos.IdAuditoria = au_auditorias.IdAuditoria', 'LEFT' );
		$this->db->join( 'au_equipos', 'au_equipos.IdAuditoria = au_auditorias.IdAuditoria', 'LEFT' );
		$this->db->select( 'au_auditorias.IdAuditoria, au_auditorias.Auditoria, au_auditorias.Ano, au_auditorias.Inicio, au_auditorias.Termino, au_auditorias.Estado, au_auditorias_procesos.IdAuditoriaProceso, au_equipos.IdEquipo');
		$consulta = $this->db->get_where( 'au_auditorias', $condicion );
		
		return $consulta;
	}

	
	
	//
	// get_procesos( $id ): Obtiene los procesos para una auditoría
	//	
	function get_procesos( $id ) {
		$condicion = array(
			'Estado' => '1'
		);
		
		$consulta_procesos = $this->get_procesos_auditoria( $id );
		$procesos_no = array();
		if( $consulta_procesos->num_rows() > 0 ) {
			$i = 0;
			foreach( $consulta_procesos->result() as $row ) {
				$procesos_no[$i] = $row->IdProceso;
				$i++;
			}
			$this->db->where_not_in( 'IdProcesos', $procesos_no );
		}
		$this->db->order_by('au_procesos.Tipo, au_procesos.Proceso');
		$consulta = $this->db->get_where( 'au_procesos', $condicion );
		
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
	// get_procesos_documentos( $id ): Obtiene las relaciones procesos-documentos
	//	
	function get_procesos_documentos( $id ) {
		$this->db->join( 'bc_documentos', 'bc_documentos.IdDocumento = au_procesos_instructivos.IdInstructivo' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = bc_documentos.IdArea' );
		$consulta = $this->db->get( 'au_procesos_instructivos' );
		
		return $consulta;
	}
	
	//
	// get_procesos_disponibles( $id ): Obtiene los procesos de una auditoria disponibles para asignar a equipos
	//	
	function get_procesos_disponibles( $id ) {
		$condicion = array(
			'IdAuditoria' => $id
		);
		
		$consulta_procesos = $this->get_equipos_procesos( $id );
		$procesos_no = array();
		if( $consulta_procesos->num_rows() > 0 ) {
			$i = 0;
			foreach( $consulta_procesos->result() as $row ) {
				$procesos_no[$i] = $row->IdProceso;
				$i++;
			}
			$this->db->where_not_in( 'IdProcesos', $procesos_no );
		}
		$this->db->join( 'au_procesos', 'au_procesos.IdProcesos = au_auditorias_procesos.IdProceso' );
		$consulta = $this->db->get_where( 'au_auditorias_procesos', $condicion );
		
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
	// get_equipos_disponibles( $id ): Obtiene a los auditores que ya tienen equipo de una auditoria y a los que se les puede asignar un proceso
	//	
	function get_equipos_disponibles( $id ) {
		// obtiene a los auditores que ya tienen equipo para formar un array
		$condicion = array(
			'au_equipos.IdAuditoria' => $id,
		);
		
		$this->db->order_by( 'au_equipos.Nombre' );
		$this->db->join( 'au_equipos_usuarios', 'au_equipos_usuarios.IdUsuario = ab_usuarios.IdUsuario' );
		$this->db->join( 'au_equipos', 'au_equipos.IdEquipo = au_equipos_usuarios.IdEquipo' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = ab_usuarios.IdArea' );
		$this->db->select( 'au_equipos.Nombre as Equipo, au_equipos.IdEquipo, ab_areas.Area, ab_usuarios.IdUsuario, ab_usuarios.Nombre, ab_usuarios.Paterno, ab_usuarios.Materno');
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion );
		
		return $consulta;
	}

	//
	// get_auditores( $id ): Obtiene a los auditores disponibles para formar un equipo
	//	
	function get_auditores( $id ) {
		$condicion = array(
			'ab_usuarios.Estado' 			 => '1',
			'ab_usuarios_permisos.IdPermiso' => '11',
		);
		
		$consulta_auditores = $this->get_auditores_equipo( $id );
		$auditores_no = array();
		if( $consulta_auditores->num_rows() > 0 ) {
			$i = 0;
			foreach( $consulta_auditores->result() as $row ) {
				$auditores_no[$i] = $row->IdUsuario;
				$i++;
			}
			$this->db->where_not_in( 'ab_usuarios.IdUsuario', $auditores_no );
		}
		$this->db->order_by( 'ab_usuarios.IdArea' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = ab_usuarios.IdArea' );
		$this->db->join( 'ab_usuarios_permisos', 'ab_usuarios_permisos.IdUsuario = ab_usuarios.IdUsuario' );
		$this->db->select( 'ab_usuarios.IdUsuario, ab_usuarios.Nombre, ab_usuarios.Paterno, ab_usuarios.Materno, ab_areas.Area');
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion );
		
		return $consulta;
	}
	
	//
	// get_auditoria( $id ): Obtiene la auditoria en base a una id
	//	
	function get_auditoria( $id ) {
		$condicion = array(
			'IdAuditoria' => $id
		);
		
		$consulta = $this->db->get_where( 'au_auditorias', $condicion );
		
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
	// get_equipo( $id ): Obtiene a un equipo en base a la id
	//	
	function get_equipo( $id ) {
		$condicion = array(
			'IdEquipo' => $id
		);
		
		$consulta = $this->db->get_where( 'au_equipos', $condicion, 1 );
		
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
	// inserta_programa: Inserta un programa de auditoría
	//
	function inserta_programa() {
		// array para insertar en la bd
		$inserta = array(
			'Auditoria'	=> $this->input->post('auditoria'),
		   	'Ano'		=> $this->input->post('ano'),
		   	'Inicio'	=> $this->input->post('inicio'),
		   	'Termino'	=> $this->input->post('termino'),
		   	'Estado'	=> '0',
		);
		
		// realiza la inserción de la primera auditoria
		$resp = $this->db->insert('au_auditorias', $inserta);
			
		return $resp;
	}
	
	//
	// inserta_auditoria_procesos( $id ): Inserta los procesos a auditar de la auditoría
	//
	function inserta_auditoria_procesos( $id ) {
		$i = 0;
		$inserta = array();				
		foreach( $this->input->post('procesos') as $id_proceso ) {
			$inserta[$i] = array(
			   'IdAuditoria' => $id,
			   'IdProceso'	 => $id_proceso,
			);
			$i++;
		}
		$resp = $this->db->insert_batch( 'au_auditorias_procesos', $inserta );

		return $resp;
	}
	
	//
	// inserta_auditoria_procesos( $id ): Inserta los procesos a auditar de la auditoría
	//
	function inserta_auditoria_equipo( $id ) {
		$this->db->trans_start();
		// array para insertar en la bd
		$inserta = array(
			'IdAuditoria'	=> $id,
		   	'Nombre'		=> $this->input->post('equipo'),
		   	'Estado'		=> '1' // equipo activo
		);
		
		// realiza la inserción de la primera auditoria
		$resp = $this->db->insert('au_equipos', $inserta);
		
		if( $resp ) {
			$i = 0;
			$inserta = array();				
			foreach( $this->input->post('usuario') as $id_usuario ) {
				$inserta[$i] = array(
				   'IdEquipo'	=> $this->db->insert_id(),
				   'IdUsuario'	=> $id_usuario,
				   'Tipo'		=> $this->input->post('tipo_'.$id_usuario),
				);
				$i++;
			}
			$resp = $this->db->insert_batch( 'au_equipos_usuarios', $inserta );
		}

		$this->db->trans_complete();
		return $resp;
	}
	
	//
	// inserta_procesos_equipos( $id ): Inserta la asignación de procesos a equipos
	//
	function inserta_procesos_equipos( $id ) {
		$i = 0;
		$inserta = array();				
		foreach( $this->input->post('proceso') as $id_proceso ) {
			$inserta[$i] = array(
			   'IdEquipo' 	=> $this->input->post('equipo'),
			   'IdProceso'	=> $id_proceso,
			   'Fecha'		=> $this->input->post('fecha'),
			   'Hora'		=> $this->input->post('hora'),
			);
			$i++;
		}
		$resp = $this->db->insert_batch( 'au_equipos_procesos', $inserta );

		return $resp;
	}

	//
	// actualiza_auditoria( $id ): Complementa los datos de la auditoría específica
	//
	function actualiza_auditoria( $id ) {
		$actualiza = array(
			'Alcance'	=> $this->input->post('alcance'),
			'Objetivo'	=> $this->input->post('objetivo'),
			'Lider'		=> $this->input->post('lider'),
		);
		
		$this->db->where( 'IdAuditoria', $id );
		$resp = $this->db->update( 'au_auditorias', $actualiza );

		return $resp;
	}
		
	//
	// modifica_auditoria( $id ): Modifica una auditoría
	//
	function modifica_auditoria( $id ) {
		$actualiza = array(
			'Auditoria'	=> $this->input->post('auditoria'),
			'Ano'		=> $this->input->post('ano'),
			'Inicio'	=> $this->input->post('inicio'),
			'Termino'	=> $this->input->post('termino'),
		);
		
		$this->db->where( 'IdAuditoria', $id );
		$resp = $this->db->update( 'au_auditorias', $actualiza );

		return $resp;
	}
	
	//
	// modificar_auditoria_equipo( $id_auditoria, $id_equipo, $nuevos_auditores ): Modifica el nombre de equipo y agrega nuevos miembros
	//
	function modificar_auditoria_equipo( $id_auditoria, $id_equipo, $nuevos_auditores ) {
		$this->db->trans_start();
		// array para insertar en la bd
		$actualiza = array(
		   	'Nombre'		=> $this->input->post('equipo'),
		);
		
		// condicion para actualizar
		$condicion = array(
			'IdAuditoria'	=> $id_auditoria,
			'IdEquipo'		=> $id_equipo,
		);
		
		// realiza la inserción de la primera auditoria
		$this->db->where( $condicion );
		$resp = $this->db->update('au_equipos', $actualiza);
		
		if( $resp && $nuevos_auditores ) {
			$i = 0;
			$inserta = array();				
			foreach( $this->input->post('usuario') as $id_usuario ) {
				$inserta[$i] = array(
				   'IdEquipo'	=> $id_equipo,
				   'IdUsuario'	=> $id_usuario,
				   'Tipo'		=> $this->input->post('tipo_'.$id_usuario),
				);
				$i++;
			}
			$resp = $this->db->insert_batch( 'au_equipos_usuarios', $inserta );
		}

		$this->db->trans_complete();
		return $resp;
	}
	
	//
	// get_conformidad( $id ): Obtiene los datos de una no conformidad en base a la id
	//
	function get_conformidad( $proceso ) {
		$condicion = array(
			'IdConformidad' => $proceso
		);
		$this->db->join('ab_areas', 'ab_areas.IdArea = pa_conformidades.IdArea');
		$this->db->join('ab_departamentos', 'ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento');
		$consulta = $this->db->get_where( 'pa_conformidades', $condicion );
		
		return $consulta;
	}

	//
	// get_conformidades_usuario( $id ): Obtiene todas las no conformidades de un usuario en base al estado
	//
	function get_conformidades_usuario( $edo ) {
		$this->db->order_by("IdConformidad", "DESC");
		$this->db->join("ab_areas", "ab_areas.IdArea = pa_conformidades.IdArea");
		$this->db->join("ab_departamentos", "ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento");
		
		switch( $edo ) {
			case "pendientes" :				
				$consulta = $this->db->where('pa_conformidades.IdUsuario = '.$this->session->userdata('id_usuario').' AND ( pa_conformidades.Estado= 0 OR  pa_conformidades.Estado = 1 )')->get('pa_conformidades');
				break;
				
			case "cerradas" :				
				$consulta = $this->db->get_where('pa_conformidades',array('pa_conformidades.IdUsuario' => $this->session->userdata('id_usuario'), 'pa_conformidades.Estado' => '2'));
				break;
				
			case "eliminadas" :				
				$consulta = $this->db->get_where('pa_conformidades',array('pa_conformidades.IdUsuario' => $this->session->userdata('id_usuario'), 'pa_conformidades.Estado' => '3'));
				break;
				
			case "evidencias" :
				$consulta = $this->db->get_where('pa_conformidades',array('pa_conformidades.IdUsuario' => $this->session->userdata('id_usuario'), 'pa_conformidades.Estado' => '4'));
				break;
		}				
		
		return $consulta;
	}
	
	//
	// get_seguimiento( $id ): Obtiene los datos del seguimiento de una no conformidad en base a la id
	//
	function get_seguimiento( $id ) {		
		$condicion = array(
			'pa_conformidades_seguimiento.IdConformidad' => $id
		);
		
		$consulta = $this->db->get_where( 'pa_conformidades_seguimiento', $condicion );
		
		return $consulta;
	}

	//
	// get_diagrama( $id ): Obtiene los datos del diagrama de una no conformidad en base a la id
	//
	function get_diagrama( $id ) {
		$condicion = array(
			'pa_conformidades_diagrama.IdConformidad' => $id
		);
		
		$consulta = $this->db->get_where( 'pa_conformidades_diagrama', $condicion );
		
		return $consulta;
	}
	

	//
	// get_diagrama( $id ): Obtiene los datos del diagrama de una no conformidad en base a la id
	//
	function get_contencion( $id ) {
		$condicion = array(
			'pa_conformidades_contencion.IdConformidad' => $id
		);
		
		$consulta = $this->db->get_where( 'pa_conformidades_contencion', $condicion );
		
		return $consulta;
	}
	//
	// get_acciones( $id ): Obtiene los datos de las acciones de una no conformidad en base a la id
	//
	function get_acciones( $id ) {
		$condicion = array(
			'pa_conformidades_acciones.IdConformidad' => $id
		);
		
		$consulta = $this->db->get_where( 'pa_conformidades_acciones', $condicion );
		
		return $consulta;
	}
	
	//
	// get_evidencias( $id ): Obtiene las evidencias de la no conformidad 
	//
	function get_evidencias( $id ) {
		$condicion = array(
			'pa_conformidades_evidencias.IdConformidad' => $id
		);
		
		$consulta = $this->db->get_where( 'pa_conformidades_evidencias', $condicion );
		
		return $consulta;
	}
}
?>
