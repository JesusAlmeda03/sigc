<?php 
/****************************************************************************************************
*
*	MODELS/procesos/minutas_model.php
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
class Minutas_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_datos_minuta(): Revisa si no se ha generado ya esta minuta
	//
	function get_datos_minuta( ) {
		$condicion = array(
			'IdArea' 	=> $this->session->userdata('id_area'), 
			'Periodo' 	=> $this->input->post('periodo'),
			'Ano' 		=> $this->input->post('ano'), 
			'Estado'	=> '1'
		);
		$this->db->join('mn_minutas_puntos','mn_minutas_puntos.IdMinuta = mn_minutas.IdMinuta');
		$consulta = $this->db->get_where( 'mn_minutas', $condicion, 1 );
		
		return $consulta;
	}
	
	//
	// get_puntos( $id ): Obtiene los datos que se van guardando
	//
	function get_puntos( $id ) {
		$condicion = array(
			'mn_minutas.IdMinuta' => $id
		);
		$this->db->join('mn_minutas_puntos','mn_minutas_puntos.IdMinuta = mn_minutas.IdMinuta');
		$consulta = $this->db->get_where( 'mn_minutas', $condicion, 1 );
		
		return $consulta;
	}
	
	//
	// inserta_minuta(): Inicializa una minuta
	//
	function inserta_minuta() {
		$this->db->trans_start();
		// array para insertar en la bd
		$inserta = array(
		    'IdArea'	=> $this->session->userdata('id_area'),
			'Periodo'	=> $this->input->post('periodo'),
			'Ano'		=> $this->input->post('ano'),
			'Estado'	=> 1, // minuta activa
		);
		
		// realiza la inserción en la tabla de minutas y minutas_puntos
		if( $this->db->insert( 'mn_minutas', $inserta ) ) {
			$id_minuta = $this->db->insert_id();
			$inserta = array(
				'IdMinuta'	=> $id_minuta
			);
			if( $this->db->insert('mn_minutas_puntos', $inserta) ) {
				$id_minuta_puntos = $this->db->insert_id();
				$this->db->trans_complete();
				return 'procesos/minutas/puntos/'.$id_minuta.'/10/'.$id_minuta_puntos.'/0';
			}
			else {
				$this->db->trans_complete();
				return fasle;
			}
		}
		else {
			$this->db->trans_complete();
			return fasle;
		}
	}
	
	//
	// modifica_punto( $id_punto, $id_minuta_punto ): Modifica un punto de la minuta
	//
	function modifica_punto( $id_punto, $id_minuta_punto, $campo, $campo_2, $input, $input_2 ) {
		switch ( $id_punto ) {
			// IV. Desempeño - Infraestructura y Ambiente de Trabajo
			case 41 :
				$actualiza = array(
					$campo => $this->input->post( $input ),
					$campo_2 => $this->input->post( $input_2 ),
				);
				break;
			
			// Todos los puntos
			default :					
				$actualiza = array(
					$campo => $this->input->post( $input )
				);
				break;
		}
		
		$this->db->where( 'IdMinutaPuntos', $id_minuta_punto );
		$resp = $this->db->update( 'mn_minutas_puntos', $actualiza );
		
		return $resp;
	}
}
?>
