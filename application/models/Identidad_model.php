<?php 
/****************************************************************************************************
*
*	MODELS/identidad_model.php
*
*		Descripción:  		  
*			Identidad del sistema 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			10/Julio/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Identidad_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_texto( $id ): Obtiene el texto de la sección de identidad especificada por el id
	//
	function get_texto( $id ) {
		$identidad = array();
		
		// obtiene la información del SIGC
		$condicion = array( 
			'cd_identidad_textos.IdSistema' => '1', // Id del SIGC
			'cd_identidad_textos.IdIdentidad' => $id
		);
		$this->db->order_by( 'cd_sistemas.IdSistema' );
		$this->db->select( 'cd_identidad.Titulo, cd_identidad_textos.Texto, cd_sistemas.Sistema' );
		$this->db->join( 'cd_identidad', 'cd_identidad_textos.IdIdentidad = cd_identidad.IdIdentidad' );
		$this->db->join( 'cd_sistemas', 'cd_sistemas.IdSistema = cd_identidad_textos.IdSistema' );
		$consulta = $this->db->get_where( 'cd_identidad_textos', $condicion );
		if ( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$identidad['titulo'] = $row->Titulo;
				$identidad['texto'] = '<div style="font-weight:bold; font-size:22px; text-align:center">'.$row->Sistema.'</div>'.$row->Texto;
			}
			$seguir = true;
		}
		else {
			// obtiene la información
			$condicion = array( 
				'cd_identidad_textos.IdSistema' => $this->session->userdata( 'id_sistema' ),
				'cd_identidad_textos.IdIdentidad' => $id
			);
			$this->db->order_by( 'cd_sistemas.IdSistema' );
			$this->db->select( 'cd_identidad.Titulo, cd_identidad_textos.Texto, cd_sistemas.Sistema' );
			$this->db->join( 'cd_identidad', 'cd_identidad_textos.IdIdentidad = cd_identidad.IdIdentidad' );
			$this->db->join( 'cd_sistemas', 'cd_sistemas.IdSistema = cd_identidad_textos.IdSistema' );
			$consulta = $this->db->get_where( 'cd_identidad_textos', $condicion );
			if ( $consulta->num_rows() > 0 ) {
				foreach( $consulta->result() as $row ) {
					$identidad['titulo'] = $row->Titulo;
					$identidad['texto'] = $row->Texto;
				}
			}
			$seguir = false;
		}
		
		// obtiene la información del sistema del usuario
		if( $seguir && ( $this->session->userdata( 'id_sistema' ) == 2 || $this->session->userdata( 'id_sistema' ) == 4 || $this->session->userdata( 'id_sistema' ) == 5 )  ) {
			// obtiene la información
			$condicion = array( 
				'cd_identidad_textos.IdSistema' => $this->session->userdata( 'id_sistema' ),
				'cd_identidad_textos.IdIdentidad' => $id
			);
			$this->db->order_by( 'cd_sistemas.IdSistema' );
			$this->db->select( 'cd_identidad.Titulo, cd_identidad_textos.Texto, cd_sistemas.Sistema' );
			$this->db->join( 'cd_identidad', 'cd_identidad_textos.IdIdentidad = cd_identidad.IdIdentidad' );
			$this->db->join( 'cd_sistemas', 'cd_sistemas.IdSistema = cd_identidad_textos.IdSistema' );
			$consulta = $this->db->get_where( 'cd_identidad_textos', $condicion );
			if ( $consulta->num_rows() > 0 ) {
				foreach( $consulta->result() as $row ) {
					$identidad['texto'] .= '<div style="border:1px dashed #CCC; margin:30px 0"></div><div style="font-weight:bold; font-size:22px; text-align:center">'.$row->Sistema.'</div>'.$row->Texto;
				}
			}
		}
		
		return $identidad;
	}
}
?>
