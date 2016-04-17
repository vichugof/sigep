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

    //FUNCION PARA LLAMAR EP POR ZOOM
    function get_entries($lon=null, $lat=null, $radius=500)
    {
        
        $query = $this
                ->db
                ->select('id_ep AS id, ST_AsGeoJSON(the_geom) AS geom, fuente, nombre, categoria, shape_area, barrio, comuna, fechacreacion, fechaactualizacion, idtipo, escala ', FALSE)
                ->where("ST_DWithin( ST_Transform(ST_GeomFromText('POINT(".$lon." ".$lat.")',  4326), 26986) ,ST_Transform(ep.the_geom, 26986), ".$radius.") ", NULL, FALSE)
                ->get('ep');      

        return $query->result();
    }

    //FUNCION PARA LLAMAR EP POR LIMITES DE BARRIO
    function get_entries_by_bounds($bounds)
    {
        

        $query = $this
                ->db
                ->select ('id_ep as id, ST_AsGeoJSON(the_geom) as geom, categoria, escala, fuente, nombre, shape_area, barrio, comuna, estra_moda as estrato, idtipo, fechaactualizacion, fechacreacion ', FALSE)
                ->where ("ST_Intersects(ST_PolygonFromText('POLYGON ((".$bounds['southwest']['lng']." ".$bounds['southwest']['lat'].", ".$bounds['northeast']['lng']." ".$bounds['northeast']['lat'].", 
                ".$bounds['northwest']['lng']." ".$bounds['northwest']['lat'].", ".$bounds['southeast']['lng']." ".$bounds['southeast']['lat'].", ".$bounds['southwest']['lng']." ".$bounds['southwest']['lat']."))', 4326), ep.the_geom)",NULL, FALSE)
                ->get('ep');      

                 

        return $query->result();
    }


}