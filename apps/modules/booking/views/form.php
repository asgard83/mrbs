<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="breadcrumbs-wrapper" class=" grey lighten-3">
  <div class="container">
    <div class="row">
      <div class="col s12 m12 l12">
        <h5 class="breadcrumbs-title">Forms</h5>
        <ol class="breadcrumb">
          <li><a href="<?= site_url(); ?>">Home</a>
        </li>
        <li><a href="#">Form Pengajuan Ruangan Rapat</a>
      </li>
    </ol>
  </div>
</div>
</div>
</div>
<div class="container">
<div class="section">
<div class="row">
  <div class="col s12 m12 l12">
    <div class="card-panel">
      <h4 class="header2">Identitas Pemesan Ruangan</h4>
      <div class="row">
        <form class="col s12">


          <div class="row">
            <div class="col s2"><?= $building_name; ?></div>
            <div class="col s10"><?= $room_name; ?></div>
          </div>

          <div style="height:20px;">&nbsp;</div>

          <div class="row">
            <div class="col s2">Jenis Ruangan</div>
            <div class="col s4"><?= $obj['REFF_COMMENT']; ?></div>

            <div class="col s2">Kapasitas</div>
            <div class="col s4"><?= $obj['TYPE_ROOM_CAPACITY']; ?></div>
          </div>


          <div class="row">
            <div class="input-field col s12">
              <input id="first_name" type="text">
              <label for="first_name">Nama Pemesan</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="email5" type="email">
              <label for="email">Email</label>
            </div>
          </div>
          <div class="row">
          <div class="input-field col s6">
            <input type="text" class="datepicker picker__input" readonly="" id="P496433900" tabindex="-1" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="P496433900_root"><div class="picker" id="P496433900_root" tabindex="0" aria-hidden="true"><div class="picker__holder"><div class="picker__frame"><div class="picker__wrap"><div class="picker__box"><div class="picker__date-display"><div class="picker__weekday-display">Thursday</div><div class="picker__month-display"><div>Jun</div></div><div class="picker__day-display"><div>2</div></div><div class="picker__year-display"><div>2016</div></div></div><div class="picker__calendar-container"><div class="picker__header"><select class="picker__select--month browser-default" disabled="" aria-controls="P496433900_table" title="Select a month"><option value="0">January</option><option value="1">February</option><option value="2">March</option><option value="3">April</option><option value="4">May</option><option value="5" selected="">June</option><option value="6">July</option><option value="7">August</option><option value="8">September</option><option value="9">October</option><option value="10">November</option><option value="11">December</option></select><select class="picker__select--year browser-default" disabled="" aria-controls="P496433900_table" title="Select a year"><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016" selected="">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option></select><div class="picker__nav--prev" data-nav="-1" role="button" aria-controls="P496433900_table" title="Previous month"> </div><div class="picker__nav--next" data-nav="1" role="button" aria-controls="P496433900_table" title="Next month"> </div></div><table class="picker__table" id="P496433900_table" role="grid" aria-controls="P496433900" aria-readonly="true"><thead><tr><th class="picker__weekday" scope="col" title="Sunday">S</th><th class="picker__weekday" scope="col" title="Monday">M</th><th class="picker__weekday" scope="col" title="Tuesday">T</th><th class="picker__weekday" scope="col" title="Wednesday">W</th><th class="picker__weekday" scope="col" title="Thursday">T</th><th class="picker__weekday" scope="col" title="Friday">F</th><th class="picker__weekday" scope="col" title="Saturday">S</th></tr></thead><tbody><tr><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1464454800000" role="gridcell" aria-label="29 May, 2016">29</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1464541200000" role="gridcell" aria-label="30 May, 2016">30</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1464627600000" role="gridcell" aria-label="31 May, 2016">31</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1464714000000" role="gridcell" aria-label="1 June, 2016">1</div></td><td role="presentation"><div class="picker__day picker__day--infocus picker__day--today picker__day--highlighted" data-pick="1464800400000" role="gridcell" aria-label="2 June, 2016" aria-activedescendant="true">2</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1464886800000" role="gridcell" aria-label="3 June, 2016">3</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1464973200000" role="gridcell" aria-label="4 June, 2016">4</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465059600000" role="gridcell" aria-label="5 June, 2016">5</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465146000000" role="gridcell" aria-label="6 June, 2016">6</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465232400000" role="gridcell" aria-label="7 June, 2016">7</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465318800000" role="gridcell" aria-label="8 June, 2016">8</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465405200000" role="gridcell" aria-label="9 June, 2016">9</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465491600000" role="gridcell" aria-label="10 June, 2016">10</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465578000000" role="gridcell" aria-label="11 June, 2016">11</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465664400000" role="gridcell" aria-label="12 June, 2016">12</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465750800000" role="gridcell" aria-label="13 June, 2016">13</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465837200000" role="gridcell" aria-label="14 June, 2016">14</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1465923600000" role="gridcell" aria-label="15 June, 2016">15</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466010000000" role="gridcell" aria-label="16 June, 2016">16</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466096400000" role="gridcell" aria-label="17 June, 2016">17</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466182800000" role="gridcell" aria-label="18 June, 2016">18</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466269200000" role="gridcell" aria-label="19 June, 2016">19</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466355600000" role="gridcell" aria-label="20 June, 2016">20</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466442000000" role="gridcell" aria-label="21 June, 2016">21</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466528400000" role="gridcell" aria-label="22 June, 2016">22</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466614800000" role="gridcell" aria-label="23 June, 2016">23</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466701200000" role="gridcell" aria-label="24 June, 2016">24</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466787600000" role="gridcell" aria-label="25 June, 2016">25</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466874000000" role="gridcell" aria-label="26 June, 2016">26</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1466960400000" role="gridcell" aria-label="27 June, 2016">27</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1467046800000" role="gridcell" aria-label="28 June, 2016">28</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1467133200000" role="gridcell" aria-label="29 June, 2016">29</div></td><td role="presentation"><div class="picker__day picker__day--infocus" data-pick="1467219600000" role="gridcell" aria-label="30 June, 2016">30</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467306000000" role="gridcell" aria-label="1 July, 2016">1</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467392400000" role="gridcell" aria-label="2 July, 2016">2</div></td></tr><tr><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467478800000" role="gridcell" aria-label="3 July, 2016">3</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467565200000" role="gridcell" aria-label="4 July, 2016">4</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467651600000" role="gridcell" aria-label="5 July, 2016">5</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467738000000" role="gridcell" aria-label="6 July, 2016">6</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467824400000" role="gridcell" aria-label="7 July, 2016">7</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467910800000" role="gridcell" aria-label="8 July, 2016">8</div></td><td role="presentation"><div class="picker__day picker__day--outfocus" data-pick="1467997200000" role="gridcell" aria-label="9 July, 2016">9</div></td></tr></tbody></table></div><div class="picker__footer"><button class="btn-flat picker__today" type="button" data-pick="1464800400000" disabled="" aria-controls="P496433900">Today</button><button class="btn-flat picker__clear" type="button" data-clear="1" disabled="" aria-controls="P496433900">Clear</button><button class="btn-flat picker__close" type="button" data-close="true" disabled="" aria-controls="P496433900">Close</button></div></div></div></div></div></div>
            <label for="Tanggal">Tanggal</label>
          </div>
          <div class="input-field col s3">
              <input id="first_name" type="text">
              <label for="first_name">Mulai</label>
          </div>
          <div class="input-field col s3">
              <input id="first_namex" type="text">
              <label for="first_namex">Selesai</label>
          </div>
        </div>
        
        

        <div class="row">
            <div class="input-field col s12">
              <input id="first_name" type="text">
              <label for="first_name">Nama Acara</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="first_name" type="text">
              <label for="first_name">Pimpinan Rapat</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="first_name" type="text">
              <label for="first_name">Kontak yang bisa dihubungi</label>
            </div>
          </div>

          <div class="row">
          <div class="input-field col s12">
            <textarea id="message5" class="materialize-textarea" length="120"></textarea>
            <label for="message">Deskripsi</label>
            <span class="character-counter" style="float: right; font-size: 12px; height: 1px;"></span></div>
            <div class="row">
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Pesan
                <i class="mdi-content-send right"></i>
                </button>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>