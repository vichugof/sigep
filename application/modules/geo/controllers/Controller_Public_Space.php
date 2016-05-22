<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Controller_Public_Space extends CI_Controller {
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

    function get_form_pass_ep($parameters = array()){
         $this->load->view( '_form_pass_ep',

           array(
               'parameters' => $parameters,
           )
       );
    }
}