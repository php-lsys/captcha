<?php
use LSYS\Captcha\Geetest;
require_once  __DIR__."/../Bootstarp.php";
$t = new Geetest(\LSYS\Config\DI::get()->config("captcha.geetest"));
echo $t->getResult();