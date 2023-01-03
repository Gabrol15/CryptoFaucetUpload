<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class File extends CI_Model{ 

    public function getRows(){ 
		return $this->db->query("SELECT  * FROM files ORDER BY id ASC")->result_array();
    } 
     
    public function insert($data = array()){ 
        $this->db->insert_batch('files',$data); 
    } 

    public function getOptions()
    {
        return $this->db->get('type_dokumen')->result_array();
    }

    public function delete($id){
    	$this->db->delete('files', ['id' => $id]);
    }
}