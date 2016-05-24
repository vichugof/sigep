<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Epnuevo_model extends CI_Model {

  function __construct(){
    // Call the Model constructor
    parent::__construct();
    $this->load->database();
  }

  function get_estra_comuna($id){
    return $this
            ->db
            ->select('barrios.fidcomuna, barrios.estra_moda, barrios.barrio')
            ->from('barrios')
            ->join('epnuevo', 'epnuevo.barrio=barrios.fidbarrio')
            // ->where('ST_Intersects(
            //              ST_GeomFromText(
            //                ST_AsText( 
                             
            //                    ST_GeomFromGeoJSON(epnuevo.the_geom)
                             
            //                )
            //              , 4326
            //              ) 
            //            , barrios.the_geom 
            //          )', NULL, FALSE) 
            ->where('ST_Intersects( epnuevo.the_geom, barrios.the_geom )', NULL, FALSE) 
            ->where('epnuevo.idnuevo', $id)
            ->get()
            ->result();
  }

  function transforma_ep ($id, $categoria, $escala){
    $data   = $this->get_entry($id);
    $barrio = $this->get_estra_comuna($id);
    
    if(empty($barrio) || empty($data))
      return false;

    $data_ep = array(    
      // 'the_geom'            => $data[0]->geom,
      'categoria'           => $categoria, 
      'escala'              => $escala,
      'fuente'              => "ciudadania",    
      'nombre'              => $barrio[0]->barrio,
      'shape_area'          => $data[0]->area,
      'barrio'              => $data[0]->barrio,
      'comuna'              => $barrio[0]->fidcomuna,
      'estra_moda'          => $barrio[0]->estra_moda,
      'idtipo'              => 1,
      'fechaactualizacion'  => date('Y-m-d H:i:s'),
      'fechacreacion'       => date('Y-m-d H:i:s'),
    );
    $this->db->set('the_geom',  'ST_GeomFromText( \''.$data[0]->geom_text.'\' , 4326)', FALSE); 
    $this->db->insert('ep', $data_ep);

    return $this->db->insert_id();
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
                /*->limit(1)*/
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
              ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, ST_AsText(epnuevo.the_geom) AS geom_text, epnuevo.shape_area AS area, epnuevo.barrio AS barrio, fechaactualizacion, fechacreacion, idtipo', FALSE)
              ->from('epnuevo')
              ->where('idnuevo = '.$id, NULL, FALSE);
        
    return $query->get()->result();
  }


  // recuperar epnuevos
  // function get_entries($limit = null) {
        
  //   $query = $this  
  //         ->db
          // ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio, barrios.barrio AS barrio_nombre, comunas.nombre AS comuna_nombre, fechaactualizacion, fechacreacion, idtipo', FALSE)
  //         ->from('epnuevo')
  //         ->join('barrios', 'epnuevo.barrio = barrios.fidbarrio', 'inner')
  //         ->join('comunas', 'barrios.fidcomuna = comunas.fidcomuna', 'inner');
        
  //     return $query->get()->result();
  //   }

  function get_entries($user_name_temp = null, $limit = null) {
         
    $query = $this  
          ->db
          // ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio, barrios.barrio AS barrio_nombre, comunas.nombre AS comuna_nombre, fechaactualizacion, fechacreacion, idtipo', FALSE)
          ->from('epnuevo')
          ->join('barrios', 'epnuevo.barrio = barrios.fidbarrio', 'inner')
          ->join('comunas', 'barrios.fidcomuna = comunas.fidcomuna', 'inner');

    if($user_name_temp != null){
      $query
        ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio, barrios.barrio AS barrio_nombre, comunas.nombre AS comuna_nombre, epnuevo.fechaactualizacion, epnuevo.fechacreacion, epnuevo.idtipo, epnuevo_usu_temporal.usu_id_temp', FALSE)
        ->join('epnuevo_usu_temporal', 'epnuevo.idnuevo=epnuevo_usu_temporal.idnuevo', 'inner')
        ->where('epnuevo_usu_temporal.usu_id_temp', (string) $user_name_temp);
    }else{
      $query
        ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON(epnuevo.the_geom) AS geom, epnuevo.shape_area AS area, epnuevo.barrio, barrios.barrio AS barrio_nombre, comunas.nombre AS comuna_nombre, epnuevo.fechaactualizacion, epnuevo.fechacreacion, epnuevo.idtipo', FALSE);
    }
         
    return $query->get()->result();
  }

  function get_entry_by_id_with_centroid($id){
    $query = $this
              ->db
              ->select('epnuevo.idnuevo AS id, ST_AsGeoJSON( ST_Centroid(epnuevo.the_geom) ) AS centroid,  ST_AsGeoJSON( epnuevo.the_geom) AS geom, epnuevo.shape_area, epnuevo.barrio, barrios.barrio AS barrio_nombre, comunas.nombre AS comuna_nombre, epnuevo.fechacreacion, epnuevo.fechaactualizacion, epnuevo.idtipo', FALSE)
              ->where("epnuevo.idnuevo = ".$id, NULL, FALSE)
              // ->get('epnuevo');      
              ->from('epnuevo')
              ->join('barrios', 'epnuevo.barrio = barrios.fidbarrio', 'inner')
              ->join('comunas', 'barrios.fidcomuna = comunas.fidcomuna', 'inner')
              ->get();

    return $query->result();

  }
}