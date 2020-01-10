<?php 
/****************************************************************************************************
*
*	MODELS/procesos/conformidades_model.php
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
class Conformidades_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_conformidad( $id ): Obtiene los datos de una no conformidad en base a la id
	//
	function get_conformidad( $id ) {
		$condicion = array(
			'IdConformidad' => $id
		);
		$this->db->join('ab_areas', 'ab_areas.IdArea = pa_conformidades.IdArea');
		$this->db->join('ab_departamentos', 'ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento');
		$consulta = $this->db->get_where( 'pa_conformidades', $condicion );
		
		return $consulta;
	}
	
	//
	// get_conformidad_usuario( $id ): Obtiene los datos del usuario de una no conformidad en base a la id
	//
	function get_conformidad_usuario( $id ) {
		$condicion = array(
			 'pa_conformidades.IdConformidad' => $id
		);
		
		$this->db->join( 'ab_usuarios', 'ab_usuarios.IdUsuario = pa_conformidades.IdUsuario');
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = ab_usuarios.IdArea');
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
	/*function get_evidencias( $id ) {
		$condicion = array(
			'pa_conformidades_evidencias.IdConformidad' => $id
		);
		
		$consulta = $this->db->get_where( 'pa_conformidades_evidencias', $condicion );
		
		return $consulta;
	}*/
	
	//
	// get_conformidades_cerrar(): Listado de las no conformidades a cerrar
	//
	function get_conformidades_cerrar() {
		$condicion = array(
			'IdUsuario' => $this->session->userdata( 'id_usuario' ),
			'Estado' 	=> '1', 
		);
		$this->db->order_by( 'IdConformidad', 'DESC' );
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = pa_conformidades.IdArea' );
		$this->db->join( 'ab_departamentos', 'ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento' );
		$consulta = $this->db->get_where( 'pa_conformidades', $condicion );
		
		return $consulta;
	}
	function get_tipo($id){
		$condicion = array(
				'Idusuario' => $id, 
				'Clave'	=> 'CON'
			);
		$consulta = $this->db->get_where('ab_usuarios_permisos', $condicion);
		return $consulta;
	}
	//
	// get_conformidades_cerrar(): Listado de las no conformidades a cerrar
	//
	function get_conformidades_revisar($id) {
		$condicion = array(
			'IdConformidad' => $id
		);
		$this->db->join('ab_usuarios', 'ab_usuarios.IdUsuario = pa_conformidades.IdUsuario');
		$this->db->join('ab_areas', 'ab_areas.IdArea = pa_conformidades.IdArea');
		$this->db->join('ab_departamentos', 'ab_departamentos.IdDepartamento = pa_conformidades.IdDepartamento' );
		$consulta = $this->db->get_where( 'pa_conformidades', $condicion );
		return $consulta;
	}

	//
	//get_aCont($id) recupera las acciones de contencion de la base de datos
	function get_aCont($id){
		$condicion = array(
			'IdConformidad' => $id
		);

		$aCon = $this->db->get_where('pa_conformidades_contencion', $condicion);
		return $aCon;
	}
					
	//
	// inserta_conformidad(): Inserta una nueva no confomidad
	//
	function inserta_conformidad() {
		// array para insertar en la bd
		$inserta = array(
		   	'IdUsuario'		 => $this->session->userdata('id_usuario'),
		   	'IdArea'		 => $this->input->post('area'),
		   	'IdDepartamento' => $this->input->post('departamento'),
		   	'Fecha'			 => $this->input->post('fecha'),
		   	'Tipo' 			 => $this->input->post('tipo'),
		   	'Origen'		 => $this->input->post('origen'),
		   	'Descripcion'	 => $this->input->post('descripcion'),
		   	'EstadoAvance'	 => '0', // avance de la no conformidad
			'Estado' 		 => '0',  // no conformidad sin atender
		);
		
		// realiza la inserción
		$resp = $this->db->insert( 'pa_conformidades', $inserta );
		
		return $resp;		
	}

	//
	// inserta_conformidad_auditoria(): Inserta una nueva no confomidad en base a un hallazgo de la auditoría
	//
	function inserta_conformidad_auditoria( $id ) {
		$this->db->trans_start();
		// array para insertar en la bd
		$inserta = array(
		   	'IdUsuario'		 => $this->session->userdata('id_usuario'),
		   	'IdArea'		 => $this->input->post('area'),
		   	'IdDepartamento' => $this->input->post('departamento'),
		   	'Fecha'			 => $this->input->post('fecha'),
		   	'Tipo' 			 => $this->input->post('tipo'),
		   	'Origen'		 => $this->input->post('origen'),
		   	'Descripcion'	 => $this->input->post('descripcion'),
		   	'EstadoAvance'	 => '0', // avance de la no conformidad
			'Estado' 		 => '0',  // no conformidad sin atender
		);
		
		// realiza la inserción
		$resp = $this->db->insert( 'pa_conformidades', $inserta );
		if( $resp ) {
			$inserta = array(
				'IdConformidad' => $this->db->insert_id(),
				'IdHallazgo'	=> $id
			);
			// si no es sibib
			if( $this->session->userdata( 'id_area') != 9 ) {
				$resp = $this->db->insert( 'pa_conformidades_hallazgos', $inserta );
			}
			// sibib
			else {
				$resp = $this->db->insert( 'pa_conformidades_hallazgos_sibib', $inserta );
			}
		}
		
		$this->db->trans_complete();
		return $resp;
	}
	
	//
	// inserta_pescado( $categorias_array ): Inserta el diagrama de pescado de la no confomidad
	//
	function inserta_pescado( $id, $categorias_array, $avance ) {
		$this->db->trans_start();
		$i = 1;
		$j = 0;
		$inserta = array();
		foreach ($categorias_array as $row) {
			$inserta[$j] = array(
				'IdConformidad' => $id, 
				'Categoria' 	=> $row, 
				'Causa' 		=> $this->input->post('causa_' . $i)
			);
			$i++;
			$j++;
		}
		
		// inserta el diagrama
		if( $this->db->insert_batch( 'pa_conformidades_diagrama', $inserta ) ) {
			//actualiza el avance
			$actualiza = array(
				'EstadoAvance' => $avance
			);
			$resp = $this->db->where( 'IdConformidad', $id )->update( 'pa_conformidades', $actualiza );
		}
		
		$this->db->trans_complete();
		return $resp;		
	}
	
	//
	// inserta_causa( $id, $avance ): Inserta la causa raíz de la no confomidad
	//
	function inserta_causa( $id, $avance) {
		$this->db->trans_start();
		$inserta = array(
			'IdConformidad' => $id,
			'Causa' 		=> $this->input->post('causa'),
			'Herramienta' 	=> 'Diagrama de Pescado',
		);
		
		// inserta la causa
		if ( $this->db->insert( 'pa_conformidades_seguimiento', $inserta ) ) {
			//actualiza el avance
			$actualiza = array(
				'EstadoAvance' => $avance
			);
			$resp = $this->db->where( 'IdConformidad', $id )->update( 'pa_conformidades', $actualiza );
		}
		
		$this->db->trans_complete();
		return $resp;		
	}
	
	//
	// inserta_acciones( $id, $avance ): Inserta las acciones correctivas de la no confomidad
	//
	function inserta_acciones( $id, $avance ) {
		$this->db->trans_start();
		$inserta = array();
		$inserta[0] = array(
			'IdConformidad' => $id,
			'Tipo' 			=> $this->input->post('accion'),
			'Accion' 		=> $this->input->post('descripcion'),
			'Responsable' 	=> $this->input->post('responsable'),
			'Fecha' 		=> $this->input->post('fecha')
		);
		for ( $i = 2; $i <= $this->input->post('nextinput'); $i++ ) {
			$inserta[$i] = array(
				'IdConformidad' => $id,
				'Tipo' 			=> $this->input->post('accion_' . $i),
				'Accion' 		=> $this->input->post('descripcion_' . $i),
				'Responsable' 	=> $this->input->post('responsable_' . $i),
				'Fecha' 		=> $this->input->post('fecha_' . $i))
			;
		}

		// inserta las acciones
		if ( $this->db->insert_batch( 'pa_conformidades_acciones', $inserta ) ) {
			// actualiza el avance
			$actualiza = array(
				'EstadoAvance'  => $avance,
				'Estado' 		=> 1 // evidencias de la no conformidad atendida
			);
			if ( $this->db->where( 'IdConformidad', $id )->update( 'pa_conformidades', $actualiza ) ) {
				// inserta el auditor responsable
				$actualiza = array(
					'Auditor' => $this->input->post('auditor')
				);
				$resp = $this->db->where( 'IdConformidad', $id )->update( 'pa_conformidades_seguimiento', $actualiza );
			}
		}

		$this->db->trans_complete();
		return $resp;		
	}

		//
	// inserta_contencion( $id, $accionCont ): Inserta las acciones de contencion
	//
	function inserta_contencion( $id, $aCont, $evidencia ) {
		$condicion = array(
			'IdConformidad' => $id,
			'Acciones' 		=> $aCont,
			'Evidencia'		=> $evidencia, 
		);
		$this->db->insert('pa_conformidades_contencion', $condicion);		
	}


	//
	// inserta_evidencia( $id, $documento ): Inserta evidencia de la no conformidad
	//
	function inserta_evidencia( $id, $documento ) {
		$this->db->trans_start();
		$inserta = array(
			'IdConformidad' => $id,
			'Evidencia'		=> $documento,
		);
		
		// inserta la causa
		if ( $this->db->insert( 'pa_conformidades_evidencias', $inserta ) ) {
			//actualiza el avance
			$actualiza = array(
				'Estado' => '1'
			);
			$resp = $this->db->where( 'IdConformidad', $id )->update( 'pa_conformidades', $actualiza );
		}
		
		$this->db->trans_complete();
		return $resp;		
	}
	
	//
	// modifica_conformidad( $id ): Actualiza la información de la no conformidad en base a la id
	//
	function modifica_conformidad( $id ) {
		$actualiza = array(
			'IdArea' 			=> $this->input->post('area'),
			'IdDepartamento' 	=> $this->input->post('departamento'),
			'Fecha' 			=> $this->input->post('fecha'),
			'Origen' 			=> $this->input->post('origen'), 
			'Tipo' 				=> $this->input->post('tipo'), 
			'Descripcion' 		=> $this->input->post('descripcion'), );
					
		// realiza la actualizacion
		$this->db->where( 'pa_conformidades.IdConformidad', $id );
		$resp = $this->db->update('pa_conformidades', $actualiza );
		
		return $resp;
	}
	
	//
	// modifica_seguimiento( $id ): Actualiza la información del seguimiento de la no conformidad en base a la id
	//
	function modifica_seguimiento( $id ) {
		$this->db->trans_start();
	// actualiza el seguimiento
		$actualiza_seguimiento = array(
			'Causa' 	=> $this->input->post('causa'),
			'Auditor' 	=> $this->input->post('auditor')
		);
		$this->db->where( 'pa_conformidades_seguimiento.IdConformidad', $id ); 
		$resp = $this->db->update( 'pa_conformidades_seguimiento', $actualiza_seguimiento );
		
	// actualiz el diagrama
		if ($resp) {
			$diagrama = $this->db->get_where( 'pa_conformidades_diagrama', array( 'pa_conformidades_diagrama.IdConformidad' => $id ) );
			if ($diagrama -> num_rows() > 0) {
				$j = 1;
				foreach ($diagrama->result() as $row) {
					$actualiza_accion = array(
						'Categoria' => $this->input->post('categoria_diagrama_' . $j), 
						'Causa' 	=> $this->input->post('causa_diagrama_' . $j),
					);
					$j++;
					$this->db->where( 'pa_conformidades_diagrama.IdConformidadDiagrama', $row -> IdConformidadDiagrama );
					$resp = $this->db->update( 'pa_conformidades_diagrama', $actualiza_accion );
				}
			}
			
	// actualiza las acciones
			if ($resp) {
				$acciones = $this->db->get_where( 'pa_conformidades_acciones', array( 'pa_conformidades_acciones.IdConformidad' => $id ) ) ;
				if ($acciones -> num_rows() > 0) {
					$j = 1;
					foreach ($acciones->result() as $row) {
						$actualiza_accion = array('Fecha' => $this -> input -> post('fecha_accion_' . $j), 'Tipo' => $this -> input -> post('tipo_accion_' . $j), 'Accion' => $this -> input -> post('accion_accion_' . $j), 'Responsable' => $this -> input -> post('responsable_accion_' . $j), );
						$j++;
						$this->db->where( 'pa_conformidades_acciones.IdConformidadAcciones', $row->IdConformidadAcciones );
						$resp = $this->db->update( 'pa_conformidades_acciones', $actualiza_accion );
					}
				}
			}
	//actualiza la contencion
			if ($resp) {
				$contencion = $this->db->get_where( 'pa_conformidades_contencion', array( 'pa_conformidades_contencion.IdConformidad' => $id ) ) ;

				if ($contencion -> num_rows() > 0) {
					$j = 1;
					foreach ($contencion->result() as $row) {
						$actualiza_accion = array('Acciones' => $this -> input -> post('Acciones'), 'Evidencia' => $this -> input -> post('Evidencia'));
						$j++;
						$this->db->where( 'pa_conformidades_contencion.IdConformidad', $row->IdConformidad );
						$resp = $this->db->update( 'pa_conformidades_contencion', $actualiza_accion );
					}
				}
			}
		}
		$this->db->trans_complete();
		return $resp;
	}
	//
	// cierra_no_conformidades(): Cierra las no conformidades
	//
	function cierra_no_conformidades() {
		foreach ( $this->input->post('conformidad') as $lista ) {
			$resp = $this->db->where('pa_conformidades.IdConformidad', $lista)->update('pa_conformidades', array('Estado' => '2'));
		}
		
		return $resp;
	}
	
	//
	// elimina_pescado( $id ): Elimina un pescado de una no conformidad
	//
	function elimina_pescado( $id ) {
		$this->db->trans_start();
		$condicion = array(
			'IdConformidad' => $id,
		);
		$resp = $this->db->delete( 'pa_conformidades_diagrama', $condicion );
		
		if ($resp) {
			$actualiza = array(
				'EstadoAvance' => '0',
			);
			$resp = $this->db->where( $condicion )->update( 'pa_conformidades', $actualiza );
		}
		
		$this->db->trans_complete();
		return $resp;
	}
}
?>
