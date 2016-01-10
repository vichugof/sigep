<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Public_Space extends CI_Controller {
    public function index()
    {
        $this->load->view('public_space_index');
    }
}