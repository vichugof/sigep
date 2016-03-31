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
            // $feature['cod_barrio'] = $item->cod_barrio;
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

    public function get_eptrabajo_layers(){

       
       $this->load->model('Barrio_model', 'Barrio');
       $this->load->model('Comuna_model', 'Comuna');
       
     
       $result = $this->Barrio->get_entries();    
       $output_barrios = array();
             
       foreach ($result as $item) {

            $feature = array();
            $feature['id'] = $item->id;
            $feature['fidbarrio'] = $item->id;
            $feature['geom'] = (array)json_decode($item->geom);
            // $feature['the_geom'] = (array)json_decode($item->geom);
            $feature['nombre'] = $item->nom_barrio;
            $feature['fidcomuna'] = $item->comuna;
            $feature['estra_moda'] = $item->estrato;
            $feature['area'] = $item->area;
            $feature['perimetro'] = $item->perimetro;
            $feature['color'] = '#DEF7B8';
            $output_barrios[] = $feature;
            $feature['border_color'] = '#58FAF4';
       }

       $result = $this->Comuna->get_entries();
       $output_comunas = array();

       foreach ($result as $item) {

            $feature = array();
            $feature['id'] = $item->id;
            $feature['fidcomuna'] = $item->id;
            $feature['geom'] = (array)json_decode($item->geom);
            // $feature['the_geom'] = (array)json_decode($item->geom);
            $feature['nombre'] = $item->nombre;
            $feature['area'] = $item->area;
            $feature['perimetro'] = $item->perimetro;
            $feature['comuna'] = $item->comuna;
            // $feature['color'] = '#58FAF4';
            $feature['outline_style'] = 'solid';
            $feature['border_color'] = '#58FAF4';
           
            $output_comunas[] = $feature;
       }

        $this->load->model('Eppriorizado_model', 'eppriorizado');
        
        $result = $this->eppriorizado->get_entries();

        $output_epriorizado = array();

        foreach ($result as $item) {

            $feature = array();
            $feature['id'] = $item->id;
            $feature['geom'] = (array)json_decode($item->geom);
            $feature['shape_area'] = $item->shape_area;
            $feature['nombre'] = $item->nombre;
            $output_epriorizado[] = $feature;
        }

       $this->load->view( 'eppriorizado_layer_json',

           array(
               'geojsonepriorizado' => $this->convertToGeojson($output_epriorizado),
               'geojsoncomuna' => $this->convertToGeojson($output_comunas),
               'geojsonbarrio' => $this->convertToGeojson($output_barrios)
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