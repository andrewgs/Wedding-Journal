<?php
	class Otherimagemodel extends Model{
	
		var $oiid 		= 0;
		var $oiuid 		= 0;
		var $oisrc 		= '';
		var $oititle 	= '';
		var $oitype		= '';
		 
		function Otherimagemodel(){			
			
			parent::Model();
		}
		
		function insert_record($insertdata,$uid,$type){
			
			$this->oisrc 	= $insertdata['file'];
			$this->oititle 	= $insertdata['title'];
			$this->oiuid 	= $uid;
			$this->oitype 	= $type;
			$this->db->insert('otherimage', $this);
		}
		
		function read_record($type,$uid){
		
			$this->db->where('oitype',$type);
			$this->db->where('oiuid',$uid);
			$query = $this->db->get('otherimage',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}
		
		function update_record($updatedata,$type,$uid){
			
			$this->db->set('oisrc',$updatedata['file']); 
			$this->db->set('oititle',strip_tags($updatedata['title'])); 
			$this->db->where('oiuid',$uid);
			$this->db->where('oitype',$type);
			$this->db->update('otherimage');
		}
		
		function update_title($title,$type,$uid){
			
			$this->db->set('oititle',$title); 
			$this->db->where('oiuid',$uid);
			$this->db->where('oitype',$type);
			$this->db->update('otherimage');
		}
	}
?>