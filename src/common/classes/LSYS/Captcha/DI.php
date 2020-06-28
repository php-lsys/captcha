<?php
namespace LSYS\Captcha;
/**
 * @method \LSYS\Captcha captcha($uid=null)
 */
class DI extends \LSYS\DI{
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->captcha)&&$di->captcha(new \LSYS\DI\VirtualCallback(\LSYS\Captcha::class));
        return $di;
    }
}