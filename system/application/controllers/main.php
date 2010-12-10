<?php
class Main extends Controller{

	function Main(){
	
		parent::Controller();
	} /* end constructor Main*/
	
	function activation(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Регистрация нового пользователя | Активация',
					'baseurl' 		=> base_url(),
					);
		$code = $this->uri->segment(2);
		if(!isset($code) or !empty($code)):
			if($this->usersmodel->user_id('uconfirmation',$code) == FALSE):
				$this->session->unset_userdata('userid');
				$pagevar['text'] = '<b>Активация невозможна: ссылка устарела!</b>';
				$this->load->view('main/message',$pagevar);
				return TRUE;
			endif;
			if($this->usersmodel->update_status($code)):
				$user_id = $this->usersmodel->user_id('uconfirmation',$code);
				$this->session->set_userdata('userid',$user_id);
				redirect('signup/themes');
			else:
				$pagevar['text'] = '<b>Активация невозможна: профиль уже активирован</b>';
				$this->load->view('main/message',$pagevar);
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
					'author'		=> '',
					'title'			=> 'Авторизация пользователя',
					'baseurl' 		=> base_url(),
					'text'			=> '',
					'formaction'	=> 'login',
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
					redirect('login');
				endif;
				if($this->usersmodel->close_status($user['usite'])):
					$this->usersmodel->open_user($user['uid']);
					$this->session->set_flashdata('operation_error','none');
					$this->session->set_flashdata('operation_message','Сайт сново функционирует');
					$this->session->set_flashdata('operation_saccessfull','Включение произведено успешно');
					$this->load->model('logmodel');
					$this->logmodel->insert_record($user['uid'],'Произведено включение сайта');
				endif;
				if($user['ustatus'] == 'enabled'):
					$this->session->sess_destroy();
					$this->session->set_userdata('login_id',md5($_POST['login'].$user['uconfirmation']));
					$this->session->set_userdata('login',$_POST['login']);
					$this->session->set_userdata('confirmation',$user['uconfirmation']);
					$this->session->set_userdata('userid',$user['uid']);
					$this->usersmodel->active_user($_POST['login']);
					$this->load->model('logmodel');
					$this->logmodel->insert_record($user['uid'],'login');
					redirect($user['usite'].'/admin');
				else:
					$pagevar['message'] = '<div class="join_error">Учетная запись не активирована!</div>';
					$this->load->view('main/login',$pagevar);
					return TRUE;
				endif;
			else:
				redirect('login');
			endif;
		endif;
		$this->load->view('main/login',$pagevar);
	} /*end function authorization*/ 
	
	function choicetheme(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Регистрация нового пользователя | Выбор темы',
					'baseurl' 		=> base_url(),
					'backpath'		=> '',
					'themes'		=> array(),
					'formaction'	=> $this->uri->uri_string(),
					'errortext'		=> 'Произошла ошибка при создании учетной записи.',
					'errorcode'		=> '0x0000'
					);
		$user_id = $this->session->userdata('userid');
		if(!isset($user_id) or empty($user_id)):
			$pagevar['errorcode'] = '0x0007';
			$this->load->view('main/error',$pagevar);
			return FALSE;
		endif;
		if($this->input->post('btsubmit')):			
			$_POST['btsubmit'] = NULL;
			$themes = $this->themesmodel->read_record($_POST['theme']);
			if($themes['thstatus'] != 'free'):
				redirect(base_url());
			endif;
			$theme['userid'] = $user_id;
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

	function passrestore(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Восстановление пароля',
					'baseurl' 		=> base_url(),
					'text'			=> '',
					'formaction'	=> 'restore',
					'message'		=> '',
					'errortext'		=> 'Произошла ошибка при создании учетной записи.',
					'errorcode'		=> '0x0000'
					);
		if($this->input->post('btsubmit')):
			$this->form_validation->set_rules('email','"E-mail"','required|valid_email|trim|callback_email_restore');
			$this->form_validation->set_error_delimiters('<div class="join_error">','</div>');
			if($this->form_validation->run()):
				$_POST['btsubmit'] = NULL;
				$password = $this->generate_password(12);
				if(!$this->usersmodel->update_password($password,$_POST['email'])):
					$pagevar['errorcode'] = '0x0007';
					$this->load->view('main/error',$pagevar);
					return FALSE;
				endif;
				$message = "Weweds.ru\nСистема восстановления паролей!\nНовый пароль - ".$password."\nВвойдите в систему под новым паролем.\nМожете измениете его через панель администратора.";
				if($this->sendmail($_POST['email'],$message,"Восстановление пароля","admin@weweds.ru")):
					$pagevar['text'] = '<b>На указанный E-mail выслано письмо c новым паролем</b>';
					$this->load->view('main/message',$pagevar);
					return TRUE;
				else:
					$this->email->print_debugger();
				endif;
			else:
				$_POST['btsubmit'] = NULL;
				$this->passrestore();
				return FALSE;
			endif;
		endif;
		$this->load->view('main/restore',$pagevar);
	} /* end fun restore */
	
	function generate_password($number){

		$arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0');
		$pass = '';
		for($i = 0; $i < $number; $i++):
			$index = rand(0,count($arr) - 1);
			$pass .= $arr[$index];
		endfor;
		return $pass;
	} /* end function generate_password */
	
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
	
	function email_restore($email){
	
		if(!$this->usersmodel->user_exist('uemail',$email)):
			$this->form_validation->set_message('email_restore','E-mail не зарегистрирован');
			return FALSE;
		endif;
		return TRUE;
	} /* end function email_restore */

	function error($text,$code){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Произошла ошибка при выполнении скрипта',
					'baseurl' 		=> base_url(),
					'pathback'		=> '/',
					'errortext'		=> $text,
					'errorcode'		=> $code
				);
		$this->load->view('main/error',$pagevar);
	} /* end function error */
	
	function finish(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Регистрация нового пользователя | Завершение регистрации',
					'baseurl' 		=> base_url(),
					'site'			=> '',
					'backpath'		=> '',
					'errortext'		=> 'Произошла ошибка при создании учетной записи.',
					'errorcode'		=> '0x0000'
				);
		$user_id = $this->session->userdata('userid');
		if(!isset($user_id) or empty($user_id)):
			$pagevar['errorcode'] = '0x0007';
			$this->load->view('main/error',$pagevar);
			return FALSE;
		endif;
		$pagevar['site'] = $this->usersmodel->read_field($user_id,'usite');
		if(!$pagevar['site']):
			$pagevar['errorcode'] = '0x0001';
			$this->load->view('main/error',$pagevar);
			return FALSE;
		endif;
		$userdir = getcwd().'/users/'.$pagevar['site'];
		if(is_dir($userdir)):
			$pagevar['errorcode'] = '0x0002';
			$this->load->view('main/error',$pagevar);
			return FALSE;
		endif;
		if(!mkdir($userdir,0777)):
			$pagevar['errorcode'] = '0x0003';
			$this->load->view('main/error',$pagevar);
			return FALSE;
		else:
			if(!mkdir($userdir.'/images',0777)):
				$pagevar['errorcode'] = '0x0004';
				$this->load->view('main/error',$pagevar);
				return FALSE;
			endif;
			if(!mkdir($userdir.'/video',0777)):
				$pagevar['errorcode'] = '0x0005';
				$this->load->view('main/error',$pagevar);
				return FALSE;
			endif;
			if(!mkdir($userdir.'/swf',0777)):
				$pagevar['errorcode'] = '0x0006';
				$this->load->view('main/error',$pagevar);
				return FALSE;
			endif;
		endif;
		$pagevar['errorcode'] = $this->defaultobjects($user_id,$pagevar['site']);
		if($pagevar['errorcode'] != '0x0000'):
			$this->load->view('main/error',$pagevar);
			return FALSE;
		endif;
		$this->session->sess_destroy();
		$pagevar['backpath'] = base_url().$pagevar['site'];
		$this->load->view('main/profile/finish',$pagevar);
	} /* end function finish */
	
	function defaultobjects($uid,$site){
		
		/* cоздание записи по-умолчанию */
		$this->load->model('eventsmodel');
		$this->eventsmodel->insert_record(array('title'=>'Тестовая запись','date'=>date("Y-m-d"),'text'=>'Текст записи'),$uid);
		/* cоздание альбом по-умолчанию */
		$this->load->model('albummodel');
		$filepath = getcwd().'/images/default/wedding.jpg';
		$file = fopen($filepath,'rb');
		$image = fread($file,filesize($filepath));
		fclose($file);
		$album = $this->albummodel->insert_record(array('title'=>'Тестовы альбом','annotation'=>'Описание альбома','image'=>$image,'photo_title'=>'фото'),$uid);
		$file = getcwd().'/images/default/1.jpg';
		$newfile = getcwd().'/users/'.$site.'/images/1.jpg';
		if (!copy($file,$newfile)):
    		return '0x0008';
		endif;
		$file = getcwd().'/images/default/2.jpg';
		$newfile = getcwd().'/users/'.$site.'/images/2.jpg';
		if (!copy($file,$newfile)):
    		return '0x0008';
		endif;
		$this->load->model('imagesmodel');
		for($i = 1; $i < 3; $i++):
			$filepath = getcwd().'/images/default/thumb_'.$i.'.jpg';
			$file = fopen($filepath,'rb');
			$image = fread($file,filesize($filepath));
			fclose($file); 
			$this->imagesmodel->insert_record(array('file'=>$i.'.jpg','imagetitle'=>'Описание фото','album'=>$album,'thumb'=>$image),$uid);
			$this->albummodel->insert_photo($album);
		endfor;
		/* cоздание карточки друга по-умолчанию */
		$this->load->model('friendsmodel');
		$this->load->model('socialmodel');
		$filepath = getcwd().'/images/default/friend.jpg';
		$file = fopen($filepath,'rb');
		$image = fread($file,filesize($filepath));
		fclose($file);
		$friend = $this->friendsmodel->insert_record(array('name'=>'Мой друг','profession'=>'Студент','social'=>2,'image'=>$image,'note'=>'Описание друга'),$uid);
		$this->socialmodel->insert_record(array('friend_id'=>$friend,'social'=>'ВКОНТАКТЕ','href'=>'http://vkontakte.ru'));
		$this->socialmodel->insert_record(array('friend_id'=>$friend,'social'=>'ОДНОКЛАССНИКИ','href'=>'http://odnoklasniki.ru/'));
		/* cоздание страницы "О нас" по-умолчанию */
		$this->load->model('othertextmodel');
		$this->load->model('otherimagemodel');
		$this->othertextmodel->insert_record('О нас...','','about',$uid);
		$this->othertextmodel->insert_record('Текст главной страници','Weweds.ru','index',$uid);
		$this->otherimagemodel->insert_record(array('file'=>'','title'=>'О нас'),$uid,'about');
		return '0x0000';
	} /* end function defaultobjects */
	
	function index(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'formaction'	=> 'login'
					);
		$this->session->unset_userdata('userid');
		$this->load->view('main/welcome',$pagevar);
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
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					);
		$this->load->view('main/page404',$pagevar);
	} /* end function page404 */
  
	function page403(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					);
		if(!$this->session->userdata('errormessage')):
			$redirect = '';
			$redirect = $this->session->userdata('backpage');
			if(empty($redirect)) redirect('page404');
			redirect($redirect);
		endif;
		$this->session->set_userdata('errormessage',FALSE);
		$this->load->view('main/page403',$pagevar);
	} /* end function page404 */

	function notexisting(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					);
		if(!$this->session->userdata('errormessage')):
			$redirect = '';
			$redirect = $this->session->userdata('backpage');
			if(empty($redirect)) redirect('page404');
			redirect($redirect);
		endif;
		$this->session->set_userdata('errormessage',FALSE);
		$this->load->view('main/notexisting',$pagevar);
	} /* end function notexisting */

	function closesite(){
	
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					);
		if(!$this->session->userdata('errormessage')):
			$redirect = '';
			$redirect = $this->session->userdata('backpage');
			if(empty($redirect)) redirect('page404');
			redirect($redirect);
		endif;
		$this->session->set_userdata('errormessage',FALSE);	
		$this->load->view('main/closesite',$pagevar);
	} /* end function notexisting */

	function accountstatus(){
		
		$pagevar = array(
					'description'	=> '',
					'keywords' 		=> '',
					'author'		=> '',
					'title'			=> 'Свадебный сайт',
					'baseurl' 		=> base_url(),
					'text' 			=> "Регистрация до конца не пройдена.<br />Сайт еще не функционирует. Проверьте почтовый ящик на наличие письма с подтверждением регистарации."
					);
		if(!$this->session->userdata('errormessage')):
			$redirect = '';
			$redirect = $this->session->userdata('backpage');
			if(empty($redirect)) redirect('page404');
			redirect($redirect);
		endif;
		$this->session->set_userdata('errormessage',FALSE);	
		$this->load->view('main/accountstatus',$pagevar);
	} /* end function accountstatus */
	
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
					'author'		=> '',
					'title'			=> 'Регистрация нового пользователя | Анкета',
					'baseurl' 		=> base_url(),
					'pathback'		=> base_url(),
					'formaction'	=> 'signup'
					);
		$this->session->unset_userdata('userid');
		if($this->input->post('btsubmit')):
			$this->form_validation->set_rules('login','"Ваш логин"','required|callback_login_check|trim');
			$this->form_validation->set_rules('password','"Ваш пароль"','required|min_length[6]|matches[confirmpass]|trim');
			$this->form_validation->set_rules('confirmpass','"Подтверждение пароля"','required|trim');
			$this->form_validation->set_rules('sitename','"Нзвание сайта"','required|callback_sitename_check|trim');
			$this->form_validation->set_rules('name','"Ваше имя"','required|xss_clean|encode_php_tags|trim');
			$this->form_validation->set_rules('subname','"Ваша фамилия"','required|trim');
			$this->form_validation->set_rules('email','"Ваш email"','required|valid_email|trim|callback_email_check');
			$this->form_validation->set_rules('weddingdate','"Дата свадьбы"','required|trim');
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
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['weddingdate'] = preg_replace($pattern,$replacement,$_POST['weddingdate']);
				$user_id = $this->usersmodel->insert_record($_POST);
				$message = 'Для активации аккаунта пройдите по следующей ссылке'."\n".'<a href="'.base_url().'activation/'.$_POST['confirm'].'" target="_blank">'.base_url().'activation/'.$_POST['confirm'].'</a>';
				$message .= "\n".'или скопируйте ссылку в окно ввода адреса браузера и нажмите enter.';
				if($this->sendmail($_POST['email'],$message,"Подтверждение регистарции на сайте","admin@weweds.ru")):
					$pagevar['text'] = '<b>Учетная запись создана.</b><br><b>На Ваш адрес "'.$_POST['email'].'" выслано письмо</b><br><b>Для активации учетной записи перейдите по ссылке указанной в письме</b><br><b>Спасибо за регистрацию на нашем сайте.</b><br>';
					$this->load->view('main/message',$pagevar);
					return TRUE;
				else:
					$this->email->print_debugger();
				endif;
			endif;
		endif;
		$this->session->set_userdata('capcha',mt_rand(100000,999999));
		$this->load->view('main/profile/step1',$pagevar);
	} /* end function signup */
	
	function sitename_check($sitename){
	
		if(preg_match('/^admin/i',$sitename)):
			$this->form_validation->set_message('sitename_check','Не допустимое название сайта');
			return FALSE;
		endif;
		if($sitename == 'restore' || $sitename == 'page404' || $sitename == 'page403' || $sitename == 'activation' || $sitename == 'signup' ||
			$sitename == 'login' || $sitename == 'capcha' || $sitename == 'logoff'):
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