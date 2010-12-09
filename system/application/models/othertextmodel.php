<?php
class Othertextmodel extends Model{
	
	var $otid 		= 0;
	var $otuid 		= '';
	var $ottext 	= '';
	var $ottitle 	= '';
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
	
	function read_record($type,$uid){
		
		$this->db->select('ottitle AS title, ottext AS text');
		$this->db->where('ottype',$type);
		$this->db->where('otuid',$uid);
		$query = $this->db->get('othertext',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function insert_record($text,$title,$type,$uid){
		
		$this->otuid 	= $uid;
		$this->ottext 	= strip_tags($text,'<br>'); 
		$this->ottitle 	= strip_tags($title); 
		$this->ottype 	= $type;
		$this->db->insert('othertext',$this);
	}
	
	function update_record($text,$title,$type,$uid){
		
		$this->db->set('ottext',strip_tags($text,'<br>')); 
		$this->db->set('ottitle',strip_tags($title)); 
		$this->db->where('otuid',$uid);
		$this->db->where('ottype',$type);
		$this->db->update('othertext');
	}
}
?>