<?php

	class Configmodel extends Model{
	
		var $cfgid 			= 0;
		var $cfguid 		= 0;
		var $cfgtheme 		= '';
		var $cfgthemepath 	= '';
		
		
		function Configmodel(){			
			
			parent::Model();
		}
		
		function read_record($uid){
		
			$this->db->where('cfguid',$uid);
			$query = $this->db->get('configuration',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}
		
		function insert_record($insertdata){
			
			$this->cfguid 		= $insertdata['userid'];
			$this->cfgtheme 	= $insertdata['name'];
			$this->cfgthemepath = $insertdata['path'];
			
			$this->db->insert('configuration',$this);
			return $this->db->insert_id();
		}
		
		function update_theme($updatedata,$uid){
			
			$this->db->set('cfgtheme',$updatedata['thname']);
			$this->db->set('cfgthemepath',$updatedata['thpath']);
			$this->db->where('cfguid',$uid);
			$this->db->update('configuration');
			return TRUE;
		}
		
		function read_field($userid,$field){
			
			$this->db->where('cfguid',$userid);
			$query = $this->db->get('configuration',1);
			$data = $query->result_array();
			if(count($data)>0) return $data[0][$field];
			return FALSE;
		}
	}
?>