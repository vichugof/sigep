<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH. '/modules/users/libraries/Ion_auth.php';

class My_Ion_auth extends Ion_auth {
  
  protected $CI;
  
  public function __construct()
  {
    $this->CI =& get_instance();
    $this->load = $this->CI->getLoader();
    parent::__construct();

  }
}