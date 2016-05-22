<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends MY_Model {
    const INICIANDO = 1;
    const EN_PROCESO = 2;
    const FINALIZADO = 3;
    
    public $table = 'estdo';
    public $primary_key = 'id';
    function __construct() {  
        parent::__construct();
        $this->load->database();
    }
}