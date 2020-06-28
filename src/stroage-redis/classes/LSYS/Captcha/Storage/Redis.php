<?php
namespace LSYS\Captcha\Storage;
use LSYS\Captcha\Storage;
/**
 * 连接形式访问
 * 数据存储于缓存中
 */
class Redis implements Storage{
	public static $prefix="captcha:";
	protected $_redis;
	protected $_uid;
	public function __construct(?string $uid,\LSYS\Redis $redis=null){
		$this->_uid=$uid;
		$this->_redis=$redis?$redis:\LSYS\Redis\DI::get()->redis();
	}
	private function _key(){
		return self::$prefix.md5($this->_uid);
	}
	public function get(){
	    $this->_redis->configConnect();
		return $this->_redis->get($this->_key());
	}
	public function set(string $value):bool{
	    $this->_redis->configConnect();
	    return (bool)$this->_redis->setex($this->_key(),3600,$value);
	}
	public function clear():bool{
	    $this->_redis->configConnect();
	    return (bool)$this->_redis->del($this->_key());
	}
}