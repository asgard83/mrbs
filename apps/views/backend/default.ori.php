{_header_}
<title>{_appname_}</title>
<body>
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="cyan">
        <div class="nav-wrapper">
          <ul class="left">
            <li class="no-hover"><a href="#" data-activates="slide-out" class="menu-sidebar-collapse btn-floating btn-flat btn-medium waves-effect waves-light cyan"><i class="mdi-navigation-menu"></i></a></li>
            <li>MRBS</li>
          </ul>
          <ul class="right hide-on-med-and-down">
            <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</header>
<div id="main" style="padding-left:0px;">
  <div class="wrapper">
    <aside id="left-sidebar-nav">
    {_navmenu_}
      <ul id="slide-out" class="side-nav leftside-navigation ps-container ps-active-y" style="left: -250px; height: 663px;">
        <li class="user-details cyan darken-2">
          <div class="row">
            <div class="col col s4 m4 l4">
              <img src="<?= base_url(); ?>public/images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
            </div>
            <div class="col col s8 m8 l8">
              <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">John Doe<i class="mdi-navigation-arrow-drop-down right"></i></a><ul id="profile-dropdown" class="dropdown-content">
              <li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a>
            </li>
            <li><a href="#"><i class="mdi-action-settings"></i> Settings</a>
          </li>
          <li><a href="#"><i class="mdi-communication-live-help"></i> Help</a>
        </li>
        <li class="divider"></li>
        <li><a href="#"><i class="mdi-action-lock-outline"></i> Lock</a>
      </li>
      <li><a href="#"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
    </li>
  </ul>
  <p class="user-roal">Demo</p>
</div>
</div>
</li>
<li class="bold active"><a href="<?= site_url(); ?>" class="waves-effect waves-cyan"><i class="mdi-action-home"></i> Beranda</a></li>
<li class="bold active"><a href="<?= site_url('reference/rooms'); ?>" class="waves-effect waves-cyan"><i class="mdi-action-room"></i> Daftar Ruang Rapat</a></li>
<li class="bold active"><a href="<?= site_url('logout'); ?>" class="waves-effect waves-cyan"><i class="mdi-action-exit-to-app"></i> Keluar</a></li>
</ul>
</aside>
<section id="content">
<div class="container">
{_content_}
</div>
</section>
</div>
</div>
<footer class="page-footer" style="padding-left:0px;">
<div class="footer-copyright">
<div class="container">
Copyright © 2016 All rights reserved.
<span class="right"> Design and Developed</span>
</div>
</div>
</footer>
<script type="text/javascript" src="<?= base_url(); ?>public/js/materialize.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>public/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>public/js/vendor.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>public/js/app.js"></script>
</body>
</html>