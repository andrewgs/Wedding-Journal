<?php
	class Imagesmodel extends Model{
	
		var $img_id 		= 0;
		var $img_src 		= '';
		var $img_title 		= '';
		var $img_uid 		= 0;
		var $img_album		= 0;
		var $img_thumb		= 0;
		var $img_slideshow 	= 1;
		var $img_cmnt 		= 0;
		 
		function Imagesmodel(){			
			
			parent::Model();
		}
		
		function insert_record($data,$uid){
			
			$this->img_src 		= $data['file'];
			$this->img_title 	= $data['imagetitle'];
			$this->img_uid 		= $uid;
			$this->img_album 	= $data['album'];
			$this->img_thumb 	= $data['thumb'];
			
			$this->db->insert('images', $this);
		}
		
		function get_images($album,$uid){
		
			$this->db->where('img_album',$album);
			$this->db->where('img_uid',$uid);
			$query = $this->db->get('images');
			return $query->result_array();
		}

		function read_record($id,$uid){
			
			$this->db->select('img_id AS id,img_src AS src,img_title AS title,img_album AS album');
			$this->db->where('img_id',$id);
			$this->db->where('img_uid',$uid);
			$query = $this->db->get('images',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}

		function insert_comments($id,$uid){
		
			$this->db->set('img_cmnt','img_cmnt+1',FALSE);
			$this->db->where('img_id',$id);
			$this->db->where('img_uid',$uid);
			$this->db->update('images');
		}
		
		function delete_comments($id,$uid){
		
			$this->db->set('img_cmnt','img_cmnt-1',FALSE);
			$this->db->where('img_id',$id);
			$this->db->where('img_uid',$uid);
			$this->db->update('images');
		}
		
		function count_records($userid){
		
			$this->db->select('count(*) as cnt');
			$this->db->where('img_uid',$userid);
			$query = $this->db->get('images');
			$data = $query->result_array();
			return $data[0]['cnt'];
		}
		
		function get_names($album,$uid){
		
			$this->db->select('img_id AS id,img_src AS src');
			$this->db->where('img_album',$album);
			$this->db->where('img_uid',$uid);
			$query = $this->db->get('images');
			return $query->result_array();
		}
		
		function get_album($id,$uid){
		
			$this->db->where('img_id',$id);
			$this->db->where('img_uid',$uid);
			$query = $this->db->get('images');
			$data = $query->result_array();
			return $data[0]['img_album'];
		}
		
		function get_image($id){
			
			$this->db->where('img_id',$id);
			$query = $this->db->get('images');
			$data = $query->result_array();
			return $data[0]['img_thumb'];
		}
				
		function image_delete($id,$uid){
		
			$this->db->where('img_id',$id);
			$this->db->where('img_uid',$uid);
			$this->db->delete('images');
		}

		function images_delete($album,$uid){
		
			$this->db->where('img_album',$album);
			$this->db->where('img_uid',$uid);
			$this->db->delete('images');
		}
			
		function exist_image($id,$uid){
			
			$this->db->where('img_id',$id);
			$this->db->where('img_uid',$uid);
			$query = $this->db->get('images',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return FALSE;
		}

		function slideshow_status($id,$uid,$status){
			
			$this->db->set('img_slideshow',$status,FALSE);
			$this->db->where('img_id',$id);
			$this->db->where('img_uid',$uid);
			$this->db->update('images');
			return $status;
		}
		
		function slideshow_images($uid,$status){
			
			$this->db->select('img_id AS id,img_src AS src, img_title AS title');
			$this->db->where('img_uid',$uid);
			$this->db->where('img_slideshow',$status);
			$query = $this->db->get('images');
			return $query->result_array();
		}
	}
?>