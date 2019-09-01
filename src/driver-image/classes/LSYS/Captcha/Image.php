<?php
namespace LSYS\Captcha;
use LSYS\Captcha;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use LSYS\Captcha\Storage\Session;
class Image extends Captcha{
	protected $_storage;
	/**
	 * 验证码基类
	 */
	public function __construct($uid=null,Storage $storage=null){
		parent::__construct($uid);
		$this->_storage=$storage==null?new Session($this->_uid):$storage;
	}
	/**
	 * {@inheritDoc}
	 * @see \LSYS\Captcha::valid()
	 */
	public function valid($data){
		if (!$this->test($data)) return false;
		$this->_storage->clear();
		return true;
	}
	/**
	 * 生成验证码进行存储,图片验证调用时需要知道存储的TOKEN名字,所以返回TOKEN名即可
	 * {@inheritDoc}
	 * @see \LSYS\Captcha::getResult()
	 */
	public function getResult(){
		$code=new PhraseBuilder();
		$this->_storage->set($code->build(3));
		return $this->_uid;
	}
	/**
	 * 测试验证码是否正确
	 * @param string $data
	 * @return boolean
	 */
	public function test($data){
		$code=$this->_storage->get();
		if (empty($code))return false;
		return strtolower($code)==strtolower($data);
	}
	/**
	 * 渲染输出验证码
	 * @param int $width
	 * @param int $height
	 * @param string $reset 是否重新生成验证码数据,当点击刷新验证时传入true
	 */
	public function render($width,$height,$reset=true){
		if ($reset||!$this->_storage->get())$this->getResult();
		$code=$this->_storage->get();
		$builder = new CaptchaBuilder($code);
		$builder->build();
		$builder->setDistortion(false);
		$builder->setIgnoreAllEffects(true);
		$builder->build($width,$height);
		(!headers_sent())&&header('Content-type: image/jpeg');
		$builder->output();
	}
}