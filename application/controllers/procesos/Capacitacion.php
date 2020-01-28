<?php 
/****************************************************************************************************
*
*	CONTROLLERS/procesos/capacitacion.php
*
*		Descripción:
*			Capacitación 
*
*		Fecha de Creación:
*			09/Enero/2013
*
*		Ultima actualización:
*			09/Enero/2013
*
*		Autor:
*			ISC Rogelio Castañeda Andrade
*			rogeliocas@gmail.com
*			@rogelio_cas 
*
****************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capacitacion extends CI_Controller {
	
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
			$this->load->model('procesos/capacitacion_model','',TRUE);
		}
	}
	
/** Funciones **/
	//
	// usuarios( $id_evaluacion ): Evaluación de detección de necesidades de capacitación
	//
	function usuarios( $id_evaluacion ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( 'inicio' );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Detección de Necesidades de Capacitación: Usuarios';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id_evaluacion'] = $id_evaluacion;
		
		// obtiene los puestos del área del usuario
		$datos['usuarios'] = $this->capacitacion_model->get_usuarios_evaluar( $id_evaluacion );

		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/usuarios',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// evaluar( $id_evaluacion, $id_usuario ): Evaluación de detección de necesidades de capacitación
	//
	function evaluar( $id_evaluacion, $id_usuario ) {
		
		
		// variables necesarias para la página
		$datos['titulo'] = 'Detección de Necesidades de Capacitación';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id_evaluacion'] = $id_evaluacion;
		$datos['id_usuario'] = $id_usuario;
		
		// obtiene los puestos del área del usuario
		$puestos = $this->capacitacion_model->get_puestos();
		
		// obtiene el nombre del usuario
		$usuario = $this->capacitacion_model->get_usuario( $id_usuario );
		foreach( $usuario->result() as $row ) {
			$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
		}

		// obtiene las habilidades y aptitudes del puesto
		$habilidades = $this->capacitacion_model->get_habilidades( $id_usuario );
		$datos['habilidades'] =  $habilidades;
		if( $habilidades->num_rows() > 0 ) {
			foreach( $habilidades->result() as $row ) {
				$datos['puesto_usuario'] = $row->Puesto;
				$id_puesto = $row->IdPuesto;
			}
		}
		else {
			$datos['puesto_usuario'] = '';
		}
				
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
			
		if( $_POST ) {
			$datos['habilidades'] = $this->capacitacion_model->get_habilidades( $id_usuario );
			if( $this->capacitacion_model->inserta_respuestas( $id_evaluacion, $id_usuario, $id_puesto ) ) {
				// si se esta evaluando a él mismo
				if( $id_usuario == $this->session->userdata('id_usuario') ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Tus respuestas se han guardado, ahora deberas proponer Cursos de Capacitación";
					$datos['enlace'] = "procesos/capacitacion/cursos/".$id_evaluacion;
					$this->load->view('mensajes/ok_redirec',$datos);
				}
				// si esta evaluando a otro usuario
				else {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "Tus respuestas se han guardado<br />¿Deseas guardar la información de otro usuario?";
					$datos['enlace_si'] = "procesos/capacitacion/usuarios/".$id_evaluacion;
					$datos['enlace_no'] = "procesos/capacitacion/cursos_propuestos";
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/evaluar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// cursos(): Evaluación de detección de necesidades de capacitación
	//
	function cursos() {
		// regresa si no trae las variables
		if( $this->uri->segment(6) == false ) {
			$id_evaluacion = $this->capacitacion_model->get_evaluacion();
		}
		else {
			$id_evaluacion = $this->uri->segment(6);
		}

		// variables necesarias para la página
		$datos['titulo'] = 'Cursos de Capacitación';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id_evaluacion'] = $id_evaluacion;
		$area=$this->session->userdata('id_area');
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		$datos['propuestos'] = false;

		// obtiene la información de la evaluación
		$resultados = $this->capacitacion_model->get_resultados_evaluacion( $id_evaluacion);
		if( $resultados->num_rows() > 0 ) {
			foreach( $resultados->result() as $row ) {
				$id_puesto = $row->IdPuesto;
				break;
			}
		}
		$habilidades = $this->capacitacion_model->get_habilidades( $this->session->userdata('id_usuario') );
		
		// obtiene los cursos propuestos
		$datos['cursos'] = $this->capacitacion_model->get_cursos( $id_evaluacion);
		
		// gráfica de resultados
		if( $habilidades->num_rows() > 0 ) {
			$mediciones = '';
			foreach( $habilidades->result() as $row_h ) {
				$mediciones .= '["'.$row_h->Habilidad.'",';
				if( $resultados->num_rows() > 0 ) {
					$i = 0;
					$total = 0;
					foreach( $resultados->result() as $row_r ) {
						if( $row_h->IdCapacitacionHabilidad == $row_r->IdHabilidad ) {
							$total = $total + $row_r->Valor;
							$i++;
						}
					}
					$total = ( $total / $i ) * 10;
					$mediciones .= $total.'],';
				}
			}
		}
		$datos['grafica'] = '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">			
			  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
			  google.setOnLoadCallback(drawChart);			  
			  function drawChart() {		
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "Habilidad/Aptitud");
			  data.addColumn("number", "Avance");
			  data.addRows(['.$mediciones.']);
			  var options = {
				  width: 650,
				  height: 300,
				  colors: ["#CC0000"],
				  fontSize: "12",
				  fontName: "Tahoma",
				  legend: "none",
				  vAxis: { title: "Porcentaje", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "maximized",
						  },
				  chartArea: { top: 30, left: 100, width: 590, height: 200 },
				  tooltipTextStyle: { fontSize: "16" },
			  };
			  
			  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column
  
			  var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div>
		';
				
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// muestra el msj de que el voto se guardo
		if( $this->uri->segment(5) == 'voto' ) {
			// msj de éxito
			$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
			$datos['mensaje'] = "Tu voto se ha guardado correctamente<br /><br />¿Deseas proponer otro Curso de Capacitación?";
			$datos['enlace_si'] = "procesos/capacitacion/cursos/".$id_evaluacion;
			$datos['enlace_no'] = "inicio";
			$this->load->view('mensajes/pregunta_enlaces',$datos);
		}
		elseif ( $this->uri->segment(5) == 'propuestos' ) {
			$datos['propuestos'] = true;
		}
		
		if( $_POST ) {
			// reglas de validación
			$this->form_validation->set_rules('curso', 'Curso', 'required|trim');
			$this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
			$this->form_validation->set_message('required', 'Debes introducir el campo <strong>%s</strong>');		
			
			// envia mensaje de error si no se cumple con alguna regla
			if( $this->form_validation->run() == FALSE ){
				$this->load->view('mensajes/error_validacion',$datos);
			}
			// realiza la inserción a la base de datos si todo ha estado bien
			else{
				if( $this->capacitacion_model->inserta_curso( $id_evaluacion ) ) {
					// msj de éxito
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "La información se ha guardado correctamente<br /><br />¿Deseas proponer otro Curso de Capacitación?";
					if ( $this->uri->segment(5) == 'propuestos' ) {
						$datos['enlace_si'] = "procesos/capacitacion/cursos/".$id_evaluacion."/propuestos";
						$datos['enlace_no'] = "procesos/capacitacion/cursos";
					}
					else {
						$datos['enlace_si'] = "procesos/capacitacion/cursos/".$id_evaluacion;
						$datos['enlace_no'] = "inicio";
					}
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
			}
		}
		
		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/cursos',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// votar( $id_evaluacion, $id_curso ): Vota a favor de un curso de capacitación
	//
	function votar( $id_evaluacion, $id_curso ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) == false ) {
			redirect( 'inicio' );
		}

		if( $this->capacitacion_model->inserta_voto( $id_curso ) ) {
			redirect( 'procesos/capacitacion/cursos/'.$id_evaluacion.'/voto' );
		}
	}

	//
	// cursos_propuestos(): Revisa los cursos propuestos por los usuarios del área y propone los que se enviaran a CC
	//
	function cursos_propuestos() {
		// variables necesarias para la página
		$datos['titulo'] = 'Cursos de Capacitación Propuestos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		
		// obtiene la evaluación activa
		$id_evaluacion = $this->capacitacion_model->get_evaluacion();
		$datos['id_evaluacion'] = $id_evaluacion;
		
		// obtiene los cursos propuestos por los usuarios
		$datos['cursos'] = $this->capacitacion_model->get_cursos_propuestos( $id_evaluacion );
		
		// obtiene los cursos propuestos por el encargado de capacitación, los cuales se enviaron a CC
		$datos['cursos_area'] = $this->capacitacion_model->get_cursos_propuestos_info( $id_evaluacion);

		// guarda los cursos propuestos
		if( $_POST ) {
			if( $this->capacitacion_model->inserta_cursos_propuestos() ) {
				redirect( 'procesos/capacitacion/cursos_propuestos_info' );
			}
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/cursos_propuestos',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');		
	}

	//
	// cursos_propuestos_info(): Revisa los cursos propuestos por los usuarios del área y propone los que se enviaran a CC
	//
	function cursos_propuestos_info($id_evaluacion, $id) {
		// variables necesarias para la página
		$datos['titulo'] = 'Cursos de Capacitación Propuestos';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// obtiene la evaluación activa
		$id_evaluacion = $this->capacitacion_model->get_evaluacion();
		
		
		
		// obtiene la información de los cursos propuestos por el área
		$datos['cursos'] = $this->capacitacion_model->get_cursos_propuestos_info2( $id_evaluacion, $id);

		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		// guarda los cursos propuestos
		if( $_POST ) {
			
			$usuario=$this->db->get('pa_capacitacion_cursos', 'pa_capacitacion_cursos.IdCapacitacionCurso', $id);
			if($usuario->num_rows > 0){
				foreach($usuario->result() as $row){
					$var=$row->IdUsuario;				
				}
			}
			
			$area=$this->db->get('ab_usuarios', 'ab_usuarios.IdUsuario', $var);
			if($area->num_rows > 0){
				foreach($area->result() as $row){
					$IdArea=$row->IdArea;				
				}
			}
			
			echo $IdArea;
			// FALTA VALIDACION!
			
			$tipo=$this->input->post('Tipo');
			$fecha=$this->input->post('Fecha');
			$cantidad=$this->input->post('Cantidad');
			$observaciones=$this->input->post('Observaciones');
			$this->capacitacion_model->actualiza_cursos_propuestos( $id,$IdArea, $tipo, $fecha, $cantidad,$observaciones);
			
			$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
			$datos['mensaje'] = "La información de los cursos se ha guardado correctamente";
			$datos['enlace'] = "procesos/capacitacion/cursos_propuestos";
			$this->load->view('mensajes/ok_redirec',$datos);
		}
		
		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/cursos_propuestos_info',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');		
	}

	//
	// expediente_listado(): Listado de los usuarios del área para poder actualizar / revisar si expediente 
	//
	function calendario() {
		// variables necesarias para la página
		$datos['titulo'] = 'Listado de Expedientes de Usuarios';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// Obtiene a los usuarios del área
		
		$datos['consulta'] = $this->capacitacion_model->calendario();
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/calendario',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	//
	// expediente_listado(): Listado de los usuarios del área para poder actualizar / revisar si expediente 
	//
	function expediente_listado() {
		// variables necesarias para la página
		$datos['titulo'] = 'Listado de Expedientes de Usuarios';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// Obtiene a los usuarios del área
		$datos['usuarios'] = $this->capacitacion_model->get_usuarios();
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/expediente/listado',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
    //
	// autoevaluados(): Listado de los usuarios que han contestado y no la autoevaluacion
    //
	function autoevaluados() {
		// variables necesarias para la página
		$datos['titulo'] = 'Usuarios que ya Respondieron la Evaluación';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();		        		
        
        // Obtiene a los usuarios que ya realizaron la autoevaluacion
		$datos['autoevaluados'] = $this->capacitacion_model->get_autoevaluados();
        
        // Obtiene a los usuarios que NO han realizado la autoevaluacion
		$datos['no_autoevaluados'] =	$this->capacitacion_model->get_no_autoevaluados();
		
		
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/autoevaluados',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
    
    //
	// revisar_evaluacion( $id ): Resultados de la evaluación de un usuario
    //
	function revisar_evaluacion( $id ) {
    // regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/capacitacion/autoevaluados" );
		}
        
		// variables necesarias para la página
		$datos['titulo'] = 'Autoevaluación';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		 
		$this->Inicio_model->set_sort( 15 );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();		        		
        
        // Obtiene a los resultados del usuario
		$autoevaluados = $this->capacitacion_model->get_autoevaluacion( $id );        
		$datos['autoevaluados'] = $autoevaluados;
		
		$desempeno = $this->capacitacion_model->get_resultados_desempeno( $id );        
		$datos['desempeno'] = $desempeno;
        
        // Genera la gráfica
        if( $autoevaluados->num_rows() > 0 ) {
			$mediciones = '';
			foreach( $autoevaluados->result() as $row ) {
				$mediciones .= '["'.$row->Habilidad.'",'.$row->Valor.'],';				
			}
		}
        $datos['grafica'] = '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">			
			  google.load("visualization", "1.0", {"packages":["corechart"]});			  			 
			  google.setOnLoadCallback(drawChart);			  
			  function drawChart() {		
			  var data = new google.visualization.DataTable();
			  data.addColumn("string", "Habilidad/Aptitud");
			  data.addColumn("number", "Valor");
			  data.addRows(['.$mediciones.']);
			  var options = {
				  width: 650,
				  height: 300,
				  colors: ["#CC0000"],
				  fontSize: "12",
				  fontName: "Tahoma",
				  legend: "none",
				  vAxis: { title: "Porcentaje", titleTextStyle: { fontSize: "18", fontName: "Tahoma" } },
				  hAxis: {
							 title: "Porcentaje de Avance",				  	 
							 format:"#\'%\'", 
							 titleTextStyle: {
								 fontSize: "18", 
								 fontName: "Tahoma" 
							 },					 
							 viewWindowMode: "maximized",
						  },
				  chartArea: { top: 30, left: 100, width: 590, height: 200 },
				  tooltipTextStyle: { fontSize: "16" },
			  };
			  
			  var formatter = new google.visualization.NumberFormat({suffix: "%",fractionDigits: 0});
			  formatter.format(data, 1); // Apply formatter to second column
  
			  var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
			  chart.draw(data, options);
			}
			</script>
            <div id="chart_div"></div><br /><br />
		';
        
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/revisar_evaluacion',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// expediente_agregar(): Agregar una evidencia al expediente de un usuario 
	//
	function expediente_agregar( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/capacitacion/expediente_listado" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Actualizar Expediente de Usuario';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		
		// Obtiene el nombre del usuario
		$usuario = $this->capacitacion_model->get_usuario_expediente( $id );
		foreach( $usuario->result() as $row  ) {
			$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
			break;
		}
		
		// estructura de la página (1)
		$this->load->view('_estructura/header',$datos);
		
		if( $_POST ){		
			// configuración del archivos a subir
			$nom_doc = $this->session->userdata('id_area')."-".$id."-".substr(md5(uniqid(rand())),0,6);
			$config['file_name'] = $nom_doc;
			$config['upload_path'] = './includes/docs/expedientes/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '0';
	
			$this->load->library('upload', $config);
	
			if ( !$this->upload->do_upload('archivo') ) {
				// msj de error
				$datos['mensaje_titulo'] = "Error";
				$datos['mensaje'] = $this->upload->display_errors();
				$this->load->view('mensajes/error',$datos);
			}
			else {						
				// renombra el documento
				$upload_data = $this->upload->data();
				$nom_doc = $nom_doc.$upload_data['file_ext'];

				// se guarda el documento
				if( $this->capacitacion_model->inserta_expediente( $id, $nom_doc ) ) {
					$datos['mensaje_titulo'] = "&Eacute;xito al Guardar";
					$datos['mensaje'] = "El archivo se ha guardado correctamente<br />¿deseas agregar otro para éste usuario?";
					$datos['enlace_si'] = "procesos/capacitacion/expediente_agregar/".$id;
					$datos['enlace_no'] = "procesos/capacitacion/expediente_listado";
					$this->load->view('mensajes/pregunta_enlaces',$datos);
				}
			}
		}

		// estructura de la página (2)
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/expediente/agregar',$datos);
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}
	
	//
	// expediente_revisar(): Revisa el expediente de un usuario 
	//
	function expediente_revisar( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/capacitacion/expediente_listado" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Expediente de Usuario';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id_usuario'] = $id;
		
		// Obtiene el expediente del usuario
		$datos['usuario_expediente'] = $this->capacitacion_model->get_usuario_expediente( $id );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// Obtiene el nombre del usuario
		$usuario_nombre = $this->capacitacion_model->get_usuario( $id );
		foreach( $usuario_nombre->result() as $row  ) {
			$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
		}
		
		// estructura de la página
		$this->load->view('_estructura/header',$datos);
		$this->load->view('_estructura/top',$datos);
		$this->load->view('procesos/capacitacion/expediente/revisar',$datos);
		$this->load->view( 'mensajes/pregunta_oculta_usuario' );
		$this->load->view('_estructura/right');
		$this->load->view('_estructura/footer');
	}

	//
	// expediente_modificar(): Revisa el expediente de un usuario 
	//
	function expediente_modificar( $id ) {
		// regresa si no trae las variables
		if( $this->uri->segment(4) === false ) {
			redirect( "procesos/capacitacion/expediente_listado" );
		}
		
		// variables necesarias para la página
		$datos['titulo'] = 'Modificar Descripcion del Documento';
		$datos['secciones'] = $this->Inicio_model->get_secciones();
		$datos['identidad'] = $this->Inicio_model->get_identidad();
		$datos['usuario'] = $this->Inicio_model->get_usuario();
		$datos['id_usuario'] = $id;
		
		// Obtiene el expediente del usuario
		$datos['usuario_expediente'] = $this->capacitacion_model->get_usuario_expediente( $id );
		$datos['sort_tabla'] = $this->Inicio_model->get_sort();
		
		// Obtiene el nombre del usuario
		$usuario_nombre = $this->capacitacion_model->get_usuario( $id );
		foreach( $usuario_nombre->result() as $row  ) {
			$datos['nombre_usuario'] = $row->Nombre.' '.$row->Paterno.' '.$row->Materno;
		}

		if($_POST){
			$descripcion = $this->input->post('Descripcion');
			
			$this->capacitacion_model->actualizar_registro($id, $descripcion); 
			redirect('procesos/capacitacion/expediente_revisar/'.$this->session->userdata( 'id_usuario' ));

		}else{
			// estructura de la página
			$this->load->view('_estructura/header',$datos);
			$this->load->view('_estructura/top',$datos);
			$this->load->view('procesos/capacitacion/expediente/modificar',$datos);
			$this->load->view( 'mensajes/pregunta_oculta_usuario' );
			$this->load->view('_estructura/right');
			$this->load->view('_estructura/footer');
		}
		
		
	}



}