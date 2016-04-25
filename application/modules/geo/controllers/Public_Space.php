<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Public_Space extends CI_Controller {
    public function index()
    {
        $this->load->view('public_space_index');
    }

    public function create_ep_nuevo(){
        $layers = $this->input->post('layers', TRUE);
        $this->load->model('Epnuevo_model', 'epnuevo');   

        foreach ($layers as $layer) {
           $result = $this->epnuevo->new_entries($layer);
           
        }        

        $output = array(
            'success'   => true,
            'data'      => array(
                'success'       => 'success', 
                'supplemental'  => $result
            ) 
        );

        $this->output->set_content_type('application/json')
             ->set_output( json_encode($output) );

        return;
    }

    public function get_eptrabajo_layers() { 

       
       $this->load->model('Barrio_model', 'Barrio');              
       $result = $this->Barrio->get_entries();    
       $output_barrios = array();
             
       foreach ($result as $item) { 

            $feature = array();
            //$feature['id'] = $item->id;
            $feature['id'] = $item->id;
            $feature['the_geom'] = (array)json_decode($item->geom);
            $feature['nombre'] = $item->nombre;
            $feature['fidcomuna'] = $item->comuna;
            $feature['estra_moda'] = $item->estrato;
            $feature['area'] = $item->area;
            $feature['perimetro'] = $item->perimetro;
            $feature['color'] = '#838685';
            $feature['border_color'] = '#181A19';
            $output_barrios[] = $feature;
            
       }

       $this->load->model('Comuna_model', 'Comuna');
       $result = $this->Comuna->get_entries();
       $output_comunas = array();

       foreach ($result as $item) {

            $feature = array();
            $feature['id'] = $item->id;
            $feature['the_geom'] = (array)json_decode($item->geom);
            $feature['nombre'] = $item->nombre;
            $feature['area'] = $item->area;
            $feature['perimetro'] = $item->perimetro;
            $feature['comuna'] = $item->comuna;
            $feature['color'] = '#006633';
            $feature['outline_style'] = 'solid';
            $feature['border_color'] = '#006633';
            $output_comunas[] = $feature;
       }


        $this->load->model('Eppropuesto_model', 'eppropuesto'); 
        $result = $this->eppropuesto->get_entries();
        $output_epropuesto = array();
        
        foreach ($result as $item) {            

            $feature = array();
            $feature['id'] = $item->id;
            $feature['the_geom'] = (array)json_decode($item->the_geom);
            $feature['comuna'] = $item->comuna;
            $feature['actualizacion'] = $item->fechaactualizacion;
            $feature['creacion'] = $item->fechacreacion;
            $feature['shape_area'] = $item->shape_area;
            $feature['id_tipo'] = $item->idtipo;
            $feature['tipo'] = $item->tipo;
            $feature['nombre'] = $item->nombre;
            $feature['color'] = '#E2A11E';
            $feature['outline_style'] = 'solid';
            $feature['border_color'] = '#A87000';
            $output_epropuesto[] = $feature;

            
        }


        $this->load->model('Eppriorizado_model', 'eppriorizado');     
        $result = $this->eppriorizado->get_entries();
        $output_epriorizado = array();


        foreach ($result as $item) {            

            $feature = array();
            $feature['id'] = $item->id;
            $feature['the_geom'] = (array)json_decode($item->the_geom);
            $feature['comuna'] = $item->comuna;
            $feature['actualizacion'] = $item->fechaactualizacion;
            $feature['creacion'] = $item->fechacreacion;
            $feature['barrio'] = $item->barrio;
            $feature['shape_area'] = $item->shape_area;
            $feature['id_tipo'] = $item->idtipo;
            $feature['nombre'] = $item->nombre;
            $feature['color'] = '#CC0000';
            $feature['outline_style'] = 'solid';
            $feature['border_color'] = '#CC0000';
            $output_epriorizado[] = $feature;
        }

        $this->load->model('Epnuevo_model', 'epnuevo');   
        $result = $this->epnuevo->get_entries();
        $output_epnuevos = array();


        foreach ($result as $item) {            

            $feature = array();
            $feature['id'] = $item->id;
            $feature['the_geom'] = (array)json_decode($item->the_geom);
            $feature['shape_area'] = $item->area;
            $feature['barrio'] = $item->barrio;
            $feature['actualizacion'] = $item->fechaactualizacion;
            $feature['creacion'] = $item->fechacreacion;   
            $feature['id_tipo'] = $item->idtipo;
            $feature['color'] = '#7F00FF';
            $feature['outline_style'] = 'solid';
            $feature['border_color'] = '#7F00FF';
            $output_epnuevos[] = $feature;

        }
        
               
       $this->load->view( 'eppriorizado_layer_json',

           array(
               
               'geojsoncomuna' => $this->convertToGeojson($output_comunas),
               'geojsonbarrio' => $this->convertToGeojson($output_barrios),
               'geojsonepriorizado' => $this->convertToGeojson($output_epriorizado),
               'geojsonepropuesto' => $this->convertToGeojson($output_epropuesto),
               'geojsonepnuevo' => $this->convertToGeojson($output_epnuevos),
               
           )
       );

   
    }


    function get_ep_rows(){
        //load the model
        $this->load->model('Ep_model', 'ep');
        $bounds = $this->input->post('bounds', TRUE);
        //get the rows from ep
        /*$result = $this->ep->get_entries($coor['lng'], $coor['lat'], 3000);*/
        $result = $this->ep->get_entries_by_bounds($bounds);

        $output_ep = array();
        //echo "<pre>"; print_r($result); echo "</pre>"; 
        foreach ($result as $item) {

            $feature = array();
            $feature['id'] = $item->id;
            $feature['the_geom'] = (array)json_decode($item->geom);
            $feature['fuente'] = $item->fuente;
            $feature['categoria'] = $item->categoria;
            $feature['nombre'] = $item->nombre;
            $feature['escala'] = $item->escala;
            $feature['shape_area'] = $item->shape_area;
            $feature['creacion'] = $item->fechacreacion;
            $feature['actualizacion'] = $item->fechaactualizacion;
            $feature['id_tipo'] = $item->idtipo;
            $feature['comuna'] = $item->comuna;
            $feature['barrio'] = $item->barrio;
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
                "geometry" => $coordinate['the_geom']
            );

            foreach($coordinate as $column => $value){

                    $result["features"][$idx_row]["properties"][$column] = $value;
            }
            $idx_row++;
        }
        return $result;
    }

}