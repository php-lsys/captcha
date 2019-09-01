<?php
use LSYS\Captcha\Geetest;
require_once  __DIR__."/../Bootstarp.php";
$t = new Geetest(\LSYS\Config\DI::get()->config("captcha.geetest"),$_POST['uid']);
$data=implode(",",array(
	$_POST['geetest_challenge'], 
	$_POST['geetest_validate'], 
	$_POST['geetest_seccode']
));
if($t->valid($data)){
	echo '{"status":"success"}';
}else echo '{"status":"fail"}';