<?php 
/****************************************************************************************************
*
*	CONTROLLERS/auditoria.php
*
*		Descripción:
*			Todo lo relacionado con el proceso de la Auditoría para el usuario 
*
*		Fecha de Creación:
*			31/Octubre/2012
*
*		Ultima actualización:
*			31/Octubre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correo extends CI_Controller {
	
/** Atributos **/
	private $id;
	private $auditoria_nombre;

/** Propiedades **/
	public function set_id() { $this->id = $this->auditoria_model->get_auditoria_id(); }
	public function set_auditoria_nombre() { $this->auditoria_nombre = $this->auditoria_model->get_auditoria( $this->id ); }
	
/** Constructor **/
	function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper('url');
		
		// si no se ha identificado correctamente o no es auditor
		if( !$this->session->userdata( 'id_usuario' ) || !$this->session->userdata('AUD') ) {
			redirect( 'inicio' );
		}
		else {
			// Modelo
			$this->load->model('auditoria_model','',TRUE);
			$this->set_id();
			$this->set_auditoria_nombre();
		}
    }

	/** Funciones **/	
	//
	// index(): Lista de opciones disponibles para los auditores
    //

    public function index(){
        $this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        $to = 'jesus.almeda@ujed.mx';//$this->input->post('to');
        $subject = 'prueba';
        
        $message = '<br><h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, iusto voluptatibus repellat maxime eligendi repudiandae sapiente sed ab quidem molestiae rem ducimus aperiam illo alias, nisi dolore facilis ad quasi.</h1></br>';

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
            show_error($this->email->print_debugger());
        }

    }
}

