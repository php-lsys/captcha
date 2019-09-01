<?php
namespace LSYS;
abstract class Captcha{
	protected $_uid;
	/**
	 * 验证码基类 
	 * @param string $uid 请求ID
	 */
	public function __construct($uid=null){
		if ($uid==null)$uid=uniqid();
		$this->_uid=$uid;
	}
	/**
	 * 获取调用验证时需要的数据
	 */
	abstract public function getResult();
	/**
	 * 校验验证码是否正确
	 * @param string $code
	 */
	abstract public function valid($code);
}