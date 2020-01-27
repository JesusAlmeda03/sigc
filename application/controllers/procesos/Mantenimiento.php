<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/mantenimiento.php
*
*		Descripción:
*			Quejas del sistema 
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			21/Septiembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mantenimiento extends CI_Controller {
	
/** Atributos **/

/** Propiedades **/	
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
		// si no se ha identificado correctamente
		if( !$this->session->userdata( 'id_usuario' ) ) {
			redirect( 'inicio' );
		}
		else {
			// Modelo
			$this->load->model('procesos/mantenimiento_model','',TRUE);
		}
	}
	
/** Funciones **/
	//
	// index(): Realiza la programación del mantenimiento del equipo de cómputo
	//
	function index() {
		// variables necesarias para la página
		$datos['titulo'] = 'Mantenimiento de Equipo de C&oacute;mputo';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}
				
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		if( $_POST ) {
			// revisa si no se ha generado ya esta programación
			$consulta = $this->mantenimiento_model->get_programa();
			if( $consulta->num_rows > 0 ) {
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = 'Ya se ha generado el programa de mantenimiento de esta &aacute;rea, pero si lo deseas puedes modificar los datos';
				$datos['enlace'] = 'listados/mantenimiento';
				$this->load->view('mensajes/ok_redirec',$datos);
			}
			// Inserta
			else {
				$resp = $this->mantenimiento_model->inserta_programa();
				if( $resp ) {
					redirect('procesos/mantenimiento/documento/'.$resp );
				}			
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = 'Ha ocurrido un error al tratar de generar el programa de mantenimiento';
					$this->load->view('mensajes/ok',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/mantenimiento/inicio',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

//agrega evidencia del mantenimiento
function evidencia() {
		// regresa si no trae las variables
		// variables necesarias para la página
		$datos['titulo'] = 'Agregar Evidencias de Mantenimiento';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		$areas = $this->Inicio_model->get_areas();
		if ($areas -> num_rows() > 0) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach ($areas->result() as $row)
				$datos['area_options'][$row -> IdArea] = $row -> Area;
		}
		
		if( $_POST ){		
			// configuración del archivos a subir
			$nom_doc =substr(md5(uniqid(rand())),0,6);
			$config['file_name'] = $nom_doc;
			$config['upload_path'] = './includes/evidencias/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '0';
	
			$this->load->library('upload', $config);
	
			if ( !$this->upload->do_upload('archivo') ) {
				// msj de error
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = $this->upload->display_errors();
				$this->load->view('mensajes/error',$datos);
			}else{			
				$upload_data = $this->upload->data();
				$nom_doc = $nom_doc.$upload_data['file_ext'];
					
				$area=$this->input->post('area');
				$periodo=$this->input->post('periodo');
				$ano=$this->input->post('ano');
				// se guarda el documento
				if( $this->mantenimiento_model->inserta_evidencia_mtto( $area,$periodo,$ano, $nom_doc) ) {
				
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "El archivo se ha guardado correctamente<br />¿deseas agregar ?";
					$this->load->view('mensajes/pregunta_enlaces',$datos);
					
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/mantenimiento/evidencia',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// documento( $idp ): Documento del listado de un programa de mantenimiento
	//
	function documento( $idp ) {
				
		// obtiene la información del programa
		$programa = $this->mantenimiento_model->get_programa_informacion( $idp );
		if ( $programa -> num_rows() > 0 ) {
			foreach ( $programa->result() as $row ) {
				$periodo	= $row->Periodo.' '.$row->Ano;
				$fecha 		= $row->Fecha;
				$ida 		= $row->IdArea;
				$area 		= $row->Area;
				$usuario 	= $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
			}
		}
		$equipo = $this->mantenimiento_model->get_equipo( $ida );
				
		$this->load->library('fpdf');
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));
		            
		$this->load->library('fpdf');
		            
		// Inicia el pdf
		$pdf = new FPDF('L','mm','A4');
				
		// Genera el pdf
		$pdf->AddPage();
		$pdf->SetFont("Arial","",12);
				
    // Datos de la No Conformidad
    	$pdf->SetLineWidth(.1);
    	$pdf->SetFillColor(198,34,35);
    	$pdf->SetTextColor(255);
		$pdf->SetFont("Arial","B",14);
		$pdf->Cell(0,10,utf8_decode('Programa de Mantenimiento de Equipo de Cómputo'),1,0,'C',true);		
		$pdf->Ln();
		$pdf->Ln(1);
		$pdf->SetFillColor(250,250,251);
		$pdf->SetTextColor(0);
		
    	// area
    	$pdf->SetFont("Arial","B",12);    	
    	$pdf->Cell(0,6,utf8_decode('Área'),1,0,'L',true);
		$pdf->Ln();	
		$pdf->SetFont("Arial","",12);
		$pdf->WriteHTML(utf8_decode($area));
		$pdf->Ln();
		
    	// usuario
		$pdf->Ln();
    	$pdf->SetFont("Arial","B",12);    	
    	$pdf->Cell(0,6,'Responsable del Mantenimiento',1,0,'L',true);
		$pdf->Ln();	
		$pdf->SetFont("Arial","",12);
		$pdf->WriteHTML(utf8_decode($usuario));
		$pdf->Ln();
		
    	// periodo
		$pdf->Ln();
    	$pdf->SetFont("Arial","B",12);    	
    	$pdf->Cell(0,6,'Periodo',1,0,'L',true);
		$pdf->Ln();	
		$pdf->SetFont("Arial","",12);
		$pdf->WriteHTML(utf8_decode($periodo));
		$pdf->Ln();		
			
    	// fecha
		$pdf->Ln();
    	$pdf->SetFont("Arial","B",12);    	
    	$pdf->Cell(0,6,'Fecha',1,0,'L',true);
		$pdf->Ln();	
		$pdf->SetFont("Arial","",12);
		$pdf->WriteHTML(utf8_decode($fecha));
		$pdf->Ln();	
		$pdf->Ln();	
		
		// Cabecera
		$pdf->SetFillColor(198,34,35);
    	$pdf->SetTextColor(255);
		$pdf->SetFont("Arial","B",12);
		$pdf->Cell(47.5,7,'Equipo',1,0,'C',true);
		$pdf->Cell(95.5,7,'Responsable',1,0,'C',true);
		$pdf->Cell(95.5,7,'Departamento',1,0,'C',true);			
		$pdf->Cell(37.5,7,'Firma',1,0,'C',true);					
		$pdf->Ln();
		
		// Equipo
		$pdf->SetFont("Arial","",9); 
		$pdf->SetFillColor(250,250,251);
		$pdf->SetTextColor(0);
		if ( $equipo -> num_rows() > 0 ) {
			foreach ( $equipo->result() as $row ) {
				$pdf->Cell(47.5,6,utf8_decode($row->Equipo),1);
				$pdf->Cell(95.5,6,utf8_decode($row->Responsable),1);
				$pdf->Cell(95.5,6,utf8_decode($row->Departamento),1);
				$pdf->Cell(37.5,6,'',1);
				$pdf->Ln();
			}
		}
		$pdf->Output();
		
	}

	function ver(){
		$datos['titulo'] = 'Ver Evidencias de Mantenimiento';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		$area=$this->session->userdata('id_area');
		$datos['evidencia'] = $this->mantenimiento_model->ver_evidencia($area);
		
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/mantenimiento/ver',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
}
