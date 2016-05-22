<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Epnuevo_usu_temporal_model extends MY_Model {

  public $table = 'epnuevo_usu_temporal';
  public $primary_key = 'id';
  function __construct() {
   // Call the Model constructor
    $this->timestamps = array('fechacreacion','fechaactualizacion');
    parent::__construct();
    $this->load->database();
  }

  public function new_entries(){

    
  }

}