<?php 
/****************************************************************************************************
*
*	MODELS/procesos/expediente_model.php
*
*		Descripción:  		  
*			Expedientes de los usuarios del sistema 
*
*		Fecha de Creación:
*			10/Enero/2013
*
*		Ultima actualización:
*			10/Enero/2013
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Expediente_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_usuarios(): Obtiene a los usuarios del área
	// 
	function get_usuarios() {
		$condicion = array(
			'IdArea' => $this->session->userdata('id_area'),
			'Estado' => '1'
		);
		
		$this->db->order_by( 'Nombre' );
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion ); 
		
		return $consulta;
	}
	
	//
	// get_usuario( $id ): Obtiene el expediente de un usuario
	// 
	function get_usuario( $id ) {
		$condicion = array(
			'ab_usuarios.IdUsuario' => $id,
		);
		
		$this->db->order_by( 'Fecha', 'DESC' );
		$this->db->join( 'ab_expediente', 'ab_expediente.IdUsuario = ab_usuarios.IdUsuario', 'LEFT' );
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion ); 
		
		return $consulta;
	}
	
	//
	// inserta_expediente( $nom_doc ): Obtiene el expediente de un usuario
	// 
	function inserta_expediente( $id_usuario, $nom_doc ) {
		$insert = array(
			'IdUsuario' => $id_usuario,
			'Ruta'		=> $nom_doc,
			'Fecha'		=> date('Y').'/'.date('m').'/'.date('d'),
		);
		$resp = $this->db->insert( 'ab_expediente', $insert ); 
		
		return $resp;
	}
}
?>