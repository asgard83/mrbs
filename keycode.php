<?php
require_once("captcha/simplecaptcha.class.php");
@session_start();
$captcha = new SimpleCaptcha();
$captcha->session_var = "keycode_ses";
$captcha->lokasifont = "captcha/fonts/";
$captcha->CreateImage();
?>