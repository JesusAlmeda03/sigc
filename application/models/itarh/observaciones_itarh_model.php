<?php 
/****************************************************************************************************
*
*	MODELS/itarh/observaciones_itarh_model.php
*
*		Descripción:  		  
*			Observaciones 
*
*		Fecha de Creación:
*			08/Octubre/2011
*
*		Ultima actualización:
*			08/Octubre/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Observaciones_itarh_model extends CI_Model {
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
/** Funciones **/
	//
	// get_quincenas(): Obtiene las quincenas disponibles
	//	
	public function get_quincenas(){
		$this->db->group_by( 'Quincena' );
		$consulta = $this->db->get( 'rh_observaciones' );
		
		return $consulta;
	}
	
	//
	// get_observaciones( $quin, $edo ): Inserta una observación
	//	
	public function get_observaciones( $quin, $edo ){
		$condicion = array();
		
		// Quincena
		if( $quin != 'todos' ) {
			$quin = $rep = str_replace('-', ' ', $quin);
			$condicion['Quincena'] = $quin;
		}
		
		// Estado
		switch( $edo ) {
			case 'pendientes' :
				$condicion['Estado'] = '0';
				break;
				
			case 'solventadas' :
				$condicion['Estado'] = '1';
				break;
				
			case 'eliminadas' :
				$condicion['Estado'] = '2';
				break;
		}
		
		$consulta = $this->db->get_where( 'rh_observaciones', $condicion );
		
		return $consulta;
	}
	
	//
	// get_observacion( $id ): Obtiene la info de una observación en base a la id
	//	
	public function get_observacion( $id ){
		$condicion = array(
			'rh_observaciones.IdObservacion' => $id 
		);
		
		$this->db->join( 'rh_observaciones_seguimiento', 'rh_observaciones_seguimiento.IdObservacion = rh_observaciones.IdObservacion', 'LEFT' );
		$consulta = $this->db->get_where( 'rh_observaciones', $condicion, 1 );
		
		return $consulta;
	}
	
	//
	// inserta_observacion(): Inserta una observación
	//	
	public function inserta_observacion(){
		// array para insertar en la bd
		$inserta = array(
		   'IdUsuario'		=> $this->session->userdata('id_usuario'),
		   'Quincena'		=> $this->input->post('quincena').' quincena de '.$this->input->post('mes').' '.$this->input->post('ano'),
		   'Matricula'		=> $this->input->post('matricula'),
		   'Nombre'			=> $this->input->post('nombre'),
		   'Unidad'			=> $this->input->post('unidad'),
		   'Empleado'		=> $this->input->post('empleado'),
		   'Permanencia'	=> $this->input->post('permanencia'),
		   'Horas'			=> $this->input->post('contrato'),
		   'Sistema'		=> $this->input->post('sistema'),
		   'Contraloria'	=> $this->input->post('contraloria'),
		   'Observacion'	=> $this->input->post('observacion'),
		   'FechaRegistro'	=> date( 'g : m A  j/n/Y' ),
		   'Estado'			=> '0', // observación pendiente
		);
		
		// realiza la inserción
		$resp = $this->db->insert('rh_observaciones', $inserta); 
		
		return $resp;
	}
	
	//
	// inserta_resolver( $id ) : Inserta el seguimiento de la Observación
	//
	function inserta_resolver( $id ) {
		$this->db->trans_start();
		
		// array para insertar en la bd
		$inserta = array(
		   'IdObservacion'	=> $id,
		   'IdUsuario'		=> $this->session->userdata('id_usuario'), 
		   'Accion'			=> $this->input->post('accion'),
		   'FechaRegistro'	=> date( 'g : m A  j/n/Y' ),
		);
		
		// realiza la inserción
		$resp = $this->db->insert( 'rh_observaciones_seguimiento', $inserta );
		if( $resp ) {
			$actualiza = array( 'Estado' => '1' );
			
			// realiza la actualización del estado de la observación
			$this->db->where( 'IdObservacion', $id );
			$resp = $this->db->update( 'rh_observaciones', $actualiza );
		} 
		
		$this->db->trans_complete();
		return $resp;
	}
	
	//
	// modificar_observacion( $id, $edo ) : Inserta el seguimiento de la Observación
	//
	function modificar_observacion( $id, $edo ) {
		$this->db->trans_start();
		
		// array para insertar en la bd
		$acualiza = array(
		   'Quincena'		=> $this->input->post('quincena').' quincena de '.$this->input->post('mes').' '.$this->input->post('ano'),
		   'Matricula'		=> $this->input->post('matricula'),
		   'Nombre'			=> $this->input->post('nombre'),
		   'Unidad'			=> $this->input->post('unidad'),
		   'Empleado'		=> $this->input->post('empleado'),
		   'Permanencia'	=> $this->input->post('permanencia'),
		   'Horas'			=> $this->input->post('contrato'),
		   'Sistema'		=> $this->input->post('sistema'),
		   'Contraloria'	=> $this->input->post('contraloria'),
		   'Observacion'	=> $this->input->post('observacion'),
		);
		
		// realiza la inserción
		$this->db->where( 'IdObservacion', $id );
		$resp = $this->db->update( 'rh_observaciones', $acualiza );

		if( $resp && $edo == 1) {
			$actualiza = array(
				'Accion' => $this->input->post('accion'),
			);
			// realiza la actualización del estado de la observación
			$this->db->where( 'IdObservacion', $id );
			$resp = $this->db->update( 'rh_observaciones_seguimiento', $actualiza );
		}
		
		$this->db->trans_complete();
		return $resp;
	}
}
?>
