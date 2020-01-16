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
class Gestion_model extends CI_Model {
/** Atributos **/
    private $sort_tabla;

/** Propiedades **/
    public function get_sort() { return $this->sort_tabla; }
    public function set_sort( $reg ) { $this->sort_tabla = $this->get_info_sort( $reg ); }
/** Constructor **/	
	function __construct() {
		parent::__construct();
    }
    
    function get_evidencias(){
        $condicion = array(
            'IdArea' => $this->session->userdata('id_area'),
        );

        $consulta = $this->db->get_where('pa_evidencias_gestion', $condicion);
       
        return $consulta;
        
    }


    //Cuidado aqui
	function inserta_evidencia_gestion($insercion ) {
		$resp = $this->db->insert( 'pa_evidencias_gestion', $insert ); 		
		return $resp;
	}

    //
	// get_info_sort( $reg ): Especificaciones para el sort de la tabla, estableciendo el número de registros a mostrar
	//
	function get_info_sort( $reg ) {
		$sort_tabla = '
			<script type="text/javascript" charset="utf-8">
                $(document).ready(function() {
                    var dontSort = [];
                    $("#tabla thead th").each( function () {
                        if ( $(this).hasClass( "no_sort" )) {
                            dontSort.push( { "bSortable": false } );
                        } else {
                            dontSort.push( null );
                        }
                    } );
                    $("#tabla").dataTable({
						"bJQueryUI": true,
						"sPaginationType": "full_numbers",
                        "aoColumns": dontSort,
                        "iDisplayLength": '.$reg.',
                        "aLengthMenu": [[-1, 10, 25, 50, 100], [ " - Todos los registros - ", "10 registros", "25 registros", "50 registros", "100 registros"]]
                    });
                } );
            </script>
		';

		return $sort_tabla;
	}

}
