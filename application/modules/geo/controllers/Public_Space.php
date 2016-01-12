<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Public_Space extends CI_Controller {
    public function index()
    {
        $this->load->view('public_space_index');
    }

    // public function get_layers(){
    public function get_epriorizado_layers(){


        $this->load->model('Eppriorizado_model', 'eppriorizado');
        $this->load->model('Ep_model', 'ep');

        // $result = $this->eppriorizado->get_last_ten_entries();
        $result = $this->eppriorizado->get_entries();

        $output_epriorizado = array();
        //echo "<pre>"; print_r($result); echo "</pre>"; 
        foreach ($result as $item) {
            //$wkb = pg_unescape_bytea($item['geom']); // Make sure to unescape the hex blob
            //$wkb = pg_unescape_bytea($item->geom); // Make sure to unescape the hex blob
            //$geom = geoPHP::load($wkb, 'ewkb'); // We now a full geoPHP Geometry object

            //$output[] = pg_escape_bytea($geom->out('ewkb'));
            //$output[]['geom'] = pg_escape_bytea($geom->out('geojson'));
            $feature = array();
            $feature['id'] = $item->id;
            $feature['geom'] = (array)json_decode($item->geom);
            $feature['shape_area'] = $item->shape_area;
            $feature['cod_barrio'] = $item->cod_barrio;
            $feature['nombre'] = $item->nombre;
            $output_epriorizado[] = $feature;
        }

        // $result = $this->ep->get_entries();

        // $output_ep = array();

        // foreach ($result as $item) {

        //     $feature = array();
        //     $feature['id'] = $item->id;
        //     $feature['geom'] = (array)json_decode($item->geom);
        //     $feature['fuente'] = $item->fuente;
        //     $feature['categoria'] = $item->categoria;
        //     $feature['nombre'] = $item->nombre;
        //     $output_ep[] = $feature;
        // }

        $this->load->view( 'eppriorizado_layer_json', 
            array(
                    'geojsonepriorizado' => $this->convertToGeojson($output_epriorizado),
                    // 'geojsonep' => $this->convertToGeojson($output_ep),
            ) 
        );
    }

    function get_ep_rows(){
        //load the model
        $this->load->model('Ep_model', 'ep');

        $coor = $this->input->post('coor', TRUE);

        //get the rows from ep
        $result = $this->ep->get_entries($coor['lng'], $coor['lat'], 1000);

        $output_ep = array();
        //echo "<pre>"; print_r($result); echo "</pre>"; 
        foreach ($result as $item) {

            $feature = array();
            $feature['id'] = $item->id;
            $feature['geom'] = (array)json_decode($item->geom);
            $feature['fuente'] = $item->fuente;
            $feature['categoria'] = $item->categoria;
            $feature['nombre'] = $item->nombre;
            $output_ep[] = $feature;
        }

        $output = array(
            'success'   => true,
            'data'      => array(
                'success'       => 'success', 
                'supplemental'  => $this->convertToGeojson($output_ep)
            ) 
        );

        $this->output->set_content_type('application/json')
             ->set_output( json_encode($output) );

        return;
    }

    public function convertToGeojson($coordinates){
        $result = array();
        $result["type"] = "FeatureCollection";
        $result["features"] = array();
        $idx_row = 0;

        foreach ($coordinates as $coordinate) {

            $result["features"][$idx_row] = array(
                "type" => "Feature", 
                "id" => $coordinate['id'], 
                "properties" => array(), 
                "geometry" => $coordinate['geom']
            );

            foreach($coordinate as $column => $value){

                    $result["features"][$idx_row]["properties"][$column] = $value;
            }
            $idx_row++;
        }
        return $result;
    }
}