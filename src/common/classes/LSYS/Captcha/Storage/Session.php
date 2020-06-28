<?php
namespace LSYS\Captcha\Storage;
use LSYS\Captcha\Storage;
/**
 * 如果是浏览器访问
 * 数据存储于SESSION中
 */
class Session implements Storage{
	protected $_uid;
	protected $_session;
	public function __construct(?string $uid,\LSYS\Session $session=null){
		$this->_uid=$uid;
		$this->_session=$session?$session:\LSYS\Session\DI::get()->session();
	}
	private function _key(){
		return substr(md5($this->_uid),0,16);
	}
	public function get(){
		$key=$this->_key();
		$captcha=$this->_session->get("CAPTCHA",[]);
		if (!isset($captcha[$key])) return NULL;
		return $captcha[$key];
	}
	public function set(string $value):bool{
		$captcha=$this->_session->get("CAPTCHA",[]);
		if (isset($captcha)&&count($captcha)>5){
			array_shift($captcha);
		}
		$captcha[$this->_key()]=$value;
		$this->_session->set("CAPTCHA",$captcha);
		return true;
	}
	public function clear():bool{
		$captcha=$this->_session->get("CAPTCHA",[]);
		if (isset($captcha[$this->_key()]))unset($captcha[$this->_key()]);
		$this->_session->set("CAPTCHA",$captcha);
		return true;
	}
}