<?php 

define('BOT_TOKEN', '');
define('BOT_ID', '494807396');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('T_FILE_URL', 'https://api.telegram.org/file/bot'.BOT_TOKEN.'/');



class Bot {

	public $token = ''; 

	public function __construct($token) {
		$this->token = $token;
	}

	public function sendMessage($id, $message) {
		$data = array(
			'chat_id'=> $id,
			'text'=> $message,
		);

		$result = $this->request('sendMessage', $data);
		return $result;
	}

	public function request($method, $data = array()) {
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $this->token .  '/' . $method);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		$out = json_decode(curl_exec($curl), true);

		curl_close($curl);

		return $out;
	}

	public function saveUserProfilePhoto($userId) {
		$photoUser = $this->request('getUserProfilePhotos',array('user_id'=> $userId));
		$photoId = $photoUser['result']['photos'][0][0]['file_id'];
		$photoUser = $this->request('getFile',array('file_id'=> $photoId));
		$photoUrl = T_FILE_URL.$photoUser['result']['file_path'];
		$saveFile = 'assets/photo/'.$userId.'.jpg';
		copy($photoUrl, $saveFile);
	}

	public function logBot($log) {
		$dir = 'log/log.txt';
		$file = fopen($dir, 'a') or die('File not found or unavailable');
		$arrLog = print_r($log, TRUE);
		fwrite($file, $arrLog."\n");
		fclose($file);
	}
}
