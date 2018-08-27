<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
  <div class="row">
    <div class="col s12 m12 l12">
      <h5 class="breadcrumbs-title"><?= $building_name; ?></h5>
      <ol class="breadcrumb">
        <li><a href="#">Detil Ruang Rapat</a></li>
      </ol>
    </div>
  </div>
</div>
<div class="widgets">
  <div class="row">
    <!-- Start !-->
    <?php
    $count_building_rooms = count($building_room);
    if($count_building_rooms > 0)
    {
    for($i = 0; $i < $count_building_rooms; $i++)
    {
    ?>
    <div class="col s12 m6 l4">
      <div id="flight-card" class="card">
        <div class="card-header blue darken-2">
          <div class="card-title" style="padding:10px;">
            <p class="flight-card-title"><?= $building_room[$i]['ROOM_NAME']; ?></p>
            <p class="flight-card-date"><?= dateindo(date("Y-m-d")); ?></p>
          </div>
        </div>
        <div class="card-content-bg white-text">
          <div class="card-content">
            <div class="row" style="margin:0 0 50px!important;">
              <div class="col sm-12 center-align">
                <span class="card-title text-white" style="valign:middle;"><i class="mdi-action-speaker-notes"></i> Nama Acara Rapat</span>
              </div>
            </div>
            <div class="row">
              <div class="col s6 m6 12 center-align">
                <div class="flight-info">
                  <p class="small"><span class="grey-text text-lighten-4">Mulai : </span> 10.00</p>
                  <p class="small"><span class="grey-text text-lighten-4">Tipe Ruangan</p>
                </div>
              </div>
              <div class="col s6 m6 12 center-align flight-state-two">
                <div class="flight-info">
                  <p class="small"><span class="grey-text text-lighten-4">Selesai : </span> 12.00</p>
                  <p class="small"><span class="grey-text text-lighten-4">Rounded Table</p>
                </div>
              </div>
            </div>
          </div>
          <div class="product-card">
            <ul class="card-action-buttons">
              <li><a class="btn-floating waves-effect waves-light light-blue" title="Detil Info Pemesanan Ruangan"><i class="mdi-action-info activator"></i></a>
            </li>
            <li><a href="<?= site_url('booking/rooms/'.$building_room[$i]['ROOM_BUILDING_ID'] .'/'. $building_room[$i]['ROOM_ID']); ?>" class="btn-floating green" title="Pemesanan Ruangan"><i class="large mdi-editor-insert-invitation"></i></a>
            </li>
          </ul>
          <div class="card-reveal">
            <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Deskripsi</span>
            <p>Detil Info Pemesanan <?= $building_room[$i]['ROOM_NAME']; ?></p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col s12 m12" style="border-bottom:1px solid #ccc;">
      <div class="blog-card">
        
        <div class="card-content">
          <p style="font-size:14px;"><i class="mdi-notification-more"></i> <?= $building_room[$i]['ROOM_FACILITIES']; ?></p>
          <p style="font-size:13px;"><i class="mdi-notification-phone-in-talk"></i> <?= $building_room[$i]['ROOM_PABX']; ?></p>
          <p style="font-size:13px;"><i class="mdi-action-perm-identity"></i> <?= $building_room[$i]['ROOM_PIC']; ?></p>
        </p>
      </div>
    </div>
  </div>
</div>
<?php
}
}
?>
<!-- End Start !-->
</div>
</div>