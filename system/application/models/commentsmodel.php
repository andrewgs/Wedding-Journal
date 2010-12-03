<?php
	class Commentsmodel extends Model{
		
		var $cmnt_id 		= 0;
		var $cmnt_uid 		= 0;
		var $cmnt_evnt_id 	= 0;
		var $cmnt_album 	= 0;
		var $cmnt_img_id 	= 0;
		var $cmnt_usr_name 	= '';
		var $cmnt_usr_email = '';
		var $cmnt_web 		= '';
		var $cmnt_usr_date 	= '';
		var $cmnt_text 		= '';		
		
		function Commentsmodel(){
		
			parent::Model();
		}
		
		function comments_records($uid,$event_id,$image_id){
			
			$this->db->where('cmnt_uid',$uid);
			$this->db->where('cmnt_evnt_id',$event_id);
			$this->db->where('cmnt_img_id',$image_id);
			$this->db->order_by('cmnt_usr_date desc, cmnt_id desc');
			$query = $this->db->get('comments');
			return $query->result_array();			
		}
	
		function exist_comment($id,$event_id,$img_id){
		
			$this->db->where('cmnt_id',$id);
			$this->db->where('cmnt_evnt_id',$event_id);
			$this->db->where('cmnt_img_id',$img_id);
			$query = $this->db->get('comments',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return FALSE;
		}
		
		function comment_record($id){
			
			$this->db->where('cmnt_id',$id);
			$query = $this->db->get('comments',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}

		function comment_name($id,$uid){
			
			$this->db->where('cmnt_id',$id);
			$this->db->where('cmnt_uid',$uid);
			$query = $this->db->get('comments',1);
			$data = $query->result_array();
			return $data[0]['cmnt_usr_name'];
		}
		
		function insert_record($uid,$insertdata,$event_id,$album,$img_id){
			
			$this->cmnt_uid 		= $uid;
			$this->cmnt_evnt_id 	= $event_id;
			$this->cmnt_album 		= $album;
			$this->cmnt_img_id 		= $img_id;
			$this->cmnt_usr_name 	= $insertdata['user_name'];
			$this->cmnt_usr_email 	= $insertdata['user_email'];
			$this->cmnt_web 		= $insertdata['homepage'];
			$this->cmnt_usr_date 	= date("Y-m-d"); 
			$this->cmnt_text 		= strip_tags($insertdata['cmnt_text'],'<p> <br> <img>');
			$this->db->insert('comments',$this);
		}
		
		function delete_records($uid,$event_id,$img_id){
			
			$this->db->where('cmnt_uid',$uid);
			$this->db->where('cmnt_evnt_id',$event_id);
			$this->db->where('cmnt_img_id',$img_id);
			$this->db->delete('comments');
		}

		function delete_albums($uid,$album_id){
			
			$this->db->where('cmnt_uid',$uid);
			$this->db->where('cmnt_album',$album_id);
			$this->db->delete('comments');
		}
		
		function delete_record($comment_id,$uid){
			
			$this->db->where('cmnt_id',$comment_id);
			$this->db->where('cmnt_uid',$uid);
			$this->db->delete('comments');
		}
		
		function update_record($id,$uid,$event,$album,$img,$updatedata){
		
			$this->cmnt_id 			= $id;
			$this->cmnt_uid 		= $uid;
			$this->cmnt_evnt_id 	= $event;
			$this->cmnt_album	 	= $album;
			$this->cmnt_img_id 		= $img;
			$this->cmnt_usr_name 	= $updatedata['user_name'];
			$this->cmnt_usr_email 	= $updatedata['user_email'];
			$this->cmnt_web 		= $updatedata['homepage'];
			$this->cmnt_usr_date 	= $updatedata['user_date'];
			$this->cmnt_text 		= $updatedata['cmnt_text'];
			$this->db->where('cmnt_id',$this->cmnt_id);
			$this->db->update('comments',$this);
		}
	}
?>