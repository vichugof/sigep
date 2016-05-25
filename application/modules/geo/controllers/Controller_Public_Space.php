<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
//class Controller_Public_Space extends CI_Controller {
class Controller_Public_Space extends MX_Controller {

    public function __construct(){
        $this->autoload = array(
          //'libraries' => array('session'),
        );
        parent::__construct();
    }
    public function index()
    {
        //$this->load->view('public_space_index');
    }

    // function get_ep_rows(){
    //     //load the model
    //     $this->load->model('Ep_model', 'ep');

    //     $coor = $this->input->post('coor', TRUE);

    //     //get the rows from ep
    //     $result = $this->ep->get_entries($coor['lng'], $coor['lat'], 1000);

    //     $output_ep = array();
    //     //echo "<pre>"; print_r($result); echo "</pre>"; 
    //     foreach ($result as $item) {

    //         $feature = array();
    //         $feature['id'] = $item->id;
    //         $feature['geom'] = (array)json_decode($item->geom);
    //         $feature['fuente'] = $item->fuente;
    //         $feature['categoria'] = $item->categoria;
    //         $feature['nombre'] = $item->nombre;
    //         $output_ep[] = $feature;
    //     }

    //     $output = array(
    //         'success'   => true,
    //         'data'      => array(
    //             'success'       => 'success', 
    //             'supplemental'  => $this->convertToGeojson($output_ep)
    //         ) 
    //     );

    //     $this->output->set_content_type('application/json')
    //          ->set_output( json_encode($output) );

    //     return;
    // }

    // public function convertToGeojson($coordinates){
    //     $result = array();
    //     $result["type"] = "FeatureCollection";
    //     $result["features"] = array();
    //     $idx_row = 0;

    //     foreach ($coordinates as $coordinate) {

    //         $result["features"][$idx_row] = array(
    //             "type" => "Feature", 
    //             "id" => $coordinate['id'], 
    //             "properties" => array(), 
    //             "geometry" => $coordinate['geom']
    //         );

    //         foreach($coordinate as $column => $value){

    //                 $result["features"][$idx_row]["properties"][$column] = $value;
    //         }
    //         $idx_row++;
    //     }
    //     return $result;
    // }

    public function get_form_pass_ep($parameters = array()){
        $this->load->view( '_form_pass_ep',

           array(
               'parameters' => $parameters,
           )
       );
    }

    public function get_flash_section(){
        //$this->load->library('session');
        $flashdata = $this->session->flashdata();

        $css_class = NULL;
        $message = NULL;

        if(isset($flashdata['success_msg'])){
            $message = $flashdata['success_msg'];
            $css_class = 'success';
        }
        if(isset($flashdata['error_msg'])){
            $message = $flashdata['error_msg'];
            $css_class = 'danger';
        }
        if(isset($flashdata['info_msg'])){
            $message = $flashdata['info_msg'];
            $css_class = 'info';
        }
        // $message = 'Todo very good Todo very good Todo very good Todo very good';
        // $css_class = 'danger';
        $this->load->view( '_flash_section',

           array(
               'flashdata' => $flashdata,
               'message' => $message,
               'css_class' => $css_class
           )
       );
    }
}