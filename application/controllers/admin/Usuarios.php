<?php 
/****************************************************************************************************
*
*	CONTROLLERS/admin/usuarios.php
*
*		Descripción:
*			Controlador de las acciones del administrador sobre los usuarios
*
*		Fecha de Creación:
*			21/Octubre/2011
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

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	
/** Atributos **/
	private $menu;
	private $barra;

/** Propiedades **/
	public function set_menu() {
		$this->menu = $this->inicio_admin_model->get_menu( 'usuarios' );
	}
	
	public function get_barra( $enlaces ) {
		$this->barra = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';
		
		foreach( $enlaces as $enlace => $titulo ) {
			$this->barra .= '
				<img src="'.base_url().'includes/img/arrow_right.png"/>
				<a href="'.base_url().'index.php/admin/usuarios/'.$enlace.'">'.$titulo.'</a>
			';
		}
	}
		
/** Constructor **/	
	function __construct() {
		parent::__construct();
		
		// validacion de administrador
		if ( $this->session->userdata('id_usuario') ) {
			if ( !$this->session->userdata('admin') ) {
				redirect('admin/inicio/login');
			}
			else {
				$this->load->model('admin/inicio_admin_model','',TRUE);
				$this->load->model('admin/usuarios_admin_model','',TRUE);
				$this->set_menu();
			}
		}
		else {
			redirect( 'inicio' );
		}
	}

/** Funciones **/
	//
	// anadir(): A�adir usuarios
	//
	function anadir() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'A&ntilde;adir Usuario';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'anadir' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
			
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			// reglas de validaci�n
			$this->form_validation->set_rules('area', 'area', 'trim');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('paterno', 'Paterno', 'required|trim');
			$this->form_validation->set_rules('materno', 'materno', 'trim');
			$this->form_validation->set_rules('correo', 'Correo', 'trim');
			$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
			$this->form_validation->set_rules('contrasena', 'Contrase&ntilde;a', 'required|trim|md5');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			$this->form_validation->set_message('valid_email', 'Debes introducir una direccion de correo v&aacute;lida');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{
				// valida que no exista ya ese usuario
				if( $this->usuarios_admin_model->get_usuario_validar( 'usuario','' ) ) {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "El nombre del <strong>Usuario</strong> no esta disponible, debes elegir otro";
					$this->load->view('mensajes/ok',$datos);
				}
				else {
					// valida que no exista un usuario con ese nombre exacto
					if( $this->usuarios_admin_model->get_usuario_validar( 'nombre','' ) ) {
						$datos['mensaje_titulo'] = "Error";
						$datos['mensaje'] = "Ya existe un usuario con ese <strong>Nombre</strong> y esos <strong>Apellidos</strong>";
						$this->load->view('mensajes/ok',$datos);
					}
					else {
						if( $this->usuarios_admin_model->inserta_usuario() ) {
							// msj de �xito
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "El usuario se ha a&ntilde;adido correctamente.<br />&iquest;Deseas agregar otro?";
							$datos['enlace_si'] = "admin/usuarios/anadir";
							$datos['enlace_no'] = "admin/usuarios/listado/".$this->input->post('area')."/1";
							$this->load->view('mensajes/pregunta_enlaces',$datos);
						}
					}
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/anadir',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// buscar(): Busca usuarios
	//
	function buscar() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Buscar Usuario';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		$datos['busqueda'] = false;
		$datos['are'] = "";
		$datos['nom'] = "";
		$datos['pat'] = "";
		$datos['mat'] = "";
		$datos['usu'] = "";
		
		// genera la barra de dirección
		$this->get_barra( array( 'buscar' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			$datos['busqueda'] = true;			
			$datos['are'] = $this->input->post('area');
			$datos['nom'] = $this->input->post('nombre');
			$datos['pat'] = $this->input->post('paterno');
			$datos['mat'] = $this->input->post('materno');
			$datos['usu'] = $this->input->post('usuario');
			
			// realiza la búsqueda
			$datos['consulta'] = $this->usuarios_admin_model->get_busqueda( $datos['are'], $datos['nom'], $datos['pat'], $datos['mat'], $datos['usu'] );
		}
		else {
			$datos['busqueda'] = false;
		}

		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/buscar',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// listado(): Listado de usuarios
	//
	function listado() {
		// si los datos han sido enviados por post se sobre escribe la variable $are
		if( $_POST ) {
			$are = $this->input->post('area');
			$edo = $this->input->post('estado');
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$are = $this->uri->segment(4);
				$edo = $this->uri->segment(5);
			}
			else {
				$are = 'elige';
				$edo = '1';
			}
		}
		$datos['area'] = $are;
		$datos['estado'] = $edo;
		
		// obtiene todas las areas
		$areas = $this->usuarios_admin_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		$datos['estado_options'] = array(
			'todos' => ' - Todos - ', 
			'1' 	=> 'Activos', 
			'0' 	=> 'Inactivos' 
		);
		
		// obtiene el listado
		$datos['consulta'] = $this->usuarios_admin_model->get_listado( $are, $edo );
				
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Listado de Usuarios';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'listado' => $titulo ) );
		$datos['barra'] = $this->barra;
				
		// estructura de la pagina		
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/listado',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// especiales(): Listado de usuarios especiales
	//
	function especiales( $usu ) {
		// si los datos han sido enviados por post se sobre escribe la variable $are
		if( $_POST ) {
			$are = $this->input->post('area');
			$usu = 'todos';
		}
		else {
			if( $this->uri->segment(5) ) {
				$are = $this->uri->segment(5);
			}
			else {
				$are = 'elige';
			}
		}
		$datos['are'] = $are;
		$datos['usu'] = $usu;
		
		// obtiene todas las areas
		$areas = $this->usuarios_admin_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][''] = "";
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// obtiene todos los permisos
		$datos['permisos'] = $this->usuarios_admin_model->get_permisos();
		
		// se obtiene el listado
		$consulta_usuarios = $this->usuarios_admin_model->get_especiales( $usu, $are );
		
		$arreglo = false;
		if( $consulta_usuarios->num_rows() > 0 ) {
			$arreglo = array();
			foreach( $consulta_usuarios->result() as $row_u ) {
				$consulta_permisos = $this->usuarios_admin_model->get_permisos_usuario($row_u->IdUsuario );
				if( $consulta_permisos->num_rows() > 0 ) {
					$i = 1;
					foreach( $consulta_permisos->result() as $row_p ) {
						$nombre = $row_u->Nombre.' '.$row_u->Paterno.' '.$row_u->Materno;
						$arreglo[$nombre][$i] = array(
								'permiso'	=> $row_p->IdPermiso,
								'area'		=> $row_u->Area,
								'ida'		=> $are,
								'idu'		=> $row_u->IdUsuario,
						);
						$i++;
					}
				}
			}
		}
		$datos['consulta'] = $arreglo;
				
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Usuarios Especiales';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		
		// genera la barra de dirección
		$this->get_barra( array( 'especiales/todos' => $titulo ) );
		$datos['barra'] = $this->barra;		
				
		// estructura de la pagina		
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta');
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/especiales',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// anadir_especial(): Añade permisos a los usuarios
	//
	function anadir_especial() {
		// variables necesarias para la estructura de la página
		$titulo = 'Otorgar Permisos a Usuario';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$this->inicio_admin_model->set_sort( 20 );
		$datos['sort_tabla'] = $this->inicio_admin_model->get_sort();
		$datos['busqueda'] = false;
		$datos['are'] = "";
		$datos['nom'] = "";
		$datos['pat'] = "";
		$datos['mat'] = "";
		$datos['usu'] = "";
		
		// genera la barra de dirección
		$this->get_barra( array( 'anadir_especial' => $titulo ) );
		$datos['barra'] = $this->barra;
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options']['todos'] = " - Todas las &Aacute;reas - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// revisa si ya se a enviado el formulario por post	
		if( $_POST ){
			$datos['busqueda'] = true;			
			$datos['are'] = $this->input->post('area');
			$datos['nom'] = $this->input->post('nombre');
			$datos['pat'] = $this->input->post('paterno');
			$datos['mat'] = $this->input->post('materno');
			$datos['usu'] = $this->input->post('usuario');
			
			$datos['consulta'] = $this->usuarios_admin_model->get_especial( $datos['are'], $datos['nom'], $datos['pat'], $datos['mat'], $datos['usu'] ); 
		}
		else {
			$datos['busqueda'] = false;
		}

		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/anadir_especial',$datos);
		$this->load->view('admin/_estructura/footer');
	}
	
	//
	// jerarquias(): Asigna las jerarquias de los usuarios
	//
	function jerarquias() {
		// si los datos han sido enviados por post se sobre escribe la variable $are
		if( $_POST ) {
			$are = $this->input->post('area');
			if( $this->input->post( 'usuarios' ) ) {
				$usu = $this->input->post('usuarios');
			}
			else {
				$usu = 'elige';
			}
		}
		else {
			if( $this->uri->segment(4) || $this->uri->segment(5) ) {
				$are = $this->uri->segment(4);
				$usu = $this->uri->segment(5);
			}
			else {
				$are = 'elige';
				$usu = 'elige';
			}
		}
		$datos['area'] = $are;
		$datos['usuario'] = $usu;

		// variables necesarias para la estructura de la página
		$titulo = 'Asignar / Revisar Jerarquias';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'jerarquias' => $titulo ) );
		$datos['barra'] = $this->barra;		
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['areas'] = array();
			$datos['areas']['elige'] = ' - Elige un &Aacute;rea - ';
			foreach( $areas->result() as $row ) { 
				$datos['areas'][$row->IdArea] = $row->Area;
			}
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		if( $are != 'elige' ) {
			// obtiene los usuarios del área espcificada
			$usuarios = $this->usuarios_admin_model->get_usuarios( $are );
			if( $usuarios->num_rows() > 0 ) {
				$datos['usuarios'] = array();
				$datos['usuarios']['elige'] = ' - Elige un usuario - ';
				foreach( $usuarios->result() as $row ) { 
					$datos['usuarios'][$row->IdUsuario] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
				}
			}
			
			// si ya se eligio a un usuario del área busca a los usuarios asignados que tenga asignados
			if( $usu != 'elige' ) {				
				// subordinados ya asignados a este usuario
				$subordinados = $this->usuarios_admin_model->get_mandos( $usu );
				if( $subordinados->num_rows() > 0 ) {					
					$datos['subordinados'] = $subordinados;
				}
				else {
					$datos['subordinados'] = '';
				}
				
				// usuarios posibles a asignar
				$datos['usuarios_asignar'] = $this->usuarios_admin_model->get_usuarios_asignar( $are, $usu );
				
				// se guardan los usuarios seleccionados para ser asignados
				if( $this->input->post('aceptar') ) {
					$this->form_validation->set_rules('usuario-sub[]', 'los Usuarios a Asignar', 'required|trim');
					$this->form_validation->set_message('required', 'Debes elegir <strong>%s</strong>');
					
					// envia mensaje de error si no se cumple con alguna regla
					if( $this->form_validation->run() == FALSE ){
						$this->load->view('mensajes/error_validacion',$datos);
					}
					else {
						if( $this->usuarios_admin_model->inserta_jerarquias( $usu ) ) {
							$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
							$datos['mensaje'] = "La asignaci&oacute;n de los usuarios se ha guardado correctamente";
							$datos['enlace'] = "admin/usuarios/jerarquias/".$are."/".$usu;
							$this->load->view('mensajes/ok_redirec',$datos);
						}
					}
				}
			}
			else {
				$datos['subordinados'] = '';
				$datos['usuarios_asignar'] = '';
			}
		}
			
		// estructura de la página (2)		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('mensajes/pregunta_oculta',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/jerarquias',$datos);
		$this->load->view('admin/_estructura/footer');	
	}
	
	//
	// expediente( $idu, $uri ): Muestra el expediente de un usuario
	//
	function expediente( $idu, $uri ) {
		// variables necesarias para la estructura de la página
		$titulo = 'Expediente del Usuario';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		$datos['uri'] = str_replace('-','/',$uri);
		
		// modifica la url 
		$uri_old = str_replace('-','/',$uri);
		
		// genera la barra de dirección
		$enlaces = array(
			$uri_old 							=> 'Usuarios',
			'expediente/'.$idu.'/'.$uri  => $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		// obtiene los datos del usuario
		$usuario = $this->usuarios_admin_model->get_usuario( $idu );
		if( $usuario->num_rows() > 0 ) {
			foreach( $usuario->result() as $row ) {
				$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
				break;
			}
		}
		
		// obtiene el expediente del usuario
		$datos['usuario_expediente'] = $this->usuarios_admin_model->get_expediente( $idu );
				
		// estructura de la página
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/expediente',$datos);
		$this->load->view('admin/_estructura/footer');
	}

	//
	// sesion(): Muestra el formulario para elegir un �rea para iniciar sesi�n
	//
	function sesion() {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Iniciar Sesi&oacute;n por &Aacute;rea';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// genera la barra de dirección
		$this->get_barra( array( 'sesion' => $titulo ) );
		$datos['barra'] = $this->barra;		
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			foreach( $areas->result() as $row ) 
				$datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/sesion',$datos);
		$this->load->view('admin/_estructura/footer');	
	}
	
	//
	// sesion_usuario( $id_usuario ): Inicia sessión en el sistema como un usuario específico
	//
	function sesion_usuario( $id_usuario ) {
		$this->db->join( 'ab_areas', 'ab_areas.IdArea = ab_usuarios.IdArea' );
		$resp = $this->db->get_where( 'ab_usuarios', array('IdUsuario' => $id_usuario), 1 );
		if ( $resp->num_rows() > 0 ) {
			foreach ( $resp->result_array() as $row ) {
				$idu = $row['IdUsuario'];
				$ida = $row['IdArea'];
				$ids = $row['IdSistema'];
				$nom = $row['Nombre']." ".$row['Paterno']." ".$row['Materno'];
				$are = $row['Area'];						
			}
			// id del administrador actual, no del nuevo usuario
			$a_resp = $this->db->get_where('ab_administradores', array('IdUsuario' => $this->session->userdata('id_usuario')));
			if ( $a_resp->num_rows() > 0 )
				$admin = true;
			else
				$admin = false;
			
			$datos_sesion = array(
			   'id_usuario'	=> $idu,
			   'id_area'	=> $ida,
			   'id_sistema'	=> $ids,
			   'nombre'  	=> $nom,
			   'area' 	 	=> $are,
			   'admin'		=> $admin
			);
			// permisos del usuario
			$per = $this->db->get_where('ab_usuarios_permisos', array('IdUsuario' => $idu));
			if ( $per->num_rows() > 0 ) {
				foreach( $per->result() as $row ) :
					$datos_sesion[$row->Clave] = $row->Clave;
				endforeach;
			}
			$this->session->set_userdata($datos_sesion);
			redirect('inicio');
		}
	}

	//
	// asignar_permisos( $id_usuario, $id_permiso ): Asigna permisos a un usuario
	//
	function asignar_permisos( $id_usuario, $id_permiso ) {
		$usuario = 'todos';
		$area = 'elige';
		if( $this->uri->segment(6) ) {
			$usuario = $this->uri->segment(6); 
		}
		
		if( $this->uri->segment(7) ) {
			$area = $this->uri->segment(7); 
		}
		
		switch( $id_permiso ){
			case 0 : $clave = 'NULL'; break;
			case 1 : $clave = 'QUE'; break;
			case 2 : $clave = 'CON'; break;
			case 3 : $clave = 'SOL'; break;
			case 4 : $clave = 'IND'; break;
			case 5 : $clave = 'MIN'; break;
			case 6 : $clave = 'SAT'; break;
			case 7 : $clave = 'MAN'; break;
			case 8 : $clave = 'USU'; break;
			case 9 : $clave = 'JEF'; break;
			case 10 : $clave = 'ADI'; break;
			case 11 : $clave = 'AUD'; break;
			case 12 : $clave = 'CAP'; break;
			case 13 : $clave = 'RI'; break;
			case 14 : $clave = 'GR'; break;
		}
		$condicion = array(
		   'IdUsuario'	=> $id_usuario,
		   'IdPermiso'	=> $id_permiso,
		   'Clave'		=> $clave
		);
				
		if( $this->usuarios_admin_model->inserta_permiso( $condicion ) ) {
			if( $id_usuario == $this->session->userdata('id_usuario') )
				$this->session->set_userdata($clave,$clave);
			if( $usuario != '' && $area == 'elige' ) {
				redirect( 'admin/usuarios/especiales/'.$id_usuario );
			}
			elseif( $area != '' ) {
				redirect( 'admin/usuarios/especiales/todos/'.$area );
			}
			else {
				redirect( 'admin/usuarios/especiales/todos' );
			}
		}
	}
	
	//
	// quitar_permisos( $id_usuario, $id_permiso ): Quita permisos a un usuario
	//
	function quitar_permisos( $id_usuario, $id_permiso, $usuario, $area ) {
		switch( $id_permiso ){
			case 0 : $clave = 'NULL'; break;
			case 1 : $clave = 'QUE'; break;
			case 2 : $clave = 'CON'; break;
			case 3 : $clave = 'SOL'; break;
			case 4 : $clave = 'IND'; break;
			case 5 : $clave = 'MIN'; break;
			case 6 : $clave = 'SAT'; break;
			case 7 : $clave = 'MAN'; break;
			case 8 : $clave = 'USU'; break;
			case 9 : $clave = 'JEF'; break;
			case 10 : $clave = 'ADI'; break;
			case 11 : $clave = 'AUD'; break;
			case 12 : $clave = 'CAP'; break;
			case 13 : $clave = 'RI'; break;
			case 14 : $clave = 'GR'; break;
		}
		
		if( $this->usuarios_admin_model->quitar_permiso( $id_usuario, $id_permiso ) ) {
			if( $id_usuario == $this->session->userdata('id_usuario') )
				$this->session->unset_userdata($clave);
			if( $usuario == 'todos' ) {
				if( $area == 'todos') {
					redirect( 'admin/usuarios/especiales/todos' );
				}
				else {
					redirect( 'admin/usuarios/especiales/todos/'.$area );
				}
			}
			else {
				redirect( 'admin/usuarios/especiales/'.$id_usuario );
			}
		}
	}
	
	//
	// usuario_sesion(): Inicia sesión como usuario del área elegida
	//
	function usuario_sesion() {
		$ida = $this->input->post('area');
		
		// obtiene los datos del area
		$areas = $this->usuarios_admin_model->get_area( $ida );
		if( $areas->num_rows() > 0 ) {
			$datos_sesion = array('QUE' => 'QUE', 'CON' => 'CON', 'SOL' => 'SOL',	'IND' => 'IND',	'MIN' => 'MIN',	'SAT' => 'SAT',	'MAN' => 'MAN',	'USU' => 'USU',	'CAP' => 'CAP', 'RI' => 'RI', 'GR' => 'GR' );
			foreach( $areas->result() as $row ) :
				$datos_sesion['id_area'] 	= $row->IdArea;
				$datos_sesion['id_sistema']	= $row->IdSistema;				
				$datos_sesion['area'] 		= $row->Area;
			endforeach;
		}
		
		$this->session->unset_userdata('id_area');
		$this->session->unset_userdata('id_sistema');
		$this->session->unset_userdata('area');		
		$this->session->set_userdata($datos_sesion);
		redirect('inicio');
	}
				
	//
	// modificar_usuarios(): Modifica un usuario
	//
	function modificar_usuario( $idu, $uri ) {
		// variables necesarias para la estructura de la p�gina
		$titulo = 'Modificar Usuario';
		$datos['titulo'] = $titulo;
		$datos['menu'] = $this->menu;
		
		// modifica la url 
		$uri_old = str_replace('-','/',$uri);
		
		// genera la barra de dirección
		$enlaces = array(
			$uri_old 							=> 'Usuarios',
			'modificar_usuario/'.$idu.'/'.$uri  => $titulo
		);
		$this->get_barra( $enlaces );
		$datos['barra'] = $this->barra;

		// obtiene los datos del usuario
		$documento = $this->usuarios_admin_model->get_usuario( $idu );
		if( $documento->num_rows() > 0 ) {
			foreach( $documento->result() as $row ) :
				$datos['ida'] = $row->IdArea;
				$datos['nom'] = $row->Nombre;
				$datos['pat'] = $row->Paterno;
				$datos['mat'] = $row->Materno;
				$datos['cor'] = $row->Correo;
				$datos['usu'] = $row->Usuario;
				$datos['uri'] = str_replace('-','/',$uri);
			endforeach;			
		}
		
		// Areas
		$areas = $this->usuarios_admin_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}
		
		// estructura de la p�gina
		$this->load->view('_estructura/header',$datos);		
		$this->load->view('admin/_estructura/top',$datos);
		$this->load->view('admin/_estructura/usuario',$datos);
		$this->load->view('admin/usuarios/modificar',$datos);
		$this->load->view('admin/_estructura/footer');
		
		if( $_POST ){		
			// reglas de validaci�n
			$this->form_validation->set_rules('area', 'area', 'trim');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('paterno', 'Paterno', 'required|trim');
			$this->form_validation->set_rules('materno', 'Materno', 'trim');
			$this->form_validation->set_rules('correo', '', 'trim');
			$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
			if( $this->input->post('mod_contrasena') )
				$this->form_validation->set_rules('contrasena', 'Contrase&ntilde;a', 'required|trim|md5');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
			$this->form_validation->set_message('valid_email', 'Debes introducir una direccion de correo v&aacute;lida');
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserci�n a la base de datos si todo ha estado bien
			else{
				// valida que no exista ya ese usuario
				if( $this->usuarios_admin_model->get_usuario_validar( 'usuario', $idu ) ) {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "El nombre del <strong>Usuario</strong> no esta disponible, debes elegir otro";
					$this->load->view('mensajes/ok',$datos);
				}
				else {					
					if( $this->usuarios_admin_model->modifica_usuario( $idu ) ) {
						// msj de �xito
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La informaci&oacute;n del usuario se ha modificado correctamente";
						$uri = str_replace('-','/',$uri);
						$datos['enlace'] = 'admin/usuarios/'.$uri;
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}
	}	
}