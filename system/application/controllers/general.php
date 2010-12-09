<?php
class General extends Controller{

	var $months = array("01"=>"января", 	"02"=>"февраля",
						"03"=>"марта",		"04"=>"апреля",
						"05"=>"мая",		"06"=>"июня",
						"07"=>"июля",		"08"=>"августа",
						"09"=>"сентября", 	"10"=>"октября",
						"11"=>"ноября",		"12"=>"декабря"
					);
					
	var $usrinfo = array('uid'=>0,'name'=>'','subname'=>'','email'=>'','status'=>FALSE);
					
	function General(){
	
		parent::Controller();
		
		$this->load->model('eventsmodel');
		$this->load->model('albummodel');
		$this->load->model('friendsmodel');
		$this->load->model('socialmodel');
		$this->load->model('commentsmodel');
		$this->load->model('imagesmodel');
		$this->load->model('othertextmodel');
		$this->load->model('otherimagemodel');
		if($this->usersmodel->close_status($this->uri->segment(1))):
			redirect('closed-site');
		endif;
		$this->usrinfo['uid'] = $this->usersmodel->user_exist('usite',$this->uri->segment(1));
		if(!$this->usrinfo['uid']):
			redirect('not-existing');
		endif;
		$cookieuid = $this->session->userdata('userid');
		if((isset($cookieuid) and !empty($cookieuid)) and ($cookieuid === $this->usrinfo['uid'])):
			$login 			= $this->session->userdata('login');
			$confirmation 	= $this->session->userdata('confirmation');
			if($this->session->userdata('login_id') == md5($login.$confirmation)):
				$userinfo = $this->usersmodel->read_record($login);
				$this->usrinfo['firstname']		= $userinfo['uname'];
				$this->usrinfo['secondname'] 	= $userinfo['usubname'];
				$this->usrinfo['email'] 		= $userinfo['uemail'];
				$this->usrinfo['status'] 		= TRUE;
			else:
				$this->usrinfo['status'] = FALSE;
			endif;
		endif;
	} /* end constructor Main*/
	
	function index(){
		
		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $this->uri->segment(1),
					'message'		=> $this->setmessage('','','',0),
					'events'		=> array(),
					'images'		=> array(),
					'pagetext'		=> array(),
					'wedday'		=> 0,
					'wedtext'		=> '',
					'days'			=> ''
			);
		$days = array('1'=>'день','2'=>'дня','3'=>'дня','4'=>'дня','5'=>'дней','6'=>'дней','7'=>'дней','8'=>'дней','9'=>'дней','0'=>'дней');
		$this->session->set_userdata('backpage',$pagevar['usite']);
		$pagevar['pagetext'] = $this->othertextmodel->read_record('index',$this->usrinfo['uid']);
		$pagevar['wedday'] = $this->usersmodel->weddingday($this->usrinfo['uid']);
		if($pagevar['wedday'] < 0):
			$pagevar['wedtext'] = 'До свадьбы осталось';
		elseif($pagevar['wedday'] > 0):
			$pagevar['wedtext'] = 'Мы женаты';
		else:
			$pagevar['wedtext'] = 'Поздравьте нас!<br/>У нас сегодня СВАДЬБА!';
		endif;
		$pagevar['wedday'] = abs($pagevar['wedday']);
		$index = fmod($pagevar['wedday'],10.0);
		$pagevar['days'] = $days[$index];
		$pagevar['events'] = $this->eventsmodel->new_events($this->usrinfo['uid'],3);
		$pagevar['images'] = $this->imagesmodel->slideshow_images($this->usrinfo['uid'],TRUE);
//		print_r($pagevar['images']); exit;
		for($i = 0;$i < count($pagevar['events']); $i++):
			$pagevar['events'][$i]['evnt_date'] = $this->operation_date($pagevar['events'][$i]['evnt_date']);
			$pagevar['events'][$i]['evnt_text'] = strip_tags($pagevar['events'][$i]['evnt_text']);
			if(mb_strlen($pagevar['events'][$i]['evnt_text'],'UTF-8') > 325):									
				$pagevar['events'][$i]['evnt_text'] = mb_substr($pagevar['events'][$i]['evnt_text'],0,325,'UTF-8');	
				$pos = mb_strrpos($pagevar['events'][$i]['evnt_text'],'.',0,'UTF-8');
				$pagevar['events'][$i]['evnt_text'] = mb_substr($pagevar['events'][$i]['evnt_text'],0,$pos,'UTF-8');
				$pagevar['events'][$i]['evnt_text'] .= '. ';
			endif;
		endfor;
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf):
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		endif;
		
		$this->load->view($pagevar['themeurl'].'/index',$pagevar);
	} /* end function index */
	
	function albums(){
	
		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт | Фоторепортажи',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $this->uri->segment(1),
					'albums'		=> array(),
					'message'		=> $this->setmessage('','','',0)
					);
		$this->session->set_userdata('backpage',$pagevar['usite'].'/photo-albums');
		$pagevar['albums'] = $this->albummodel->albums_records($this->usrinfo['uid']);
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
			 
		$this->load->view($pagevar['themeurl'].'/albums',$pagevar);
	} /* end function albums */
	
	function photo(){

		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт | Фоторепортажи | Фотографии',
					'baseurl' 		=> base_url(),
					'backpath' 		=> $this->session->userdata('backpage'),
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $this->uri->segment(1),
					'images'		=> array(),
					'album'			=> $this->uri->segment(4),
					'message'		=> $this->setmessage('','','',0),
					);
		$alb_id = $this->uri->segment(4);
		$album = $this->albummodel->exist_album($alb_id,$this->usrinfo['uid']);
		if(!$album) redirect('page403');
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf):
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		endif;
		$pagevar['images'] = $this->imagesmodel->get_images($pagevar['album'],$this->usrinfo['uid']);
		for($i = 0; $i < count($pagevar['images']); $i++):
			if($pagevar['images'][$i]['img_slideshow']) 
				$pagevar['images'][$i]['img_slideshow'] = 'Да';
			else 
				$pagevar['images'][$i]['img_slideshow'] = 'Нет';
		endfor;
		$this->load->view($pagevar['themeurl'].'/photo-gallery',$pagevar);
	} /* end function photo */
	
	function photocomments($img_id = 0){
	
		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$usersite = $this->uri->segment(1);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт | Фоторепортажи | Фотографии | Комментарии',
					'baseurl' 		=> base_url(),
					'backpath' 		=> $usersite.'/photo-albums/photo-gallery/',
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $usersite,
					'formaction' 	=> $this->uri->uri_string(),
					'album'			=> '',
					'image'			=> array(),
					'comments'		=> array(),
					'count'			=> 0,
					'user'			=> $this->usrinfo,
					'message'		=> $this->setmessage('','','',0),
					);
		if($img_id == 0 or empty($img_id)):
			$img_id = $this->uri->segment(4);
		endif;
		$image = $this->imagesmodel->exist_image($img_id,$this->usrinfo['uid']);
		if(!$image) redirect('page403');
		$pagevar['image'] = $this->imagesmodel->read_record($img_id,$this->usrinfo['uid']);
		if($this->input->post('commit')):
			$this->form_validation->set_rules('user_name','"Ваше имя"','required|trim');
			$this->form_validation->set_rules('user_email','"E-mail"','required|valid_email|trim');
			$this->form_validation->set_rules('cmnt_text','"Комментарий"','required|trim');
			$this->form_validation->set_rules('homepage','"Веб-сайт"','trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$_POST['commit'] = NULL;
				$this->photocomments($img_id);
				return FALSE;
			else:
				if(isset($_POST['homepage']) and !empty($_POST['homepage']))
					if(strncmp(strtolower($_POST['homepage']),'http://',7) != 0)
						$_POST['homepage'] = 'http://'.$_POST['homepage'];
				$this->imagesmodel->insert_comments($img_id,$this->usrinfo['uid']);
				$_POST['img_id'] = $img_id;
				$this->commentsmodel->insert_record($this->usrinfo['uid'],$_POST,0,$pagevar['image']['album'],$img_id);
				$_POST['commit'] = NULL;
				redirect($pagevar['formaction']);
				return TRUE;
			endif;
		endif;
		$pagevar['album'] = $this->albummodel->album_title($pagevar['image']['album'],$this->usrinfo['uid']);
		$pagevar['backpath'] .= $pagevar['image']['album'];
		$pagevar['image']['src'] = $pagevar['baseurl'].'users/'.$usersite.'/images/'.$pagevar['image']['src'];
		$info = getimagesize($pagevar['image']['src']);
		$pagevar['image']['wight'] = round($info[0]/2);
		$pagevar['image']['height'] = round($info[1]/2);
		$pagevar['comments'] = $this->commentsmodel->comments_records($this->usrinfo['uid'],0,$img_id);
		for($i = 0;$i < count($pagevar['comments']);$i++):
			$pagevar['comments'][$i]['cmnt_usr_date'] = $this->operation_date_slash($pagevar['comments'][$i]['cmnt_usr_date']);
		endfor;
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		
		$this->load->view($pagevar['themeurl'].'/image',$pagevar);
	} /* end function photocomments */
	
	function events(){
	
		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $this->uri->segment(1),
					'events'		=> array(),
					'pages'			=> '',
					'count'			=> 0,
					'message'		=> $this->setmessage('','','',0)
					);
		$this->session->set_userdata('backpage',$pagevar['usite'].'/events');
		$pagevar['count'] = $this->eventsmodel->count_records($this->usrinfo['uid']);
		$config['base_url'] 		= $pagevar['baseurl'].$pagevar['usite'].'/events';
        $config['total_rows'] 		= $pagevar['count']; 
        $config['per_page'] 		= 5;
        $config['num_links'] 		= 2;
        $config['uri_segment'] 		= 3;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open']		= '<b>';
		$config['cur_tag_close'] 	= '</b>';
		$from = intval($this->uri->segment(3));
		if(isset($from) and !empty($from)):
			$this->session->set_userdata('backpage',$pagevar['usite'].'/events/'.$from);
		endif;			
		$pagevar['events'] = $this->eventsmodel->events_limit($this->usrinfo['uid'],5,$from);
		for($i = 0;$i < count($pagevar['events']);$i++):
			$pagevar['events'][$i]['evnt_date'] = $this->operation_date($pagevar['events'][$i]['evnt_date']);
		endfor;
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		
		$this->load->view($pagevar['themeurl'].'/events',$pagevar);
	} /* end function events */
	
	function event($event_id = 0){
		
		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'backpath' 		=> $this->session->userdata('backpage'),
					'formaction' 	=> $this->uri->uri_string(),
					'usite'			=> $this->uri->segment(1),
					'event'			=> array(),
					'comments'		=> array(),
					'count'			=> 0,
					'user'			=> $this->usrinfo,
					'message'		=> $this->setmessage('','','',0)
					);
		if($event_id == 0 or empty($event_id)):
			$event_id = $this->uri->segment(3);
		endif;
		$event = $this->eventsmodel->exist_event($event_id,$this->usrinfo['uid']);
		if(!$event) redirect('page403');
		$this->session->unset_userdata('commentlist');
		if($this->input->post('commit')):
			$this->form_validation->set_rules('user_name','"Ваше имя"','required|trim');
			$this->form_validation->set_rules('user_email','"E-mail"','required|valid_email|trim');
			$this->form_validation->set_rules('cmnt_text','"Комментарий"','required|trim');
			$this->form_validation->set_rules('homepage','"Веб-сайт"','trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$_POST['commit'] = NULL;
				$this->event($event_id);
				return FALSE;
			else:
				if(isset($_POST['homepage']) and !empty($_POST['homepage']))
					if(strncmp(strtolower($_POST['homepage']),'http://',7) != 0)
						$_POST['homepage'] = 'http://'.$_POST['homepage'];
				$this->eventsmodel->insert_comments($event_id,$this->usrinfo['uid']);
				$_POST['event_id'] = $event_id;
				$this->commentsmodel->insert_record($this->usrinfo['uid'],$_POST,$event_id,0,0);
				$_POST['commit'] = NULL;
				redirect($pagevar['formaction']);
				return TRUE;
			endif;
		endif;
		$pagevar['event'] = $this->eventsmodel->event_record($event_id);
		if(count($pagevar['event']) > 0):
			$pagevar['event']['evnt_date'] = $this->operation_date($pagevar['event']['evnt_date']);
		endif;
		$pagevar['comments'] = $this->commentsmodel->comments_records($this->usrinfo['uid'],$event_id,0);
		for($i = 0;$i < count($pagevar['comments']);$i++):
			$pagevar['comments'][$i]['cmnt_usr_date'] = $this->operation_date_slash($pagevar['comments'][$i]['cmnt_usr_date']);
		endfor;
		$pagevar['title'] .=' | '.$pagevar['event']['evnt_title'];
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		
		$this->load->view($pagevar['themeurl'].'/event',$pagevar);	
	} /* end function event */

	function friends(){
	
		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $this->uri->segment(1),
					'friend'		=> array(),
					'socials'		=> array(),
					'key'			=> 0,
					'message'		=> $this->setmessage('','','',0)
					);
		$this->session->set_userdata('backpage',$pagevar['usite'].'/friends');
		$friends = $this->friendsmodel->friends_records($this->usrinfo['uid']);
		$pagevar['social'] = $this->socialmodel->social_records();
		$i = 0; $y = 0; $pagevar['key'] = 0;
		$pagevar['friendcard'][$i][$y] = array('id'=>0,'name'=>'','profession'=>'','social'=>0,'note'=>'','image'=>'');
		for($fr = 0;$fr < count($friends);$fr++):
			$pagevar['key']++;				
			$pagevar['friend'][$i][$y]['id'] 			= $friends[$fr]['fr_id'];
			$pagevar['friend'][$i][$y]['name'] 			= $friends[$fr]['fr_name'];
			$pagevar['friend'][$i][$y]['profession'] 	= $friends[$fr]['fr_profession'];
			$pagevar['friend'][$i][$y]['social'] 		= $friends[$fr]['fr_social'];
			$pagevar['friend'][$i][$y]['note'] 			= $friends[$fr]['fr_note'];
			$pagevar['friend'][$i][$y]['image'] 		= $friends[$fr]['fr_image'];
			if($pagevar['key'] % 3 == 0):
				$i++; $y = 0;
			else:
				$y++;	
			endif;
		endfor;
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf)
			$pagevar['message'] = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		
		$this->load->view($pagevar['themeurl'].'/friends',$pagevar);
	} /*end function friends */
	
	function about(){
	
		$cfg = $this->configmodel->read_record($this->usrinfo['uid']);
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'themeurl' 		=> $cfg['cfgthemepath'],
					'admin'			=> $this->usrinfo['status'],
					'usite'			=> $this->uri->segment(1),
					'message'		=> $this->setmessage('','','',0),
					'type'			=> $this->uri->segment(2),
					'text'			=> '',
					'image'			=> array()
					);
		$this->session->set_userdata('backpage',$pagevar['usite'].'/about');
		$pagevar['text'] = nl2br($this->othertextmodel->read_text($pagevar['type'],$this->usrinfo['uid']));
		$pagevar['image'] = $this->otherimagemodel->read_record($pagevar['type'],$this->usrinfo['uid']);	
		$this->load->view($pagevar['themeurl'].'/about',$pagevar);
	} /* end function about */
	
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
	
		$section = $this->uri->segment(2);
		$id = $this->uri->segment(4);
		switch ($section){
			case 'album' :	$image = $this->albummodel->get_image($id);	break;
			case 'photo' :	$image = $this->imagesmodel->get_image($id); break;
			case 'friend': 	$image = $this->friendsmodel->get_image($id); break;
		}
		header('Content-type: image/gif');
		echo $image;
	} /* end function viewimage */
	
	function setmessage($error,$saccessfull,$message,$status){
			
		$msg['error'] 		= $error;
		$msg['saccessfull'] = $saccessfull;
		$msg['message'] 	= $message;
		$msg['status'] 		= $status;
		return $msg;
	} /* end function setmessage */
	
} /* end class General */
?>