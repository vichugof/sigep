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
              ->select('quejas.radicado', FALSE)
              ->from('quejas')
              ->join('epnuevo', 'epnuevo.idtipo = quejas.tipoep_id and epnuevo.idnuevo= quejas.frips ', 'left')
              ->join('ep', 'ep.idtipo = quejas.tipoep_id and ep.id_ep= quejas.frips ', 'left')
              ->where('radicado = '.$busca_radica);
        
    return $query->get()->result();
  }



}