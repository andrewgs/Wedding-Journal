<?php
class General extends Controller{

	var $months = array("01"=>"января", 	"02"=>"февраля",
						"03"=>"марта",		"04"=>"апреля",
						"05"=>"мая",		"06"=>"июня",
						"07"=>"июля",		"08"=>"августа",
						"09"=>"сентября", 	"10"=>"октября",
						"11"=>"ноября",		"12"=>"декабря"
					);
					
	var $usrinfo = array(
					'name' 		=> '',
					'subname' 	=> '',
					'email' 	=> '',
					'status' 	=> FALSE
					);
					
	function General(){
	
		parent::Controller();
		$this->load->model('eventsmodel');
		$login 		= $this->session->userdata('login');
		$password 	= $this->session->userdata('password');
		if($this->session->userdata('login_id') == md5(crypt($login,$password))):
			$userinfo = $this->usersmodel->read_record($login);
			$this->usrinfo['firstname']		= $userinfo['uname'];
			$this->usrinfo['secondname'] 	= $userinfo['usubname'];
			$this->usrinfo['email'] 		= $userinfo['uemail'];
			$this->usrinfo['status'] 		= TRUE;
		else:
			$this->usrinfo['status'] = FALSE;
		endif;
	} /* end constuructor Main*/
	
	function index(){
		
		$usersite = $this->uri->segment(1);
		if(!$this->usersmodel->user_exist('usite',$usersite)):
			redirect('page404');
		else:
			$userid = $this->usersmodel->user_id('usite',$usersite);
			$cfg = $this->configmodel->read_record($userid);
		endif;
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> base_url().$cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $usersite,
					'events'		=> array()
					);
		$this->nsession->set_userdata('backpage',$pagevar['baseurl']);
		
		$pagevar['events'] = $this->eventsmodel->new_events($userid,3);
		for($i = 0;$i < count($pagevar['events']); $i++):
			$pagevar['events'][$i]['evnt_date'] = $this->operation_date($pagevar['events'][$i]['evnt_date']);
			$text = $pagevar['events'][$i]['evnt_text'];			
			if(mb_strlen($text,'UTF-8') > 325):									
				$text = mb_substr($text,0,325,'UTF-8');	
				$pos = mb_strrpos($text,' ',0,'UTF-8');
				$text = mb_substr($text,0,$pos,'UTF-8');
				$pagevar['events'][$i]['evnt_text'] =$text.' ...';
			endif;
		endfor;
		$this->parser->parse('general/index',$pagevar);
	} /* end function index */
	
	function operation_date($field){
			
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 г."; 
		return preg_replace($pattern, $replacement,$field);
	} /* end function operation_date */
	
	function operation_date_slash($field){
		
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5/\$3/\$1"; 
		return preg_replace($pattern, $replacement,$field);
	} /* end function operation_date_slash */
} /* end class General */
?>