<?php 
/****************************************************************************************************
*
*	CONTROLLERS/itarh/inicio.php
*
*		Descripción:
*			Inicio del Sistema por medio de la aplicación de Recursos Humanos 
*
*		Fecha de Creación:
*			08/Octubre/2011
*
*		Ultima actualización:
*			08/Octubre/2011
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
		
		$this->load->model('itarh/inicio_itarh_model','',TRUE);
	}
	
/** Funciones **/
	//
	// index(): Pagina principal de la aplicación
	function index() {
		// validacion de las áreas que pueden acceder
		if ( $this->session->userdata('id_usuario') ) {
			if ( $this->session->userdata('id_area') != 1 && 
				 $this->session->userdata('id_area') != 4 && 
				 $this->session->userdata('id_area') != 5 && 
				 $this->session->userdata('id_area') != 10 &&
				 $this->session->userdata('id_area') != 11 
				) {
				redirect('inicio');
			}
			else {
				$datos['titulo'] = 'Bienvenido';
				$datos['menu'] = $this->inicio_itarh_model->get_menu( 'inicio' );
				$datos['barra'] = '<a href="'.base_url().'index.php/itarh/inicio">Inicio</a>';		
				
				// solicitudes pendientes
				$datos['solicitudes'] = $this->db->from('pa_solicitudes')->where(array('Estado' => '2'))->count_all_results();
				
				// mensajes de contacto pendientes
				$datos['contacto'] = $this->db->from('ef_contacto')->where(array('Estado' => '1'))->count_all_results();
				
				$this->load->view('_estructura/header',$datos);
				$this->load->view('itarh/_estructura/top',$datos);
				$this->load->view('itarh/_estructura/usuario',$datos);
				$this->load->view('itarh/inicio/principal',$datos);
				$this->load->view('itarh/_estructura/footer');
			}
		}
		else {
			redirect( 'itarh/inicio/login' );
		}
	}
	
	//
	// login(): Login para entrar a la aplicación
	//
	function login() {
		if ( $this->session->userdata('id_usuario') ) {
			if ( $this->session->userdata('id_area') == 1 && 
				 $this->session->userdata('id_area') == 4 && 
				 $this->session->userdata('id_area') == 5 && 
				 $this->session->userdata('id_area') == 10 && 
				 $this->session->userdata('id_area') == 11 
				) {
				redirect('itarh/inicio');
			}
			else {
				redirect('inicio');
			}
		}
		else {
			$datos['sesion'] = false;
			$datos['titulo'] = "IT.ARH.01";
			
			$this->load->view('_estructura/header',$datos);
			$this->load->view('itarh/_estructura/top',$datos);
			$this->load->view('itarh/inicio/login',$datos);
			$this->load->view('itarh/_estructura/footer');
			
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
				$this->db->like(array('Usuario' => $datos['usuario'],'Contrasena' => $datos['contrasena'],'Estado' => '1'));
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
					redirect('itarh/inicio');
				}
				else {
					$datos['mensaje_titulo'] = "Error de Login";
					$datos['mensaje'] = "Tu <strong>Usuario</strong> o <strong>Contrase&ntilde;a</strong> no son correctos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
	}
}