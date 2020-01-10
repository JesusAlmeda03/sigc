<?php
/****************************************************************************************************
*
*	CONTROLLERS/procesos/quejas.php
*
*		Descripción:
*			Quejas del sistema
*
*		Fecha de Creación:
*			03/Octubre/2011
*
*		Ultima actualización:
*			14/Noviembre/2012
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quejas extends CI_Controller {

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
			$this->load->model('procesos/quejas_model','',TRUE);
		}
	}

/** Funciones **/
	//
	// index(): Levantar la queja
	//
	function index() {
		// variables necesarias para la página
		$datos['titulo'] = 'Quejas';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);

		// revisa si ya se a enviado el formulario por post
		if( $_POST ){
			// obtiene todos los departamentos
			$datos['departamentos'] = $this->Inicio_model->get_departamentos( $this->input->post( 'area' ) );

			// reglas de validación
			$this->form_validation->set_rules('area', 'area', 'trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('nombre_queja', 'nombre', 'trim');
			$this->form_validation->set_rules('correo', 'Correo', 'required|trim');
			$this->form_validation->set_rules('telefono', 'telefono', 'trim');
			$this->form_validation->set_rules('queja', 'Queja y/o Sugerencia', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				// valida el departamento
				if( !$this->input->post('departamento') ) {
					// msj de error
					$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
					$datos['mensaje'] = "Has olvidado elegir el departamento del &Aacute;rea ";
					$this->load->view('mensajes/error',$datos);
				}
				else {
					if( $this->quejas_model->inserta_queja() ) {
						// msj de éxito
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "Tu queja se ha levantado correctamente";
						$datos['enlace'] = "inicio";
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/quejas/levantar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// seguimiento( $id ): Seguimiento de la queja
	//
	function seguimiento( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "listados/quejas/pendientes" );
		}

		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(5) ) {
			$datos['estado'] = $this->uri->segment(5);
		}
		else {
			$datos['estado'] = '';
		}

		// variables necesarias para la página
		$datos['titulo'] = 'Seguimiento de Queja';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene los datos de la queja
		$queja = $this->quejas_model->get_queja( $id );
		if( $queja->num_rows() > 0 ) {
			foreach( $queja->result() as $row ) :
				$datos['are'] = $row->Area;
				$datos['dep'] = $row->Departamento;
				$datos['nom'] = $row->Nombre;
				$datos['fec'] = $row->FechaS;
				$datos['cor'] = $row->Correo;
				$datos['tel'] = $row->Telefono;
				$datos['que'] = $row->Queja;
			endforeach;
		}
		else {
			redirect( "listados/quejas/pendientes" );
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/quejas/seguimiento',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');

		// revisa si ya se a enviado el formulario por post
		if( $_POST ){
			// reglas de validación
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('responsable', 'Responsable', 'required|trim');
			$this->form_validation->set_rules('descripcion', 'Descripcion', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->quejas_model->inserta_seguimiento( $id ) ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Los datos del seguimiento de han guardado correctamente";
					$datos['enlace'] = "listados/quejas";
					$this->load->view('mensajes/ok_redirec',$datos);
				}
			}
		}
	}

	//
	// ver( $id ): Muestra la información de la queja
	//
	function ver( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "listados/quejas/pendientes" );
		}

		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(5) ) {
			$datos['estado'] = $this->uri->segment(5);
		}
		else {
			$datos['estado'] = '';
		}

		// variables necesarias para la página
		$datos['titulo'] = 'Queja ';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene los datos de la queja
		$queja = $this->quejas_model->get_queja( $id );
		if( $queja->num_rows() > 0 ) {
			foreach( $queja->result() as $row ) :
				$tipo = $row->Estado;
				$datos['idq'] = $row->IdQueja;
				$datos['are'] = $row->Area;
				$datos['dep'] = $row->Departamento;
				$datos['nom'] = $row->Nombre;
				$datos['fec'] = $this->Inicio_model->set_fecha( $row->Fecha );
				$datos['cor'] = $row->Correo;
				$datos['tel'] = $row->Telefono;
				$datos['que'] = $row->Queja;
			endforeach;
		}
		else {
			redirect( "listados/quejas/pendientes" );
		}

		// Obtiene la info segun el tipo de queja
		switch( $tipo ) {
			// pendiente
			case 0 :
				$datos['tipo'] = false;
				redirect('_estructura/error_404');
				break;

			// terminada
			case 1 :
				$datos['seguimiento'] = true;
				$datos['tipo_title'] = "Resuelta";
				$datos['titulo'] .= $datos['tipo_title'];
				$queja = $this->quejas_model->get_seguimiento( $id );
				if( $queja->num_rows() > 0 ) {
					foreach( $queja->result() as $row ) :
						$datos['res'] 		= $row->Responsable;
						$datos['des'] 		= $row->Descripcion;
						$datos['obs'] 		= $row->Observacion;
						$datos['fec_seg'] 	= $this->Inicio_model->set_fecha( $row->FechaS );
					endforeach;
				}
				break;

			// eliminada
			case 2 :
				$datos['tipo_title'] = "Eliminada";
				$datos['titulo'] .= $datos['tipo_title'];
				$queja = $this->quejas_model->get_seguimiento( $id );
				if( $queja->num_rows() > 0 ) {
					$datos['seguimiento'] = true;
					foreach( $queja->result() as $row ) :
						$datos['res'] = $row->Responsable;
						$datos['des'] = $row->Descripcion;
						$datos['obs'] = $row->Observacion;
						$datos['fec_seg'] 	= $this->Inicio_model->set_fecha( $row->Fecha );
					endforeach;
				}
				else {
					$datos['seguimiento'] = false;
				}
				break;
		}

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/quejas/ver',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// modificar( $ide ): Modifica la queja
	//
	function modificar( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "listados/quejas/terminadas" );
		}

		// obtiene las variables para mostrar el listado específico
		if( $this->uri->segment(5) ) {
			$datos['estado'] = $this->uri->segment(5);
		}
		else {
			$datos['estado'] = '';
		}

		// variables necesarias para la página
		$datos['titulo'] = 'Modificar Queja ';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();

		// obtiene todas las areas excepto la de invitado
		$areas = $this->Inicio_model->get_areas();
		if( $areas->num_rows() > 0 ) {
			$datos['area_options'] = array();
			$datos['area_options'][0] = " - Elige un &Aacute;rea - ";
			foreach( $areas->result() as $row ) $datos['area_options'][$row->IdArea] = $row->Area;
		}

		// obtiene los datos de la queja
		$queja = $this->quejas_model->get_queja( $id );
		if( $queja->num_rows() > 0 ) {
			foreach( $queja->result() as $row ) :
				$datos['ida'] = $row->IdArea;
				$datos['idd'] = $row->IdDepartamento;
				$datos['nom'] = $row->Nombre;
				$datos['fec'] = $row->Fecha;
				$datos['cor'] = $row->Correo;
				$datos['tel'] = $row->Telefono;
				$datos['que'] = $row->Queja;
				$datos['edo'] = $row->Estado;
			endforeach;
		}
		else {
			redirect( "listados/quejas/terminadas" );
		}

		// obtiene los datos del seguimiento(si es que tiene)
		$queja_seguimiento = $this->quejas_model->get_seguimiento( $id );
		if( $queja_seguimiento->num_rows() > 0 ) {
			$datos['edo'] = true;
			foreach( $queja_seguimiento->result() as $row ) {
				$datos['res'] = $row->Responsable;
				$datos['des'] = $row->Descripcion;
				$datos['fes'] = $row->Fecha;
				$datos['obs'] = $row->Observacion;
			}
		}
		else {
			$datos['edo'] = false;
			$datos['res'] = '';
			$datos['des'] = '';
			$datos['fes'] = '';
			$datos['obs'] = '';
		}

		// obtiene todos los departamentos
		$departamentos = $this->Inicio_model->get_departamentos( $datos['ida'] );
		if( $departamentos->num_rows() > 0 ) {
			$datos['departamento_options'] = array();
			$datos['departamento_options'][0] = " - Elige un &Aacute;rea - ";
			foreach( $departamentos->result() as $row ) {
				$datos['departamento_options'][$row->IdDepartamento] = $row->Departamento;
			}
		}

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);

		// revisa si ya se a enviado el formulario por post
		if( $_POST ){
			// reglas de validación
			$this->form_validation->set_rules('area', 'area', 'trim');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
			$this->form_validation->set_rules('nombre', 'nombre', 'trim');
			$this->form_validation->set_rules('correo', 'Correo', 'required|trim');
			$this->form_validation->set_rules('telefono', 'telefono', 'trim');
			$this->form_validation->set_rules('queja', 'Queja y/o Sugerencia', 'required|trim');
			// si hay seguimiento
			if( $datos['edo'] ) {
				$this->form_validation->set_rules('fecha_seguimiento', 'Fecha', 'required|trim');
				$this->form_validation->set_rules('responsable', 'Responsable', 'required|trim');
				$this->form_validation->set_rules('descripcion', 'Descripci&oacute;n', 'required|trim');
			}
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');

			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la actualizacion si todo ha estado bien
			else{
				// valida el departamento
				if( !$this->input->post('departamento') ) {
					// msj de error
					$datos['mensaje_titulo'] = "Error de Validaci&oacute;n";
					$datos['mensaje'] = "Has olvidado elegir el departamento del &Aacute;rea ";
					$this->load->view('mensajes/error',$datos);
				}
				else {
					if( $this->quejas_model->modifica_queja( $id, $datos['edo'] ) ) {
						$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
						$datos['mensaje'] = "La queja se ha modificado correctamente";
						$datos['enlace'] = 'listados/quejas/all/0';
						$this->load->view('mensajes/ok_redirec',$datos);
					}
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/quejas/modificar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}







	function nuevo_doc($idc){
		$i = 0;
		$html = 0;
		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Scalidad');
		$pdf->SetTitle('No Conformidad '.$idc);
		$pdf->SetSubject('Tutorial TCPDF');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config

				$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));

		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//relación utilizada para ajustar la conversión de los píxeles

				//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			//  $pdf->Image('./includes/logo.png', 15, 140, 75, 113, 'PNG');
				//$html= '<img src="http://localhost/control/includes/logo.png"></h1></br>';

				$prov = "Adios";
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
				$pdf->setFontSubsetting(true);

		// Establecer el tipo de letra

		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
				$pdf->SetFont('Helvetica', '', 14, '', true);

		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
				$pdf->AddPage();
				$html = '
					<table border="0" style="width:100%;">
						<tr>
							<td style="width: 10%; text-align: center;">
							<br>
								<img src="includes/img/sigc.png" style="margin-top: 10px; display: block;">
							</td>
							<td style="background: #003A66; width: 90%; margin: 10px; text-align: center;">
								<h2 style="display: block; margin-top: 300px; background: #002A66; ">Sistema de Gestión de Calidad</h2>
							</td>

						</tr>
					</table>
					<br>
						';

				$html.= '
						<table border="1" style="width: 100%;">
							<tr>
							<td style="background: #003A66; width: 100%; margin: 10px; text-align: center;">
								<h2 style="display: block; margin-top: 300px; background: #002A66; ">Datos de la Queja</h2>
							</td>
							</tr>
						</table>
					';


					// Imprimimos el texto con writeHTMLCell()
					$pdf->writeHTMLCell($w = 0, $h = 0, $x = '10', $y = '5', $html, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = false);

					// ---------------------------------------------------------
					// Cerrar el documento PDF y preparamos la salida
					// Este método tiene varias opciones, consulte la documentación para más información.
					$nombre_archivo = utf8_decode("NoConfromidad ".$prov.".pdf");
					$pdf->Output($nombre_archivo, 'I');
	}

	/**8**/
	//
	// documento(): Muestra la queja en pdf
	//
	function documento( $idq ) {
        $this->load->library('pdf');

	// Documento ---------------------------------------------------------
		// crea el documento
		$this->pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// informacion del documento
		$this->pdf->SetCreator('SIGC2.0');
		$this->pdf->SetAuthor('ISC Rogelio Casta�eda Andrade');
		$this->pdf->SetTitle('Documento de la Queja');
		$this->pdf->SetSubject('Queja No');

		// header
		//$this->pdf->SetHeaderData('includes/img/logo.jpg', '40', 'Sistema Integral de Gestion de Calidad UJED', 'Queja');

		// fuentes del header y el footer
		$this->pdf->setHeaderFont(Array('Helvetica', '', 18));
		$this->pdf->setFooterFont(Array('Helvetica', '', 11));

		// margenes
		$this->pdf->SetMargins(5, 50, 5);
		$this->pdf->SetHeaderMargin(0);
		$this->pdf->SetFooterMargin(10);

		// saltos de pagina automaticos
		$this->pdf->SetAutoPageBreak(TRUE, 10);

		/*
		// lenguaje
		$this->pdf->setLanguageArray($l);
		*/

	// Contenido ---------------------------------------------------------
		// agrega la pagina
		$this->pdf->AddPage();

		// obtiene los datos del segumiento
		$quejaSeguimiento = $this->quejas_model->get_seguimiento( $idq );
		if( $quejaSeguimiento->num_rows() > 0 ) {
			foreach( $quejaSeguimiento->result() as $row ) {
					/*$tipo = $row->Estado;
					$are = $row->Area;
					$dep = $row->Departamento;
					$nom = $row->Nombre;*/
					$fecha = $row->FechaS;
					$observacion = $row->Observacion;
					$responsable = $row->Responsable;
					$desSeguimiento = $row->Descripcion;
			}
		}
		// obtiene los datos de la queja
		$queja = $this->quejas_model->get_queja( $idq );
		if( $queja->num_rows() > 0 ) {
			foreach( $queja->result() as $row ) :
				switch( substr($row->Fecha,5,2) ) {
					case "01" : $mes = "Enero"; break;
					case "02" : $mes = "Febrero"; break;
					case "03" : $mes = "Marzo"; break;
					case "04" : $mes = "Abril"; break;
					case "05" : $mes = "Mayo"; break;
					case "06" : $mes = "Junio"; break;
					case "07" : $mes = "Julio"; break;
					case "08" : $mes = "Agosto"; break;
					case "09" : $mes = "Septiembre"; break;
					case "10" : $mes = "Octubre"; break;
					case "11" : $mes = "Noviembre"; break;
					case "12" : $mes = "Diciembre"; break;
				}
				$tipo = $row->Estado;
				$are = $row->Area;
				$dep = $row->Departamento;
				$nom = $row->Nombre;
				$fec = substr($row->Fecha,8,2)." / ".$mes." / ".substr($row->Fecha,0,4);
				$cor = $row->Correo;
				$tel = $row->Telefono;
				$que = $row->Queja;
				$descripcion = $row->Queja;
			endforeach;
		}
		$this->pdf->SetY(30);

		// Datos de la queja
	    $this->pdf->SetFont('Helvetica','B',14);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetFillColor(198,34,35);
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->SetX(10);
		$this->pdf->Cell(195,10,'Datos de la queja',1,1,'C',true,'','','','','C');
		$this->pdf->SetX(10);

		// Area
		$this->pdf->Ln(1,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Area',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$are,1,0,'L',true);

		// Departamento
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Departamento',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$dep,1,0,'L',true);

		// Nombre
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Nombre',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$nom,1,0,'L',true);

		// Fecha
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Fecha',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$fec,1,0,'L',true);

		// Correo
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Correo',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$cor,1,0,'L',true);

		// Telefono
		$this->pdf->Ln(11,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Telefono',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$tel,1,0,'L',true);

		// Queja
		$this->pdf->Ln(11,true);
	   	$this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(195,10,'Queja',1,0,'C',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Ln(11,true);
		$queja = utf8_decode(strip_tags(nl2br($que)));
		$this->pdf->WriteHTMLCell(195, '', 10, 120, $queja, 1, 1, 1, false, 'l', true);
		$this->pdf->AddPage();
		$this->pdf->SetY(30);

		// Datos del Seguimiento
	    $this->pdf->SetFont('Helvetica','B',14);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetFillColor(198,34,35);
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->SetX(10);
		$this->pdf->Cell(195,10,'Datos del Seguimiento',1,1,'C',true,'','','','','C');
		$this->pdf->SetX(10);

		// Responsable
		$this->pdf->Ln(1,true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Responsable',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$responsable,1,0,'L',true);

		// Descripcion
		$this->pdf->Ln(11, true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Descripcion',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$desSeguimiento,1,0,'L',true);

		// Fecha
		$this->pdf->Ln(11, true);
	    $this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(34,10,'Fecha',1,0,'R',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Cell(160,10,$fecha,1,0,'L',true);

		// Observacion
		$this->pdf->Ln(11,true);
	   	$this->pdf->SetFont('Helvetica','B',12);
		$this->pdf->SetFillColor(238,238,238);
		$this->pdf->SetDrawColor(204,204,204);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetX(10);
		$this->pdf->Cell(195,10,'Observacion',1,0,'C',true);
		$this->pdf->SetFillColor(255,255,255);
		$this->pdf->SetX(45);
		$this->pdf->Ln(11,true);
		$respuesta = utf8_decode(strip_tags(nl2br($observacion)));
		$this->pdf->WriteHTMLCell(195, '', 10, 84, $observacion, 1, 1, 1, false, 'l', true);



		//$this->pdf->Cell(160, 500,$que, 1, 0, 1, true, 'J', true);

		/*
		$this->pdf->MultiCell(160,10,'',1,'J',true,1,'','',true,0,true,true);
		$this->pdf->SetFillColor(0,0,0);
		$this->pdf->writeHTML($que,false,true,false,true,'L');*/

		// cierra y muestra el documento
		$this->pdf->Output('queja.pdf', 'I');
	}
}
