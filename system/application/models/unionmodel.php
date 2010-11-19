<?php
	class Unionmodel extends Model{
		
		function Unionmodel(){
		
			parent::Model();
		}
		
		function select_comments($cntday,$count,$from,$uid){
			
			$datesub = 'DATE_SUB(CURDATE(),INTERVAL '.$cntday.' DAY)';
			
			$this->db->select('comments.*,events.*',FALSE);
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
		
		function count_record($cntday,$uid){
			
			$datesub = 'DATE_SUB(CURDATE(),INTERVAL '.$cntday.' DAY)';
			
			$this->db->select('comments.*,events.*',FALSE);
			$this->db->from('comments');
			$this->db->join('events','events.evnt_id = comments.cmnt_evnt_id','inner');
			$this->db->where('cmnt_usr_date >=',$datesub,FALSE);
			$this->db->where('cmnt_usr_date <=',"CURDATE()",FALSE);
			$this->db->where('evnt_uid',$uid);
			return $this->db->count_all_results();
		}
	}
?>