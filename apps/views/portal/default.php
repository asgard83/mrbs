<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div>
  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
      <form class="login-form" method="post" action="<?= site_url(); ?>authentication/get_login/<?= $this->session->userdata('session_id'); ?>" autocomplete="off" id="login-form">
        <div class="row">
          <div class="input-field col s12 center">
            <!-- <img src="<?= base_url(); ?>public/images/logobpom_.jpg" alt="" class="circle responsive-img valign profile-image-login"> !-->
            <!-- <p class="center login-form-text">e-sarpras <br> BPOM</p> !-->
            <p class="center login-form-text">Si RAMUAN</p>
            <p class="center login-form-text">(Aplikasi Ruang Pertemuan)</p>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input id="username" type="text" isnull = "false" name="uid">
            <label for="username" class="center-align">Nama Pengguna</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" type="password" isnull = "false" name="pwd">
            <label for="password">Kata Sandi</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12 center">
            <center>
            <a href="javascript:changeImage();" title="Klik pada gambar untuk menggannti atau mereload kode keamanan"><img src="<?= base_url(); ?>keycode.php?<?= md5("YmdHis"); ?>" style="height:50px;" id="img-keycode" align="abstop"></a>
            </center>
            <input type="text" class="form-control" style="text-align: center;" placeholder="Kode Verifikasi" name="cpth" isnull = "false" maxlength="4">
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <a href="javascript:void(0);" class="btn waves-effect waves-light col s12" onClick="auth('#login-form',$(this));" id="<?= md5(rand()); ?>">Login</a>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6 m6 l6">
            <p class="margin medium-small"><a href="page-register.html">Daftar Baru!</a></p>
          </div>
          <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="page-forgot-password.html">Lupa Kata Sandi?</a></p>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"> function changeImage(){ document.getElementById("img-keycode").src = "<?= base_url(); ?>keycode.php?rnd="+Math.random(); } </script>