<?php
namespace LSYS\Captcha;
use LSYS\Captcha;
use LSYS\Captcha\Storage\Session;
use LSYS\Config;
class Geetest extends Captcha{
	const TYPE_PC="pc";
	const TYPE_MOBILE="mobile";
	protected $_config;
	protected $_type;
	protected $_storage;
	public function __construct(Config $config,$uid=null,Storage $storage=null,$type=self::TYPE_PC){
		parent::__construct($uid);
		$this->_storage=$storage==null?new Session($this->_uid):$storage;
		$this->_config=$config;
		$this->_type=$type;
	}
	/**
	 * 调用API进行校验
	 * {@inheritDoc}
	 * @see \LSYS\Captcha::valid()
	 */
	public function valid($data){
		$GtSdk = new \GeetestLib($this->_config->get($this->_type.".captcha_id"), $this->_config->get($this->_type.".private_key"));
		$data=explode(",",$data);
		if (count($data)!=3) return false;
		list($geetest_challenge,$geetest_validate,$geetest_seccode)=$data;
		$dat=$this->_storage->get();
		if (substr($dat, 0,1)== 1) {   //服务器正常
			return $GtSdk->success_validate($geetest_challenge, $geetest_validate,$geetest_seccode, substr($dat, 1));
		}else{  //服务器宕机,走failback模式
			if (strpos($geetest_validate, '_')===false)return false;
			return $GtSdk->fail_validate($geetest_challenge, $geetest_validate,$geetest_seccode);
		}
	}
	/**
	 * 得到调用Geetest API获取显示验证时的必要参数
	 * {@inheritDoc}
	 * @see \LSYS\Captcha::getResult()
	 */
	public function getResult(){
		$GtSdk = new \GeetestLib($this->_config->get($this->_type.".captcha_id"), $this->_config->get($this->_type.".private_key"));
		$status = $GtSdk->pre_process($this->_uid);
		if ($status)$dat='1'.$this->_uid;
		else $dat='0'.$this->_uid;
		$this->_storage->set($dat);
		$data=json_decode($GtSdk->get_response_str(),true);
		$data['uid']=$this->_uid;
		return json_encode($data);
	}
}