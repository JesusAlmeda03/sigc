<?php
/****************************************************************************************************
*
*	MODELS/procesos/quejas_model.php
*
*		Descripción:
*			Documentos del sistema
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
class Quejas_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/
	function __construct() {
		parent::__construct();
	}

/** Funciones **/
	//
	// get_queja( $id ): Obtiene los datos de una queja en base a la id
	//
	function get_queja( $id ) {
		$condicion = array(
			'IdQueja' => $id
		);
		$this->db->join('ab_areas','ab_areas.IdArea = pa_quejas.IdArea');
		$this->db->join('ab_departamentos','ab_departamentos.IdDepartamento = pa_quejas.IdDepartamento');
		$consulta = $this->db->get_where( 'pa_quejas', $condicion );

		return $consulta;
	}

	//
	// get_seguimiento( $id ): Obtiene los datos del seguimiento de una queja en base a la id
	//
	function get_seguimiento( $id ) {
		$condicion = array(
			'pa_quejas_seguimiento.IdQueja' => $id
		);
		$this->db->select( 'pa_quejas.IdQueja, pa_quejas_seguimiento.Responsable, pa_quejas_seguimiento.Descripcion, pa_quejas_seguimiento.FechaS, pa_quejas_seguimiento.Observacion');
		$this->db->join('pa_quejas','pa_quejas.IdQueja = pa_quejas_seguimiento.IdQueja');
		$consulta = $this->db->get_where( 'pa_quejas_seguimiento', $condicion );

		return $consulta;
	}

	//
	// inserta_queja(): Inserta una nueva queja
	//
	function inserta_queja() {
		// array para insertar en la bd
		$inserta = array(
		   'IdUsuario'		=> $this->session->userdata('id_usuario'),
		   'IdArea'			=> $this->input->post('area'),
		   'IdDepartamento'	=> $this->input->post('departamento'),
		   'Nombre'			=> $this->input->post('nombre_queja'),
		   'Fecha'			=> $this->input->post('fecha'),
		   'Correo'			=> $this->input->post('correo'),
		   'Telefono'		=> $this->input->post('telefono'),
		   'Queja'			=> $this->input->post('queja'),
		   'Estado'			=> '0', // queja pendiente
		);

		// realiza la inserción
		$resp = $this->db->insert( 'pa_quejas', $inserta );

		return $resp;
	}

	//
	// inserta_seguimiento( $id ): Inserta el seguimiento de la queja
	//
	function inserta_seguimiento( $id ) {
		$this->db->trans_start();
		// array para insertar en la bd
		$inserta = array(
		   'IdQueja'			=> $id,
		   'FechaS'				=> $this->input->post('fecha'),
		   'Responsable'	=> $this->input->post('responsable'),
		   'Descripcion'	=> $this->input->post('descripcion'),
		   'Observacion'	=> $this->input->post('observacion'),
		);

		// realiza la inserción
		$resp = $this->db->insert( 'pa_quejas_seguimiento', $inserta );
		if( $resp ) {
			$actualiza = array('Estado'	=> '1'); // queja terminada

			// actualiza el estado de la queja
			$this->db->where( 'IdQueja', $id );
			$resp = $this->db->update( 'pa_quejas', $actualiza );
		}

		$this->db->trans_complete();
		return $resp;
	}

	//
	// modifica_queja( $id, $edo ): Modifica una queja
	//
	function modifica_queja( $id, $edo ) {
		$this->db->trans_start();
		// array para actualizar en la bd
		$actualiza = array(
		   'IdArea'			=> $this->input->post('area'),
		   'IdDepartamento'	=> $this->input->post('departamento'),
		   'Nombre'			=> $this->input->post('nombre'),
		   'FechaS'			=> $this->input->post('fecha'),
		   'Correo'			=> $this->input->post('correo'),
		   'Telefono'		=> $this->input->post('telefono'),
		   'Queja'			=> $this->input->post('queja'),
		);

		// realiza la actualización
		$this->db->where( 'pa_quejas.IdQueja', $id );
		$resp = $this->db->update( 'pa_quejas', $actualiza );
		if( $resp ) {
			// si hay seguimiento
			if( $edo ) {
				// array para actualizar en la bd
				$actualiza = array(
				   'Responsable'	=> $this->input->post('responsable'),
				   'Descripcion'	=> $this->input->post('descripcion'),
				   'FechaS'			=> $this->input->post('fecha_seguimiento'),
				   'Observacion'	=> $this->input->post('observaciones'),
				);

				// realiza la actualización
				$this->db->where( 'pa_quejas_seguimiento.IdQueja', $id );
				$resp = $this->db->update( 'pa_quejas_seguimiento', $actualiza );
			}
		}

		$this->db->trans_complete();
		return $resp;
	}
}
?>
