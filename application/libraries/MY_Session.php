<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH. '/../vendor/codeigniter/framework/system/libraries/Driver.php';
require_once APPPATH. '/../vendor/codeigniter/framework/system/libraries/Session/Session.php';

class My_Session extends CI_Session {
  
  protected $CI;
  
  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->CI =& get_instance();

    // $this->CI->output->set_header("HTTP/1.0 200 OK");
    // $this->CI->output->set_header("HTTP/1.1 200 OK");
    // $this->CI->output->set_header("Expires: Wed, 12 Dec 1980 00:00:00 GMT");
    // $this->CI->output->set_header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
    // $this->CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
    // $this->CI->output->set_header("Cache-Control: post-check=0, pre-check=0");
    // $this->CI->output->set_header("Pragma: no-cache");  

    // $this->CI->output->set_output("test");
    // $this->CI->output->_display();
    // exit;

  }
}