<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Public_Space extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('public_space_index');
    }

    public function view_ep(){
      $ep_id = $this->input->post('ep_id', TRUE);
      $tipoep_id = $this->input->post('tipoep_id', TRUE);

      $result = false;

      if($tipoep_id == 4){// ep nuevo
        $this->load->model('Epnuevo_model', 'epnuevo');
        $result = $epnuevo->get_entry($ep_id);
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

    public function create_ep(){
      $this->load->library('session');
      $session_data = $this->session->userdata();
      $user_id = $session_data['__ci_last_regenerate'];

      $layers = $this->input->post('layers', TRUE);
      $this->load->model('Epnuevo_model', 'epnuevo');
      $result = array();
      foreach ($layers as $layer) {
        $result = $this->epnuevo->new_entries($layer, $user_id);
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

    public function get_ep_row(){
      $ep_id = $this->input->get_post('ep_id', TRUE);
      $tipoep_id = $this->input->get_post('tipoep_id', TRUE);
      $this->load->model('Ep_model', 'ep');
      $this->load->model('Epnuevo_model', 'epnuevo');
      $this->load->model('complain/Queja_model', 'queja');
      $this->load->model('complain/Anexosep_model', 'anexos');

      if($tipoep_id == 1)
        $result = $this->ep->get_entry_by_id_with_centroid($ep_id);

      if($tipoep_id == 4)
        $result = $this->epnuevo->get_entry_by_id_with_centroid($ep_id);

      $output_ep = array();

      foreach ($result as $item) {
        $feature = array();
        $feature['id'] = $item->id;
        $feature['the_geom'] = (array)json_decode($item->geom);
        $feature['centroid'] = (array)json_decode($item->centroid);

        if($tipoep_id == 1){
          $feature['fuente'] = $item->fuente;
          $feature['categoria'] = $item->categoria;
          $feature['nombre'] = $item->nombre;  
        }

        if($tipoep_id == 4){
          $feature['shape_area'] = $item->shape_area;
          $feature['barrio'] = $item->barrio;
          $feature['barrio_nombre'] = $item->barrio_nombre;
          $feature['comuna_nombre'] = $item->comuna_nombre;
        }
        
        $feature['id_tipo'] = $item->idtipo;

        $queja  = $this->queja->where(array('frips =' =>  $ep_id, 'tipoep_id' => $tipoep_id ))->get_all();  

        foreach ($queja as &$item) {
          $anexos = $this->anexos->where('queja_id =', $item->id)->get_all();
          $item->anexos = $anexos;
        }

        $feature['quejas'] = $queja;

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

      $this->load->helper('text');
      // $this->load->library('ion_auth');
      $base_url_uploads = 'http://localhost/~vichugof/sigep/upload/';
      $base_url = base_url();
      $this->load->model('Barrio_model', 'Barrio');
      $this->load->model('Comuna_model', 'Comuna');
       
     
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

      $this->load->model('complain/Queja_model', 'queja');
      $quejas = $this->queja->order_by('fechacreacion', 'ASC')->get_all();

      $this->load->view( 'eppriorizado_layer_json',

        array(
          'geojsonepriorizado' => $this->convertToGeojson($output_epriorizado),
          'geojsoncomuna'      => $this->convertToGeojson($output_comunas),
          'geojsonbarrio'      => $this->convertToGeojson($output_barrios),
          'quejas'             => $quejas,
          'base_url_uploads'   => $base_url_uploads,
          'base_url'           => $base_url
        )
      );
   }

    function get_ep_rows(){
      //load the model
      $this->load->model('Ep_model', 'ep');
      $bounds = $this->input->post('bounds', TRUE);
      //get the rows from ep
      $result = $this->ep->get_entries_by_bounds($bounds);
      $output_ep = array();
      
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

    function get_ep_new_rows(){
      //load the model
      $this->load->model('Epnuevo_model', 'epnuevo');

      $this->load->library('session');
      $session_data = $this->session->userdata();
      $user_id = $session_data['__ci_last_regenerate'];
      //get the rows from ep
      $result = $this->epnuevo->get_entries($user_id);
      $output_epnuevo = array();
      
      foreach ($result as $item) {
        $feature = array();
        $feature['id'] = $item->id;
        $feature['the_geom'] = (array)json_decode($item->geom);
        $feature['shape_area'] = $item->area;
        $feature['creacion'] = $item->fechacreacion;
        $feature['actualizacion'] = $item->fechaactualizacion;
        $feature['id_tipo'] = $item->idtipo;
        $feature['comuna_nombre'] = $item->comuna_nombre;
        $feature['barrio_nombre'] = $item->barrio_nombre;
        $feature['barrio'] = $item->barrio;
        $output_epnuevo[] = $feature;
      }
      $output = array(
          'success'   => true,
          'data'      => array(
              'success'       => 'success', 
              'supplemental'  => $this->convertToGeojson($output_epnuevo)
          ) 
      );

      $this->output->set_content_type('application/json')
           ->set_output( json_encode($output) );
      return;
    }

    public function pass_to_new_ep(){
      $recipient  = $this->input->post('recipient', TRUE);
      $new_ep_id  = $recipient['ref-ep-id'];
      $tipoep_id  = $recipient['tipoep-id'];
      $escala     = $recipient['escala'];
      $categoria  = $recipient['categoria'];

      $this->load->model('Epnuevo_model', 'epnuevo');
      $this->load->model('Ep_model', 'ep');

      //get the rows from ep
      $retrieved_new_ep = $this->epnuevo->get_entry($new_ep_id);

      $ep_id = $this->epnuevo->transforma_ep($retrieved_new_ep[0]->id, $categoria, $escala);

      $result = $this->ep->get_entry_by_id_with_centroid($ep_id);

      $output_trans_ep = array();
      
      foreach ($result as $item) {
        $feature = array();
        $feature['id'] = $item->id;
        $feature['the_geom'] = (array)json_decode($item->geom);
        $feature['centroid'] = (array)json_decode($item->centroid);
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
        $output_trans_ep[] = $feature;
      }

      $output = array(
          'success'   => true,
          'data'      => array(
              'success'       => 'success', 
              'supplemental'  => $this->convertToGeojson($output_trans_ep),
          ) 
      );

      $this->output->set_content_type('application/json')
           ->set_output( json_encode($output) );
      return;
    }

    public function get_main_view($parameters){
      $this->load->view( '_main_view',
            array(
              'parameters' => $parameters,
            )
      );
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