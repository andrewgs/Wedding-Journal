<?php
class Administrator extends Controller{

	var $admin = array('uid'=>0,'login'=>'','password'=>'','site'=>'','themeurl'=>'');
			
	var $months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля",
						"05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа",
						"09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");	
						
	function Administrator(){
	
		parent::Controller();
		session_start();
		$this->load->model('eventsmodel');
		$this->load->model('albummodel');
		$this->load->model('friendsmodel');
		$this->load->model('socialmodel');
		$this->load->model('commentsmodel');
		$this->load->model('logmodel');
		$this->load->model('imagesmodel');
		$this->load->model('unionmodel');
		$this->load->model('othertextmodel');
		$this->load->model('otherimagemodel');
		if(!$this->usersmodel->user_exist('usite',$this->uri->segment(1))):
			redirect('not-existing');
		endif;
		$this->admin['login'] = $this->session->userdata('login');
		$this->admin['confirmation'] = $this->session->userdata('confirmation');
		if($this->admin['login'] and $this->admin['confirmation']):
			$this->admin['uid'] = $this->usersmodel->user_id('ulogin',$this->admin['login']);
			$this->admin['site'] = $this->usersmodel->read_field($this->admin['uid'],'usite');
			$_SESSION['usersite'] = $this->admin['site'];
			if($this->admin['site'] != $this->uri->segment(1)):
				die('Не возможно работать с двумя сайтами одновременно.<br/>Текущий автивный сайт - "'.$this->admin['site'].'"<br/>Завершите сеанс и попробуйте снова.');
			endif;
			$this->admin['themeurl'] = $this->configmodel->read_field($this->admin['uid'],'cfgthemepath');
		else:
			$this->admin['site'] = $this->uri->segment(1);
		endif;
		$segm = $this->uri->total_segments();
		if($this->session->userdata('login_id') == md5($this->admin['login'].$this->admin['confirmation'])) return;
		if ($this->uri->segment($segm)==='login') return;
		redirect($this->admin['site'].'/login');
	} /* end constructor Administrator */
	
	function index(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Панель администрирования',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0)
					);
		$this->session->unset_userdata('commentlist');
		$this->session->unset_userdata('cmntval');
		$this->session->set_userdata('backpage',$pagevar['usite'].'/admin');
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage(trim($flasherr),trim($flashsaf),trim($flashmsg),1);
		$this->load->view($pagevar['themeurl'].'/admin/adminpanel',$pagevar);
	} /* end function index*/
	
	function login(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Авторизация пользователя',
					'baseurl' 		=> base_url(),
					'formaction'	=> $this->uri->uri_string(),
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
					redirect($this->uri->uri_string());
				endif;
				if($user['usite'] != $this->uri->segment(1)):
					redirect($this->uri->uri_string());	
				endif;
				if($this->usersmodel->close_status($user['usite'])):
					$this->usersmodel->open_user($user['uid']);
					$this->session->set_flashdata('operation_error','none');
					$this->session->set_flashdata('operation_message','Сайт сново функционирует');
					$this->session->set_flashdata('operation_saccessfull','Включение произведено успешно');
					$this->logmodel->insert_record($user['uid'],'Произведено включение сайта');
				endif;
				if($user['ustatus'] == 'enabled'):
					$this->session->sess_destroy();
					$this->session->set_userdata('login_id',md5($_POST['login'].$user['uconfirmation']));
					$this->session->set_userdata('login',$_POST['login']);
					$this->session->set_userdata('confirmation',$user['uconfirmation']);
					$this->usersmodel->active_user($_POST['login']);
					redirect($user['usite'].'/admin');
				else:
					$pagevar['message'] = '<div class="join_error">Учетная запись не активирована!</div>';
					$this->load->view('main/login',$pagevar);
					return TRUE;
				endif;
			else:
				redirect($this->uri->uri_string());
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
		unset($_SESSION['usersite']);
		redirect($backpage);
	} /* end function logoff*/
	
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
				$this->session->set_flashdata('operation_error','none');
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
		$event = $this->eventsmodel->exist_event($event_id,$this->admin['uid']);
		if(!$event) redirect('page403');
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
				$this->session->set_flashdata('operation_error','none');
				$this->session->set_flashdata('operation_message','Название записи - '.$_POST['title']);
				$this->session->set_flashdata('operation_saccessfull','Запись изменена');
				redirect($pagevar['backpath']);
			endif;
		endif;
		$pagevar['event'] = $this->eventsmodel->event_record($event_id);
		if(count($pagevar['event']) > 0):
			$pagevar['event']['evnt_date'] = $this->operation_date_slash($pagevar['event']['evnt_date']);
		endif;
//		print_r($_SESSION['ckfinder_baseUrl']); exit;
        $this->load->view($pagevar['themeurl'].'/admin/admin-event',$pagevar);
	} /* end function eventedit */			
	
	function eventdestroy(){
		
		$backpath = $this->session->userdata('backpage');
		$event_id = $this->uri->segment(3);
		$event = $this->eventsmodel->exist_event($event_id,$this->admin['uid']);
		if(!$event) redirect('page403');
		$evnttitle = $this->eventsmodel->event_title($event_id,$this->admin['uid']);
		$this->eventsmodel->delete_record($event_id);
		$this->commentsmodel->delete_records($this->admin['uid'],$event_id,0);
		$this->logmodel->insert_record($this->admin['uid'],'Удалена запись');
		$this->session->set_flashdata('operation_error','none');
		$this->session->set_flashdata('operation_message','Название удаленной записи - '.$evnttitle);
		$this->session->set_flashdata('operation_saccessfull','Запись удалена успешно');
		redirect($backpath);
	} /* end function eventdestroy */
	
	function commentedit($comment_id = 0,$object_id = 0,$error = FALSE){
		
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
			$comment_id = $this->uri->segment(5);
			$object_id 	= $this->uri->segment(4);
		endif;
		switch ($this->uri->segment(2)):
			case 'photo-albums': 	$comment = $this->commentsmodel->exist_comment($comment_id,0,$object_id);
									if(!$comment) redirect('page403');
									$img_id = $object_id; 
									$event_id = 0;
									$album = $this->imagesmodel->get_album($img_id,$this->admin['uid']);
									$pagevar['backpath'] =$pagevar['usite'].'/photo-albums/photo-comments/'.$object_id.'#comment_'.$comment_id;
									break;
			case 'event'		:	$comment = $this->commentsmodel->exist_comment($comment_id,$object_id,0);
									if(!$comment) redirect('page403');
									$img_id = 0;
									$event_id = $object_id;
									$album = 0;
									$pagevar['backpath'] = $pagevar['usite'].'/event/'.$object_id.'#comment_'.$comment_id;
									break;
		endswitch;
		if(isset($pagevar['commentlist']) and !empty($pagevar['commentlist'])):
			$pagevar['backpath'] = $pagevar['commentlist'];
		endif;
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('user_name','"Имя"','required');
			$this->form_validation->set_rules('user_email','"E-mail"','required|valid_email');
			$this->form_validation->set_rules('cmnt_text','"Текст комментария"','required');
			$this->form_validation->set_rules('user_date','"Дата"','');
			$this->form_validation->set_rules('homepage','"Веб-сайт"','');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->commentedit($_POST['id'],$_POST['object_id'],TRUE);
				return FALSE;
			else:
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['user_date'] = preg_replace($pattern, $replacement, $_POST['user_date']);
				$this->commentsmodel->update_record($comment_id,$this->admin['uid'],$event_id,$album,$img_id,$_POST);
				$this->session->set_flashdata('operation_error','none');
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
		
		$object_id = $this->uri->segment(4);
		$comment_id = $this->uri->segment(5);
		switch ($this->uri->segment(2)):
			case 'photo-albums'	: 	$comment = $this->commentsmodel->exist_comment($comment_id,0,$object_id);
									if(!$comment) redirect('page403');
									$backpath = $this->admin['site'].'/photo-albums/photo-comments/'.$object_id;
									$this->imagesmodel->delete_comments($object_id,$this->admin['uid']);
									break;
			case 'event'		:	$comment = $this->commentsmodel->exist_comment($comment_id,$object_id,0);
									if(!$comment) redirect('page403');
									$backpath = $this->admin['site'].'/event/'.$object_id;
									$this->eventsmodel->delete_comments($object_id,$this->admin['uid']);
									break;
		endswitch;
		$commentlist = $this->session->userdata('commentlist');
		if(isset($commentlist) and !empty($commentlist)) 
			$backpath = $commentlist;
		$uname = $this->commentsmodel->comment_name($comment_id,$this->admin['uid']);
		$this->commentsmodel->delete_record($comment_id,$this->admin['uid']);
		$this->session->set_flashdata('operation_error','none');
		$this->session->set_flashdata('operation_message','Комментарий от "'.$uname.'"');
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
				$this->session->set_flashdata('operation_error','none');
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
		$friend = $this->friendsmodel->exist_friend($friend_id,$this->admin['uid']);
		if(!$friend) redirect('page403');
		$pagevar['friend'] = $this->friendsmodel->friend_record($friend_id,$this->admin['uid']);
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
				$this->session->set_flashdata('operation_error','none');
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
		$friend = $this->friendsmodel->exist_friend($friend_id,$this->admin['uid']);
		if(!$friend) redirect('page403');
		$frname = $this->friendsmodel->friend_name($friend_id,$this->admin['uid']);
		$this->friendsmodel->delete_record($friend_id);
		$this->socialmodel->delete_records($friend_id);
		$this->logmodel->insert_record($this->admin['uid'],'Удалена карточка друга');
		$this->session->set_flashdata('operation_error','none');
		$this->session->set_flashdata('operation_message','Удаленна карточка - '.$frname);
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
				$this->session->set_flashdata('operation_error','none');
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
					'album'			=> array(),
					);
		if($album_id == 0 or empty($album_id)):
			$album_id = $this->uri->segment(3);
		endif;
		$album = $this->albummodel->exist_album($album_id,$this->admin['uid']);
		if(!$album) redirect('page403');
		$pagevar['album'] = $this->albummodel->album_record($album_id,$this->admin['uid']);
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
				$this->session->set_flashdata('operation_error','none');
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
		$album = $this->albummodel->exist_album($album_id,$this->admin['uid']);
		if(!$album) redirect('page403');
		$albtitle = $this->albummodel->album_title($album_id,$this->admin['uid']);
		$images = $this->imagesmodel->get_names($album_id,$this->admin['uid']);
		for($i = 0;$i < count($images);$i++):
			$filepath = getcwd().'/users/'.$this->admin['site'].'/images/'.$images[$i]['src'];
			if(!$this->filedelete($filepath)):
				$this->logmodel->insert_record($this->admin['uid'],'Ошибка удаления файла - '.$images[$i]['src']);
			endif;
			$filepath = getcwd().'/users/'.$this->admin['site'].'/_thumbs/Images/'.$images[$i]['src'];
			if(is_file($filepath)):
				if(!$this->filedelete($filepath)):
					$this->logmodel->insert_record($this->admin['uid'],'Ошибка удаления миниатюры - '.$images[$i]['src']);
				endif;	
			endif;
		endfor;
		$this->imagesmodel->images_delete($album_id,$this->admin['uid']);
		$this->albummodel->delete_record($album_id);
		$this->commentsmodel->delete_albums($this->admin['uid'],$album_id);
		$this->logmodel->insert_record($this->admin['uid'],'Удален альбом');
		$this->session->set_flashdata('operation_error','none');
		$this->session->set_flashdata('operation_message','Название удаленного альбома - '.$albtitle);
		$this->session->set_flashdata('operation_saccessfull','Альбом удален успешно');
		redirect($backpath);
	} /* end function albumdestroy */

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
		/*if(!preg_match("/(^[a-zA-Z0-9]+([a-zA-Z\_ 0-9\.-]*))$/",$_FILES['userfile']['name'])):
			$this->form_validation->set_message('userfile_check','Имя должно содержать только латинские символы, цифры и пробелы');
			return FALSE;
		endif;*/
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
			$image = file_get_contents($tmpName);
			return $image;
		endif;
		if($size_x > $size_y):
			$this->resize_image($tmpName,$size_x,$hgt,TRUE);
		else:
			$this->resize_image($tmpName,$wgt,$size_y,TRUE);
		endif;
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
		imageCopy($image_dst,$image_src,0,0,$x,$y,$wight,$height);
		imagePNG($image_dst,$tmpName);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		$image = file_get_contents($tmpName);
		/*$file = fopen($tmpName,'rb');
		$image = fread($file,filesize($tmpName));
		fclose($file);
		header('Content-Type: image/jpeg' );
		echo $image;
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
	
		$this->load->library('image_lib');
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
					'backpath'		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'user'			=> array(),
					'valid'			=> $error,
					'errortext'		=> 'Произошла ошибка при изменении профиля.',
					'errorcode'		=> '0x0000'
					);
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('name','"Ваше имя"','required|xss_clean|encode_php_tags|trim');
			$this->form_validation->set_rules('subname','"Ваша фамилия"','required|trim');
			$this->form_validation->set_rules('weddingdate','"Дата свадьбы"','required|trim');
			$this->form_validation->set_rules('sitename','"Нзвание сайта"','required|callback_sitename_check|trim');
			$this->form_validation->set_rules('email','"E-mail"','required|valid_email|trim|callback_email_check');
			$this->form_validation->set_error_delimiters('<dd><div class="join_error">','</div></dd>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->profile(TRUE);
				return FALSE;
			else:
				$userdir = getcwd().'/users/'.$pagevar['usite'];
				$newdir = getcwd().'/users/'.$_POST['sitename'];
				if($pagevar['usite'] != $_POST['sitename']):
					if(!is_dir($userdir)):
						$pagevar['errorcode'] = '0x0010';
						$this->load->view('main/error',$pagevar);
						return FALSE;
					endif;
					if(!rename($userdir,$newdir)):
						$pagevar['errorcode'] = '0x0011';
						$this->load->view('main/error',$pagevar);
						return FALSE;
					endif;
				endif;
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['weddingdate'] = preg_replace($pattern,$replacement,$_POST['weddingdate']);
				$this->usersmodel->update_profile($_POST,$this->admin['uid']);
				$this->logmodel->insert_record($this->admin['uid'],'Личные данные изменены');
				$this->session->set_flashdata('operation_error','none');
				$this->session->set_flashdata('operation_message','none');
				$this->session->set_flashdata('operation_saccessfull','Личные данные изменены.');
				redirect($_POST['sitename'].'/admin');
			endif;
		endif;
		$pagevar['user'] = $this->usersmodel->read_record($this->admin['login']);
		if(count($pagevar['user']) > 0):
			$pagevar['user']['uweddingdate'] = $this->operation_date_slash($pagevar['user']['uweddingdate']);
		endif;
		$this->load->view($pagevar['themeurl'].'/admin/profile',$pagevar);
	} /* end function profile */

	function passwordchange(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords'		=> '',
					'title'			=> 'Администрирование | Смена пароля администратора',
					'baseurl'		=> base_url(),
					'themeurl'		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath'		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
				);
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('oldpass','"Старый пароль"','required|callback_oldpass_check');
			$this->form_validation->set_rules('password','"Новый пароль"','required|min_length[6]|matches[confirmpass]');
			$this->form_validation->set_rules('confirmpass','"Подтверждение пароля"','required');
			$this->form_validation->set_error_delimiters('<div class="join_error">','</div>');
			$this->form_validation->set_message('min_length','Минимальная длина пароля — 6 символов.');
			$this->form_validation->set_message('matches','Пароли не совпадают');
			if ($this->form_validation->run() == FALSE):
				$pagevar['message'] = $this->setmessage('Не выполнены условия.','','Ошибка при изменении пароля',1);
				$this->load->view($pagevar['themeurl'].'/admin/password',$pagevar);
				return FALSE;
			else:
				$this->usersmodel->changepassword($_POST,$this->admin['uid']);
				$this->logmodel->insert_record($this->admin['uid'],'Пароль изменен');
				$this->session->set_flashdata('operation_error','none');
				$this->session->set_flashdata('operation_message','none');
				$this->session->set_flashdata('operation_saccessfull','Пароль изменен.');
				redirect($pagevar['usite'].'/admin');
				return TRUE;
			endif;
		endif;
		$flashmsg = $this->session->flashdata('operation_saccessfull');
		if(isset($flashmsg) and !empty($flashmsg)):
			$pagevar['message'] = $this->setmessage('','',$flashmsg,1);
		endif;
        $this->load->view($pagevar['themeurl'].'/admin/password',$pagevar);
	} /* end function passwordchange */
									 
	function oldpass_check($pass){
		
		$password = $this->usersmodel->read_field($this->admin['uid'],'upassword');
		if(md5($pass) != $password):
			$this->form_validation->set_message('oldpass_check','Введен не верный пароль!');
			return FALSE;
		endif;
		return TRUE;
	} /* end function oldpass_check */
	
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
	
	function email_check($email){
		
		if($email === $this->usersmodel->read_field($this->admin['uid'],'uemail')):
			return TRUE;
		endif;
		if($this->usersmodel->user_exist('uemail',$email)):
			$this->form_validation->set_message('email_check','E-mail уже ceществует');
			return FALSE;
		endif;
		return TRUE;
	} /* end function email_check */
	
	function themechange(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Панель администрирования | Изменение темы',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $this->admin['themeurl'],
					'backpath' 		=> $this->session->userdata('backpage'),
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'themes'		=> array(),
					'formaction'	=> $this->uri->uri_string()
					);
		if($this->input->post('btsubmit')):			
			$_POST['btsubmit'] = NULL;
			if(!$this->input->post('theme')):
				$this->themechange();
				return FALSE;
			endif;
			$themes = $this->themesmodel->read_record($_POST['theme']);
			if($themes['thstatus'] != 'free'):
				die('денег хватает только на водку!');
			endif;
			$this->configmodel->update_theme($themes,$this->admin['uid']);
			$this->logmodel->insert_record($this->admin['uid'],'Тема изменена');
			$this->session->set_flashdata('operation_error','none');
			$this->session->set_flashdata('operation_message','Выбрана тема - '.$themes['thname']);
			$this->session->set_flashdata('operation_saccessfull','Тема применена.');
			redirect($pagevar['usite'].'/admin');
		endif;
		$pagevar['themes'] = $this->themesmodel->read_records(TRUE);
		$this->load->view($pagevar['themeurl'].'/admin/themechange',$pagevar);
	} /* end function themechange */

	function profileclose(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords'		=> '',
					'title'			=> 'Администрирование | Закрытие сайта',
					'baseurl'		=> base_url(),
					'themeurl'		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'backpath'		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'errortext'		=> 'Произошла ошибка при закрытии профиля.',
					'errorcode'		=> '0x0000'
					);
		if($this->input->post('btnsubmit')):
			if($this->input->post('close')):
				$email = $this->usersmodel->read_field($this->admin['uid'],'uemail');
				$path = base_url().$pagevar['usite'].'/admin';
				$message = "My-wedding.ru\nСайт ".$pagevar['usite']." закрыт.\nВвойдите в панель администрирования
				<a href=".$path.">".$path."</a> для восстановления.\nСайт будет удален через 30 дней.";
				if($this->sendmail($email,$message,"Закрытие сайта","admin@my-wedding.ru")):
					$this->usersmodel->close_user($this->admin['uid']);
					$this->logmodel->insert_record($this->admin['uid'],'Произведено выключение сайта');
					$this->usersmodel->deactive_user($this->session->userdata('login'));
					$this->session->sess_destroy();
					redirect('/');
				else:
					$pagevar['errorcode'] = '0x0009';
					$this->load->view('main/error',$pagevar);
					return FALSE;
				endif;
			else:
				redirect($this->uri->uri_string());
			endif;
		endif;
		$this->load->view($pagevar['themeurl'].'/admin/close',$pagevar);
	} /* end function profileclose */
							   
	function sendmail($email,$msg,$subject,$from){
		
		$config['smtp_host'] = 'localhost';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from($from,'Администрация сайта');
		$this->email->to($email);
		$this->email->bcc('');
		$this->email->subject($subject);
		$this->email->message(strip_tags($msg));
		if (!$this->email->send()):
			return FALSE;
		endif;
		return TRUE;
	} /* end function sendmail */
													 
	function uploadfiles(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Редактирование альбома',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> '',
					'album' 		=> $this->uri->segment(4),
					'formaction1'	=> $this->uri->uri_string(),
					'formaction2'	=> $this->admin['site'].'/admin/multi-upload',
					'errortext'		=> 'Произошла ошибка при загрузке фотографий.',
					'errorcode'		=> '0x0000'
					);
		$alb_id = $this->uri->segment(4);
		$album = $this->albummodel->exist_album($alb_id,$this->admin['uid']);
		if(!$album) redirect('page403');
		$pagevar['backpath'] = $this->admin['site'].'/photo-albums/photo-gallery/'.$pagevar['album'];
		if($this->input->post('btnsubmit')):
			$this->form_validation->set_rules('imagetitle','"Описание"','required');
			$this->form_validation->set_rules('userfile','"Фото"','callback_userfile_check');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btnsubmit'] = NULL;
				$this->uploadfiles();
				return FALSE;
			else:
				$_FILES['userfile']['name'] = preg_replace('/.+(.)(\.)+/',date("Ymdhis")."\$2", $_FILES['userfile']['name']);
				$_POST['file'] = $_FILES['userfile']['name'];
				$_POST['album'] = $pagevar['album'];
				if(!$this->fileupload('userfile',$this->admin['site'],480,640,FALSE,TRUE)):
					$pagevar['errorcode'] = '0x0012';
					$this->load->view('main/error',$pagevar);
					return FALSE;
				endif;
				$_POST['thumb'] = $this->resize_img($_FILES['userfile']['tmp_name'],186,186);
				$this->imagesmodel->insert_record($_POST,$this->admin['uid']);
				$this->albummodel->insert_photo($pagevar['album']);
				$this->logmodel->insert_record($this->admin['uid'],'Загружена фотография');
				$this->session->set_flashdata('operation_error','none');
				$this->session->set_flashdata('operation_message','Название фотографии - '.$_POST['file']);
				$this->session->set_flashdata('operation_saccessfull','Фотография загружена успешно');
				redirect($pagevar['backpath']);
			endif;
		endif;
		$this->load->view($pagevar['themeurl'].'/admin/uploadfiles',$pagevar);
	} /* end function uploadfiles */

	function multiupload(){
		
		$album = $this->albummodel->exist_album($_POST['album'],$this->admin['uid']);
		if(!$album) exit;
		$imgtitle = $this->albummodel->album_title($_POST['album'],$this->admin['uid']);
		$files_count = sizeof($_FILES['fileToUpload']['name']);
		for ($i = 0; $i < $files_count-1; $i++):
			if($_FILES['fileToUpload']['error'][$i] == FALSE):
				if($this->case_image($_FILES['fileToUpload']['tmp_name'][$i])):
					$_FILES['fileToUpload']['name'][$i] = preg_replace('/.+(.)(\.)+/',date("Ymdhis-").$i."\$2",$_FILES['fileToUpload']['name'][$i]);
					$filepath = getcwd().'/users/'.$this->admin['site'].'/images/'.$_FILES['fileToUpload']['name'][$i];
					$this->load->library('image_lib');
					$this->image_lib->clear();
					$config['image_library'] 	= 'gd2';
					$config['source_image']		= $_FILES['fileToUpload']['tmp_name'][$i]; 
					$config['create_thumb'] 	= FALSE;
					$config['maintain_ratio'] 	= TRUE;
					$config['width']	 		= 640;
					$config['height']			= 480;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
					copy($_FILES['fileToUpload']['tmp_name'][$i],$filepath);
					$_POST['thumb'] = $this->resize_img($_FILES['fileToUpload']['tmp_name'][$i],186,186);
					$_POST['file'] = $_FILES['fileToUpload']['name'][$i];
					$_POST['imagetitle'] = $imgtitle;
					$this->imagesmodel->insert_record($_POST,$this->admin['uid']);
					$this->albummodel->insert_photo($_POST['album']);
					$this->logmodel->insert_record($this->admin['uid'],'Загружена фотография');
					@unlink($_FILES['fileToUpload'][$i]);
				endif;	
			endif;		    
		endfor;
	} /* end function multiupload */

	function fileupload($userfile,$user,$height,$wight,$overwrite,$ration){
		
		$path = getcwd().'/users/'.$user.'/images/';
		$this->load->library('upload');
		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png';
		$config['remove_spaces'] 	= TRUE;
		$config['overwrite'] 		= $overwrite;
		$this->upload->initialize($config);
		if(!$this->upload->do_upload($userfile)):
			$this->logmodel->insert_record($this->admin['uid'],$this->upload->display_errors());
			return FALSE;
		else:
			$file = $this->upload->data();
			$this->load->library('image_lib');
			$this->image_lib->clear();
			$conf['image_library'] 	= 'gd2';
			$conf['source_image']	= $file['full_path']; 
			$conf['create_thumb'] 	= FALSE;
			$conf['maintain_ratio'] = $ration;
			$conf['width']	 		= $wight;
			$conf['height']			= $height;
			$this->image_lib->initialize($conf); 
			$this->image_lib->resize();
		endif;
		return TRUE;
	} /* end function fileupload */

	function commentslist($countday = 21){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Список комментариев за период',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->admin['site'].'/admin',
					'formaction'	=> $this->uri->uri_string(),
					'message'		=> $this->setmessage('','','',0),
					'pages'			=> '',
					'count'			=> 0,
					'events'		=> array(),
					'images'		=> array()
					);
		$this->session->set_userdata('commentlist',$pagevar['usite'].'/admin/comments');
		if($this->input->post('btnsubmit')):
			$_POST['btnsubmit'] = NULL;
			if(!isset($_POST['cmntval'])):
				$this->session->unset_userdata('cmntval');
				redirect($this->uri->uri_string());
			endif;
			$this->session->set_userdata('cmntval',$_POST['cmntval']);
		endif;
		$cmntval = $this->session->userdata('cmntval');
		if($cmntval):
			if($cmntval == 1):
				$pagevar['count'] = $this->unionmodel->count_events($countday,$this->admin['uid']);
			else:
				$pagevar['count'] = $this->unionmodel->count_images($countday,$this->admin['uid']);
			endif;
			$config['base_url'] 		= base_url().$pagevar['usite'].'/admin/comments';	
	       	$config['total_rows'] 		= $pagevar['count'];
			$config['per_page'] 		= 10;
	       	$config['num_links'] 		= 2;
	       	$config['uri_segment'] 		= 4;
			$config['first_link'] 		= 'В начало';
			$config['last_link'] 		= 'В конец';
			$config['next_link'] 		= 'Далее &raquo;';
			$config['prev_link'] 		= '&laquo; Назад';
			$config['cur_tag_open'] 	= '<b>';
			$config['cur_tag_close']	= '</b>';
			$from = intval($this->uri->segment(4));
			if(isset($from) and !empty($from)):
				$this->session->set_userdata('commentlist',$pagevar['usite'].'/admin/comments/'.$from);
			endif;
			if($cmntval == 1):
				$pagevar['events'] = $this->unionmodel->select_events($countday,10,$from,$this->admin['uid']);
				for($i = 0;$i < count($pagevar['events']);$i++):
					$pagevar['events'][$i]['evnt_date'] = $this->operation_date($pagevar['events'][$i]['evnt_date']);
					$pagevar['events'][$i]['cmnt_usr_date'] = $this->operation_date_slash($pagevar['events'][$i]['cmnt_usr_date']);
				endfor;
			else:
				$pagevar['images'] = $this->unionmodel->select_images($countday,10,$from,$this->admin['uid']);
				for($i = 0;$i < count($pagevar['images']);$i++):
					$pagevar['images'][$i]['img_src'] = $pagevar['baseurl'].'users/'.$this->admin['site'].'/images/'.$pagevar['images'][$i]['img_src'];
					$info = getimagesize($pagevar['images'][$i]['img_src']);
					$pagevar['images'][$i]['wight'] = round($info[0]/6);
					$pagevar['images'][$i]['height'] = round($info[1]/6);
					$pagevar['images'][$i]['cmnt_usr_date'] = $this->operation_date_slash($pagevar['images'][$i]['cmnt_usr_date']);
				endfor;
			endif;
			$this->pagination->initialize($config);
			$pagevar['pages'] = $this->pagination->create_links();
		endif;
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		
		$this->load->view($pagevar['themeurl'].'/admin/comments',$pagevar);
	} /* end function commentslist */
	
	function photochange(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Администрирование | Замена фотографии',
					'baseurl' 		=> base_url(),
					'admin'			=> TRUE,
					'themeurl' 		=> $this->admin['themeurl'],
					'usite'			=> $this->admin['site'],
					'message'		=> $this->setmessage('','','',0),
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction'	=> $this->uri->uri_string(),
					'type'			=> $this->uri->segment(2),
					'text'			=> '',
					'image'			=> array(),
					'errortext'		=> 'Произошла ошибка при загрузке фотографии',
					'errorcode'		=> '0x0000',
					'ratio'			=> ''
					);
		if($this->input->post('btnsubmit')):
			if($_FILES['userfile']['error'] != 4):
				$this->form_validation->set_rules('userfile','"Фото"','callback_userfile_check');
				$this->form_validation->set_error_delimiters('<div class="message">','</div>');
				if (!$this->form_validation->run()):
					$_POST['btnsubmit'] = NULL;
					$this->photochange();
					return FALSE;
				endif;
				$_FILES['userfile']['name'] = preg_replace('/.+(.)(\.)+/',date("Ymdhis")."\$2", $_FILES['userfile']['name']);
				$_POST['file'] = $_FILES['userfile']['name'];
				if(!$this->fileupload('userfile',$this->admin['site'],603,907,TRUE,FALSE)):
					$pagevar['errorcode'] = '0x0013';
					$this->load->view('main/error',$pagevar);
					return FALSE;
				endif;
				$oldimage = $this->otherimagemodel->get_name($pagevar['type'],$this->admin['uid']);
				$filepath = getcwd().'/users/'.$this->admin['site'].'/images/'.$oldimage;
				if(!$this->filedelete($filepath)):
					$this->logmodel->insert_record($this->admin['uid'],'Ошибка удаления файла - '.$oldimage);
				endif;
				$filepath = getcwd().'/users/'.$this->admin['site'].'/_thumbs/Images/'.$oldimage;
				if(is_file($filepath)):
					if(!$this->filedelete($filepath)):
						$this->logmodel->insert_record($this->admin['uid'],'Ошибка удаления миниатюры - '.$oldimage);
					endif;	
				endif;
				$this->otherimagemodel->update_record($_POST,$pagevar['type'],$this->admin['uid']);
			else:
				$this->otherimagemodel->update_title($_POST['title'],$pagevar['type'],$this->admin['uid']);
			endif;
			switch ($pagevar['type']):
			
				case 'about' : 	$this->othertextmodel->update_record(nl2br($_POST['text']),$pagevar['type'],$this->admin['uid']);
								break;
			
			endswitch;
			$this->logmodel->insert_record($this->admin['uid'],'Изменение информациии "О нас"');
			$this->session->set_flashdata('operation_error','none');
			$this->session->set_flashdata('operation_message','none');
			$this->session->set_flashdata('operation_saccessfull','Операция выполнена успешно');
			redirect($pagevar['backpath']);
		endif;
		switch ($pagevar['type']):
			
			case 'about' : 	$pagevar['text'] = strip_tags($this->othertextmodel->read_text($pagevar['type'],$this->admin['uid']));
							$pagevar['image'] = $this->otherimagemodel->read_record($pagevar['type'],$this->admin['uid']);
							$pagevar['ratio']= '(Размер 907х603)';
							if(empty($pagevar['text']) and empty($pagevar['image']['oisrc'])) $pagevar['edit'] = FALSE;
							break;
			
		endswitch;
//		print_r($pagevar['image']['oisrc']);
		$this->load->view($pagevar['themeurl'].'/admin/photo-change',$pagevar);
		
	} /* end function photochange */
	
	function photodestroy(){
		
		$img_id = $this->uri->segment(4);
		$image = $this->imagesmodel->exist_image($img_id,$this->admin['uid']);
		if(!$image) redirect('page403');
		$backpath = $this->admin['site'].'/photo-albums/photo-gallery/'.$image['img_album'];
		$this->imagesmodel->image_delete($img_id,$this->admin['uid']);
		$this->albummodel->delete_photo($image['img_album']);
		$this->commentsmodel->delete_records($this->admin['uid'],0,$img_id);
		$filepath = getcwd().'/users/'.$this->admin['site'].'/images/'.$image['img_src'];
		if($this->filedelete($filepath)):
			$this->logmodel->insert_record($this->admin['uid'],'Фотография удалена');
			$this->session->set_flashdata('operation_error','none');
			$this->session->set_flashdata('operation_message','Фотография - '.$image['img_src']);
			$this->session->set_flashdata('operation_saccessfull','Фотография удалена успешно');
		else:
			$this->session->set_flashdata('operation_error','Файл отсутствует на диске');
			$this->session->set_flashdata('operation_message','none');
			$this->session->set_flashdata('operation_saccessfull','Фотография удалена c ошибкой');
		endif;
		$filepath = getcwd().'/users/'.$this->admin['site'].'/_thumbs/Images/'.$image['img_src'];
		if(is_file($filepath)):
			if(!$this->filedelete($filepath)):
				$this->logmodel->insert_record($this->admin['uid'],'Ошибка удаления миниатюры - '.$image['img_src']);
			endif;	
		endif;
		redirect($backpath);
	} /* end function photodestroy */
	
	function filedelete($file){
		
		if(is_file($file)):
			@unlink($file);
			return TRUE;
		else:
			return FALSE;
		endif;
	} /* end function filedelete */
	
	function photoslideshow(){
		
		$img_id = $this->uri->segment(4);
		$image = $this->imagesmodel->exist_image($img_id,$this->admin['uid']);
		if(!$image) redirect('page403');
		$backpath = $this->admin['site'].'/photo-albums/photo-gallery/'.$image['img_album'];
		$status = $this->imagesmodel->slideshow_status($img_id,$this->admin['uid'],abs($image['img_slideshow']-1));
		if($status):
			$this->session->set_flashdata('operation_error','none');
			$this->session->set_flashdata('operation_message','Фотография - '.$image['img_src']);
			$this->session->set_flashdata('operation_saccessfull','Фотография добавлена на главную страницу');
		else:
			$this->session->set_flashdata('operation_error','none');
			$this->session->set_flashdata('operation_message','Фотография - '.$image['img_src']);
			$this->session->set_flashdata('operation_saccessfull','Фотография убрана с главной страницу');
		endif;
		redirect($backpath);
	} /* end function photoslideshow */
							  
} /* end class*/
?>