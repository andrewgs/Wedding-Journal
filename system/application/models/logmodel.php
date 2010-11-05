<?php
	class Logmodel extends Model{
		
		var $log_id 		= 0;
		var $log_uid 		= 0;
		var $log_date 		= '';
		var $log_text		= '';
		
		function Logmodel(){
			
			parent::Model();
		}
		
		function insert_record($uid,$text){
		
			$this->log_uid 		= $uid; 
			$this->log_date 	= date("Y-m-d");
			$this->log_text 	= $text;
			$this->db->insert('log',$this);
		}
}
?>