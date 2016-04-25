<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Eppriorizado_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    // function get_last_ten_entries()
    function get_entries($limit = null)
    {
        

        $query = $this
                ->db
                
                ->select('epriorizado."idEprio" AS id, ST_AsGeoJSON(epriorizado.the_geom) AS the_geom, epriorizado.shape_area AS shape_area, epriorizado.nombre AS nombre, epriorizado.barrio AS barrio, epriorizado.comuna AS comuna, fechaactualizacion, fechacreacion, idtipo', FALSE)
                ->from('epriorizado');
                //->join('barrios', 'barrios.id_barrio = epriorizado.id_barrio');
                //->get('epriorizado', 10);
                //->get('epriorizado');
        
        return $query->get()->result();
    }

}