<?php

	class Usersmodel extends Model{
	
		var $uid 			= 0;	/* идентификатор пользователя*/
		var $ulogin 		= '';	/* логин пользователя*/
		var $upassword 		= '';	/* пароль пользователя*/
		var $uname 			= '';	/* имя пользователя*/
		var $usubname 		= '';	/* фамилия пользователя*/
		var $uemail 		= '';	/* почта пользователя*/
		var $usite 			= '';	/* название сайта пользователя*/
		var $ucryptpassword = '';	/* зашифорованый пароль пользователя*/
		var $usignupdate 	= '';	/* дата регистрации пользователя*/
		var $ulastlogindate = '';	/* дата последней авторизации пользователя*/
		var $ustatus 		= '';	/* статус пользователя (активирован /не активирован) */
		var $uactive 		= '';	/* статус активности пользователя */
		var $udestroy		= ''; 	/* дата запланированого удаления пользователя */
		var $uconfirmation	= ''; 	/* идентификатор подтверждения регистрации */
		
		function Usersmodel(){			
			
			parent::Model();
		}
		
		function read_record($login){
		
			$this->db->where('ulogin',$login);
			$query = $this->db->get('users',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}
		
		function auth_user($login,$password){
		
			$this->db->where('ulogin',$login);
			$this->db->where('upassword',md5($password));
			$query = $this->db->get('users',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0];
			return NULL;
		}
		
		function insert_record($insertdata){
			
			$this->ulogin 			= $insertdata['login'];
			$this->upassword 		= md5($insertdata['password']);
			$this->uname 			= $insertdata['name'];
			$this->usubname 		= $insertdata['subname'];
			$this->uemail 			= $insertdata['email'];
			$this->usite 			= strtolower($insertdata['sitename']);
			$this->ucryptpassword 	= $this->encrypt->encode($insertdata['password']);
			$this->usignupdate 		= date("Y-m-d");
			$this->ulastlogindate 	= '2000-01-01';
			$this->ustatus 			= 'disabled';
			$this->uactive 			= FALSE;
			$this->udestroy 		= '3000-01-01';
			$this->uconfirmation	= $insertdata['confirm'];
			
			$this->db->insert('users',$this);
			return $this->db->insert_id();
		}
		
		function update_status($code){
			
			$this->db->set('ustatus','enabled');
			$this->db->where('uconfirmation',$code);
			$this->db->where('ustatus','disabled');
			$this->db->update('users');
			$res = $this->db->affected_rows();
			if($res == 0) return FALSE;
			return TRUE;
		}
		
		function user_exist($field,$parameter){
			
			$this->db->where($field,$parameter);
			$query = $this->db->get('users',1);
			$data = $query->result_array();
			if(count($data)>0) return TRUE;
			return FALSE;
		}
		
		function user_id($field,$parameter){
			
			$this->db->where($field,$parameter);
			$query = $this->db->get('users',1);
			$data = $query->result_array();
			if(count($data)>0) return $data[0]['uid'];
			return FALSE;
		}
		
		function read_field($uid,$field){
			
			$this->db->where('uid',$uid);
			$query = $this->db->get('users',1);
			$data = $query->result_array();
			if(isset($data[0])) return $data[0][$field];
			return FALSE;
		}
	}
?>