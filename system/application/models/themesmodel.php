<?php

	class Themesmodel extends Model{
	
		var $thid 			= 0;	/* идентификатор темы */
		var $thname 		= '';	/* название темы */
		var $thpath 		= '';	/* относительный путь к теме */
		var $thstatus 		= '';	/* статус темы (бесплатная, платная) */
		var $thactive 		= '';	/* статус активности темы */
		var $thprice 		= '';	/* цена темы */
		
		function Themesmodel(){			
			
			parent::Model();
		}
		
		function read_records($active){
		
			$this->db->where('thactive',$active);
			$this->db->order_by('thstatus');
			$this->db->order_by('thname');
			$query = $this->db->get('themes');
			return $query->result_array();
		}
		
		function read_record($id){
		
			$this->db->where('thid',$id);
			$query = $this->db->get('themes',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}
		
		function insert_record($insertdata){
			
			$this->thname 	= $insertdata['name'];
			$this->thpath 	= $insertdata['path'];
			$this->thstatus = $insertdata['status'];
			$this->thactive = $insertdata['active'];
			$this->thprice 	= $insertdata['price'];
			
			$this->db->insert('themes',$this);
			return $this->db->insert_id();
		}
	}
?>