<?php
class Administrator extends Controller{

	var $admin = array(
				'login' 	=> '',
				'password' 	=> '',
				'site' 		=> ''
			);
	
	function Administrator(){
	
		parent::Controller();
		$this->admin['login'] 		= $this->session->userdata('login');
		$this->admin['password'] 	= $this->session->userdata('password');
		$this->admin['site'] 		= $this->session->userdata('site');
		if(!$this->admin['site']):
			$this->admin['site'] = $this->uri->segment(1);
		endif;
		$segm = $this->uri->total_segments();
		if($this->session->userdata('login_id') == md5(crypt($this->admin['login'],$this->admin['password']))) return;
		if ($this->uri->segment($segm)==='login') return;
		redirect($this->admin['site'].'/login');
	} /* end constuructor Administrator */
	
	function check_logon(){
		
		return '12345';
	} /* function check_logon*/
	
	function index(){
		
		$this->parser->parse('administrator/welcome',$this->admin);
	} /* end function index*/
	
	function login(){
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Авторизация',
					'baseurl' 		=> base_url(),
					'pathback'		=> base_url(),
					'formaction'	=> 'login'
					);
		$this->parser->parse('administrator/login',$pagevar);
	} /* end function login*/
	
	function logoff(){
		
       	$this->session->sess_destroy();
		$this->admin['site'] = $this->session->userdata('site');
		$this->usersmodel->deactive_user($this->session->userdata('login'));
		redirect($this->admin['site']);
	} /* end function logoff*/
} /* end class*/
?>