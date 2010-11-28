<?php
class Othertextmodel extends Model{
	
	var $otid 		= 0;
	var $otuid 		= '';
	var $ottext 		= '';
	var $ottype 	= '';
	
	function Othertextmodel(){
		
		parent::Model();
	}
	
	function read_text($type,$uid){
		
		$this->db->where('ottype',$type);
		$this->db->where('otuid',$uid);
		$query = $this->db->get('othertext',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0]['ottext'];
		return NULL;
	}
	
	function insert_record($text,$type,$uid){
		
		$this->otuid 	= $uid;
		$this->ottext 	= $text; 
		$this->ottype 	= $type;
		$this->db->insert('othertext',$this);
	}
	
	function update_record($text,$type,$uid){
		
		$this->db->set('ottext',strip_tags($text,'<br>')); 
		$this->db->where('otuid',$uid);
		$this->db->where('ottype',$type);
		$this->db->update('othertext');
	}
}
?>