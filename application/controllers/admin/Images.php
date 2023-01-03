<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Images extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->model('file');
    }

    public function index()
    {
        $this->data['page'] = 'Image settings';
        $this->data['files'] = $this->file->getRows(); 
		$this->data['options'] = $this->file->getOptions();
        $this->render('images', $this->data);
    }

    public function submit()
    {
        $type = $this->input->post('type');
            if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
                $filesCount = count($_FILES['files']['name']); 
                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                     
if (!is_dir('assets/upload/'.$type)) {
     mkdir('./assets/upload/'.$type, 0777, TRUE);
 }
          $config['upload_path'] = 'assets/upload/'.$type; 
                    $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                    $config['maintain_ratio'] = TRUE;
		            $config['encrypt_name']	= TRUE;
                    $this->load->library('upload', $config); 
                    $this->upload->initialize($config); 
                     
                    if($this->upload->do_upload('file')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $uploadData[$i]['type'] = $type;
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                    $insert = $this->file->insert($uploadData); 
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/'.$type.'/'.$fileData['file_name']; // missing slash before name
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '50%';
                    if($type == 'favicon') {
                    $config['width']= 64;
                    $config['height']= 64;
                    }else if($type == 'hero_image') {
                    $config['width']= 1920;
                    $config['height']= 1053;
                    }else if($type == 'logo') {
                    $config['width']= 500;
                    $config['height']= 500;
                    }
                //$config['new_image'] = './assets/images/upload/' . $filename;
                $this->load->library('image_lib');
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
            $this->session->set_flashdata('sweet_message', faucet_sweet_alert('success', 'Upload success!'));
                    }else{  
            $this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'Upload failed!'));
                    } 
                } 
                 
            }else{ 
             $this->session->set_flashdata('sweet_message', faucet_sweet_alert('error', 'Mohon masukan gambar!'));
            } 

        redirect(site_url('admin/images'));
    }
    
    public function delete($id = '', $type = '', $filename = '')
    {
    unlink('assets/upload/'.$type.'/'.$filename);
     $this->file->delete($id);
        redirect(site_url('admin/images'));
    }
}
