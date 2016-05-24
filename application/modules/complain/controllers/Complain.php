<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Complain extends CI_Controller {

    function __construct(){
        parent::__construct();
        // $this->load->model('Queja_model', 'queja');
        // $this->load->model('Anexosep_model', 'anexos');
    }

    public function index()
    {
        $this->load->view('complain_json');
    }

    public function get(){        

        $this->load->model('Anexosep_model', 'anexos');
        $this->load->model('Queja_model', 'queja');

        $ep_id  = $this->input->post('ep_id');

        $queja  = $this->queja->where('frips =', $ep_id)->get();

        if(isset($queja->id) && $queja->id > 0){
            $anexos = $this->anexos->where('queja_id =', $queja->id)->get_all();
        }else{
            $anexos = null;
        }
        
        $result = array('anexos' => $anexos, 'queja' => $queja);

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

    public function get_list($quejas){

        $this->load->view( '_list_complain',

           array(
               'quejas' => $quejas,
           )
       );
    }

    public function get_form_register($parameters){

        $this->load->view( '_form_register',

           array(
               'parameters' => $parameters,
           )
       );
    }

    public function create(){
        
        $this->load->library('session');
        $this->load->model('Queja_model', 'queja');

        $session_data = $this->session->userdata();
        $user_id = $session_data['__ci_last_regenerate'];

        $queja_id           = $this->input->post('recipient-queja-id');
        $ep_id              = $this->input->post('recipient-ref-ep-id');
        $solicitante        = $this->input->post('recipient-name');
        $solicitante_email  = $this->input->post('recipient-email');
        $fecha_radicado     = date('Y-m-d H:i:s');
        $radicado           = uniqid().time();
        $comentario         = $this->input->post('recipient-message-text');
        $tipoep_id          = $this->input->post('recipient-tipoep-id');;
        $ip                 = $this->input->ip_address();

        $data[] = array(
            'solicitante'       => $solicitante, 
            'solicitante_email' => $solicitante_email, 
            'fecha'             => $fecha_radicado, 
            'radicado'          => $radicado, 
            'frips'             => $ep_id, 
            'comentario'        => $comentario, 
            'ip'                => $ip, 
            'tipoep_id'         => $tipoep_id, 
            'estado_id'         => 1, 
        );

        if($queja_id > 0){
            unset($data[0]['fecha']);
            unset($data[0]['radicado']);
            $data[0]['id'] = $queja_id;
            
            $new_queja = $this->queja->update($data[0], $queja_id);
        }else{
            $new_queja = $this->queja->insert($data);
        }
        

        $data_uploaded = $this->_upload($user_id, $new_queja);

        $output = array(
            'success'   => true,
            'data'      => array(
                'success'       => 'success', 
                'supplemental'  => array('files' => $_FILES, 'user_id' => $user_id, 'data_uploaded' => $data_uploaded)
            ) 
        );

        /*$this->output->set_content_type('application/json')
             ->set_output( json_encode($output) );*/


        redirect('public/index.php/geo/get_layers', 'refresh');

        return ;
    }

    public function _upload($user_id, $new_queja){
        if($this->input->post() && count($new_queja) > 0) {
            $this->load->model('Anexosep_model', 'anexos');

            // retrieve the number of images uploaded;
            $number_of_files = sizeof($_FILES['recipient-uploadedimages']['tmp_name']);

            // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
            $files = $_FILES['recipient-uploadedimages'];
         
            
            $errors = array();
         
            // first make sure that there is no error in uploading the files
            for($i=0;$i<$number_of_files;$i++){
                if($_FILES['recipient-uploadedimages']['error'][$i] != 0) {
                    $errors[$i][] = 'Couldn\'t upload file '.$_FILES['recipient-uploadedimages']['name'][$i];
                }
            }

            $data_anexos_ep = array();
            $data = array();

            if(sizeof($errors)==0 && $number_of_files > 0) {
                //set preferences
                $config['remove_spaces']    = TRUE;
                $config['encrypt_name']     = TRUE; // for encrypting the name
                $config['allowed_types']    = 'gif|jpg|png|pdf';
                $config['max_size']         = '78000';
                // next we pass the upload path for the images
                $config['upload_path']      = APPPATH.'/../upload/';

                // now, taking into account that there can be more than one file, for each file we will have to do the upload
                // we first load the upload library
                $this->load->library('upload');
                
                // also, we make sure we allow only certain type of images
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                for ($i = 0; $i < $number_of_files; $i++) {
                    $_FILES['uploadedimage']['name'] = $files['name'][$i];
                    $_FILES['uploadedimage']['type'] = $files['type'][$i];
                    $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['uploadedimage']['error'] = $files['error'][$i];
                    $_FILES['uploadedimage']['size'] = $files['size'][$i];
                    //now we initialize the upload library
                    $this->upload->initialize($config);
                    // we retrieve the number of files that were uploaded
                    if ($this->upload->do_upload('uploadedimage')) {
                        $data['uploads'][$i] = $this->upload->data();

                        //now creating thumbnails
                        $config_thumb = array(
                            'source_image'      => $data['uploads'][$i]['full_path'],
                            'create_thumb'      => true,
                            'overwrite'         => true,
                            'maintain_ratio'    => true,
                            'new_image'         => APPPATH . '/../upload/thumbnails/',
                            'thumb_marker'      => '',
                            'maintain_ratio'    => true,
                            'width'             => 128,
                            'height'            => 128
                        );

                        $this->load->library('image_lib');
                        $this->image_lib->initialize($config_thumb);
                        $this->image_lib->resize();

                        if ( ! $this->image_lib->resize()){
                            $data['upload_errors'][$i] = $this->image_lib->display_errors();
                        }
                        $data_anexos_ep[] = array(
                            // 'ref_ep_id' => $ep_id, 
                            'user_id'   => $user_id,
                            'queja_id'  => $new_queja[0],
                            'file_path' => $data['uploads'][$i]['file_name'],
                            // 'tipoep_id' => 1,
                            'fechaactualizacion'    => date('Y-m-d H:i:s', time()),
                            'fechacreacion'         => date('Y-m-d H:i:s', time()),
                        );
                        $this->image_lib->clear();
                    } else {
                        $data['upload_errors'][$i] = $this->upload->display_errors();
                    }
                }

                if(isset($data['upload_errors']) && count($data['upload_errors']) > 0){

                    $this->session->set_flashdata('success_msg', '<div class="alert alert-success text-center">Your file <strong>' . '</strong> was NOT uploaded!</div>');
                }
                else{
                    
                    $this->anexos->insert($data_anexos_ep); 
                    $this->session->set_flashdata('success_msg', '<div class="alert alert-success text-center">Your file <strong>' . '</strong> was successfully uploaded!</div>');
                }
            }
        } else {
            print_r($errors);
        }

        return $data;
    }
}