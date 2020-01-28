<?php 
/****************************************************************************************************
*
*	MODELS/procesos/capacitacion_model.php
*
*		Descripción:  		  
*			Capacitación del sistema 
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
class Capacitacion_model extends CI_Model {
/** Atributos **/

/** Propiedades **/

/** Constructor **/	
	function __construct() {
		parent::__construct();
	}
	
/** Funciones **/
	//
	// get_puestos(): Obtiene los puestos del área del usuario
	// 
	function get_puestos() {
		$condicion = array(
			'IdArea' => $this->session->userdata('id_area'),
		);
		
		$this->db->order_by( 'Puesto' );
		$consulta = $this->db->get_where( 'ab_puestos', $condicion ); 
		
		return $consulta;
	}
	
	//
	// get_habilidades( $id_usuario ): Obtiene las habilidades del usuario por su puesto
	// 
	function get_habilidades( $id_usuario ) {
		$condicion = array(
			'IdUsuario' => $id_usuario,
		);
		$this->db->order_by( 'Habilidad' );
		$this->db->join('ab_puestos','ab_puestos.IdPuesto = pa_capacitacion_habilidades.IdPuesto');
		$consulta = $this->db->get_where( 'pa_capacitacion_habilidades', $condicion ); 
		
		return $consulta;
	}
		
	//
	// get_cursos( $id_evaluacion ): Obtiene los cursos propuestos
	// 
	function get_cursos( $id_evaluacion ) {
		$condicion = array(
			'IdCapacitacionEvaluacion'	=> $id_evaluacion,
			'pa_capacitacion_cursos_propuestos.IdArea'=> $this->session->userdata('id_area'),
			
		);
		
		// obtiene los cursos por los que el usuario ya voto 
		$votos = array();
		$v = $this->get_votos();
		if( $v->num_rows() > 0 ) {
			$i = 0;
			foreach( $v->result() as $row ) {
				$votos[$i] = $row->IdCurso;
				$i++;
			}
		}
		$this->db->group_by( 'Curso' );
		$this->db->join('pa_capacitacion_cursos', 'pa_capacitacion_cursos.IdCapacitacionCurso=pa_capacitacion_cursos_propuestos.IdCurso');
		$consulta = $this->db->get_where( 'pa_capacitacion_cursos_propuestos', $condicion ); 
		return $consulta;
	}
	
	//
	// get_cursos_propuestos( $id_evaluacion ): Obtiene los cursos propuestos en el área
	// 
	function get_cursos_propuestos( $id_evaluacion ) {
		$condicion = array(
			'pa_capacitacion_cursos.IdCapacitacionEvaluacion'	=> $id_evaluacion,
			
			'ab_usuarios.IdArea'								=> $this->session->userdata('id_area'),
		);
		// obtiene los cursos por los que el usuario ya voto 
		$cursos = array();
		$v = $this->get_cursos_propuestos_info( $id_evaluacion );
		if( $v->num_rows() > 0 ) {
			$i = 0;
			foreach( $v->result() as $row ) {
				$cursos[$i] = $row->IdCurso;
				$i++;
			}
		}
		
		$this->db->group_by('pa_capacitacion_cursos.IdCapacitacionCurso');
		$this->db->join('ab_usuarios', 'ab_usuarios.IdUsuario = pa_capacitacion_cursos.IdUsuario');
		$this->db->join('pa_capacitacion_cursos_votos','pa_capacitacion_cursos_votos.IdCurso = pa_capacitacion_cursos.IdCapacitacionCurso', 'LEFT');
		$this->db->select('pa_capacitacion_cursos.IdCapacitacionCurso, pa_capacitacion_cursos.Curso, COUNT(pa_capacitacion_cursos.IdCapacitacionCurso) AS Total, pa_capacitacion_cursos_votos.IdCapacitacionCursoVoto');
		if( $cursos ) {
			$this->db->where_not_in( 'IdCapacitacionCurso', $cursos );
		}
		
		$consulta = $this->db->get_where( 'pa_capacitacion_cursos', $condicion ); 
		return $consulta;
	}	

	//
	// get_cursos_propuestos( $id_evaluacion ): Obtiene los cursos propuestos en el área
	// 
	function get_cursos_propuestos_info2( $id_evaluacion, $id ) {
		$condicion = array(
			'pa_capacitacion_cursos.IdCapacitacionEvaluacion'	=> $id_evaluacion,
			'pa_capacitacion_cursos.IdCapacitacionCurso'		=> $id,
			'ab_usuarios.IdArea'								=> $this->session->userdata('id_area'),
		);
		// obtiene los cursos por los que el usuario ya voto 
		$cursos = array();
		$v = $this->get_cursos_propuestos_info( $id_evaluacion );
		if( $v->num_rows() > 0 ) {
			$i = 0;
			foreach( $v->result() as $row ) {
				$cursos[$i] = $row->IdCurso;
				$i++;
			}
		}
		
		$this->db->group_by('pa_capacitacion_cursos.IdCapacitacionCurso');
		$this->db->join('ab_usuarios', 'ab_usuarios.IdUsuario = pa_capacitacion_cursos.IdUsuario');
		$this->db->join('pa_capacitacion_cursos_votos','pa_capacitacion_cursos_votos.IdCurso = pa_capacitacion_cursos.IdCapacitacionCurso', 'LEFT');
		$this->db->select('pa_capacitacion_cursos.IdCapacitacionCurso, pa_capacitacion_cursos.Curso, COUNT(pa_capacitacion_cursos.IdCapacitacionCurso) AS Total, pa_capacitacion_cursos_votos.IdCapacitacionCursoVoto');
		if( $cursos ) {
			$this->db->where_not_in( 'IdCapacitacionCurso', $cursos );
		}
		
		$consulta = $this->db->get_where( 'pa_capacitacion_cursos', $condicion ); 
		return $consulta;
	}	
	
	//
	// get_cursos_propuestos_info( $id_evaluacion ): Obtiene los cursos propuestos en el área por el responsable
	// 
	function get_cursos_propuestos_info( $id_evaluacion) {
		$condicion = array(
			'pa_capacitacion_cursos.IdCapacitacionEvaluacion'	=> $id_evaluacion,
			
			
		);
		
		$this->db->order_by( 'Curso' );
		$this->db->group_by('Curso');
		$this->db->join('pa_capacitacion_cursos_propuestos','pa_capacitacion_cursos_propuestos.IdCurso = pa_capacitacion_cursos.IdCapacitacionCurso');
		$this->db->select('pa_capacitacion_cursos_propuestos.Tipo, pa_capacitacion_cursos_propuestos.Fecha, pa_capacitacion_cursos_propuestos.Cantidad,pa_capacitacion_cursos_propuestos.Observaciones, pa_capacitacion_cursos.IdCapacitacionCurso, pa_capacitacion_cursos.Curso, pa_capacitacion_cursos_propuestos.IdCurso, pa_capacitacion_cursos_propuestos.Tipo, pa_capacitacion_cursos_propuestos.Observaciones, pa_capacitacion_cursos_propuestos.Estado');
		$consulta = $this->db->get_where( 'pa_capacitacion_cursos', $condicion ); 
		return $consulta;
	}
	
	//
	//get_usuarios_res():  que ya respondieron la evaluacion
	//
		function get_usuarios_res($area_evaluacion){
			$condicion=array('pa_usuario_evaluacion');
			
			
		}
	//
	// get_evaluacion(): Obtiene la evaluación activa
	// 
	function get_evaluacion() {
		$condicion = array(
			'Estado'	=> '1',
		);
		$this->db->order_by('IdCapacitacionEvaluacion', 'DESC');
		$consulta = $this->db->get_where( 'pa_capacitacion_evaluacion', $condicion, 1 );
		if( $consulta->num_rows() > 0 ) {
			foreach( $consulta->result() as $row ) {
				$id_evaluacion = $row->IdCapacitacionEvaluacion;
			}
		} 
		else {
			$id_evaluacion = 0;
		}
		
		return $id_evaluacion;
	}
	
	//
	// get_votos(): Obtiene los cursos por los que el usuario ha votado
	// 
	function get_votos() {
		$condicion = array(
			'IdUsuario' => $this->session->userdata('id_usuario'),
		);
		
		$consulta = $this->db->get_where( 'pa_capacitacion_cursos_votos', $condicion ); 
		
		return $consulta;
	}
	
	//
	// get_usuarios_evaluario(): Obtiene a los usuarios que el usuario puede evaluar
	// 
	function get_usuarios_evaluar( $id_evaluacion ) {
		$condicion = array(
			'ab_usuarios_mandos.IdUsuarioEvaluador' => $this->session->userdata('id_usuario'),
			'ab_usuarios.Estado'=> '0',
		);
		
		// obtiene los usuarios ya evaluados por el usuario actual 
		$usuarios = array();
		$u = $this->get_usuarios_evaluados( $id_evaluacion );
		if( $u->num_rows() > 0 ) {
			$i = 0;
			foreach( $u->result() as $row ) {
				$usuarios[$i] = $row->IdUsuarioEvaluado;
				$i++;
			}
		}
		
		$this->db->order_by( 'ab_usuarios.Nombre' );
		if( $usuarios ) {
			$this->db->where_not_in( 'IdUsuario', $usuarios );
		}
		$this->db->join( 'ab_usuarios', 'ab_usuarios.IdUsuario = ab_usuarios_mandos.IdUsuarioEvaluado');
		$consulta = $this->db->get_where( 'ab_usuarios_mandos', $condicion ); 
		
		return $consulta;
	}
	
	//
	// get_usuarios_evaluados(): Obtiene a los usuarios que ya fueron evaluados por un usuario
	// 
	function get_usuarios_evaluados( $id_evaluacion ) {
		$condicion = array(
			'IdCapacitacionEvaluacion' 	=> $id_evaluacion,
			'IdUsuario' 				=> $this->session->userdata('id_usuario'),
		);
		
		$this->db->group_by( 'IdUsuarioEvaluado' );
		$consulta = $this->db->get_where( 'pa_capacitacion_respuestas', $condicion ); 
		
		return $consulta;
	}
	
	//
	// get_usuarios(): Obtiene a los usuarios del área
	// 
	function get_usuarios() {
		$condicion = array(
			'IdArea' => $this->session->userdata('id_area'),
			'Estado' => '1'
		);
		
		$this->db->order_by( 'Nombre' );
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion ); 
		
		return $consulta;
	}
	
	//
	// get_usuario( $id ): Obtiene a un usuario
	// 
	function get_usuario( $id ) {
		$condicion = array(
			'IdUsuario' => $id,
		);
		
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion, 1 ); 
		
		return $consulta;
	}
	
	//
	// get_usuario_expediente( $id ): Obtiene el expediente de un usuario
	// 
	function get_usuario_expediente( $id ) {
		$condicion = array(
			'ab_usuarios.IdUsuario' => $id,
		);
		
		$this->db->order_by( 'Fecha', 'DESC' );
		$this->db->join( 'ab_expediente', 'ab_expediente.IdUsuario = ab_usuarios.IdUsuario', 'LEFT' );
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion ); 
		
		return $consulta;
	}

 //
	//get_autoevaluados(): Obtiene a los usuarios que ya realizaron la autoevaluacion
	//	
	function calendario() {
		$condicion=array(
			'pa_capacitacion_cursos_propuestos.Estado' => 1,
			'pa_capacitacion_cursos_propuestos.IdArea'	=>$this->session->userdata('id_area'),
			'pa_capacitacion_cursos_propuestos.IdArea'	=> 12,
		);
		
		$this->db->group_by('pa_capacitacion_cursos.Curso');
		$this->db->order_by('pa_capacitacion_cursos_propuestos.Fecha');
		$this->db->join('pa_capacitacion_cursos', 'pa_capacitacion_cursos.IdCapacitacionCurso = pa_capacitacion_cursos_propuestos.IdCurso');
		$consulta = $this->db->get_where( 'pa_capacitacion_cursos_propuestos', $condicion );
		 
		return $consulta;
	}
	
    //
	//get_autoevaluados(): Obtiene a los usuarios que ya realizaron la autoevaluacion
	//	
	function get_autoevaluados() {
        // obtiene la evaluacion activa 
        $id_evaluacion = $this->get_evaluacion();
        
		$condicion = array(
			'ab_usuarios.IdArea'                                     => $this->session->userdata('id_area'),
            'pa_capacitacion_respuestas.IdCapacitacionEvaluacion'    => $id_evaluacion,
            'ab_usuarios.Estado'									 => 1
		);
		
		$this->db->group_by( 'ab_usuarios.IdUsuario' );
		$this->db->join('pa_capacitacion_respuestas', 'ab_usuarios.IdUsuario = pa_capacitacion_respuestas.IdUsuario');
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion ); 
		return $consulta;
	}
	
    //
	// get_autoevaluacion( $id ): Obtiene a los usuarios que ya realizaron la autoevaluacion
	//	
	function get_autoevaluacion( $id ) {
        // obtiene la evaluacion activa 
        $id_evaluacion = $this->get_evaluacion();
        
		$condicion = array(			
            'IdCapacitacionEvaluacion' 	=> $id_evaluacion,
			'IdUsuarioEvaluado'			=> $id,
		);
		$this->db->group_by('pa_capacitacion_habilidades.Habilidad');				
        $this->db->join('ab_usuarios','ab_usuarios.IdUsuario = pa_capacitacion_respuestas.IdUsuario');        
        $this->db->join( 'pa_capacitacion_habilidades', 'pa_capacitacion_habilidades.IdCapacitacionHabilidad = pa_capacitacion_respuestas.IdHabilidad' );
		$this->db->join( 'ab_puestos', 'ab_puestos.IdPuesto = pa_capacitacion_habilidades.IdPuesto' );        
		$consulta = $this->db->get_where( 'pa_capacitacion_respuestas', $condicion ); 
		return $consulta;
	}
    
	//
	// get_no_autoevaluados(): Obtiene a los usuarios que NO han realizado la autoevaluacion
	//
	
	function get_no_autoevaluados() {
        // obtiene la evaluacion activa        
        $id_evaluacion = $this->get_evaluacion();
        
        // obtiene a los usuarios evaluados
		$usrs = array();
		$u = $this->get_autoevaluados();
		if( $u->num_rows() > 0 ) {
			$i = 0;
			foreach( $u->result() as $row ) {
				$usrs[$i] = $row->IdUsuario;
				$i++;
			}
		}
		$this->db->group_by( 'ab_usuarios.IdUsuario' );
		if( $usrs ) {
			$this->db->where_not_in( 'ab_usuarios.IdUsuario', $usrs );
		}
        
		$condicion = array(
			'ab_usuarios.IdArea'                                     => $this->session->userdata('id_area'),
			'ab_usuarios.Estado'									 => 1            
		);
		$consulta = $this->db->get_where( 'ab_usuarios', $condicion ); 
		return $consulta;
	}
	
	//
	// get_resultados_evaluacion( $id_evaluacion ): Obtiene los resultados de la evaluación
	// 
	function get_resultados_evaluacion( $id_evaluacion ) {
		$condicion = array(
			'IdCapacitacionEvaluacion' 	=> $id_evaluacion,
			'IdUsuarioEvaluado'			=> $this->session->userdata( 'id_usuario' ),
		);
		
		$this->db->order_by( 'IdCapacitacionHabilidad' );
		$this->db->join( 'pa_capacitacion_habilidades', 'pa_capacitacion_habilidades.IdCapacitacionHabilidad = pa_capacitacion_respuestas.IdHabilidad' );
		$this->db->join( 'ab_puestos', 'ab_puestos.IdPuesto = pa_capacitacion_habilidades.IdPuesto' );
		$consulta = $this->db->get_where( 'pa_capacitacion_respuestas', $condicion ); 
		
		return $consulta;
	}
	
	function get_resultados_desempeno( $id ) {
        // obtiene la evaluacion activa 
        $id_evaluacion = $this->get_evaluacion();
        
		$condicion = array(			
            
			'IdUsuarioEvaluado'			=> $id,
		);
		$this->db->group_by('en_preguntas.Pregunta');				
        $this->db->join( 'ab_usuarios','ab_usuarios.IdUsuario = en_respuestas_desempeno.IdUsuarioEvaluado');        
        $this->db->join( 'en_preguntas', 'en_preguntas.IdPregunta = en_respuestas_desempeno.IdPregunta' );  
		$this->db->join( 'en_opciones', 'en_opciones.IdOpcion = en_respuestas_desempeno.IdOpcion');      
		$consulta = $this->db->get_where( 'en_respuestas_desempeno', $condicion ); 
		return $consulta;
	}
	
	
	//
	// inserta_expediente( $nom_doc ): Obtiene el expediente de un usuario
	// 
	function inserta_expediente( $id_usuario, $nom_doc ) {
		$insert = array(
			'IdUsuario' => $id_usuario,
			'Ruta'		=> $nom_doc,
			'Fecha'		=> date('Y').'/'.date('m').'/'.date('d'),
		);
		$resp = $this->db->insert( 'ab_expediente', $insert ); 
		
		return $resp;
	}
	
	//
	// inserta_respuestas( $id_evaluacion, $id_usuario, $id_puesto ): Inserta las respuestas de la evaluacion a las habilidades y aptitudes del usuario
	// 
	function inserta_respuestas( $id_evaluacion, $id_usuario, $id_puesto ) {
		$i = 0;
		$habilidades = $this->get_habilidades( $id_usuario );
		foreach( $habilidades->result() as $row ) {
			$inserta[$i] = array(
				'IdCapacitacionEvaluacion'	=> $id_evaluacion,
				'IdPuesto'					=> $id_puesto,
				'IdHabilidad'				=> $row->IdCapacitacionHabilidad,
				'IdUsuario'					=> $this->session->userdata('id_usuario'),
				'IdUsuarioEvaluado'			=> $id_usuario,
				'Valor'						=> $this->input->post('habilidad_'.$row->IdCapacitacionHabilidad),
			);
			$i++;
		}
		$resp = $this->db->insert_batch( 'pa_capacitacion_respuestas', $inserta ); 
		
		return $resp;
	}
	
	//
	// inserta_curso( $id_evaluacion ): Inserta un curso nuevo
	// 
	function inserta_curso( $id_evaluacion ) {
		$insert = array(
			'IdCapacitacionEvaluacion'	=> $id_evaluacion,
			'IdUsuario'					=> $this->session->userdata('id_usuario'),
			'Curso'						=> $this->input->post('curso'),
			'Comentarios'				=> $this->input->post('comentarios'),
			'Estado'					=> '1',
		);
		$resp = $this->db->insert( 'pa_capacitacion_cursos', $insert ); 
		
		return $resp;
	}
	
	//
	// inserta_cursos_propuestos(): Inserta los cursos propuestos del área
	//
	 
	function inserta_cursos_propuestos() {
		$cursos = $this->input->post( 'cursos_propuestos' );
	    for( $i = 0; $i < count( $cursos ); $i++) {
	    	$inserta= array(
				'IdCurso' 	=> $cursos[$i],
				'IdArea'	=> $this->session->userdata('id_area'),
				'Fecha'			=> $this->input->post('Fecha'),
				'Cantidad'		=> $this->input->post('Cantidad'),
				'Estado'	=> '0',
			);
	    }
			
		$resp = $this->db->insert( 'pa_capacitacion_cursos_propuestos', $inserta ); 
		
		return $resp;
	}
	
	//
	// actualiza_cursos_propuestos( $id_evaluacion ): Inserta los cursos propuestos del área
	// 
	function actualiza_cursos_propuestos($id,$IdArea,$tipo,$fecha,$cantidad,$observaciones) {
		
			if( $this->input->post('tipo') ) {
				$inserta = array(
					'IdArea'		=> $IdArea,
					'IdCurso'		=> $id,
					'Tipo' 			=> $this->input->post('tipo'),				
					'Fecha'			=> $this->input->post('Fecha'),
					'Cantidad'		=> $this->input->post('Cantidad'),
					'Observaciones'	=> $this->input->post('Observaciones'),
				);	
			}else{
				echo 'no';
			}
			
			$this->db->where('IdCapacitacionCurso', $id);
			$resp=$this->db->insert('pa_capacitacion_cursos_propuestos', $inserta); 
		 
		
		return $resp;
	}

	//
	// inserta_voto( $id_curso ): Inserta un curso nuevo
	// 
	function inserta_voto( $id_curso ) {
		$insert = array(
			'IdCurso'		=> $id_curso,
			'IdUsuario'		=> $this->session->userdata('id_usuario'),
		);
		$resp = $this->db->insert( 'pa_capacitacion_cursos_votos', $insert ); 
		
		return $resp;
	}

	//
	//actualizar_registro($id) : Actualizar documento
	//
	function actualizar_registro($id, $descripcion){
		echo $id; 
		echo $descripcion;
		$consulta = $this->db->query("UPDATE ab_expediente SET Descripcion = '$descripcion' WHERE IdExpediente = '$id' LIMIT 1");
		
		return $consulta;
	}
	
}
?>