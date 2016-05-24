<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Eppropuesto_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    // function get_last_ten_entries()
    function get_entries($limit = 100)
    {
       

        $query = $this
                ->db
               

				->select('epropuesto."idEprop" AS id, ST_AsGeoJSON(epropuesto.the_geom) AS the_geom, epropuesto.tipo AS tipo, epropuesto.shape_area AS shape_area, 
                    epropuesto.nombre AS nombre, epropuesto.comuna AS comuna, idtipo, fechaactualizacion, fechacreacion', FALSE)
				
                ->from('epropuesto')
                ->limit($limit);



        return $query->get()->result();
    }

}