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

class Auditoria extends CI_Controller {
	
/** Atributos **/
	private $id;
	private $auditoria_nombre;

/** Propiedades **/
	public function set_id() { $this->id = $this->auditoria_model->get_auditoria_id(); }
	public function set_auditoria_nombre() { $this->auditoria_nombre = $this->auditoria_model->get_auditoria( $this->id ); }
	
/** Constructor **/
	function __construct() {
		parent::__construct();
		
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
	function index() {
		// variables necesarias para la página
		$datos['titulo'] = "Actividades de Auditor";
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene la lista de verificacion del usuario para esta auditoría
		$lista_verificacion = $this->auditoria_model->get_lista_verificacion( $this->id );
		$datos['lista_verificacion'] = $lista_verificacion; 
		
		$datos['hallazgos'] = false;
		$respuestas = $this->auditoria_model->get_respuestas_lista( $this->id, 'todos' );
		if( $respuestas->num_rows() > 0 ) {
			$datos['hallazgos'] = true;
		}
		
		// obtiene el nombre de la auditoría
		$datos['auditoria'] = $this->auditoria_nombre;
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'auditoria/inicio', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
	
	//
	// especifico(): Muestra el Programa Específico de Auditoría
	//
	function especifico() {
		// variables necesarias para la página
		$titulo = "Programa Espec&iacute;fico de Auditor&iacute;a";
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.'<br /><span style="font-size:22px">'.$this->auditoria_nombre.'</span>';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// obtiene información de la auditoria
		$auditoria = $this->auditoria_model->get_auditoria_info( $this->id );
		foreach( $auditoria->result() as $row ) {
			$datos['objetivo'] 	= $row->Objetivo;
			$datos['alcance'] 	= $row->Alcance;
			$datos['lider']		= $row->Lider;
		}
		
		// obtiene los equipos para esta auditoría
		$datos['equipos'] = $this->auditoria_model->get_equipos( $this->id );
		
		// obtiene la relacion los equipos y los procesos que van a auditar 
		$datos['equipos_procesos'] = $this->auditoria_model->get_equipos_procesos( $this->id );
		
		// obtiene los procesos para esta auditoría
		$datos['procesos'] = $this->auditoria_model->get_procesos_auditoria( $this->id );
		
		// obtiene las relaciones procesos-documentos para obtener las areas
		$datos['procesos_documentos'] = $this->auditoria_model->get_procesos_documentos( $this->id );
		
		// obtiene los auditores para esta auditoría
		$datos['auditores'] = $this->auditoria_model->get_auditores_equipo( $this->id );
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'auditoria/especifico', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// instructivos(): Revisa los instructivos de trabajo de los procesos a auditar
	//
	function instructivos() {
		// variables necesarias para la página
		$titulo = "Revisar Instructivos de Trabajo para la Auditor&iacute;a";
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.'<br /><span style="font-size:22px">'.$this->auditoria_nombre.'</span>';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// obtiene los instructivos para la auditoria para este usuario
		$datos['instructivos'] = $this->auditoria_model->get_instructivos( $this->id );
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'auditoria/instructivos', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
	
	//
	// lista_verificacion( $tipo ): Opciones de la Lista de Verificación
	//
	function lista_verificacion( $tipo ) {
		if( !$this->uri->segment(3) ) {
			redirect( 'inicio' );
		}

		switch( $tipo ) {
			case 'generar' :
				$this->lista_verificacion_generar();
				break;
				
			case 'revisar' :
				$this->lista_verificacion_revisar();
				break;
			
			case 'agregar' :
				$this->lista_verificacion_generar( 'agregar' );
				break;
				
			case 'documento' :
				$this->lista_verificacion_documento();
				break;
					
			default :
				redirect('inicio');
		}
	}

	//
	// lista_verificacion_generar(): Genera la Lista de Verificación
	//
	function lista_verificacion_generar() {
		$agregar = false;
		if( !$this->uri->segment(3) ) {
			redirect( 'inicio' );
		}
		if( $this->uri->segment(3) == 'agregar' ) {
			$agregar = true;
		}
		$datos['agregar'] = $agregar;
		
		// variables necesarias para la página
		$titulo = "Generar Lista de Verificaci&oacute;n";
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.'<br /><span style="font-size:22px">'.$this->auditoria_nombre.'</span>';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// obtiene la lista de verificación para elegir por parte del usuario
		$datos['lista'] = $this->auditoria_model->get_lista( $this->id );
		
		// estructura de la página (1)
		$this->load->view( '_estructura/header',$datos );
		
		if( $_POST ) {
			// envia mensaje de error si no se cumple con alguna regla
			if( !$this->input->post('lista') ){
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = "Debes de elegir al menos un punto de la lista";
				$this->load->view('mensajes/error',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->auditoria_model->inserta_lista_verificacion( $this->id ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Has creado tu Lista de Verificaci&oacute;n";
					if( $agregar ) {
						$datos['enlace'] = "auditoria/lista_verificacion/revisar";
					}
					else {
						$datos['enlace'] = "auditoria";
					}
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'auditoria/lista_verificacion_generar', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// lista_verificacion_revisar(): Revisa la Lista de Verificación
	//
	function lista_verificacion_revisar() {
		if( !$this->uri->segment(3) ) {
			redirect( 'inicio' );
		}		
		// variables necesarias para la página
		$titulo = "Revisar Lista de Verificaci&oacute;n";
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.'<br /><span style="font-size:22px">'.$this->auditoria_nombre.'</span>';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id_auditoria'] = $this->id; 
		
		// obtiene la lista de verificación del usuario para la auditoría
		$datos['lista'] = $this->auditoria_model->get_lista_usuario( $this->id );
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'mensajes/pregunta_oculta_usuario', $datos );
		$this->load->view( 'auditoria/lista_verificacion_revisar', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// respuestas_lista_verificacion(): Guarda las respuestas de la lista de verificación
	//
	function respuestas_lista_verificacion() {
		// variables necesarias para la página
		$titulo = "Guardar Respuestas de la Lista de Verificaci&oacute;n";
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.'<br /><span style="font-size:22px">'.$this->auditoria_nombre.'</span>';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// si es del SIGC obtiene los procesos del equipo del auditor
		if( $this->session->userdata( 'id_area') != 9 ) {
			$procesos = $this->auditoria_model->get_equipos_procesos_auditoria( $this->id );
			if( $procesos->num_rows() > 0 ) {
				$pro = array();
				foreach ( $procesos->result() as $row ) {
					$pro[ $row->IdProcesos ] = $row->Proceso;
				}
			}
		}
		// si es del SIBIB obtiene las bilbiotecas
		else {
			$bibliotecas = $this->auditoria_model->get_bibliotecas( $this->id );
			if( $bibliotecas->num_rows() > 0 ) {
				$pro = array();
				foreach ( $bibliotecas->result() as $row ) {
					$pro[ $row->IdBiblioteca ] = $row->Biblioteca;
				}
			}
		}
		$datos['procesos'] = $pro;
		$datos['elige_proceso'] = false;
		
		// estructura de la página (1)
		$this->load->view( '_estructura/header',$datos );
		if( $_POST ) {
			if( $this->input->post( 'procesos' ) ) {
				$datos['elige_proceso'] = true;
				// obtiene el nombre del proceso si es SIGC
				if( $this->session->userdata( 'id_area') != 9 ) {
					$proceso = $this->auditoria_model->get_proceso( $this->input->post('procesos') );				
					foreach( $proceso->result() as $row ) {
						$datos['proceso'] = $row->Proceso;
					}
				}
				// obtiene el nombre de la biblioteca si es SIBIB
				else {
					$biblioteca = $this->auditoria_model->get_biblioteca( $this->input->post('procesos') );				
					foreach( $biblioteca->result() as $row ) {
						$datos['proceso'] = $row->Biblioteca;
					}
				}

				// obtiene la lista de verificación del usuario para la auditoría para el procesos especificado
				$datos['lista'] = $this->auditoria_model->get_lista_usuario_proceso( $this->id, $this->input->post( 'procesos' ) );
				
				// obtiene las respuestas de ese usuario
				$datos['respuestas'] = $this->auditoria_model->get_respuestas_lista( $this->id, $this->input->post( 'procesos' ) );
				
				$datos['id_proceso'] = $this->input->post('procesos');
			}				
			else {				
				if( $this->auditoria_model->inserta_actualiza_respuestas( $this->id ) ) {
					// si el usuario guardo los datos
					if( $this->input->post('aceptar') ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "Las respuestas se han guardado correctamente<br />&iquest;Deseas permanecer en esta p&aacute;gina?";
						$datos['enlace_si'] = "auditoria/respuestas_lista_verificacion";
						$datos['enlace_no'] = "auditoria";
						$this->load->view('mensajes/pregunta_enlaces',$datos);
					}
					// si los datos se guardaron automaticamente
					else {
						redirect('auditoria/respuestas_lista_verificacion');
					}
					
				}
				else {
					$datos['mensaje_titulo'] = "Error";
					$datos['mensaje'] = "Ha ocurrido un error al guardar los datos";
					$this->load->view('mensajes/error',$datos);
				}
			}
		}		
		 		
		// estructura de la página (2)
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'auditoria/respuestas_lista_verificacion', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}
	
	//
	// hallazgos(): Listado de hallazgos de la auditoría
	//
	function hallazgos() {
		// variables necesarias para la página
		$titulo = "Listado de Hallazgos";
		$datos['titulo'] = $titulo;
		$datos['titulo_pagina'] = $titulo.'<br /><span style="font-size:22px">'.$this->auditoria_nombre.'</span>';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id_auditoria'] = $this->id;
		
		// si es del SIGC obtiene los procesos del equipo del auditor
		if( $this->session->userdata( 'id_area') != 9 ) {
			$procesos = $this->auditoria_model->get_equipos_procesos_auditoria( $this->id );
			if( $procesos->num_rows() > 0 ) {
				$pro = array();
				$pro[ 'todos' ] = ' - Todos los Procesos - ';
				foreach ( $procesos->result() as $row ) {
					$pro[ $row->IdProcesos ] = $row->Proceso;
				}
			}
		}
		// si es del SIBIB obtiene las bilbiotecas
		else {
			$bibliotecas = $this->auditoria_model->get_bibliotecas( $this->id );
			if( $bibliotecas->num_rows() > 0 ) {
				$pro = array();
				$pro[ 'todos' ] = ' - Todas las Bibliotecas - ';
				foreach ( $bibliotecas->result() as $row ) {
					$pro[ $row->IdBiblioteca ] = $row->Biblioteca;
				}
			}
		}
		$datos['procesos'] = $pro;
				
		// obtiene los hallazgos
		if( $_POST ) {
			$auditoria = $this->id;
			$proceso = $this->input->post( 'procesos' );
		}
		else {
			$auditoria = false;
			$proceso = 'todos';
		}
		$datos['proceso'] = $proceso;
		
		$datos['lista_verificacion'] = $this->auditoria_model->get_respuestas_lista( $this->id, $proceso );
		
		
		// estructura de la página
		$this->load->view( '_estructura/header',$datos );
		$this->load->view( '_estructura/top', $datos );
		$this->load->view( 'auditoria/hallazgos', $datos );
		$this->load->view( '_estructura/right', $datos );
		$this->load->view( '_estructura/footer' );
	}

	//
	// lista_verificacion_documento(): Genera el documento PDF de la lista de verificación
	//
	function lista_verificacion_documento() {
		// obtiene la lista de verificación del usuario
		$lista = $this->auditoria_model->get_lista_usuario( $this->id );
		$renglones = $lista->num_rows() + 8;				
						
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Lista de Verificación');
		
		// bordes de la pagina
		$this->excel->getActiveSheet()->getPageMargins()->setTop(0.5);
		$this->excel->getActiveSheet()->getPageMargins()->setRight(0.5);
		$this->excel->getActiveSheet()->getPageMargins()->setLeft(0.5);
		$this->excel->getActiveSheet()->getPageMargins()->setBottom(0.5);

		// Titulo: Lista de Verificación
		$this->excel->getActiveSheet()->setCellValue('A1', 'Lista de Verificación de Auditoría por Proceso R8.2.2.1,C');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:G1');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		// Información de la Lista de Verificación
		$this->excel->getActiveSheet()->getStyle('A2:D6')->getFont()->setSize(9);
		$this->excel->getActiveSheet()->getStyle('A2:A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->setCellValue('A2', 'Área Auditada:');
		$this->excel->getActiveSheet()->mergeCells('A2:B2');
		$this->excel->getActiveSheet()->setCellValue('A3', 'Responsable:');
		$this->excel->getActiveSheet()->mergeCells('A3:B3');
		$this->excel->getActiveSheet()->setCellValue('A4', 'Procesos Auditados:');
		$this->excel->getActiveSheet()->mergeCells('A4:B4');
		$this->excel->getActiveSheet()->setCellValue('A5', 'Auditor:');
		$this->excel->getActiveSheet()->mergeCells('A5:B5');
		$this->excel->getActiveSheet()->setCellValue('A6', 'Fecha:');
		$this->excel->getActiveSheet()->mergeCells('A6:B6');
		$this->excel->getActiveSheet()->setCellValue('C2', '________________________________________________________________');
		$this->excel->getActiveSheet()->mergeCells('C2:D2');
		$this->excel->getActiveSheet()->setCellValue('C3', '________________________________________________________________');
		$this->excel->getActiveSheet()->mergeCells('C3:D3');
		$this->excel->getActiveSheet()->setCellValue('C4', '________________________________________________________________');
		$this->excel->getActiveSheet()->mergeCells('C4:D4');
		$this->excel->getActiveSheet()->setCellValue('C5', $this->session->userdata('nombre'));
		$this->excel->getActiveSheet()->mergeCells('C5:D5');
		$this->excel->getActiveSheet()->setCellValue('C6', '____/____/________');
		$this->excel->getActiveSheet()->mergeCells('C6:D6');
		
		// Encabezados
		$this->excel->getActiveSheet()->getStyle('A8:G8')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('A8:G8')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A8:G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A8:G8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A8:G8')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getRowDimension('8')->setRowHeight(40);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(3.2);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(27);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(27);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(3.2);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(3.2);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(3.2);	
		$this->excel->getActiveSheet()->setCellValue('A8', 'Requisito ISO 9001:2008');
		$this->excel->getActiveSheet()->setCellValue('B8', '#');
		$this->excel->getActiveSheet()->setCellValue('C8', 'Cuestionamiento y/o Evidencia Solicitada');
		$this->excel->getActiveSheet()->setCellValue('D8', 'Observaciones y Descripción de las Evidencias mostradas para cada Cuestionamiento');
		$this->excel->getActiveSheet()->setCellValue('E8', 'C');
		$this->excel->getActiveSheet()->setCellValue('F8', 'NC');
		$this->excel->getActiveSheet()->setCellValue('G8', 'OM');
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getStyle('A8:G8')->applyFromArray(
		array('fill' 	=> array(
					'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
					'color'		=> array('argb' => 'CCCCCC')
				),
				'borders' => array(
					'allborders'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
				)
			)
		);
		$this->excel->getActiveSheet()->getStyle('A9:G'.$renglones)->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('A9:G'.$renglones)->getAlignment()->setIndent(10);
		$this->excel->getActiveSheet()->getStyle('A9:G'.$renglones)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A9:G'.$renglones)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A9:G'.$renglones)->applyFromArray(
		array('fill' 	=> array(
					'style'		=> PHPExcel_Style_Border::BORDER_THICK,
				),
				'borders' => array(
					'outline'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
					'inside'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
				)
			)
		);

		if( $lista->num_rows() > 0 ) {
			$i = 9;
			$j = 1;
			foreach( $lista->result() as $row ) {
				$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(60);
				
				// Requisitos
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $row->Requisito);
				$this->excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
				
				// No.
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $j);
				$this->excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);
				
				// Pregunta
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $row->Pregunta);
				$this->excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);
				
				$i++;
				$j++;
			}
		}
		
		//merge cell A1 until D1
		//$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='lista_verificacion.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
}