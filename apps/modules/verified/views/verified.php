<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container" style="min-height:535px;">
  <div class="row">
    <div class="col s12 m12 l12">
      <h5 class="breadcrumbs-title">Detil Data Pemesanan Ruangan Rapat</h5>
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
            <div class="row">
              <div class="input-field col s10">
                <label>Photo Kegiatan Rapat</label>
                <br>
                <blockquote>
                <?php
                if(strlen($obj_booking['BOOKED_EVENT_ATTACHMENT_CLOSED']) > 0){
                ?>
                  <img src="<?= base_url().$obj_booking['BOOKED_EVENT_ATTACHMENT_CLOSED']; ?>" class="lazy-hidden">
                <?php
                }
                else
                {
                  echo "photo kegiatan belum diupload atau rapat belum selesai";
                }
                ?>
                </blockquote>
              </div>
            </div>
            <!--<div class="row">
              <div class="file-field input-field col s12">
                <div class="btn blue">
                  <span>Lampiran File</span>
                  <input type="file" name="BOOKED_EVENT_ATTACHMENT" id="event_file">
                </div>
                  <input class="file-path validate" type="text">
              </div>
            </div>
            <div class="clearfix">&nbsp;</div>!-->
            <div class="row">
              <form action="<?= $action; ?>" method="post" id="fpreview" name="fpreview" autocomplete = "off" enctype="multipart/form-data">
                <input type="hidden" readonly="readonly" value="<?= $obj_booking['BOOKED_ID']; ?>" name="obj_data[BOOKED_ID]">
                <input type="hidden" readonly="readonly" value="<?= $obj_booking['BOOKED_STATUS']; ?>" name="obj_data[BOOKED_STATUS]">
                <input type="hidden" readonly="readonly" value="<?= $sRules; ?>" name="sRules">
                <?php
                if((int)$obj_booking['BOOKED_SUSPENDED'] == 1)
                {
                  ?>
                  <input type="hidden" readonly="readonly" value="<?= $obj_booking['BOOKED_SUSPENDED']; ?>" name="BOOKED_SUSPENDED">
                  <input type="hidden" readonly="readonly" value="<?= $obj_appeal['APPEAL_ROOM_ID']; ?>" name="APPEAL_ROOM_ID">
                  <input type="hidden" readonly="readonly" value="<?= $obj_appeal['ROOM_NAME']; ?>" name="ROOM_NAME">
                  <?php
                }
                ?>
                <div class="col s12">
                    <?php
                    if(count($obj_verified) > 0 )
                    {
                      ?>
                      <div class="row">
                        <div class="col s12 m12 l12">
                          <h5 class="breadcrumbs-title"><?= ($obj_booking['BOOKED_STATUS'] == '3' || (int)$this->newsession->userdata('SESS_RT') == 0) ? 'Proses Verifikasi' : 'Komentar' ?></h5>
                          <div style="height:10xp;">&nbsp;</div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <textarea name="BOOKED_LOG_COMMENT" placeholder="<?= ($obj_booking['BOOKED_STATUS'] == '3' || (int)$this->newsession->userdata('SESS_RT') == 0) ? 'Catatan Verifikasi' : 'Komentar' ?>" id="txt_booked_log_comment" class="materialize-textarea" isnull="false"></textarea>
                          <label for="txt_booked_log_comment"><?= $obj_booking['BOOKED_STATUS'] == '3' ? 'Komentar' : 'Catatan' ?> *</label>
                        </div>
                      </div>
                      <?php
                      if($obj_booking['BOOKED_STATUS'] == '3' && $obj_booking['BOOKED_CREATE_BY'] == $this->newsession->userdata('SESS_PEG_ID'))
                      {
                        ?>
                        <div class="row">
                          <div class="file-field input-field col s12">
                            <div class="btn blue">
                              <span>Lampiran File</span>
                              <input type="file" name="BOOKED_EVENT_ATTACHMENT_CLOSED" id="event_file_closing">
                            </div>
                              <input class="file-path validate" type="text">
                          </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <?php
                      }
                      ?>
                      <div class="row">
                        <div class="input-field col s12">
                          <?php
                            if(count($obj_verified) > 0){
                                foreach($obj_verified as $x){
                                    echo $x . ' ';
                                }
                            }
                          ?>
                        </div>
                      </div>
                      <?php
                    }

                    else

                    {
                      ?>
                        <a class="waves-effect waves-light btn btn-small orange" id="<?= rand(); ?>" onclick="javascript:window.history.back(); return false;"><i class="mdi-content-undo left"></i>Kembali</a>
                      <?php
                    }
                    ?>
                </div>
              </form>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="row">
                <div id="email-details" class="col s12 card-panel">
                  <p class="email-subject truncate">History Catatan Pesanan Ruangan </p>
                  <hr class="grey-text text-lighten-2">
                  <?php
                  $iCounter_Log = count($obj_log);
                  if($iCounter_Log > 0)
                  {
                     for($i = 0; $i < $iCounter_Log; $i++)
                     {
                     ?>
                     <div class="email-content-wrap">
                        <div class="row">
                          <div class="col s12">
                            <ul class="collection">
                              <li class="collection-item avatar">
                                <span class="circle light-blue"><?= substr($obj_log[$i]['USER_NAME'], 0, 1); ?></span>
                                <span class="email-title"><?= $obj_log[$i]['USER_NAME']; ?></span>
                                <p class="truncate grey-text ultra-small"><?= dateindo($obj_log[$i]['LOG_DATE']); ?> <?= $obj_log[$i]['LOG_TIME']; ?></p>
                                <p class="grey-text ultra-small"><?= timeago(strtotime($obj_log[$i]['BOOKED_LOG_CREATE_DATE'])); ?>  </p>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="email-content">
                          <p><?= $obj_log[$i]['BOOKED_LOG_COMMENT']; ?></p>
                        </div>
                      </div>
                      <hr>
                     <?php
                     }
                  }
                  ?>
                </div>
            </div>

    </div>

    <div class="col s4 m4 6">
      <blockquote>
      <p>Data Ruangan</p>
      </blockquote>
      <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator lazy-hidden" src="<?= base_url(); ?><?= $obj_booking['ROOM_PHOTO']; ?>" alt="user bg">
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
      
      <?php
      if((int)$obj_booking['BOOKED_SUSPENDED'] == 1)
      {
        obj_appeal
        ?>
        <div style="height: 5px;">&nbsp;</div>
        <blockquote>
          <p>Rekomendasi Data Ruangan</p>
          </blockquote>
          <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
              <img class="activator lazy-hidden" src="<?= base_url(); ?><?= $obj_appeal['ROOM_PHOTO']; ?>" alt="user bg">
            </div>
            <div class="card-content">
              <a class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right">
                <i class="mdi-action-room"></i>
              </a>
              <span class="card-title activator grey-text text-darken-4"><?= $obj_appeal['ROOM_NAME']; ?></span>
              <p><i class="mdi-action-perm-phone-msg"></i> <?= $obj_appeal['ROOM_PABX']; ?></p>
              <p><i class="mdi-action-account-box"></i> <?= $obj_appeal['ROOM_PIC']; ?></p>
              <p><i class="mdi-maps-store-mall-directory"></i> <?= $obj_appeal['ROOM_FACILITIES']; ?></p>
            </div>
          </div>
        <?php
      }
      ?>
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