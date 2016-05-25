<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH. '/modules/users/libraries/Bcrypt.php';

class My_bcrypt extends Bcrypt {
  
  protected $CI;
  
  public function __construct($params = array())
  {
    parent::__construct($params);

    $this->CI =& get_instance();

  }
}