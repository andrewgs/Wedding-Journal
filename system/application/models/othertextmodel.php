<?php
class Othertextmodel extends Model{
	
	var $otid 		= 0;
	var $otuid 		= '';
	var $otext 		= '';
	var $ottype 	= '';
	
	function Othertextmodel(){
		
		parent::Model();
	}
	
	function read_record($type){
		
		$this->db->where('ottype',$type);
		$query = $this->db->get('othertext',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function insert_record($insetrdata,$uid){
		
		$this->otuid 	= $uid;
		$this->otext 	= $insetrdata['text']; 
		$this->ottype 	= $insetrdata['type'];
		$this->db->insert('othertext',$this);
	}
}
?>