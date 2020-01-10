<?php
/****************************************************************************************************
*
*	MODELS/procesos/objetivos_model.php
*
*		Descripción:
*			Objetivos de Calidad
*
*		Fecha de Creación:
*			13/Febrero/2012
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
class Objetivos_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/
	function __construct() {
		parent::__construct();
	}

/** Funciones **/
	//
	// get_objetivos(): Obtiene los objetivos de Calidad
	//
	function get_objetivos() {
		$condicion = array(
			'pa_objetivos.Estado' => '1'
		);
		$this->db->order_by('Objetivo');
		$consulta = $this->db->get_where( 'pa_objetivos', $condicion );

		return $consulta;
	}

	//
	// get_indicadores(): Obtiene los indicadores
	//
	function get_indicadores() {
		$condicion = array(
			'pa_indicadores.Estado' => '1'
		);
		$consulta = $this->db->get_where( 'pa_indicadores', $condicion );

		return $consulta;
	}

	//
	// get_objetivo_indicador( $id ): Obtiene los datos de un indicadores en base a la id
	//
	function get_objetivo_indicador( $id ) {
		$condicion = array(
			'pa_objetivos_indicadores.IdObjetivoIndicador'  => $id,
			'pa_objetivos_indicadores.Estado' 				=> '1'
		);
		$this->db->join('pa_objetivos','pa_objetivos.IdObjetivo = pa_objetivos_indicadores.IdObjetivo');
		$consulta = $this->db->get_where( 'pa_objetivos_indicadores', $condicion, 1 );

		return $consulta;
	}

	//
	// get_mediciones( $id ): Obtiene las mediciones de un objetivo de calidad en base a la id
	//
	function get_mediciones( $id ) {
		$condicion = array(
			'pa_objetivos_medicion.IdObjetivoIndicador' => $id
		);

		$this->db->order_by('pa_objetivos_medicion.Fecha','ASC');
		$consulta = $this->db->get_where( 'pa_objetivos_medicion', $condicion );

		return $consulta;
	}

	//
	// inserta_medicion( $id ): Inserta una nueva medición de indicador
	//
	function inserta_medicion( $id ) {
		// array para insertar en la bd
		$inserta = array(
		   'IdObjetivoIndicador'	=> $id,
		   'Fecha'					=> $this->input->post('fecha'),
		   'Medicion'				=> $this->input->post('medicion'),
		);

		// realiza la inserción
		$resp = $this->db->insert( 'pa_objetivos_medicion', $inserta );

		return $resp;
	}

	//
	// modifica_indicador( $id ): Modifica un indicador
	//
	function modifica_objetivo_indicador( $id ) {
		// array para actualizar en la bd
		$actualiza = array(
		   	'Indicador'		=> $this->input->post('indicador'),
			'Calculo'		=> $this->input->post('calculo'),
			'Meta'			=> $this->input->post('meta'),
			'Frecuencia'	=> $this->input->post('frecuencia'),
			'Observaciones'	=> $this->input->post('observaciones'),
		);

		// realiza la actualización
		$this->db->where( 'IdObjetivoIndicador', $id );
		$resp = $this->db->update( 'pa_objetivos_indicadores', $actualiza );

		return $resp;
	}

	//
	// eliminar_medicion( $id ): Elimina una medición
	//
	function eliminar_medicion( $id ) {
		$condicion = array(
			'pa_objetivos_medicion.IdObjetivoMedicion' 	=> $id,
		);

		$resp = $this->db->delete( 'pa_objetivos_medicion', $condicion );

		return $resp;
	}
}
?>
