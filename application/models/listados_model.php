<?php 
/****************************************************************************************************
*
*	MODELS/listados_model.php
*
*		Descripción:  		  
*			Listados del sistema generados por los Procesos Automatizados 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			30/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Listados_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_quejas( $edo ): Obtiene las quejas
	//
	function get_quejas( $edo ) {
		// condicion de la consulta
		$condicion = array(
			'pa_quejas.IdArea' => $this->session->userdata('id_area')
		);
		
		if( $edo != 'todos' ) {
			switch( $edo ) {
				case 'pendientes' :	$edo = '0'; break;
				case 'terminadas' :	$edo = '1'; break;
				case 'eliminadas' :	$edo = '2'; break;
			}
			
			$condicion['pa_quejas.Estado'] = $edo;
		}
		else {
			// si no tiene los permisos no ve las eliminadas
			if( !$this->session->userdata('QUE') ) {
				$condicion['pa_quejas.Estado <>'] = '2';
			}					
		}
		
		// consulta
		$this->db->order_by( 'IdQueja', 'DESC' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = pa_quejas.IdArea' );
		$this->db->join( 'ab_departamentos', 'ab_departamentos.IdDepartamento = pa_quejas.IdDepartamento' );
		$this->db->where( $condicion );
		$consulta = $this->db->get( 'pa_quejas' );
		
		return $consulta;
	}
	
	//
	// get_conformidades( $edo ): Obtiene las no conformidades
	//
	function get_conformidades( $edo ) {
		// condicion de la consulta
		$condicion = array(
			'pa_conformidades.IdArea' => $this->session->userdata('id_area')
		);
		if( $edo != 'todos' ) {
			switch( $edo ) {
				case 'sin-atender' 	:	$edo = '0'; break;
				case 'atendidas'	:	$edo = '1'; break;
				case 'cerradas'	 	:	$edo = '2'; break;
				case 'eliminadas'	:	$edo = '3'; break;
				case 'evidencias'	:	$edo = '4'; break;
			}

			$condicion['pa_conformidades.Estado'] = $edo;
		}
		else {
			// si no tiene los permisos no ve las eliminadas
			if( !$this->session->userdata('CON') ) {
				$condicion['pa_conformidades.Estado <>'] = '3';
			}
		}
		
		// consulta
		$this->db->order_by( 'IdConformidad', 'DESC' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = pa_conformidades.IdArea' );
		$this->db->join( 'ab_departamentos', 'ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento' );
		$this->db->where( $condicion );
		$consulta = $this->db->get( 'pa_conformidades' );
		
		return $consulta;
	}
	
	//
	// get_minutas( $edo ): Obtiene las minutas
	//
	function get_minutas( $edo ) {
		// condicion de la consulta
		$condicion = array(
			'mn_minutas.IdArea' => $this->session->userdata('id_area')
		);
		if( $edo != 'todos' ) {
			switch( $edo ) {
				case 'activas' 	  :	$edo = '1'; break;
				case 'eliminadas' :	$edo = '0'; break;
			}
			
			$condicion['mn_minutas.Estado'] = $edo;
		}
		else {
			// si no tiene los permisos no ve las eliminadas
			if( !$this->session->userdata('MIN') ) {
				$condicion['mn_minutas.Estado <>'] = '0';
			}
		}
		
		
		// consulta
		$this->db->order_by("mn_minutas.IdMinuta", "DESC");
		$this->db->join('mn_minutas_puntos','mn_minutas_puntos.IdMinuta = mn_minutas.IdMinuta');
		$this->db->where( $condicion );
		$consulta = $this->db->get( 'mn_minutas' );
		
		return $consulta;
	}

	//
	// get_solicitudes( $edo, $tip ): Obtiene las solicitudes
	//
	function get_solicitudes( $edo, $tip ) {
		// condicion de la consulta
		$condicion = array(
			'pa_solicitudes.IdArea' => $this->session->userdata('id_area')
		);
		
		switch( $edo ) {
			case 'pendientes' 	  		 :	$edo = '0'; break;
			case 'aceptadas-solicitador' :	$edo = '1'; break;
			case 'aceptadas-autorizador' :	$edo = '2'; break;
			case 'aceptadas-cc'			 :	$edo = '3'; break;
			case 'rechazadas'			 :	$edo = '4'; break;
			case 'eliminadas' 			 :	$edo = '5'; break;
		}
		
		if( $edo != 'todos' && $tip != 'todos' ) {			
			$condicion['pa_solicitudes.Estado'] = $edo;
			$condicion['pa_solicitudes.Solicitud'] = $tip;
		}
		elseif( $edo != 'todos' && $tip == 'todos' ) {
			$condicion['pa_solicitudes.Estado'] = $edo;
		}
		elseif( $edo == 'todos' && $tip != 'todos' ) {
			$condicion['pa_solicitudes.Solicitud'] = $tip;
			
			// si no tiene los permisos no ve las eliminadas
			if( !$this->session->userdata('CON') ) {
				$condicion['pa_solicitudes.Estado <>'] = '5';
			}
		}
		// si no tiene los permisos no ve las eliminadas
		elseif( !$this->session->userdata('CON') ) {
			$condicion['pa_solicitudes.Estado <>'] = '5';
		}
		
		// consulta
		$this->db->order_by("pa_solicitudes.Solicitud");
		$this->db->select('bc_documentos.IdDocumento,bc_documentos.Nombre,bc_documentos.Codigo,pa_solicitudes.IdSolicitud,pa_solicitudes.Estado,pa_solicitudes.Fecha,pa_solicitudes.Causas,pa_solicitudes.Solicitud');
		$this->db->join('bc_documentos','bc_documentos.IdDocumento = pa_solicitudes.IdDocumento');
		$this->db->where( $condicion );
		$consulta = $this->db->get( 'pa_solicitudes' );
		
		return $consulta;
	}
	
	//
	// get_mantenimiento(): Obtiene los programas de mantenimiento
	//
	function get_mantenimiento() {
		$this->db->join('ab_areas','ab_areas.IdArea = pa_mtto_programa.IdArea');
		$consulta = $this->db->get( 'pa_mtto_programa' );
		
		return $consulta;
	}
	
	//
	// get_capacitacion(): Obtiene los cursos de capacitación aprobados
	//
	function get_capacitacion($fecha) {
		$condicion = array('pa_capacitacion_cursos_propuestos.Fecha >=' => $fecha, 'pa_capacitacion_cursos_propuestos.Estado' => '1');
		$this->db->join('pa_capacitacion_cursos','pa_capacitacion_cursos.IdCapacitacionCurso = pa_capacitacion_cursos_propuestos.IdCurso');
		$consulta = $this->db->get_where('pa_capacitacion_cursos_propuestos',$condicion);
				
		return $consulta;
	}
	
	//
	// cambia_estado( $tipo, $id, $estado ): Cambia de estado los registros
	//
	function cambia_estado( $tipo, $id, $estado ) {
		$this->db->trans_start();
		// realiza los cambios segun el tipo
		switch( $tipo ) {
		// Quejas
			case 'quejas' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdQueja', $id );
				$resp = $this->db->update( 'pa_quejas', $actualiza );
				if( $resp && $estado == 2 ) {
					$this->db->where( 'IdQueja', $id );
					$resp = $this->db->delete( 'pa_quejas_seguimiento' );
				}
				break;
		
		// No Conformidades
			case 'conformidades' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdConformidad', $id );
				$resp = $this->db->update( 'pa_conformidades', $actualiza );
				if( $resp && $estado == 3 ) {
					$this->db->where( 'IdConformidad', $id );
					$resp = $this->db->delete( 'pa_conformidades_acciones' );
					if( $resp ) {
						$this->db->where( 'IdConformidad', $id );
						$resp = $this->db->delete( 'pa_conformidades_diagrama' );
						if( $resp ) {
							$this->db->where( 'IdConformidad', $id );
							$resp = $this->db->delete( 'pa_conformidades_seguimiento' );
						}
					}
				}
				break;
				
		// Minutas
			case 'minutas' :
				$actualiza = array(
					'Estado' => $estado
				);
				$this->db->where( 'IdMinuta', $id );
				$resp = $this->db->update( 'mn_minutas', $actualiza );
				break;
				
		// Solicitudes
			case 'solicitudes' :
				$actualiza = array(
					'Estado' => $estado
				);
				if( $estado == 5 ) {
					$actualiza['Observaciones'] = '';
				}
				
				$this->db->where( 'IdSolicitud', $id );
				$resp = $this->db->update( 'pa_solicitudes', $actualiza );
								
				if( $resp && $estado == 5 ) {
					$actualiza = array (
						'Aceptado' => '0'
					);
					$this->db->where( 'IdSolicitud', $id );
					$resp = $this->db->update( 'pa_solicitudes_distribucion', $actualiza );
				}
				break;
				
		// Usuarios
			case 'usuarios' :
				$actualiza = array(
					'Estado' => $estado
				);				
				
				$this->db->where( 'IdUsuario', $id );
				$this->db->where( 'IdArea', $this->session->userdata('id_area') );
				$resp = $this->db->update( 'ab_usuarios', $actualiza );
				break;
				
		// Observaciones - del IT.ARH.01
			case 'observaciones' :
				$actualiza = array(
					'Estado' => $estado
				);				
				
				$this->db->where( 'IdObservacion', $id );
				$resp = $this->db->update( 'rh_observaciones', $actualiza );
				if( $resp && $estado == 1 ) {
					$this->db->where( 'IdObservacion', $id );
					$resp = $this->db->delete( 'pa_observaciones_seguimiento' );
				}
				break;
				
		// Procesos de una Auditoría
			case 'lista_verificacion' :
				$ides = explode("-", $id);
				$this->db->where( array( 
						'IdAuditoria'  					=> $ides[0],
						'IdListaVerificacionUsuario' 	=> $ides[1],
						'IdUsuario'					 	=> $this->session->userdata('id_usuario'),
					) 
				);
				$resp = $this->db->delete( 'au_lista_verificacion_usuario' );
				break;
				
		// Expediente
			case 'expediente' :
				$this->db->where( 'IdExpediente', $id );
				$resp = $this->db->delete( 'ab_expediente' );
				break;
		}
		
		$this->db->trans_complete();
		
		return $resp;
	}
}
?>
