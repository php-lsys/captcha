<?php
namespace LSYS\Captcha\Storage;
use LSYS\Captcha\Storage;
/**
 * 连接形式访问
 * 数据存储于缓存中
 */
class Memcached implements Storage{
	public static $prefix="captcha:";
	protected $_mem;
	protected $_uid;
	public function __construct($uid,\LSYS\Memcached $memcache=null){
		$this->_uid=$uid;
		$this->_mem=$memcache?$memcache:\LSYS\Memcached\DI::get()->memcached();
	}
	private function _key(){
		return self::$prefix.md5($this->_uid);
	}
	public function get(){
		return $this->_mem->configServers()->get($this->_key());
	}
	public function set($value){
	    return $this->_mem->configServers()->set($this->_key(),$value,3600);
	}
	public function clear(){
	    return $this->_mem->configServers()->delete($this->_key());
	}
}