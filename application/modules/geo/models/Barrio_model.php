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
               ->select('barrios.fidbarrio AS id, ST_AsGeoJSON(barrios.the_geom) AS geom, barrios.barrio AS nom_barrio, barrios.fidcomuna AS comuna, barrios.estra_moda AS estrato, barrios.area AS area, barrios.perimetro AS perimetro', FALSE)
               ->from('barrios');
               //->join('comunas', 'comunas.fidcomuna= barrios.fidcomuna')
               //->limit(10);
               //->get('epriorizado', 10);
               //->get('epriorizado');

       //return $query->result();
       return $query->get()->result();
   }
}