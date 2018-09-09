<?php
//显示图片
use LSYS\Captcha\Image;
require_once  __DIR__."/../Bootstarp.php";
if (empty($_GET['token']))die('bad request');
$iamge=new Image($_GET['token']);
$iamge->render(100, 40,isset($_GET['r']));