<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comuna_model extends CI_Model {

   function __construct(){
       // Call the Model constructor
       parent::__construct();
       $this->load->database();
   }
   
   // function get_last_ten_entries()
   function get_entries($limit = null){
       $query = $this
               ->db
               ->select('comunas.fidcomuna AS id, ST_AsGeoJSON(comunas.the_geom) AS geom,
                comunas.nombre AS nombre, comunas.area AS area, comunas.perimetro AS perimetro, comunas.comuna AS comuna', FALSE)
               ->from('comunas');

       //return $query->result();
       return $query->get()->result();
   }

}