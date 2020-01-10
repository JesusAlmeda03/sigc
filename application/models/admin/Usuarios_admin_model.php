<?php 
/****************************************************************************************************
*
*	MODELS/admin/usuarios_admin_model.php
*
*		Descripción:  		  
*			Documentos del sistema 
*
*		Fecha de Creación:
*			13/Febrero/2012
*
*		Ultima actualización:
*			20/Septiembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/
class Usuarios_admin_model extends CI_Model {
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/			
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
/** Funciones **/
	//
	// get_areas(): Obtiene todas las áreas
	//
	function get_areas() {
		$this->db->order_by('Area');
		$consulta = $this->db->get( 'ab_areas' );
		
		return $consulta;
	}
		
	//
	// get_area( $id ): Obtiene los datos de un área
	//
	function get_area( $id ) {
		$condicion = array(
			'IdArea' => $id
		);
		$this->db->order_by('Area');
		$consulta = $this->db->get_where( 'ab_areas', $condicion, 1 );
		
		return $consulta;
	}
	
	//
	// get_usuario( $id ): Obtiene los datos de un usuario
	//
	function get_usuario( $id ) {
		$condicion = array(
			'IdUsuario' => $id
		);		
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion );
		
		return $consulta;
	}
	
	//
	// get_usuarios( $id ): Obtiene los usuarios en base a la id del área
	//
	function get_usuarios( $id ) {
		$condicion = array(
			'IdArea' => $id
		);		
		$this->db->order_by( 'Nombre' );
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion );
		
		return $consulta;
	}
	
	//
	// get_mandos( $id ): Obtiene los usuarios subordinados en base a la id del usuario jefe
	//
	function get_mandos( $id ) {
		$condicion = array(
			'ab_usuarios_mandos.IdUsuarioEvaluador' => $id,
			'ab_usuarios.Estado'			 		=> '1'
		);		
		
		$this->db->join( 'ab_usuarios', 'ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado' );
		$consulta = $this->db->get_where( 'ab_usuarios_mandos', $condicion );
		
		return $consulta;
	}
	
	//
	// get_usuarios_asignar( $id_area, $id_usuario ): Obtiene los usuarios en base a la id del área
	//
	function get_usuarios_asignar( $id_area, $id_usuario ) {
		$this->db->trans_start();
		// obtiene el área del usuario
		$consulta = $this->get_usuario( $id_usuario );
		foreach( $consulta->result() as $row ) {
			$id_area_usuario = $row->IdArea;
		}
		
		// si el área del usuario pertenece a el área con la que se esta trabajando
		if( $id_area == $id_area_usuario ) {
			$i = 0;
			$subordinados = array();
					
			$condicion = array(
				'ab_usuarios.IdArea' 		=> $id_area,
				'ab_usuarios.IdUsuario <>' 	=> $id_usuario,
				'ab_usuarios.Estado' 		=> '1'
			);
			
			// obtiene a los usuarios que ya estan asignados para no mostrarlos
			$this->db->join( 'ab_usuarios', 'ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado' );
			$subs = $this->db->get_where( 'ab_usuarios_mandos', $condicion );
			if( $subs->num_rows() > 0 ) {
				foreach( $subs->result() as $row ) {
					$subordinados[$i] = $row->IdUsuario;
					$i++;
				}
			}
			
			// obtiene a los usuarios jefes para no mostrarlos
			$condicion_jef = $condicion;
			$condicion_jef['ab_usuarios_permisos.Clave'] = 'JEF';
			$this->db->join( 'ab_usuarios', 'ab_usuarios.IdUsuario = ab_usuarios_permisos.IdUsuario' );
			$subs = $this->db->get_where( 'ab_usuarios_permisos', $condicion_jef );
			if( $subs->num_rows() > 0 ) {
				foreach( $subs->result() as $row ) {
					$subordinados[$i] = $row->IdUsuario;
					$i++;
				}
			}		
			$this->db->order_by( 'Nombre' );
			$this->db->where_not_in( 'IdUsuario', $subordinados);
			$consulta = $this->db->get_where( 'ab_usuarios', $condicion );
		}
		else {
			$consulta = '';
		}
		
		$this->db->trans_complete();
		return $consulta;
	}
	
	//
	// get_usuario_validar( $tipo, $id_usuario ): Valida que no exista un usuario igual
	//
	function get_usuario_validar( $tipo, $id_usuario ) {
		switch( $tipo ) {
		// Usuario
			case 'usuario' :
				$condicion = array(
					'Usuario' 		=> $this->input->post('usuario'),
					'IdUsuario <>'	=> $id_usuario,
				);
				$consulta = $this->db->get_where('ab_usuarios', $condicion);
				break;
		
		// Nombre Exacto
			case 'nombre' :
				$condicion = array(
					'Nombre' 		=> $this->input->post('nombre'), 
					'Paterno' 		=> $this->input->post('paterno'), 
					'Materno'		=> $this->input->post('materno'),
					'IdUsuario <>'	=> $id_usuario,
				);
				$consulta = $this->db->get_where('ab_usuarios', $condicion);
				break;
		}
		
		// regresa la respuesta
		if( $consulta->num_rows() > 0 ) {
			return true;
		}
		else {
			return false;
		}
	}
	
	//
	// get_busqueda(): Obtiene el resultado de una búsqueda de un usuario
	//
	function get_busqueda( $are, $nom, $pat, $mat, $usu ) {
		$busqueda = array(
			'Nombre'  => $nom,
			'Paterno' => $pat,
			'Materno' => $mat,
			'Usuario' => $usu
		);
		
		$condicion = array();
		$this->db->join('ab_areas','ab_areas.IdArea = ab_usuarios.IdArea');
		if( $are == 'todos' ) {
			$this->db->like( $busqueda );
		}
		else {
			$condicion['ab_usuarios.IdArea'] = $are;
			if( $nom != '' || $pat != '' || $mat != '' || $usu != '' ) {
				$this->db->like( $busqueda );
			}
		}
		$consulta = $this->db->get_where('ab_usuarios', $condicion );
		
		return $consulta;
	}
	
	// 
	// get_listado( $id_area, $estado ): Obtiene el listado de usuarios
	//
	function get_listado( $id_area, $estado ) {
		$this->db->join("ab_areas", "ab_areas.IdArea = ab_usuarios.IdArea");
		if( $id_area == "todos" ) {
			if( $estado == "todos" ) {
				$condicion = array();
			}
			else {
				$condicion = array(
					'ab_usuarios.Estado' => $estado
				);
			}
		}
		// muestra el listado del estado espec�fico
		else {
			if( $estado == "todos" ) {
				$condicion = array(
					'ab_usuarios.IdArea' => $id_area
				);			
			}
			else {
				$condicion = array(
					'ab_usuarios.IdArea' => $id_area,
					'ab_usuarios.Estado' => $estado
				);
			}
		}
		
		$consulta = $this->db->get_where('ab_usuarios', $condicion );
		
		return $consulta;
	}
	
	// 
	// get_expediente( $id ): Obtiene el expediente del usuario
	//
	function get_expediente( $id ) {
		$condicion = array(
			'ab_expediente.IdUsuario' => $id,
		);
		
		$this->db->order_by( 'Fecha', 'DESC' );
		$consulta = $this->db->get_where( 'ab_expediente', $condicion ); 
		
		return $consulta;
	}
	
	// 
	// get_permisos(): Obtiene todos los permisos
	//
	function get_permisos() {
		$condicion = array(
			'Permiso <>' => 'Permiso Nulo'
		);
		$consulta = $this->db->get_where( 'ab_permisos', $condicion );
		
		return $consulta;
	}
	
	//
	// get_especiales( $id_usuario, $id_area ): Obtiene el listado de usuarios especiales
	//
	function get_especiales( $id_usuario, $id_area ) {
		$this->db->join("ab_areas", "ab_areas.IdArea = ab_usuarios.IdArea");
		$this->db->join('ab_usuarios_permisos','ab_usuarios_permisos.IdUsuario = ab_usuarios.IdUsuario');
		// muestra todo el listado
		if( $id_usuario != 'todos' ) {
			$condicion = array(
				'ab_usuarios.IdUsuario' => $id_usuario
			);
		}
		else {
			if( $id_area == "todos" ) {
				$this->db->group_by('ab_usuarios.IdUsuario');
				$condicion = array();				
			}
			else {
				$condicion = array(
					'ab_usuarios.IdArea' => $id_area
				);
			}
		}
		
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion );
		
		return $consulta;
	}
	
	// 
	// get_permisos_usuario( $id ): Obtiene todos los permisos de un usuario
	//
	function get_permisos_usuario( $id ) {
		$condicion = array(
			'IdUsuario' => $id
		);
		$consulta = $this->db->get_where( 'ab_usuarios_permisos', $condicion );
		
		return $consulta;
	}
	
	//
	// get_especial( $are, $nom, $pat, $mat, $usu ): Obtiene un usuario especial
	//
	function get_especial( $are, $nom, $pat, $mat, $usu  ) {
		$busqueda = array(
			'Nombre'  => $nom,
			'Paterno' => $pat,
			'Materno' => $mat,
			'Usuario' => $usu
		);
		
		$this->db->select('ab_usuarios.IdUsuario,ab_usuarios.IdArea,ab_usuarios.Nombre,ab_usuarios.Paterno,ab_usuarios.Materno,ab_areas.Area,ab_usuarios_permisos.IdPermiso');
		$this->db->join('ab_areas','ab_areas.IdArea = ab_usuarios.IdArea');
		$this->db->join('ab_usuarios_permisos','ab_usuarios_permisos.IdUsuario = ab_usuarios.IdUsuario','left');
		$this->db->group_by('ab_usuarios.IdUsuario');
		$this->db->order_by('ab_usuarios.IdArea, ab_usuarios_permisos.IdPermiso');
		
		if( $are != "todos" ) {		
			$busqueda['ab_usuarios.IdArea'] = $are;
		}
		
		$consulta = $this->db->like( $busqueda )->get_where('ab_usuarios',array('Estado' => '1'));
		
		return $consulta;
	}
	
	//
	// inserta_usuario(): Inserta un nuevo usuario
	//
	function inserta_usuario() {
		// array para insertar en la bd
		$inserta = array(
		   'IdArea'			=> $this->input->post('area'),
		   'Nombre'			=> $this->input->post('nombre'),
		   'Paterno'		=> $this->input->post('paterno'),
		   'Materno'		=> $this->input->post('materno'),
		   'Correo'			=> $this->input->post('correo'),
		   'Usuario'		=> $this->input->post('usuario'),
		   'Contrasena'		=> $this->input->post('contrasena'),
		   'Estado'			=> '1', // usuario activo
		);
		
		// realiza la inserción
		$resp = $this->db->insert('ab_usuarios', $inserta); 
		
		return $resp;
	}

	//
	// inserta_permiso( $condicion ): Inserta un permiso para un usuario
	//
	function inserta_permiso( $condicion ) {
		// realiza la inserción
		$resp = $this->db->insert( 'ab_usuarios_permisos', $condicion ); 
		
		return $resp;
	}
	
	//
	// inserta_jerarquias( $id ): Inserta los usuarios a asignar para otro usuario
	//
	function inserta_jerarquias( $id ) {
		$i = 0;
		$inserta = array();				
		foreach( $this->input->post('usuario-sub') as $lista ) {
			$inserta[$i] = array(
			   'IdUsuarioEvaluador'	=> $id,
			   'IdUsuarioEvaluado'	=> $lista,
			);
			$i++;
		}
		$resp = $this->db->insert_batch('ab_usuarios_mandos', $inserta);

		return $resp;
	}

	//
	// quitar_permiso( $id_usuario, $id_permiso ): Quita un permiso para un usuario
	//
	function quitar_permiso( $id_usuario, $id_permiso ) {
		$condicion = array(
			'IdUsuario' => $id_usuario, 
			'IdPermiso' => $id_permiso 
		);
		
		// realiza la eliminacion
		$this->db->where( $condicion );
		$resp = $this->db->delete('ab_usuarios_permisos'); 
		
		return $resp;
	}	

	// 
	// modifica_usuario( $id ): Modifica los datos de un usuario
	//
	function modifica_usuario( $id ) {
		// realiza la actualizaci�n definitiva
		$actualiza = array(
			'IdArea'	=> $this->input->post('area'),
			'Nombre'	=> $this->input->post('nombre'),
			'Paterno'	=> $this->input->post('paterno'),
			'Materno'	=> $this->input->post('materno'),
			'Correo'	=> $this->input->post('correo'),
			'Usuario'	=> $this->input->post('usuario'),
		);
		
		if( $this->input->post('mod_contrasena') ) {
			$actualiza['Contrasena'] = $this->input->post('contrasena');
		}
		
		$this->db->where( 'IdUsuario', $id );
		$resp = $this->db->update( 'ab_usuarios', $actualiza );
				
		return $resp;
	}
}
?>
