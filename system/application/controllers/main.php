<?php
class Main extends Controller{

	function Main(){
	
		parent::Controller();
	} /* end constuructor Main*/
	
	function activation(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Регистрация нового пользователя | Активация',
					'baseurl' 		=> base_url(),
					);
		$code = $this->uri->segment(2);
		if(!isset($code) or !empty($code)):
			if($this->usersmodel->user_id('uconfirmation',$code) == FALSE):
				$this->session->unset_userdata('signupstatus');
				$this->session->unset_userdata('userid');
				$pagevar['text'] = '<b>Активация невозможна: ссылка устарела!</b>';
				$this->parser->parse('main/message',$pagevar);
				return TRUE;
			endif;
			if($this->usersmodel->update_status($code)):
				$this->session->set_userdata('signupstatus',TRUE);
				$user_id = $this->usersmodel->user_id('uconfirmation',$code);
				$this->session->set_userdata('userid',$user_id);
				redirect('signup/themes');
			else:
				$pagevar['text'] = '<b>Активация невозможна: профиль уже активирован</b>';
				$this->parser->parse('main/message',$pagevar);
				return TRUE;
			endif;
		else:
			redirect('page404');
		endif;
	}  /*end function registration*/
	
	function authorization(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Авторизация пользователя',
					'baseurl' 		=> base_url(),
					'text'			=> '',
					'formaction'	=> 'login'
					);
		if($this->input->post('btsubmit')):
			$this->form_validation->set_rules('login','"Логин"','required|trim');
			$this->form_validation->set_rules('password','"Пароль"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="join_error">','</div>');
			if($this->form_validation->run()):
				$_POST['btsubmit'] = NULL;
				$user = $this->usersmodel->auth_user($_POST['login'],$_POST['password']);
				if(!$user):
					redirect('login');
				endif;
				if($user['ustatus'] == 'enabled'):
					$this->session->set_userdata('login_id',md5(crypt($_POST['login'],$_POST['password'])));
					$this->session->set_userdata('login',$_POST['login']);
					$this->session->set_userdata('password',$_POST['password']);
					$this->session->set_userdata('site',$user['usite']);
					redirect($user['usite'].'/admin');
				else:
					$pagevar['text'] = '<b>Учетная запись не активирована!</b>';
					$this->parser->parse('main/login',$pagevar);
					return TRUE;
				endif;
			else:
				return FALSE;
			endif;
		endif;
		$this->parser->parse('main/login',$pagevar);
	} /*end function authorization*/ 
	
	function choicetheme(){
		
		$status = $this->session->userdata('signupstatus');
		if(!isset($status) or empty($status)) redirect('signup');
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Регистрация нового пользователя | Выбор темы',
					'baseurl' 		=> base_url(),
					'pathback'		=> base_url(),
					'themes'		=> array(),
					'formaction'	=> 'signup/themes'
					);
		if($this->input->post('btsubmit')):			
			$_POST['btsubmit'] = NULL;
			$this->session->set_userdata('signupstatus',TRUE);
			$themes = $this->themesmodel->read_record($_POST['theme']);
			if($themes['thstatus'] != 'free'):
				redirect(base_url());
			endif;
			$theme['userid'] = $this->session->userdata('userid');;
			$theme['name'] 	 = $themes['thname'];
			$theme['path'] 	 = $themes['thpath'];
			$this->configmodel->insert_record($theme);
			redirect('signup/finish');
		endif;
		$pagevar['themes'] = $this->themesmodel->read_records(TRUE);
		$this->parser->parse('main/profile/step2',$pagevar);
	} /* end fun choicetheme */
							  
	function capcha(){
	
		$backimg = base_url().'images/capcha/'.round(mt_rand(1,3)).'.jpg';
		$image   = ImageCreateFromJpeg($backimg);
		$color   = ImageColorAllocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		$font 	 = getcwd().'/fonts/addict.ttf';
		ImageTtfText($image,23,mt_rand(-5,5),3,30,$color,$font,$this->session->userdata('capcha'));
		Header("Content-type: image/jpeg");
		ImageJpeg($image);
		ImageDestroy($image);
	} /* end function capcha */

	function code_check($code){
		
		if($code != $this->session->userdata('capcha')):
			$this->form_validation->set_message('code_check','Не верный код защиты!');
			return FALSE;
		endif;
		return TRUE;
	} /* end function code_check */
	
	function email_check($email){
		
		if($this->usersmodel->user_exist('uemail',$email)):
			$this->form_validation->set_message('email_check','E-mail уже ceществует');
			return FALSE;
		endif;
		return TRUE;
	} /* end function email_check */
									
	function error($text,$code){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Произошла ошибка при выполнении скрипта',
					'baseurl' 		=> base_url(),
					'pathback'		=> '/',
					'errortext'		=> $text,
					'errorcode'		=> $code
				);
		$this->parser->parse('main/error',$pagevar);
	} /* end function error */
	
	function finish(){
		
		$status = $this->session->userdata('signupstatus');
		if(!isset($status) or empty($status)) redirect('signup');
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Регистрация нового пользователя | Завершение регистрации',
					'baseurl' 		=> base_url(),
					'site'			=> '',
					'pathback'		=> '',
					'errortext'		=> 'Произошла ошибка при создании учетной записи.',
					'errorcode'		=> '0x0000'
				);
		$user_id = $this->session->userdata('userid');
		$pagevar['site'] = $this->usersmodel->read_field($user_id,'usite');
		if(!$pagevar['site']):
			$pagevar['errorcode'] = '0x0001';
			$this->parser->parse('main/error',$pagevar);
			return FALSE;
		endif;
		$userdir = getcwd().'/users/'.$pagevar['site'];
		if(is_dir($userdir)):
			$pagevar['errorcode'] = '0x0002';
			$this->parser->parse('main/error',$pagevar);
			return FALSE;
		endif;
		if(!mkdir($userdir,'0755')):
			$pagevar['errorcode'] = '0x0003';
			$this->parser->parse('main/error',$pagevar);
			return FALSE;
		else:
			if(!mkdir($userdir.'/images','0777')):
				$pagevar['errorcode'] = '0x0004';
				$this->parser->parse('main/error',$pagevar);
				return FALSE;
			endif;
			if(!mkdir($userdir.'/video','0777')):
				$pagevar['errorcode'] = '0x0005';
				$this->parser->parse('main/error',$pagevar);
				return FALSE;
			endif;
			if(!mkdir($userdir.'/swf','0777')):
				$pagevar['errorcode'] = '0x0006';
				$this->parser->parse('main/error',$pagevar);
				return FALSE;
			endif;
		endif;
		$this->session->unset_userdata('signupstatus');
		$this->session->unset_userdata('userid');
		$pagevar['pathback'] = base_url().$pagevar['site'];
		$this->parser->parse('main/profile/finish',$pagevar);
	} /* end function finish */
	
	function index(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Главная страница системы постороения свадебных сайтов',
					'baseurl' 		=> base_url(),
					'formaction'	=> 'login'
					);
		$this->session->unset_userdata('signupstatus');
		$this->session->unset_userdata('userid');
		$this->parser->parse('main/welcome',$pagevar);
	} /* end function index */
	
	function login_check($login){
		
		if(preg_match('/^admin/i',$login)):
			$this->form_validation->set_message('login_check','Не допустимый логин '.$login);
			return FALSE;
		endif;
		if(!preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9_]*$/',$login)):
			$this->form_validation->set_message('login_check','Логин не соответствует правилам');
			return FALSE;
		endif;
		if($this->usersmodel->user_exist('ulogin',$login)):
			$this->form_validation->set_message('login_check','Логин уже занят');
			return FALSE;
		endif;
		return TRUE;
	} /* end function login_check */
	
	function page404(){
	
		$this->load->view('main/page404');
	} /* end function index */
	
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
	
	function signup(){

		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'title'			=> 'Регистрация нового пользователя | Анкета',
					'baseurl' 		=> base_url(),
					'pathback'		=> base_url(),
					'formaction'	=> 'signup'
					);
		$this->session->set_userdata('signupstatus',FALSE);
		$this->session->unset_userdata('userid');
		if($this->input->post('btsubmit')):
			$this->form_validation->set_rules('login','"Ваш логин"','required|callback_login_check|trim');
			$this->form_validation->set_rules('password','"Ваш пароль"','required|min_length[6]|matches[confirmpass]|trim');
			$this->form_validation->set_rules('confirmpass','"Подтверждение пароля"','required|trim');
			$this->form_validation->set_rules('sitename','"Нзвание сайта"','required|callback_sitename_check|trim');
			$this->form_validation->set_rules('name','"Ваше имя"','required|xss_clean|encode_php_tags|trim');
			$this->form_validation->set_rules('subname','"Ваша фамилия"','required|trim');
			$this->form_validation->set_rules('email','"Ваш email"','required|valid_email|trim|callback_email_check');
			$this->form_validation->set_rules('code','"Код защиты"','required|trim|callback_code_check');
			$this->form_validation->set_error_delimiters('<dd><div class="join_error">','</div></dd>');
			$this->form_validation->set_message('min_length','Длина пароля не менее 6 символов.');
			$this->form_validation->set_message('matches','Пароли не совпадают');
			if(!$this->form_validation->run()):
				$_POST['btsubmit'] = NULL;
				$this->signup();
				return FALSE;
			else:
				$_POST['btsubmit'] = NULL;
				$_POST['confirm'] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].mktime());
				$user_id = $this->usersmodel->insert_record($_POST);
				$message = 'Для активации аккаунта пройдите по следующей ссылке'."\n".'<a href="'.base_url().'activation/'.$_POST['confirm'].'" target="_blank">'.base_url().'activation/'.$_POST['confirm'].'</a>';
				$message .= "\n".'или скопируйте ссылку в окно ввода адреса браузера и нажмите enter.';
				if($this->sendmail($_POST['email'],$message,"Подтверждение регистарции на сайте","admin@my-wedding.ru")):
					$pagevar['text'] = '<b>Учетная запись создана.</b><br><b>На Ваш адрес "'.$_POST['email'].'" выслано письмо</b><br><b>Для активации учетной записи перейдите по ссылке указанной в письме</b><br><b>Спасибо за регистрацию на нашем сайте.</b><br>';
					$this->parser->parse('main/message',$pagevar);
					return TRUE;
				else:
					$this->email->print_debugger();
				endif;
			endif;
		endif;
		$this->session->set_userdata('capcha',mt_rand(100000,999999));
		$this->parser->parse('main/profile/step1',$pagevar);
	} /* end function signup */
	
	function sitename_check($sitename){
	
		if(preg_match('/^admin/i',$sitename)):
			$this->form_validation->set_message('sitename_check','Не допустимое название сайта');
			return FALSE;
		endif;
		if(!preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9_]*$/',$sitename)):
			$this->form_validation->set_message('sitename_check','Название сайта не соответствует правилам');
			return FALSE;
		endif;
		if($this->usersmodel->user_exist('usite',$sitename)):
			$this->form_validation->set_message('sitename_check','Название сайта уже занято');
			return FALSE;
		endif;
		return TRUE;
	} /* end function sitename_check */
	
} /* end class*/
?>