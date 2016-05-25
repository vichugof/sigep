<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Queja_model extends MY_Model {
    public $table = 'quejas';
    public $primary_key = 'id';
    function __construct() {
       // Call the Model constructor
        $this->timestamps = array('fechacreacion','fechaactualizacion');
        // $this->has_many['anexos'] = array('foreign_model'=>'Anexosep_model','foreign_table'=>'anexos_ep','foreign_key'=>'quejas_id','local_key'=>'id');
        $this->has_many['anexos'] = 'Anexosep_model';
  
        parent::__construct();
        $this->load->database();
    }
    function search_radicado ($busca_radica) {
        $query =  $this
                  ->db
                  ->select('
                    quejas.id AS queja_id, 
                    quejas.radicado, 
                    quejas.frips AS id, 
                    quejas.tipoep_id, 
                    quejas.solicitante, 
                    quejas.solicitante_email, 
                    quejas.fecha, 
                    quejas.comentario, 
                    estado.nombre AS estado_nombre,
                    estado.id AS estado_id,
                    ST_AsGeoJSON( ST_Centroid(epnuevo.the_geom) ) AS epn_centroid,
                    ST_AsGeoJSON( epnuevo.the_geom) AS epn_geom,
                    epnuevo.shape_area AS epn_area,
                    ST_AsGeoJSON( ST_Centroid(ep.the_geom) ) AS ep_centroid,
                    ST_AsGeoJSON( ep.the_geom) AS ep_geom,
                    ep.shape_area AS ep_area,
                    ep.fuente, 
                    ep.nombre AS ep_nombre, 
                    ep.categoria, 
                    ep.escala', FALSE)
                  ->from('quejas')
                  ->join('estado', 'quejas.estado_id = estado.id', 'inner')
                  ->join('epnuevo', 'epnuevo.idtipo = quejas.tipoep_id and epnuevo.idnuevo= quejas.frips ', 'left')
                  ->join('ep', 'ep.idtipo = quejas.tipoep_id and ep.id_ep= quejas.frips ', 'left')
                  ->where('radicado', $busca_radica);

        $result = $query->get()->result();

        if(count($result) > 0)
            return $result[0];

        return false;
    }
}