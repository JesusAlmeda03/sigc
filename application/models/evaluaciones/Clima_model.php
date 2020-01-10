<?php 
/****************************************************************************************************
*
*	MODELS/evaluaciones/clima_model.php
*
*		Descripción:  		  
*			Evaluación al Clima Laboral 
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
class Clima_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_preguntas(): Obtiene las preguntas de la encuesta
	//
	function get_preguntas( $id ) {
		$consulta = array(
			'en_preguntas.IdEncuesta' => $id
		);
		
		$this->db->order_by('IdSeccion');
		$consulta = $this->db->get_where('en_preguntas', $consulta );
		
		return $consulta;
	}
	
	//
	// get_secciones(): Obtiene las secciones de la encuesta
	//
	function get_secciones( $id ) {
		$consulta = array(
			'en_secciones.IdEncuesta' => $id
		);
		
		$this->db->order_by('IdSeccion');
		$consulta = $this->db->get_where( 'en_secciones', $consulta );
		
		return $consulta;
	}
	
	//
	// get_evaluacion(): Obtiene información de la evaluación
	//
	function get_evaluacion( $id ) {
		$consulta = array(
			'IdEncuesta'	=> $id,
			'Estado'		=> '1',
		);
		
		$this->db->order_by( 'IdEvaluacion','DESC' );
		$consulta = $this->db->get_where( 'en_evaluacion', $consulta, 1 );
		
		return $consulta;
	}
	
	//
	// get_jefes(): Obtiene al/los jefes del área, que no contesta clima
	//
	function get_jefes() {
		$consulta = array(
			'ab_usuarios.IdArea' 		 => $this->session->userdata('id_area'),
			'ab_usuarios_permisos.Clave' => 'JEF'
		);
		
		$this->db->join('ab_usuarios_permisos','ab_usuarios_permisos.IdUsuario = ab_usuarios.IdUsuario');
		$consulta = $this->db->get_where( 'ab_usuarios', $consulta, 1 );
		
		$jefes = array();
		if( $consulta->num_rows() > 0 ) {
			$i = 0;
			foreach ( $consulta->result() as $row ) {
				$jefes[$i] = $row->IdUsuario; 
				$i++;
			}
		}
		
		return $jefes;
	}	
	
	//
	// get_usuarios(): Obtiene el listado del personal del área
	//
	function get_usuarios() {
		$consulta = array(
			'ab_usuarios.IdArea' 			=> $this->session->userdata('id_area'),
			'ab_usuarios.Estado' 			=> 1, 
			'ab_usuarios.Nombre NOT LIKE' 	=> '%AUDITOR%',
		);
		
		$this->db->order_by( 'ab_usuarios.Nombre' );
		if( $this->get_jefes() )
			$this->db->where_not_in( 'IdUsuario', $this->get_jefes() );
		$consulta = $this->db->get_where( 'ab_usuarios', $consulta);
		
		return $consulta;
	}
	
	//
	// get_respuestas( $id_usuario, $id_evaluacion ): Obtiene las secciones de la encuesta
	//
	function get_respuestas( $id_usuario, $id_evaluacion ) {
		$consulta = array(
			'en_respuestas_clima.IdUsuario' 	=> $id_usuario, 
			'en_respuestas_clima.IdEvaluacion' 	=> $id_evaluacion
		);
		
		$consulta = $this->db->get_where( 'en_respuestas_clima', $consulta );
		
		return $consulta;
	}
}
?>
