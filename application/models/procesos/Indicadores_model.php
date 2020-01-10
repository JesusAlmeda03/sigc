<?php 
/****************************************************************************************************
*
*	MODELS/procesos/indicadores_model.php
*
*		Descripción:  		  
*			No confomidades del sistema 
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
class Indicadores_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_indicadores(): Obtiene los indicadores de un área
	//
	function get_indicadores() {
		$condicion = array(
			'pa_indicadores.IdArea' => $this->session->userdata('id_area'),
			'pa_indicadores.Estado' => '1'
		);
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = pa_indicadores.IdArea' );
		$consulta = $this->db->get_where( 'pa_indicadores', $condicion );
		
		return $consulta;
	}	
	
	//
	// get_indicador( $id ): Obtiene los datos de un indicadores en base a la id
	//
	function get_indicador( $id ) {
		$condicion = array(
			'pa_indicadores.IdIndicador' => $id, 
			'pa_indicadores.Estado'		 => '1'
		);
				
		$consulta = $this->db->get_where( 'pa_indicadores', $condicion, 1 );
		
		return $consulta;
	}
	
	//
	// get_mediciones( $id ): Obtiene las mediciones de un indicadores en base a la id
	//
	function get_mediciones( $id ) {
		$condicion = array(
			'pa_indicadores_medicion.IdIndicador' => $id
		);
		
		$this->db->order_by( 'pa_indicadores_medicion.Fecha', 'ASC' );
		$consulta = $this->db->get_where( 'pa_indicadores_medicion', $condicion );
		
		return $consulta;
	}	
	
	//
	// inserta_medicion( $id ): Inserta una nueva medición de indicador
	//
	function inserta_medicion( $id ) {
		// array para insertar en la bd
		$inserta = array(
		   'IdIndicador'=> $id,
		   'Fecha'		=> $this->input->post('fecha'),
		   'Medicion'	=> $this->input->post('medicion'),
		);
		
		// realiza la inserción
		$resp = $this->db->insert( 'pa_indicadores_medicion', $inserta );
		
		return $resp;		
	}
	
	//
	// inserta_medicion_especiales( $id ): Inserta una nueva medición de indicador especial
	//
	function inserta_medicion_especiales( $id ) {
		// array para insertar en la bd
		$inserta = array(
		   'IdIndicador'=> $id,
		   'Fecha'		=> $this->input->post('fecha'),
		   'Concepto'	=> $this->input->post('concepto'),
		   'MedUno'		=> $this->input->post('med_uno'),
		   'MedDos'		=> $this->input->post('med_dos'),
		);
		
		// realiza la inserción
		$resp = $this->db->insert( 'pa_indicadores_medicion_especiales', $inserta );
		
		return $resp;		
	}
	
	//
	// modifica_indicador( $id ): Modifica un indicador
	//
	function modifica_indicador( $id ) {
		// array para actualizar en la bd
		$actualiza = array(
		   'Indicador'		=> $this->input->post('indicador'),
			'Calculo'		=> $this->input->post('calculo'),
			'Meta'			=> $this->input->post('meta'),
			'Responsable'	=> $this->input->post('responsable'),
			'Frecuencia'	=> $this->input->post('frecuencia'),
			'Observaciones'	=> $this->input->post('observaciones'),
		);
		
		// realiza la actualización
		$this->db->where( 'IdIndicador', $id );
		$resp = $this->db->update( 'pa_indicadores', $actualiza ); 
		
		return $resp;
	}	
	
	//
	// eliminar_medicion( $id ): Elimina una medición
	//
	function eliminar_medicion( $id ) {
		$condicion = array(
			'pa_indicadores_medicion.IdIndicadorMedicion' 	=> $id,
		);
		
		$resp = $this->db->delete( 'pa_indicadores_medicion', $condicion );
		
		return $resp;
	}
	
	//
	// eliminar_medicion_especiales( $id ): Elimina una medición
	//
	function eliminar_medicion_especiales( $id ) {
		$condicion = array(
			'pa_indicadores_medicion_especiales.IdIndicadorMedicionEspeciales' 	=> $id,
		);
		
		$resp = $this->db->delete( 'pa_indicadores_medicion_especiales', $condicion );
		
		return $resp;
	}
}
?>
