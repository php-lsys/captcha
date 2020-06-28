<?php
use LSYS\Captcha\Image;
require_once  __DIR__."/../Bootstarp.php";
if (empty($_GET['token']))die('bad request');
$iamge=new Image($_GET['token']);
var_dump($iamge->valid($_GET['code']));