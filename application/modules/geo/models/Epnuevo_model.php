<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Epnuevo_model extends CI_Model {

   function __construct(){
       // Call the Model constructor
       parent::__construct();
       $this->load->database();
   }
   

  public function new_entries($epnuevo){

    $barrio = $this
                ->db
                ->select('barrios.fidbarrio, barrios.fidcomuna')
                ->where('ST_Intersects(
                            ST_GeomFromText(
                              ST_AsText( 
                                
                                  ST_GeomFromGeoJSON(\''.$epnuevo['geom'].'\')
                                
                              )
                            , 4326
                            ) 
                          , barrios.the_geom 
                        )', NULL, FALSE) 
                
                        
                ->get('barrios',1)
                /*->limit(1)*/
                ->result(); 
        

    $data = $data = array(
      'barrio' => $barrio[0]->fidbarrio, 
      'comuna' => $barrio[0]->fidcomuna, 
      'idtipo' => 4,
    );

    $this->db->set('shape_area', 'ST_Area( ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON(\''.$epnuevo['geom'].'\')), 4326))', FALSE);           
    $this->db->set('the_geom',  'ST_GeomFromText( ST_AsText( ST_Multi(ST_GeomFromGeoJSON(\''.$epnuevo['geom'].'\'))) , 4326)', FALSE); 
    $this->db->set('fechaactualizacion', 'NOW()', FALSE); 
    $this->db->set('fechacreacion', 'NOW()', FALSE); 
    $this->db->insert('epnuevo', $data);
      
    return $this->db->insert_id(); 
  }

  function get_entry($id) {
    $query =  $this
              ->db
              ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio AS barrio, epnuevo.comuna, fechaactualizacion, fechacreacion, idtipo', FALSE)
              ->from('epnuevo')
              ->where('idnuevo = '.$id, NULL, FALSE);
        
    return $query->get()->result();
  }


  // recuperar epnuevos
  function get_entries($limit = null) {
        
    $query = $this  
          ->db
          ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio, epnuevo.comuna, fechaactualizacion, fechacreacion, idtipo', FALSE)
          ->from('epnuevo');     
        
      return $query->get()->result();
    }

  function get_entry_by_id_with_centroid($id){
    $query = $this
              ->db
              ->select('idnuevo AS id, ST_AsGeoJSON( ST_Centroid(the_geom) ) AS centroid,  ST_AsGeoJSON( the_geom) AS geom, shape_area, barrio, comuna, fechacreacion, fechaactualizacion, idtipo', FALSE)
              ->where("epnuevo.idnuevo = ".$id, NULL, FALSE)
              ->get('epnuevo');      

    return $query->result();

  }
}