<?php
class Albummodel extends Model{
		
	var $alb_id 			= 0;
	var $alb_title 			= '';
	var $alb_annotation 	= '';
	var $alb_amt 			= 0;
	var $alb_photo 			= '';
	var $alb_photo_title 	= '';
	var $alb_uid 			= 0;
	
	function Albummodel(){
		
		parent::Model();
	}
	
	function albums_records($uid){
	
		$this->db->where('alb_uid',$uid);
		$this->db->order_by('alb_id desc');
		$query = $this->db->get('albums');
		return $query->result_array();
	}
	
	function get_image($album_id){
		
		$this->db->where('alb_id',$album_id);
		$this->db->select('alb_photo');
		$query = $this->db->get('albums');
		$data = $query->result_array();
		return $data[0]['alb_photo'];
	}
	
	function album_record($album_id){
	
		$this->db->where('alb_id',$album_id);
		$query = $this->db->get('albums',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function insert_photo($id){
		$this->db->set('alb_amt','alb_amt+1', FALSE);
		$this->db->where('alb_id',$id);
		$this->db->update('albums');
	}
	
	function delete_photo($id){
		$this->db->set('alb_amt','alb_amt-1',FALSE);
		$this->db->where('alb_id',$id);
		$this->db->update('albums');
	}
		
	function insert_record($data){
		
		$this->alb_title 		= $data['title'];
		$this->alb_amt 			= 0;
		$this->alb_annotation 	= $data['annotation'];
		$this->alb_photo 		= $data['image'];
		$this->alb_photo_title 	= $data['photo_title'];
		
		if (mb_strlen($this->alb_annotation,'UTF-8') > 125)
			$this->alb_annotation = mb_substr($this->alb_annotation,0,125,'UTF-8');
			
		$this->db->insert('albums',$this);
	}
	
	function delete_record($album_id){
		
		$this->db->delete('albums',array('alb_id'=>$album_id));
	}
	
	function update_record($data){
	
		$this->alb_id 			= $data['id'];
		$this->alb_title 		= $data['title'];
		$this->alb_amt 			= $data['amt'];
		$this->alb_annotation 	= $data['annotation'];
		$this->alb_photo 		= $data['image'];
		$this->alb_photo_title 	= $data['photo_title'];
		
		if (mb_strlen($this->alb_annotation,'UTF-8') > 125)
			$this->alb_annotation = mb_substr($this->alb_annotation,0,125,'UTF-8');
		
		$this->db->where('alb_id',$this->alb_id);
		$this->db->update('albums',$this);	
	}
}
?>