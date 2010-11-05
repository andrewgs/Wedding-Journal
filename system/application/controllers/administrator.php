<?php
class Administrator extends Controller{

	var $admin = array(
				'uid'		=> 0,
				'login' 	=> '',
				'password' 	=> '',
				'site' 		=> '',
				'themeurl' 	=> ''
			);
			
	var $months = array("01"=>"января", 	"02"=>"февраля",
						"03"=>"марта",		"04"=>"апреля",
						"05"=>"мая",		"06"=>"июня",
						"07"=>"июля",		"08"=>"августа",
						"09"=>"сентября", 	"10"=>"октября",
						"11"=>"ноября",		"12"=>"декабря"
					);	
						
	function Administrator(){
	
		parent::Controller();
		$this->load->model('eventsmodel');
		$this->load->model('albummodel');
		$this->load->model('friendsmodel');
		$this->load->model('socialmodel');
		$this->load->model('commentsmodel');
		$this->load->model('logmodel');
		$this->admin['login'] 		= $this->session->userdata('login');
		$this->admin['password'] 	= $this->session->userdata('password');
		$this->admin['site'] 		= $this->session->userdata('site');
		$this->admin['uid'] 		= $this->usersmodel->user_id('ulogin',$this->admin['login']);
		$this->admin['themeurl'] 	= $this->configmodel->read_field($this->admin['uid'],'cfgthemepath');
		if(!$this->admin['site']):
			$this->admin['site'] = $this->uri->segment(1);
		endif;
		$segm = $this->uri->total_segments();
		if($this->session->userdata('login_id') == md5($this->admin['login'].$this->admin['password'])) return;
		if ($this->uri->segment($segm)==='login') return;
		redirect($this->admin['site'].'/login');
	} /* end constructor Administrator */
	
	function index(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0)
					);
		$this->session->set_userdata('backpage',$pagevar['usite'].'/admin');
		$this->session->unset_userdata('commentlist');
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		$this->load->view($pagevar['themeurl'].'/admin/adminpanel',$pagevar);
	} /* end function index*/
	
	function login(){
		
		$usersite = $this->uri->segment(1);
		if(!$this->usersmodel->user_exist('usite',$usersite)):
			redirect('page404');
		endif;
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Авторизация пользователя',
					'baseurl' 		=> base_url(),
					'formaction'	=> 'login',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> ''
					);
		if($this->input->post('btsubmit')):
			$this->form_validation->set_rules('login','"Логин"','required|trim');
			$this->form_validation->set_rules('password','"Пароль"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="join_error">','</div>');
			if($this->form_validation->run()):
				$_POST['btsubmit'] = NULL;
				$user = $this->usersmodel->auth_user($_POST['login'],$_POST['password']);
				if(!$user):
					redirect($user['usite'].'/login');
				endif;
				if($user['ustatus'] == 'enabled'):
					$this->session->set_userdata('login_id',md5(crypt($_POST['login'],$_POST['password'])));
					$this->session->set_userdata('login',$_POST['login']);
					$this->session->set_userdata('password',$_POST['password']);
					$this->session->set_userdata('site',$user['usite']);
					$this->usersmodel->active_user($_POST['login']);
					redirect($user['usite'].'/admin');
				else:
					$pagevar['message'] = '<div class="join_error">Учетная запись не активирована!</div>';
					$this->load->view('main/login',$pagevar);
					return TRUE;
				endif;
			else:
				return FALSE;
			endif;
		endif;
		$this->load->view('main/login',$pagevar);
	} /* end function login*/
	
	function logoff(){
		
		$backpage = $this->session->userdata('backpage');
		$this->usersmodel->deactive_user($this->session->userdata('login'));
		$this->session->sess_destroy();
		redirect($backpage);
	} /* end function logoff*/
	
	function events(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'events'		=> array(),
					'pages'			=> '',
					'count'			=> 0
					);
		$this->session->set_userdata('backpage',$pagevar['usite'].'/admin/events');
		$this->session->unset_userdata('commentlist');
		$pagevar['count'] = $this->eventsmodel->count_records();
		
		$config['base_url'] 		= $pagevar['baseurl'].$pagevar['usite'].'/admin/events';	 		
       	$config['total_rows'] 		= $pagevar['count'];							 	
       	$config['per_page'] 		= 5;   								
       	$config['num_links'] 		= 2;   	 							
       	$config['uri_segment'] 		= 4;								
		$config['first_link'] 		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open'] 	= '<b>';
		$config['cur_tag_close'] 	= '</b>';
		$from = intval($this->uri->segment(4));
		if(isset($from) and !empty($from))
			$this->session->set_userdata('backpage',$pagevar['usite'].'/admin/events/'.$from);
		$pagevar['events'] = $this->eventsmodel->events_limit($this->admin['uid'],5,$from);
		if (!count($pagevar['events'])) redirect($pagevar['usite'].'/admin/event-new');
		for($i = 0;$i < count($pagevar['events']);$i++)
			$pagevar['events'][$i]['evnt_date'] = $this->operation_date($pagevar['events'][$i]['evnt_date']);
		
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		
		$this->load->view($pagevar['themeurl'].'/admin/admin-events',$pagevar);		
	} /* end function events */
	
	function eventnew(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Создание записи блога',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->admin['site'].'/event-new'
					);
		$this->session->unset_userdata('commentlist');
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('title','"Оглавление"','required');
			$this->form_validation->set_rules('text','"Содержимое"','required');
			$this->form_validation->set_rules('date','"Дата"','required');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->eventnew();
				return FALSE;
			else:
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['date'] = preg_replace($pattern,$replacement,$_POST['date']);
				$this->eventsmodel->insert_record($_POST,$this->admin['uid']);
				$this->logmodel->insert_record($this->admin['uid'],'Создана новая запись');
				$this->session->set_flashdata('operation_error',' ');
				$this->session->set_flashdata('operation_message','Название новой записи - '.$_POST['title']);
				$this->session->set_flashdata('operation_saccessfull','Новая запись создана успешно');
				redirect($pagevar['backpath']);
			endif;
		endif;
		$this->load->view($pagevar['themeurl'].'/admin/admin-event-new',$pagevar);
	} /* end function eventsnew */
	
	function eventedit($event_id = 0,$error = FALSE){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Редактирование записи блога',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'valid'			=> $error,
					'event'			=> array()
					);
		if($event_id == 0 or empty($event_id))
			$event_id = $this->uri->segment(3);
		$this->session->unset_userdata('commentlist');
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('title','"Оглавление"','required');
			$this->form_validation->set_rules('text','"Содержимое"','required');
			$this->form_validation->set_rules('date','"Дата"','required');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->eventedit($event_id,TRUE);
				return FALSE;
			else:
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['date'] = preg_replace($pattern,$replacement,$_POST['date']);
				$this->eventsmodel->update_record($_POST,$this->admin['uid']);
				$this->logmodel->insert_record($this->admin['uid'],'Изменена запись');
				$this->session->set_flashdata('operation_error',' ');
				$this->session->set_flashdata('operation_message','Название записи - '.$_POST['title']);
				$this->session->set_flashdata('operation_saccessfull','Запись изменена');
				redirect($pagevar['backpath']);
			endif;
		endif;
		$pagevar['event'] = $this->eventsmodel->event_record($event_id);
		if(count($pagevar['event']) > 0):
			$pagevar['event']['evnt_date'] = $this->operation_date_slash($pagevar['event']['evnt_date']);
		endif;
        $this->load->view($pagevar['themeurl'].'/admin/admin-event-edit',$pagevar);
	}				
	
	function eventdestroy(){
		
		$backpath = $this->session->userdata('backpage');
		$event_id = $this->uri->segment(3);
		$event = $this->eventsmodel->event_record($event_id);
		$this->eventsmodel->delete_record($event_id);
		$this->commentsmodel->delete_records($event_id);
		$this->logmodel->insert_record($this->admin['uid'],'Удалена запись');
		$this->session->set_flashdata('operation_error',' ');
		$this->session->set_flashdata('operation_message','Название удаленной записи - '.$event['evnt_title']);
		$this->session->set_flashdata('operation_saccessfull','Запись удалена успешно');
		redirect($backpath);
	}
	
	function setmessage($error,$saccessfull,$message,$status){
			
		$msg['error'] 		= $error;
		$msg['saccessfull'] = $saccessfull;
		$msg['message'] 	= $message;
		$msg['status'] 		= $status;
		
		return $msg;
	} /* end function setmessage */
	
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
	
	function viewimage(){
		
		$section = $this->uri->segment(3);
		$id = $this->uri->segment(5);
		switch ($section){
			case 'album' :	$image = $this->albummodel->get_image($id);	break;
			case 'small' :	$image = $this->imagesmodel->small_image($id); break;
			case 'big'	 : 	$image = $this->imagesmodel->big_image($id); break;
			case 'friend': 	$image = $this->friendsmodel->get_image($id); break;
		}
		header('Content-type: image/gif');
		echo $image;
	} /* end function viewimage */
	
} /* end class*/
?>