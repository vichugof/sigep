<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Barrio_model extends CI_Model {

   function __construct() {
       // Call the Model constructor
       parent::__construct();
       $this->load->database();
   }
   
   // function get_last_ten_entries()
   function get_entries($limit = null) {
        $query = $this
               ->db
               ->select('barrios.fidbarrio AS id, ST_AsGeoJSON(barrios.the_geom) AS geom, barrios.barrio AS nombre, barrios.fidcomuna AS comuna, barrios.estra_moda AS estrato, barrios.area AS area, barrios.perimetro AS perimetro', FALSE)
               ->from('barrios');
               //->join('comunas', 'comunas.fidcomuna= barrios.fidcomuna')
               //->limit(10);
               //->get('epriorizado', 10);
               //->get('epriorizado');

       //return $query->result();
       return $query->get()->result();

      /* function get_epnuevo_by_barrio($limit = null) {

          select ('id_ep as id, ST_AsGeoJSON(the_geom) as geom, categoria, escala, fuente, nombre, shape_area, barrio, comuna, estra_moda as estrato, idtipo, fechaactualizacion, fechacreacion ', FALSE)
                ->where ("ST_Intersects(ST_PolygonFromText('POLYGON ((".$bounds['southwest']['lng']." ".$bounds['southwest']['lat'].", ".$bounds['northeast']['lng']." ".$bounds['northeast']['lat'].", 
                ".$bounds['northwest']['lng']." ".$bounds['northwest']['lat'].", ".$bounds['southeast']['lng']." ".$bounds['southeast']['lat'].", ".$bounds['southwest']['lng']." ".$bounds['southwest']['lat']."))', 4326), ep.the_geom)",NULL, FALSE)



       }*/
   }
}