<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MY_Controller extends CI_Controller { 
  protected $layout = 'layout';
  protected $stylesheets = array(
    'app.css'
  );
  protected $javascripts = array(
  'app.js', 'jquery-1.12.0.min.js', 'jquery-migrate-1.2.1.min.js'
  );
  protected $local_stylesheets = array();
  protected $local_javascripts = array();

  protected function render($content, Array $data = array()) { 
    $view_data = array( 
      'content' => $content,
      'stylesheets' => $this->get_stylesheets(),
      'javascripts' => $this->get_javascripts()
    );
    $view_data_keys = array_keys($view_data);
    foreach ($data as $key => $value) {
      if(!in_array($key, $view_data_keys))
        $view_data[$key] = $value;
    }
    $this->load->view($this->layout,$view_data);
  }
 
  protected function get_stylesheets() {
    return array_merge($this->stylesheets,$this->local_stylesheets);
  }
 
  protected function get_javascripts() {
    return array_merge($this->javascripts,$this->local_javascripts);
  }
}