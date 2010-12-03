<?php
	class Unionmodel extends Model{
		
		function Unionmodel(){
		
			parent::Model();
		}
		
		function select_events($cntday,$count,$from,$uid){
			
			$datesub = 'DATE_SUB(CURDATE(),INTERVAL '.$cntday.' DAY)';
			
			$this->db->select('comments.*,events.evnt_title,events.evnt_date',FALSE);
			$this->db->from('comments');
			$this->db->join('events', 'events.evnt_id = comments.cmnt_evnt_id','inner');
			$this->db->where('cmnt_usr_date >=',$datesub,FALSE);
			$this->db->where('cmnt_usr_date <=',"CURDATE()",FALSE);
			$this->db->where('evnt_uid',$uid);
			$this->db->limit($count,$from);
			$this->db->order_by('cmnt_usr_date desc, cmnt_id desc');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		function select_images($cntday,$count,$from,$uid){
			
			$datesub = 'DATE_SUB(CURDATE(),INTERVAL '.$cntday.' DAY)';
			
			$this->db->select('comments.*,images.img_id,images.img_src',FALSE);
			$this->db->from('comments');
			$this->db->join('images', 'images.img_id = comments.cmnt_img_id','inner');
			$this->db->where('cmnt_usr_date >=',$datesub,FALSE);
			$this->db->where('cmnt_usr_date <=',"CURDATE()",FALSE);
			$this->db->where('img_uid',$uid);
			$this->db->limit($count,$from);
			$this->db->order_by('cmnt_usr_date desc, cmnt_id desc');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		function count_events($cntday,$uid){
			
			$datesub = 'DATE_SUB(CURDATE(),INTERVAL '.$cntday.' DAY)';
			
			$this->db->select('comments.*,events.*',FALSE);
			$this->db->from('comments');
			$this->db->join('events','events.evnt_id = comments.cmnt_evnt_id','inner');
			$this->db->where('cmnt_usr_date >=',$datesub,FALSE);
			$this->db->where('cmnt_usr_date <=',"CURDATE()",FALSE);
			$this->db->where('evnt_uid',$uid);
			return $this->db->count_all_results();
		}
		
		function count_images($cntday,$uid){
			
			$datesub = 'DATE_SUB(CURDATE(),INTERVAL '.$cntday.' DAY)';
			
			$this->db->select('comments.cmnt_id,images.img_id',FALSE);
			$this->db->from('comments');
			$this->db->join('images','images.img_id = comments.cmnt_img_id','inner');
			$this->db->where('cmnt_usr_date >=',$datesub,FALSE);
			$this->db->where('cmnt_usr_date <=',"CURDATE()",FALSE);
			$this->db->where('img_uid',$uid);
			return $this->db->count_all_results();
		}
	}
?>