<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<div class="container" style="min-height:535px;">
  <div class="row">
    <div class="col s12 m12 l12">
      <h5 class="breadcrumbs-title">Isi Data Pemesanan Ruangan Rapat</h5>
      <div style="height:10xp;">&nbsp;</div>
    </div>
  </div>

  <div class="row">
    <div class="col s8 m8 10">
      <blockquote>
      <p>Data Pemesanan</p>
      </blockquote>
      <form action="<?= $action; ?>" method="post" id="frm_booking" name="frm_booking" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" readonly="readonly" value="<?= $iRoom_id; ?>" name="obj_booking[BOOKED_ROOM_ID]" id="txt_room_id">
        <input type="hidden" readonly="readonly" value="<?= $sRules; ?>" name="sRules">
            <div class="row">
              <div class="input-field col s6">
                <input name="obj_booking[BOOKED_EVENT_START]" placeholder="Tanggal dan Jam Mulai" id="txt_book_event_start" type="text" readonly="readonly" isnull="false">
                <label>Tanggal dan Jam Mulai</label>
              </div>
              <div class="input-field col s6">
              <input name="obj_booking[BOOKED_EVENT_FINISH]" placeholder="Tanggal dan Jam Selesai" id="txt_book_event_finish" type="text" readonly="readonly" isnull="false">
                <label>Tanggal dan Jam Selesai</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <?= form_dropdown('obj_booking[BOOKED_EVENT_TYPE]', $meeting_type, '', 'id="txt_book_event_type" isnull="false"'); ?>
                <label for="txt_book_event_type">Jenis Rapat *</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <input name="obj_booking[BOOKED_EVENT_NAME]" placeholder="Nama acara rapat" id="txt_book_event_name" type="text" isnull="false">
                <label for="txt_book_event_name">Nama Acara Rapat *</label>
              </div>
              <div class="input-field col s12">
                <input name="obj_booking[BOOKED_EVENT_LEADER]" placeholder="Nama pimpinan rapat" id="txt_book_event_leader" type="text" isnull="false">
                <label for="txt_book_event_leader">Nama Pimpinan Rapat *</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea name="obj_booking[BOOKED_EVENT_DESCRIPTION]" placeholder="Penjelasan singkat" id="txt_book_event_description" class="materialize-textarea" isnull="false"></textarea>
                <label for="txt_book_event_description">Deskripsi Rapat (Penjelasan Singkat) *</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea name="obj_booking[BOOKED_EVENT_INVITATION]" placeholder="Daftar undangan rapat" id="txt_book_event_invitation" class="materialize-textarea" isnull="false"></textarea>
                <label for="txt_book_event_invitation">Daftar Undangan *</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="obj_booking[BOOKED_EVENT_PIC]" placeholder="Nama kontak" id="txt_book_event_pic" type="text" readonly="readonly" isnull="false" value="<?= $this->newsession->userdata('SESS_NAMA'); ?>">
                <label for="txt_book_event_pic">Nama Kontak</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="obj_booking[BOOKED_EVENT_PIC_PHONE]" placeholder="No. Telpon" id="txt_book_event_phone" type="text" isnull="false" >
                <label for="txt_book_event_phone">No. Telpon *</label>
              </div>
            </div>
            <div class="row">
              <div class="file-field input-field col s12">
                <div class="btn blue">
                  <span>Lampiran File</span>
                  <input type="file" name="obj_booking[BOOKED_EVENT_ATTACHMENT]" id="event_file">
                </div>
                  <input class="file-path validate" type="text">
              </div>
            </div>
            <div class="clearfix">&nbsp;</div>

            <div class="row">
              <div class="col s12">
                <a class="waves-effect waves-light btn blue" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#frm_booking',$(this));"><i class="mdi-content-send right"></i>Proses Data Pesanan</a> 
                <a class="waves-effect waves-light btn red darken-2" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="canceled($(this));" data-url = "<?= base_url(); ?>" data-title = "Pemesanan Ruangan Rapat"><i class="mdi-action-delete left"></i>Batalkan Pesanan</a>
              </div>
            </div>
      </form>
    </div>

    <div class="col s4 m4 6">
      <blockquote>
      <p>Data Ruangan</p>
      </blockquote>
      <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" src="<?= base_url(); ?><?= $obj_rooms['ROOM_PHOTO']; ?>" alt="user bg">
        </div>
        <div class="card-content">
          <a class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right">
            <i class="mdi-action-room"></i>
          </a>
          <span class="card-title activator grey-text text-darken-4"><?= $obj_rooms['ROOM_NAME']; ?></span>
          <p><i class="mdi-action-perm-phone-msg"></i> <?= $obj_rooms['ROOM_PABX']; ?></p>
          <p><i class="mdi-action-account-box"></i> <?= $obj_rooms['ROOM_PIC']; ?></p>
          <p><i class="mdi-maps-store-mall-directory"></i> <?= $obj_rooms['ROOM_FACILITIES']; ?></p>
        </div>
      </div>
    </div>
  </div>

  
  
</div>
<script>
  $(document).ready(function(){
      var dStart = moment.utc(<?= $dStart; ?>).format('YYYY-MM-DD HH:mm:ss');
      var dEnd = moment.utc(<?= $dEnd; ?>).format('YYYY-MM-DD HH:mm:ss');
      $("#txt_book_event_start").val(dStart);
      $("#txt_book_event_finish").val(dEnd);
  });
</script>