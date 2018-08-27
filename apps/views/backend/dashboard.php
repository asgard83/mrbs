{_header_}
<title>{_appname_}</title>
<body>
  <!-- <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div> !-->
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="cyan">
        <div class="nav-wrapper">
          <ul class="left">
            <li class="no-hover"><a href="#" data-activates="slide-out" class="menu-sidebar-collapse btn-floating btn-flat btn-medium waves-effect waves-light cyan"><i class="mdi-navigation-menu"></i></a></li>
            <li>Si RAMUAN</li>
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
    <ul id="slide-out" class="side-nav leftside-navigation ps-container ps-active-y" style="left: -250px; height: 663px;">
      <li class="user-details cyan darken-2">
        <div class="row">
          <div class="col col s4 m4 l4">
            <img src="<?= base_url(); ?>public/images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
          </div>
          <div class="col col s8 m8 l8">
            <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?= $this->newsession->userdata('SESS_NAMA') ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
              <ul id="profile-dropdown" class="dropdown-content">
                <li><a href="<?= site_url('profil'); ?>"><i class="mdi-action-face-unlock"></i> Profil</a></li>
              </ul>
          </div>
        </div>
      </li>
    <?php
    $terakhir = 1;
    foreach ($_navmenu_ as $a => $b) {
      if (strlen($a) == 2) {
        if ($terakhir > 1)
          echo "</ul></li>";
        $terakhir = $b[0]; 
        if ($b[0] > 1) {
          ?>
          <li class="sub-menu"><a href="<?= $b[4]; ?>" class="waves-effect waves-cyan"><i class="<?= $b[2]; ?>"></i><span><?= $b[1]; ?></span></a>
          <ul>
          <?php
        }else{
          ?>
          <li><a href="<?= $b[4]; ?>" class="waves-effect waves-cyan"><i class="<?= $b[2]; ?>"></i><span><?= $b[1]; ?></span></a></li>
          <?php
        }
      } else if (strlen($a) == 4) {
      ?>
        <li><a href="<?= $b[4]; ?>" class="waves-effect waves-cyan"><?= $b[1]; ?></a></li>
      <?php
      }
    }
    ?>
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