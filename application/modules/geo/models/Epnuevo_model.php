<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Epnuevo_model extends CI_Model {

   function __construct(){
       // Call the Model constructor
       parent::__construct();
       $this->load->database();
   }
   
  function get_estra_comuna($id){
     $barrio = $this
                  ->db
                  ->select('barrios.fidcomuna, barrios.estra_moda, barrios.barrio')
                  ->from('barrios')
                  ->join('epnuevo, epnuevo.barrio=barrios.barrio')
                  ->where('ST_Intersects(
                              ST_GeomFromText(
                                ST_AsText( 
                                  
                                    ST_GeomFromGeoJSON(epnuevo.the_geom)
                                  
                                )
                              , 4326
                              ) 
                            , barrios.the_geom 
                          )', NULL, FALSE) 
                  ->where('epnuevo.idnuevo', $id)
                  ->result(); 

     return $barrio;
  }


  function transforma_ep ($id, $categoria, $escala){
   
  $data = $this->get_entry($id);
  $barrio = $this->get_estra_comuna($id);

  $data_ep = array(    
    'the_geom'            => $data[0]->geom,
    'categoria'           => $categoria, 
    'escala'              => $escala,
    'fuente'              => "ciudadania",    
    'nombre'              => $barrio[0]->barrio,
    'shape_area'          => $data[0]->area,
    'barrio'              => $data[0]->barrio,
    'comuna'              => $barrio[0]->fidcomuna,
    'estra_moda'          => $barrio[0]->estra_moda;
    'idtipo'              => $data[0]->idtipo,
    'fechaactualizacion'  => $data[0]->fechaactualizacion,
    'fechacreacion'       => $data[0]->fechacreacion,
    );

   $this->db->insert('ep', $data_ep);

  // $data[0]['fuente'] = "ciudadania";

  // $data[0]['barrio'] = $barrio[0]->fidcomuna;
  // $data[0]['estra_moda'] = $barrio[0]->estra_moda;
  // $data[0]['nombre'] = $barrio[0]->barrio;

  }    

  public function new_entries($epnuevo, $user_id){

    $barrio = $this
                ->db
                ->select('barrios.fidbarrio')
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
                ->result(); 
        

    $data = array(
      'barrio' => $barrio[0]->fidbarrio, 
      'idtipo' => 4,
    );

    $this->db->set('shape_area', 'ST_Area( ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON(\''.$epnuevo['geom'].'\')), 4326))', FALSE);           
    $this->db->set('the_geom',  'ST_GeomFromText( ST_AsText( ST_Multi(ST_GeomFromGeoJSON(\''.$epnuevo['geom'].'\'))) , 4326)', FALSE); 
    $this->db->set('fechaactualizacion', 'NOW()', FALSE); 
    $this->db->set('fechacreacion', 'NOW()', FALSE); 
    $this->db->insert('epnuevo', $data);
    $new_epnuevo_id =  $this->db->insert_id(); 
      
    $this->load->model('Epnuevo_usu_temporal_model', 'epnuevo_usu_temporal');

    $data = array(
      'idnuevo'                => $new_epnuevo_id, 
      'usu_id_temp'            => $user_id
    );

    $new_epnuevo_usu_temporal = $this->epnuevo_usu_temporal->insert($data);

    return $new_epnuevo_id;
  }

  function get_entry($id) {
    $query =  $this
              ->db
              ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio AS barrio,  fechaactualizacion, fechacreacion, idtipo', FALSE)
              ->from('epnuevo')
              ->where('idnuevo = '.$id, NULL, FALSE);
        
    return $query->get()->result();
  }

  function sin_queja($fecha_actual) {
    $query =  $this
              ->db
              ->select('epnuevo.idnuevo', FALSE)
              ->from('epnuevo')
              ->join('quejas', 'epnuevo.idtipo = a.tipoep_id and epnuevo.idnuevo= a.frips')
              ->where('quejas.id is null', NULL, FALSE)
              ->where('fechacreacion < '.$fecha_actual);
        
    return $query->get()->result();
  }

  // recuperar epnuevos
  function get_entries($user_name_temp = null, $limit = null) {
        
    $query = $this  
          ->db
          ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio,  epnuevo.fechaactualizacion, epnuevo.fechacreacion, epnuevo.idtipo, epnuevo_usu_temporal.usu_id_temp', FALSE)
          ->from('epnuevo')
          ->join('epnuevo_usu_temporal', 'epnuevo.idnuevo=epnuevo_usu_temporal.idnuevo', 'inner')
          // ->where('epnuevo_usu_temporal.usu_id_temp x = \''.session_id().'\'', NULL, FALSE);     
          ->where('epnuevo_usu_temporal.usu_id_temp', (string) $user_name_temp);     
        
      return $query->get()->result();
    }

  function get_entry_by_id_with_centroid($id){
    $query = $this
              ->db
              ->select('idnuevo AS id, ST_AsGeoJSON( ST_Centroid(the_geom) ) AS centroid,  ST_AsGeoJSON( the_geom) AS geom, shape_area, barrio, fechacreacion, fechaactualizacion, idtipo', FALSE)
              ->where("epnuevo.idnuevo = ".$id, NULL, FALSE)
              ->get('epnuevo');      

    return $query->result();

  }
}