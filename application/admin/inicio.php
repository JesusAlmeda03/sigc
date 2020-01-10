<?php 
/****************************************************************************************************
*
*	CONTROLLERS/admin/inicio.php
*
*		Descripción:
*			Inicio del Sistema de administrador - login 
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			09/Julio/2011
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {
	
/** Atributos **/

/** Propiedades **/
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
		$this->load->model('admin/inicio_admin_model','',TRUE);
	}
	
/** Funciones **/
	//
	// index(): Pagina principal del panel de administrador
	function index() {
		// validacion de administrador
		if ( $this->session->userdata('id_usuario') ) {
			if ( !$this->session->userdata('admin') ) {
				redirect('inicio');
			}
			else {
				$datos['titulo'] = 'Principal';
				$datos['menu'] = $this->inicio_admin_model->get_menu( 'inicio' );
				$datos['barra'] = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';		
				
				// solicitudes pendientes
				$datos['solicitudes'] = $this->db->from('pa_solicitudes')->where(array('Estado' => '2'))->count_all_results();
				
				// mensajes de contacto pendientes
				$datos['contacto'] = $this->db->from('ef_contacto')->where(array('Estado' => '1'))->count_all_results();
				
				$this->load->view('_estructura/header',$datos);
				$this->load->view('admin/_estructura/top',$datos);
				$this->load->view('admin/_estructura/usuario',$datos);
				$this->load->view('admin/inicio/principal',$datos);
				$this->load->view('admin/_estructura/footer');
			}
		}
		else {
			redirect( 'admin/inicio/login' );
		}
	}
		function manuales() {
		// validacion de administrador
		
				$datos['titulo'] = 'Manuales de Usuario';
				$datos['menu'] = $this->inicio_admin_model->get_menu( 'inicio' );
				$datos['barra'] = '<a href="'.base_url().'index.php/admin/inicio">Inicio</a>';		
				
				// solicitudes pendientes
				
				$this->load->view('_estructura/header',$datos);
				$this->load->view('admin/_estructura/top',$datos);
				$this->load->view('admin/_estructura/usuario',$datos);
				$this->load->view('admin/inicio/manuales',$datos);
				$this->load->view('admin/_estructura/footer');
			}
	
	//
	// login(): Login del panel de administrador
	//
	function login() {
		if ( $this->session->userdata('id_usuario') ) {
			if ( $this->session->userdata('admin') ) {
				redirect('admin/inicio');
			}
			else {
				redirect('inicio');
			}
		}
		else {
			$datos['sesion'] = false;
			$datos['titulo'] = "Panel de Administrador";
			
			$this->load->view('_estructura/header',$datos);
			$this->load->view('admin/_estructura/top',$datos);
			$this->load->view('admin/inicio/login',$datos);
			$this->load->view('admin/_estructura/footer');
			
			$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
			$this->form_validation->set_rules('contrasena', 'Contrasena', 'required|trim|md5');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');
	
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			else{
				$datos['usuario'] = $this->input->post('usuario');
				$datos['contrasena'] = $this->input->post('contrasena');
				
				$this->db->join('ab_areas', 'ab_usuarios.IdArea = ab_areas.IdArea');
				//$this->db->like(array('Usuario' => $datos['usuario'],'Contrasena' => $datos['contrasena'],'Estado' => '1'));
				$this->db->where( 'Usuario LIKE "'.$datos['usuario'].'" AND Contrasena LIKE "'.$datos['contrasena'].'" AND Estado LIKE "1"' );
				$resp = $this->db->get('ab_usuarios',1);
				if ( $resp->num_rows() > 0 ) {
					foreach ( $resp->result_array() as $row ) {
						$idu = $row['IdUsuario'];
						$ida = $row['IdArea'];
						$ids = $row['IdSistema'];
						$nom = $row['Nombre']." ".$row['Paterno']." ".$row['Materno'];
						$are = $row['Area'];						
					}
					// id del administrador
					$a_resp = $this->db->get_where('ab_administradores', array('IdUsuario' => $idu));
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
					redirect('admin/inicio');
				}
				else {
					$datos['mensaje_titulo'] = "Error de Login";
					$datos['mensaje'] = "Tu <strong>Usuario</strong> o <strong>Contrase&ntilde;a</strong> no son correctos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
	}

	//
	// cambiar_estado( $tipo, $id, $estado, $redirecciona ): Cambia el estado de un registro
	//
	function cambiar_estado( $tipo, $id, $estado, $redirecciona ) {
		// usuario administrador
		if ( !$this->session->userdata('admin') ) 
			redirect( 'admin/inicio' );
		
		// cambia el estado y redirecciona
		if( $this->inicio_admin_model->cambia_estado( $tipo, $id, $estado ) ) {
			$redirecciona = str_replace( "-", "/", $redirecciona );
			redirect( 'admin/'.$redirecciona );
		}
	}
}