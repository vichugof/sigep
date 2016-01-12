<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ep_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    /**
    * Get the rows to space public
    *
    * @param Float $lat Latitude
    * @param Float $lon Longitude
    * @param Int $radius radius to query, the measure is meter
    */
    function get_entries($lon=null, $lat=null, $radius=500)//
    {
        $query = $this
                ->db
                ->select('id_ep AS id, ST_AsGeoJSON(the_geom) AS geom, fuente, nombre, categoria ', FALSE)
                ->where("ST_DWithin( ST_Transform(ST_GeomFromText('POINT(".$lon." ".$lat.")',  4326), 26986) ,ST_Transform(ep.the_geom, 26986), ".$radius.") ", NULL, FALSE)
                ->get('ep');

        return $query->result();
    }

}