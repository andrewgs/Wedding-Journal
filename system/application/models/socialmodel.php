<?php
	class Socialmodel extends Model{
		
		var $soc_id = 0;
		var $soc_fr_id = 0;
		var $soc_name = '';
		var $soc_href = '';
		
		function Socialmodel(){
			
			parent::Model();
		}
		
		function social_records(){
			
			$this->db->order_by('soc_id asc');
			$query = $this->db->get('social');
			return $query->result_array();
		}
		
		function friend_social($id){
			
			$this->db->where('soc_fr_id',$id);
			$query = $this->db->get('social',2);
			return $query->result_array();
		}
		
		function insert_record($data){
		
			$this->soc_fr_id 	= $data['friend_id'];
			$this->soc_name 	= $data['social'];
			$this->soc_href 	= $data['href'];
			
			$this->db->insert('social',$this);
		}
	
		function delete_records($id){
			
			$this->db->delete('social',array('soc_fr_id'=> $id));
		}
	}
?>