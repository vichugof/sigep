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
        //$result = pg_fetch_all(pg_query($connection, "SELECT asBinary($column) as geom FROM $table"));

        $query = $this
                ->db
                //->select('CAST( ST_AsBinary(the_geom) AS text) AS geom, Shape_Area AS shape_area, COD_BARRIO AS cod_barrio, NOMBRE AS nombre, OBJECTID_1 AS object_id ', FALSE)
                //->select('epriorizado.id, ST_AsGeoJSON(epriorizado.the_geom) AS geom, epriorizado.shape_area AS shape_area, barrios.id_barrio AS cod_barrio, epriorizado.nombre AS nombre', FALSE)
                ->select('epriorizado."idEprio" AS id, ST_AsGeoJSON(epriorizado.the_geom) AS geom, epriorizado.shape_area AS shape_area, epriorizado.nombre AS nombre', FALSE)
                ->from('epriorizado');
                //->join('barrios', 'barrios.id_barrio = epriorizado.id_barrio');
                //->get('epriorizado', 10);
                //->get('epriorizado');

        //return $query->result();
        return $query->get()->result();
    }

}