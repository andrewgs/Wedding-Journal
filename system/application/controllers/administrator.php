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
		$this->load->library('image_lib');
		if(!$this->usersmodel->user_exist('usite',$this->uri->segment(1))):
			die('такой сайт не существует!');
		endif;
		$this->admin['login'] 		= $this->session->userdata('login');
		$this->admin['password'] 	= $this->session->userdata('password');
		$this->admin['uid'] 		= $this->usersmodel->user_id('ulogin',$this->admin['login']);
		$this->admin['site'] 		= $this->usersmodel->read_field($this->admin['uid'],'usite');
		$this->admin['themeurl'] 	= $this->configmodel->read_field($this->admin['uid'],'cfgthemepath');
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
		if(preg_match("/admin/i",$backpage)):
			$backpage = $this->admin['site'];
		endif;
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
					'formaction'	=> $this->uri->uri_string(),
					'valid'			=> TRUE,
					'edit'			=> FALSE
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
		$this->load->view($pagevar['themeurl'].'/admin/admin-event',$pagevar);
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
					'event'			=> array(),
					'edit'			=> TRUE
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
        $this->load->view($pagevar['themeurl'].'/admin/admin-event',$pagevar);
	} /* end function eventedit */			
	
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
	} /* end function eventdestroy */
	
	function commentedit($comment_id = 0,$event_id = 0,$error = FALSE){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Редактирование комментария',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> '',
					'formaction'	=> $this->uri->uri_string(),
					'valid'			=> $error,
					'commentlist'	=> $this->session->userdata('commentlist'),
					'comment'		=> array()
					);
		if($comment_id == 0 or empty($comment_id)):
			$comment_id = $this->uri->segment(4);
			$event_id 	= $this->uri->segment(3);
		endif;
		$pagevar['backpath'] = $pagevar['usite'].'/event/'.$event_id.'#comment_'.$comment_id;
		if(isset($pagevar['commentlist']) and !empty($pagevar['commentlist'])) 
			$pagevar['backpath'] = $pagevar['commentlist'].'#comment_'.$comment_id;
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('user_name','"Имя"','required');
			$this->form_validation->set_rules('user_email','"E-mail"','required|valid_email');
			$this->form_validation->set_rules('cmnt_text','"Текст комментария"','required');
			$this->form_validation->set_rules('user_date','"Дата"','');
			$this->form_validation->set_rules('homepage','"Веб-сайт"','');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->commentedit($_POST['id'],$_POST['event_id'],TRUE);
				return FALSE;
			else:
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['user_date'] = preg_replace($pattern, $replacement, $_POST['user_date']);
				$this->commentsmodel->update_record($_POST);
				$this->session->set_flashdata('operation_error',' ');
				$this->session->set_flashdata('operation_message','Комментарий от "'.$_POST['user_name'].'"');
				$this->session->set_flashdata('operation_saccessfull','Комментарий изменен');
				redirect($pagevar['backpath']);
			endif;
		endif;
		$pagevar['comment'] = $this->commentsmodel->comment_record($comment_id);
		$pagevar['comment']['cmnt_usr_date'] = $this->operation_date_slash($pagevar['comment']['cmnt_usr_date']);
		$this->load->view($pagevar['themeurl'].'/admin/admin-comment',$pagevar);
	} /* end function commentedit */
	
	function commentdestroy(){
		
		$event_id = $this->uri->segment(3);
		$comment_id = $this->uri->segment(4);
		$backpath = $this->admin['site'].'/event/'.$event_id;
		$commentlist = $this->session->userdata('commentlist');
		if(isset($commentlist) and !empty($commentlist)) 
			$backpath = $commentlist;
		$comment = $this->commentsmodel->comment_record($comment_id);
		$this->eventsmodel->delete_comments($event_id);
		$this->commentsmodel->delete_record($comment_id);
		$this->session->set_flashdata('operation_error',' ');
		$this->session->set_flashdata('operation_message','Комментарий от "'.$comment['cmnt_usr_name'].'"');
		$this->session->set_flashdata('operation_saccessfull','Комментарий удален успешно');
		redirect($backpath);
	} /* end function commentdestroy */

	function friendnew(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Создание карточки друга',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'valid'			=> TRUE,
					'edit'			=> FALSE	
					);
		$this->session->unset_userdata('commentlist');
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('name','"Имя друга"','required');
			$this->form_validation->set_rules('profession','"Профессия"','required');
			$this->form_validation->set_rules('userfile','"Фото"','callback_userfile_check');
			$this->form_validation->set_rules('note','"Описание друга"','required');
			$this->form_validation->set_rules('social1','"Соц.сеть"','');
			$this->form_validation->set_rules('social2','"Соц.сеть"','');
			$this->form_validation->set_rules('hrefsocial1','"Ссылка"','prep_url');
			$this->form_validation->set_rules('hrefsocial2','"Ссылка"','prep_url');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->friendnew();
				return FALSE;
			else:
				$tmpfile = $_FILES['userfile']['tmp_name'];
				$this->resize_image($tmpfile,100,70,TRUE);
				$file = fopen($tmpfile,'rb');
				$_POST['image'] = fread($file,filesize($tmpfile));
				fclose($file);
				$_POST['social'] = 0;
				$social[0] = array('friend_id'=>0,'social'=>'','href'=>'','flag'=>0);
				$social[1] = array('friend_id'=>0,'social'=>'','href'=>'','flag'=>0);							
				if(!empty($_POST['social1']) and !empty($_POST['hrefsocial1'])):
					$_POST['social'] += 1;
					$socstatus = 1;
					$social[0]['friend_id'] = 0;
					$social[0]['social'] 	= $_POST['social1'];
					$social[0]['href'] 		= $_POST['hrefsocial1'];
					$social[0]['flag'] 		= TRUE;
				endif;
				if(!empty($_POST['social2']) and !empty($_POST['hrefsocial2'])):
					$_POST['social'] += 1;
					$socstatus = 2;
					$social[1]['friend_id'] = 0;
					$social[1]['social'] 	= $_POST['social2'];
					$social[1]['href'] 		= $_POST['hrefsocial2'];
					$social[1]['flag']		= TRUE;
				endif;
				$friend_id = $this->friendsmodel->insert_record($_POST,$this->admin['uid']);				
				if(isset($socstatus)):
					for ($i = 0; $i < $socstatus; $i++):
						if (!$social[$i]['flag']) continue;
						$social[$i]['friend_id'] = $friend_id;
						$this->socialmodel->insert_record($social[$i]);
						$this->logmodel->insert_record($this->admin['uid'],'Создана новая карточка друга');			
					endfor;
				endif;	
				$this->session->set_flashdata('operation_error',' ');
				$this->session->set_flashdata('operation_message','Имя друга - '.$_POST['name']);
				$this->session->set_flashdata('operation_saccessfull','Карточка создана успешно');
				redirect($pagevar['backpath']);
			endif;
		endif;
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$msg = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
				
		$this->load->view($pagevar['themeurl'].'/admin/admin-friend',$pagevar);
	} /* end function friendnew */
	
	function friendedit($friend_id = 0,$error = FALSE){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Редактирование карточки друга',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'valid'			=> $error,
					'edit'			=> TRUE,
					'friend'		=> array(),
					'socials'		=> array(),
					);
		if($friend_id == 0 or empty($friend_id))
			$friend_id = $this->uri->segment(3);
		$pagevar['friend'] = $this->friendsmodel->friend_record($friend_id);
		$pagevar['socials'][0] = array('id'=>'','social'=>'','href'=>'');
		$pagevar['socials'][1] = array('id'=>'','social'=>'','href'=>'');
		$socials = $this->socialmodel->friend_social($friend_id);
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('name','"Имя друга"','required');
			$this->form_validation->set_rules('profession','"Профессия"','required');
			if($_FILES['userfile']['error'] != 4)
				$this->form_validation->set_rules('userfile','"Фото"','callback_userfile_check');
			$this->form_validation->set_rules('note','"Описание друга"','required');
			$this->form_validation->set_rules('social1','"Соц.сеть"','');
			$this->form_validation->set_rules('social2','"Соц.сеть"','');
			$this->form_validation->set_rules('hrefsocial1','"Ссылка"','prep_url');
			$this->form_validation->set_rules('hrefsocial2','"Ссылка"','prep_url');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->friendedit($friend_id,TRUE);
				return FALSE;
			else:
				if($_FILES['userfile']['error'] != 4):
					$tmpfile = $_FILES['userfile']['tmp_name'];
					$this->resize_image($tmpfile,100,70,TRUE);
					$file = fopen($tmpfile,'rb');
					$_POST['image'] = fread($file,filesize($tmpfile));
					fclose($file);
				else:
					$_POST['image'] = $pagevar['friend']['fr_image'];
				endif;
				$_POST['social'] = 0;			
				$social[0] = array('id'=>0,'friend_id'=>0,'social'=>'','href'=>'','flag'=>0);
				$social[1] = array('id'=>0,'friend_id'=>0,'social'=>'','href'=>'','flag'=>0);
				if(!empty($_POST['social1']) and !empty($_POST['hrefsocial1'])):
					$_POST['social'] 		+= 1;
					$socstatus 				= 1;
					$social[0]['friend_id'] = $_POST['id'];
					$social[0]['social'] 	= $_POST['social1'];
					$social[0]['href'] 		= $_POST['hrefsocial1'];
					$social[0]['flag'] 		= 1;
				endif;
				if(!empty($_POST['social2']) and !empty($_POST['hrefsocial2'])):
					$_POST['social'] 		+= 1;
					$socstatus 				= 2;
					$social[1]['friend_id'] = $_POST['id'];
					$social[1]['social'] 	= $_POST['social2'];
					$social[1]['href'] 		= $_POST['hrefsocial2'];
					$social[1]['flag'] 		= 1;
				endif;
				$this->friendsmodel->reset_social($_POST['id']);
				$this->socialmodel->delete_records($_POST['id']);
				$this->friendsmodel->update_record($_POST,$this->admin['uid']);			
				if(isset($socstatus)):
					for ($i = 0; $i < $socstatus; $i++):
						if ($social[$i]['flag'] == 0)continue;
						$this->socialmodel->insert_record($social[$i]);				
					endfor;
				endif;
				$this->logmodel->insert_record($this->admin['uid'],'Изменена карточка друга');	
				$this->session->set_flashdata('operation_error',' ');
				$this->session->set_flashdata('operation_message','Имя друга - '.$_POST['name']);
				$this->session->set_flashdata('operation_saccessfull','Карточка изменена успешно');
				redirect($pagevar['backpath']);
			endif;
		endif;
		for($i = 0; $i < count($socials); $i++):
			$pagevar['socials'][$i]['id'] 		= $socials[$i]['soc_id'];
			$pagevar['socials'][$i]['social'] 	= $socials[$i]['soc_name'];
			$pagevar['socials'][$i]['href'] 	= $socials[$i]['soc_href'];
		endfor;
		$this->load->view($pagevar['themeurl'].'/admin/admin-friend',$pagevar);
	} /* end function friendedit */
	
	function frienddestroy(){
		
		$backpath = $this->session->userdata('backpage');
		$friend_id = $this->uri->segment(3);
		$friend = $this->friendsmodel->friend_record($friend_id);
		$this->friendsmodel->delete_record($friend_id);
		$this->socialmodel->delete_records($friend_id);
		$this->logmodel->insert_record($this->admin['uid'],'Удалена карточка друга');
		$this->session->set_flashdata('operation_error',' ');
		$this->session->set_flashdata('operation_message','Удаленна карточка - '.$friend['fr_name']);
		$this->session->set_flashdata('operation_saccessfull','Карточка удалена успешно');
		redirect($backpath);
	} /* end function frienddestroy */

	function albumnew(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Создание нового фотоальбома',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'valid'			=> TRUE,
					'edit'			=> FALSE	
					);
		$this->session->unset_userdata('commentlist');
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('title','"Название альбома"','required');
			$this->form_validation->set_rules('photo_title','"Подпись"','required');
			$this->form_validation->set_rules('userfile','"Фото"','callback_userfile_check');
			$this->form_validation->set_rules('annotation','"Описание альбома"','required|prep_for_form');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->albumnew();
				return FALSE;
			else:
				$_POST['image'] = $this->resize_img($_FILES['userfile']['tmp_name'],186,186);
				$this->albummodel->insert_record($_POST,$this->admin['uid']);
				$this->session->set_flashdata('operation_error',' ');
				$this->session->set_flashdata('operation_message','Название альбома - '.$_POST['title']);
				$this->session->set_flashdata('operation_saccessfull','Альбом создан успешно');
				$this->logmodel->insert_record($this->admin['uid'],'Создан новый альбом');
				redirect($pagevar['backpath']);
			endif;
		endif;
		$this->load->view($pagevar['themeurl'].'/admin/admin-album',$pagevar);
	} /* end function albumnew */
	
	function albumedit($album_id = 0,$error = FALSE){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Редактирование альбома',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'valid'			=> $error,
					'edit'			=> TRUE,
					'$album'		=> array(),
					);
		if($album_id == 0 or empty($album_id))
			$album_id = $this->uri->segment(3);
		$this->session->unset_userdata('commentlist');
		$pagevar['album'] = $this->albummodel->album_record($album_id);
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('title','"Название альбома"','required');
			$this->form_validation->set_rules('photo_title','"Подпись"','required');
			if($_FILES['userfile']['error'] != 4)
				$this->form_validation->set_rules('userfile','"Фото"','callback_userfile_check');
			$this->form_validation->set_rules('annotation','"Описание альбома"','required|prep_for_form');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->albumedit($album_id,TRUE);
				return FALSE;
			else:
				if($_FILES['userfile']['error'] != 4)
					$_POST['image'] = $this->resize_img($_FILES['userfile']['tmp_name'],186,186);
				else
					$_POST['image'] = $pagevar['album']['alb_photo'];
				$this->albummodel->update_record($_POST,$this->admin['uid']);
				$this->session->set_flashdata('operation_error',' ');
				$this->session->set_flashdata('operation_message','Название альбома - '.$_POST['title']);
				$this->session->set_flashdata('operation_saccessfull','Альбом изменен успешно');
				$this->logmodel->insert_record($this->admin['uid'],'Изменен альбом');
				redirect($pagevar['backpath']);
			endif;
		endif;
        $this->load->view($pagevar['themeurl'].'/admin/admin-album',$pagevar);
	} /* end function albumedit */

	function albumdestroy(){
			
		$backpath = $this->session->userdata('backpage');
		$album_id = $this->uri->segment(3);
		$album = $this->albummodel->album_record($album_id);
		$this->albummodel->delete_record($album_id);
		$this->logmodel->insert_record($this->admin['uid'],'Удален альбом');
		$this->session->set_flashdata('operation_error',' ');
		$this->session->set_flashdata('operation_message','Название удаленного альбома - '.$album['alb_title']);
		$this->session->set_flashdata('operation_saccessfull','Альбом удален успешно');
		redirect($backpath);
	} /* end function albumdestroy */

	function oldpass_check($pass){
			
		$login = $this->session->userdata('login');
		$userinfo = $this->authentication->user_info($login);
			
		if(md5($pass) == $userinfo['usr_password']):
			return TRUE;
		else:
			$this->form_validation->set_message('oldpass_check','Введен не верный пароль!');
			return FALSE;
		endif;
	} /* end function oldpass_check */
	
	function userfile_check($file){
		
		$tmpName = $_FILES['userfile']['tmp_name'];
		
		if ($_FILES['userfile']['error'] == 4):
			$this->form_validation->set_message('userfile_check','Не указана фотография!');
			return FALSE;
		endif;
		if(!$this->case_image($tmpName)):
			$this->form_validation->set_message('userfile_check','Формат картинки не поддерживается!');
			return FALSE;
		endif;
		if($_FILES['userfile']['error'] == 1):
			$this->form_validation->set_message('userfile_check','Размер картинки более 10 Мб!');
			return FALSE;
		endif;
		return TRUE;
	} /* end function userfile_check */
	
	function resize_img($tmpName,$wgt,$hgt){
			
		chmod($tmpName,0777);
		$img = getimagesize($tmpName);		
		$size_x = $img[0];
		$size_y = $img[1];
		
		$wight = $wgt;
		$height = $hgt; 
		
		if(($size_x < $wgt) or ($size_y < $hgt)):
			$this->resize_image($tmpName,$wgt,$hgt,FALSE);
			$file = fopen($tmpName,'rb');
			$image = fread($file,filesize($tmpName));
			fclose($file);
			return $image;
		endif;
		if($size_x > $size_y)
			$this->resize_image($tmpName,$size_x,$hgt,TRUE);
		else
			$this->resize_image($tmpName,$wgt,$size_y,TRUE);
		$img = getimagesize($tmpName);		
		$size_x = $img[0];
		$size_y = $img[1];
		switch ($img[2]){
			case 1: $image_src = imagecreatefromgif($tmpName); break;
			case 2: $image_src = imagecreatefromjpeg($tmpName); break;
			case 3:	$image_src = imagecreatefrompng($tmpName); break;
		}
		$x = round(($size_x/2)-($wgt/2));
		$y = round(($size_y/2)-($hgt/2));
		if($x < 0):
			$x = 0;	$wight = $size_x;
		endif;
		if($y < 0):
			$y = 0; $height = $size_y;
		endif;
		
		$image_dst = ImageCreateTrueColor($wight,$height);
		imageCopy($image_dst,$image_src,0,0,$x,$y,$wgt,$hgt);
		imagePNG($image_dst,$tmpName);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		
		$file = fopen($tmpName,'rb');
		$image = fread($file,filesize($tmpName));
		fclose($file);
		/*header('Content-Type: image/jpeg' );
		echo $image['image'];
		exit();*/
		return $image;
	} /* end function resize_img */	
	
	function case_image($file){
			
		$info = getimagesize($file);
		switch ($info[2]):
			case 1	: return TRUE;
			case 2	: return TRUE;
			case 3	: return TRUE;
			default	: return FALSE;	
		endswitch;
	} /* end function case_image */
		 
	function resize_image($image,$wgt,$hgt,$ratio){
			
		$this->image_lib->clear();
		$config['image_library'] 	= 'gd2';
		$config['source_image']		= $image; 
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= $ratio;
		$config['width'] 			= $wgt;
		$config['height'] 			= $hgt;
				
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	} /* end function resize_image */
	
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
	
	function profile($error = FALSE){
		
		$pagevar = array(
					'description'	=> '',
					'keywords'		=> '',
					'title'			=> 'Администрирование | Изменение личных данных',
					'baseurl'		=> base_url(),
					'themeurl'		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath'		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'user'			=> array(),
					'valid'			=> $error
					);
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('name','"Ваше имя"','required|xss_clean|encode_php_tags|trim');
			$this->form_validation->set_rules('subname','"Ваша фамилия"','required|trim');
			$this->form_validation->set_rules('weddingdate','"Дата свадьбы"','required|trim');
			$this->form_validation->set_rules('sitename','"Нзвание сайта"','required|callback_sitename_check|trim');
			$this->form_validation->set_rules('email','"E-mail"','required|valid_email|trim|callback_email_check');
			$this->form_validation->set_error_delimiters('<dd><div class="join_error">','</div></dd>');
			$this->form_validation->set_message('min_length','Длина пароля не менее 6 символов.');
			$this->form_validation->set_message('matches','Пароли не совпадают');
			if (!$this->form_validation->run()):
				$pagevar['message'] = $this->setmessage('Не выполнены условия.','','Ошибка',1);
				$this->load->view($pagevar['themeurl'].'/admin/profile',$pagevar);
				return FALSE;
			else:
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['weddingdate'] = preg_replace($pattern,$replacement,$_POST['weddingdate']);
				$this->usersmodel->update_profile($_POST,$this->admin['uid']);
				$this->session->set_flashdata('operation_saccessfull','Личные данные изменены.');
				redirect($_POST['sitename'].'/admin');
				return TRUE;
			endif;
		endif;
		$pagevar['user'] = $this->usersmodel->read_record($this->admin['login']);
		if(count($pagevar['user']) > 0):
			$pagevar['user']['uweddingdate'] = $this->operation_date_slash($pagevar['user']['uweddingdate']);
		endif;
		$this->load->view($pagevar['themeurl'].'/admin/profile',$pagevar);
	} /* end function profile */
	
	function passwordchange(){
		
		
	} /* end function passwordchange */
	
	function sitename_check($sitename){
	
		if(preg_match('/^admin/i',$sitename)):
			$this->form_validation->set_message('sitename_check','Не допустимое название сайта');
			return FALSE;
		endif;
		if(!preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9_]*$/',$sitename)):
			$this->form_validation->set_message('sitename_check','Название сайта не соответствует правилам');
			return FALSE;
		endif;
		if($sitename === $this->admin['site']):
			return TRUE;
		endif;
		if($this->usersmodel->user_exist('usite',$sitename)):
			$this->form_validation->set_message('sitename_check','Название сайта уже занято');
			return FALSE;
		endif;
		return TRUE;
	} /* end function sitename_check */
	
} /* end class*/
?>