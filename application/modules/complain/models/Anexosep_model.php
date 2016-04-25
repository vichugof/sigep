<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Anexosep_model extends MY_Model {
    public $table = 'anexos_ep';
    public $primary_key = 'id';
    function __construct() {
       // Call the Model constructor
        $this->timestamps = array('fechacreacion','fechaactualizacion');
        parent::__construct();
        $this->load->database();
    }
}