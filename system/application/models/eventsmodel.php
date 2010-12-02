<?php
	class Eventsmodel extends Model{
		
		var $evnt_id 		= 0;
		var $evnt_title 	= '';
		var $evnt_text 		= '';
		var $evnt_date 		= '';
		var $evnt_cnt_cmnt 	= 0;
		var $evnt_uid		= 0;
		
		function Eventsmodel(){
			
			parent::Model();
		}
		
		function exist_event($id,$uid){
		
			$this->db->where('evnt_id',$id);
			$this->db->where('evnt_uid',$uid);
			$query = $this->db->get('events',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return FALSE;
		}
		
		function event_title($id,$uid){
			
			$this->db->where('evnt_id',$id);
			$this->db->where('evnt_uid',$uid);
			$query = $this->db->get('events');
			$data = $query->result_array();
			return $data[0]['evnt_title'];
		}
		
		function events_limit($uid,$count,$from){
		
			$this->db->where('evnt_uid',$uid);
			$this->db->limit($count,$from);
			$this->db->order_by('evnt_date desc,evnt_id desc');
			$query = $this->db->get('events');
			return $query->result_array();
		}
		
		function insert_record($data,$uid){
		
			$this->evnt_title 		= $data['title'];
			$this->evnt_date 		= $data['date']; 
			$this->evnt_text 		= $data['text'];
			$this->evnt_cnt_cmnt 	= 0;
			$this->evnt_uid			= $uid;
			$this->db->insert('events',$this);
		}
		
		function delete_record($id){
			
			$this->db->delete('events',array('evnt_id'=>$id));
		}		
	
		function update_record($data,$uid){
			
			$this->evnt_id 			= $data['id'];
			$this->evnt_title 		= $data['title'];
			$this->evnt_text 		= $data['text'];
			$this->evnt_cnt_cmnt	= $data['cnt'];
			$this->evnt_date 		= $data['date'];
			$this->evnt_uid			= $uid;
			$this->db->where('evnt_id',$this->evnt_id);
			$this->db->update('events',$this);
		}
		
		function new_events($uid,$count){
			
			$this->db->where('evnt_uid',$uid);
			$this->db->order_by('evnt_date desc,evnt_id desc');
			$query = $this->db->get('events',$count);
			return $query->result_array();
		}
		
		function event_record($id){
		
			$this->db->where('evnt_id',$id);
			$query = $this->db->get('events',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}
		
		function insert_comments($id){
			$this->db->set('evnt_cnt_cmnt','evnt_cnt_cmnt+1',FALSE);
			$this->db->where('evnt_id',$id);
			$this->db->update('events');
		}
		
		function delete_comments($id){
		
			$this->db->set('evnt_cnt_cmnt','evnt_cnt_cmnt-1',FALSE);
			$this->db->where('evnt_id',$id);
			$this->db->update('events');
		}
		
		function count_records($userid){
		
			$this->db->select('count(*) as cnt');
			$this->db->where('evnt_uid',$userid);
			$query = $this->db->get('events');
			$data = $query->result_array();
			return $data[0]['cnt'];
		}
	}
?>