<?php 
define('VIEW_PATH', ROOT.'view/admin/');
class AdminController{
	static $default_config = array(
	  'site_name' =>'OneIndex',
	  'password' => 'oneindex',
	  'style'=>'material',
	  'onedrive_root' =>'',
	  'cache_type'=>'filecache',
	  'cache_expire_time' => 3600,
	  'cache_refresh_time' => 600,
	  'root_path' => '?'
	);
	
	function __construct(){
	}

	function login(){
		if(!empty($_POST['password']) && $_POST['password'] == config('password')){
			setcookie('admin', md5(config('password').config('refresh_token')) );
			return view::direct(get_absolute_path(dirname($_SERVER['SCRIPT_NAME'])).'?/admin/');
		}
		return view::load('login')->with('title', '系统管理');
	}

	function logout(){
		setcookie('admin', '' );
		return view::direct(get_absolute_path(dirname($_SERVER['SCRIPT_NAME'])).'?/login');
	}

	function settings(){
		
		if($_POST){

			config('site_name',$_POST['site_name']);
			config('style',$_POST['style']);
			
			config('onedrive_root',get_absolute_path($_POST['onedrive_root']));

			config('cache_type',$_POST['cache_type']);
			config('cache_expire_time',intval($_POST['cache_expire_time']));

			$_POST['root_path'] = empty($_POST['root_path'])?'?':'';
			config('root_path',$_POST['root_path']);
            cache::clear_opcache();

		}
		$config = config('@base');
		return view::load('settings')->with('config', $config);
	}

	function cache(){
		if(!is_null($_POST['clear'])){
			cache::clear();
			$message = "清除缓存成功";
		}elseif ( !is_null($_POST['refresh']) ){
			cache::refresh_cache(get_absolute_path(config('onedrive_root')));
			$message = "重建缓存成功";
		}
        // 清除php文件缓存
        cache::clear_opcache();
		return view::load('cache')->with('message', $message);
	}

	function images(){
		if($_POST){
			$config['home'] = empty($_POST['home'])?false:true;
			$config['public'] = empty($_POST['public'])?false:true;
			$config['exts'] = explode(" ", $_POST['exts']);
			config('images@base',$config);
		}
		$config = config('images@base');
		return view::load('images')->with('config', $config);;
	}


	function show(){
		if(!empty($_POST) ){
			foreach($_POST as $n=>$ext){
				$show[$n] = explode(' ', $ext);
			}
			config('show', $show);
		}
		$names = [
			'stream'=>'直接输出(<5M)，走本服务器流量(stream)',
			'image' =>'图片(image)',
			'video'=>'Dplayer 视频(video)',
			'video2'=>'Dplayer DASH 视频(video2)/个人版账户不支持',
			'video5'=>'html5视频(video5)',
			'audio'=>'音频播放(audio)',
			'code'=>'文本/代码(code)',
			'doc'=>'文档(doc)'
		];
		$show = config('show');
		return view::load('show')->with('names', $names)->with('show', $show);
	}

	function setpass(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if($_POST['old_pass'] == config('password')){
				if($_POST['password'] == $_POST['password2']){
					config('password', $_POST['password']);
					$message = "修改成功";
				}else{
					$message = "两次密码不一致，修改失败";
				}
			}else{
				$message = "原密码错误，修改失败";
			}
		}
		return view::load('setpass')->with('message', $message);
	}

	function install(){
		if(!empty($_GET['code'])){
			return $this->install_3();
		}
		switch ( intval($_GET['step']) ){
			case 1:
				return $this->install_1();
			case 2:
				return $this->install_2();
			default:
				return $this->install_0();
		}
	}

	function install_0(){
		$check['php'] = version_compare(PHP_VERSION,'5.5.0','ge');
		$check['curl'] = function_exists('curl_init');
		$check['config'] = is_writable(ROOT.'config/');
		$check['cache'] = is_writable(ROOT.'cache/');

		return view::load('install/install_0')->with('title','系统安装')
						->with('check', $check);
	}

	function install_1(){
		if(!empty($_POST['client_secret']) && !empty($_POST['client_id']) && !empty($_POST['redirect_uri']) ){
			config('@base', self::$default_config);
			config('client_secret',$_POST['client_secret']);
			config('client_id',$_POST['client_id']);
			config('redirect_uri',$_POST['redirect_uri']);
			config('one_prefix',$_POST['one_prefix']);
			return view::direct('?step=2');
		}

		return view::load('install/install_1')->with('title','系统安装');
	}

	function install_2(){
		return view::load('install/install_2')->with('title','系统安装');
	}

	function install_3(){
		$data = onedrive::authorize($_GET['code']);

		if(!empty($data['refresh_token'])){
            $app_url = onedrive::get_app_url($data['access_token']);
            config('refresh_token', $data['refresh_token']);
            config('app_url', $app_url);
		}
		return view::load('install/install_3')->with('refresh_token',$data['refresh_token']);

	}
}
