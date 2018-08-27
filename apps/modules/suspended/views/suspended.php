<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container" style="min-height:535px;">
  <div class="row">
    <div class="col s12 m12 l12">
      <h5 class="breadcrumbs-title">Detil Data Pemesanan Ruangan Rapat - Penangguhan Ruangan</h5>
      <div style="height:10xp;">&nbsp;</div>
    </div>
  </div>
  <div class="row">
    <div class="col s8 m8 10">
      <blockquote>
        <p>Data Pemesanan</p>
      </blockquote>
      <div class="row">
        <div class="input-field col s6">
          <input type="text" readonly="readonly" value="<?= $obj_booking['BOOKED_EVENT_START']; ?> <?= $obj_booking['TIME_START']; ?>">
          <label>Tanggal dan Jam Mulai</label>
        </div>
        <div class="input-field col s6">
          <input type="text" readonly="readonly" value="<?= $obj_booking['BOOKED_EVENT_FINISH']; ?> <?= $obj_booking['TIME_END']; ?>">
          <label>Tanggal dan Jam Selesai</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input type="text" readonly="readonly" value="<?= $obj_booking['BOOKED_EVENT_TYPE']; ?>">
          <label>Jenis Rapat</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input type="text" readonly="readonly" value="<?= $obj_booking['BOOKED_EVENT_NAME']; ?>">
          <label>Nama Acara Rapat</label>
        </div>
        <div class="input-field col s12">
          <input type="text" readonly="readonly" value="<?= $obj_booking['BOOKED_EVENT_LEADER']; ?>">
          <label for="txt_book_event_leader">Nama Pimpinan Rapat</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <label>Deskripsi Rapat (Penjelasan Singkat)</label>
          <br>
          <blockquote>
            <?= $obj_booking['BOOKED_EVENT_DESCRIPTION']; ?>
          </blockquote>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <label>Daftar Undangan Rapat</label>
          <br>
          <blockquote>
            <?= $obj_booking['BOOKED_EVENT_INVITATION']; ?>
          </blockquote>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input type="text" readonly="readonly" value="<?= $obj_booking['BOOKED_EVENT_PIC']; ?>">
          <label>Nama Kontak</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input type="text" readonly="readonly" value="<?= $obj_booking['BOOKED_EVENT_PIC_PHONE']; ?>">
          <label>No. Telpon</label>
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>
    </div>
    <div class="col s4 m4 6">
      <blockquote>
        <p>Data Ruangan</p>
      </blockquote>
      <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" src="<?= base_url(); ?><?= $obj_booking['ROOM_PHOTO']; ?>" alt="user bg">
        </div>
        <div class="card-content">
          <a class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right">
            <i class="mdi-action-room"></i>
          </a>
          <span class="card-title activator grey-text text-darken-4"><?= $obj_booking['ROOM_NAME']; ?></span>
          <p><i class="mdi-action-perm-phone-msg"></i> <?= $obj_booking['ROOM_PABX']; ?></p>
          <p><i class="mdi-action-account-box"></i> <?= $obj_booking['ROOM_PIC']; ?></p>
          <p><i class="mdi-maps-store-mall-directory"></i> <?= $obj_booking['ROOM_FACILITIES']; ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col s12 m12 l12">
      <h5 class="breadcrumbs-title">Rekomendasi Ruangan Rapat</h5>
      <div style="height:10xp;">&nbsp;</div>
    </div>
  </div>

  <?php
  $iCount_Obj = count($obj_sql);
    if($iCount_Obj > 0)
    {
      ?>
      <form action="<?= $action; ?>" method="post" id="fsuspended" name="fsuspended" autocomplete = "off" enctype="multipart/form-data">
          <input type="hidden" readonly="readonly" value="<?= $obj_booking['BOOKED_ID']; ?>" name="BOOKED_ID">
          <input type="hidden" readonly="readonly" value="<?= $obj_booking['BOOKED_STATUS']; ?>" name="BOOKED_STATUS">
          <input type="hidden" readonly="readonly" value="<?= $obj_booking['BOOKED_ROOM_ID']; ?>" name="BOOKED_ROOM_ID">
          <input type="hidden" readonly="readonly" value="<?= $sRules; ?>" name="sRules">
      <div class="row">
      <?php
      for($i = 0; $i < $iCount_Obj; $i++)
      {
        ?>
        <div class="col s12 m3 l3">
          <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
              <img data-src="<?= base_url(); ?><?= $obj_sql[$i]['ROOM_PHOTO']; ?>" class="lazy-hidden" style="height: 175px;">
            </div>
            <div class="card-content">
              <span class="activator grey-text text-darken-4"><?= $obj_sql[$i]['ROOM_NAME']; ?><i class="mdi-navigation-more-vert right"></i></span>
              <p style="margin-top: 15px;">
                <input class="chkopt" name="recomendation[]" value="<?= $obj_sql[$i]['ROOM_ID']; ?>" type="radio" id="room_<?= $obj_sql[$i]['ROOM_ID']; ?>">
                <label for="room_<?= $obj_sql[$i]['ROOM_ID']; ?>">Pilih Ruangan</label>
              </p>
            </div>
            <div class="card-reveal" style="display: none; transform: translateY(0px);">
              <span class="card-title grey-text text-darken-4"><?= $obj_sql[$i]['ROOM_NAME']; ?> <i class="mdi-navigation-close right"></i></span>
              <p><span class="ultra-small">Fasilitas <?= $obj_sql[$i]['ROOM_FACILITIES']; ?> </span></p>
              <p><span class="ultra-small">Kapasitas Ruangan <?= $obj_sql[$i]['ROOM_MIN_CAPACITY']; ?> - <?= $obj_sql[$i]['ROOM_MAX_CAPACITY']; ?> Orang</span>
              </p>
              <p><span class="ultra-small">Ketersediaan Jam Ruangan Rapat</small></p>
              <p>
                <div class="progress">
                  <div class="determinate" style="width: <?= ceil($obj_sql[$i]['PERCENT']); ?>%"></div>
                </div>
              </p>
              <p><span class="ultra-small">Ruangan Tepakai <?= number_format($obj_sql[$i]['EVENT_REAL'], 1, ',', ' '); ?> jam </span> </p>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
      </div>
      <div class="row proccess" style="display: none;">
        <div class="input-field col s12">
          <textarea name="COMMENT" placeholder="Komentar atau catatan" id="txt_comment" class="materialize-textarea" isnull="false"></textarea>
          <label for="txt_comment">Komentar atau catatan *</label>
        </div>
      </div>
      <div class="row proccess" style="display: none;">
        <div class="col s12 m12 l12">
          <a class="waves-effect waves-light btn green darken-1" id="<?= rand(); ?>" onClick="post('#fsuspended',$(this));"><i class="mdi-navigation-check left"></i>Proses</a>
        </div>
      </div>
      </form>
      <?php
    }
  ?>

</div>
<script>
$(document).ready(function(){
  var dStart = moment.utc(<?= $dStart; ?>).format('YYYY-MM-DD HH:mm:ss');
  var dEnd = moment.utc(<?= $dEnd; ?>).format('YYYY-MM-DD HH:mm:ss');
  $("#txt_book_event_start").val(dStart);
  $("#txt_book_event_finish").val(dEnd);
  $(".chkopt").change(function(){
    var $this = $(this);
    if($this.is(":checked"))
    {
      if($(".proccess").length > 0)
      {
        $(".proccess").show();
      }
    }
  });
});
</script>