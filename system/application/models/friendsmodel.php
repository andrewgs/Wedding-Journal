<?php
	class Friendsmodel extends Model{
		
		var $fr_id 			= 0;
		var $fr_name 		= '';
		var $fr_profession 	= '';
		var $fr_social 		= '';
		var $fr_note 		= '';
		var $fr_image 		= '';
		var $fr_uid 		= 0;
		
		function Friendsmodel(){
			
			parent::Model();
		}
		
		function friends_records($uid){
		
			$this->db->where('fr_uid',$uid);
			$this->db->order_by('fr_id asc');
			$query = $this->db->get('friends');
			return $query->result_array();
		}
		
		function friend_record($id){
		
			$this->db->where('fr_id',$id);
			$query = $this->db->get('friends',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}
		
		function get_image($friend_id){
		
			$this->db->where('fr_id',$friend_id);
			$this->db->select('fr_image');
			$query = $this->db->get('friends');
			$data = $query->result_array();
			return $data[0]['fr_image'];
		}
		
		function insert_record($data){
			
			$this->fr_name 			= $data['name'];
			$this->fr_profession 	= $data['profession'];
			$this->fr_social 		= $data['social'];
			$this->fr_image 		= $data['image'];
			$this->fr_note 			= $data['note'];

			if (mb_strlen($this->fr_note,'UTF-8') > 245)
				$this->fr_note = mb_substr($this->fr_note,0,245,'UTF-8');	
			
			$this->db->insert('friends', $this);
			return $this->db->insert_id();
		}
		
		function delete_record($id){
			
			$this->db->delete('friends',array('fr_id'=>$id));
		}
		
		function update_record($data){
			
			$this->fr_id 			= $data['id'];
			$this->fr_name 			= $data['name'];
			$this->fr_profession 	= $data['profession'];
			$this->fr_social 		= $data['social'];
			$this->fr_note 			= $data['note'];
			$this->fr_image 		= $data['image'];
			
			if (mb_strlen($this->fr_note,'UTF-8') > 245)
				$this->fr_note = mb_substr($this->fr_note,0,245,'UTF-8');
			
			$this->db->where('fr_id',$this->fr_id);
			$this->db->update('friends',$this);
		}

		function reset_social($id){
			$this->db->set('fr_social',0,FALSE);
			$this->db->where('fr_id',$id);
			$this->db->update('friends');
		}
	}
?>