<?php
namespace LSYS\Captcha;
/**
 * 根据客户端请求不同而使用不同的存储方式
 */
interface Storage{
	/**
	 * 本地验证码存储
	 * @param string $uid
	 */
	public function __construct($uid);
	/**
	 * 通过TOKEN名获取TOKEN值
	 */
	public function get();
	/**
	 * 设置TOKEN值
	 * @param string $value
	 */
	public function set($value);
	/**
	 * 清除指定TOKEN值
	 */
	public function clear();
}