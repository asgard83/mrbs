<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	&nbsp;
</div>
<div class="container">
	<div class="row">
		<div class="col s12">
			<div class="section-title blue-border">
				<h2>Hasil</h2>
				<small>Pencarian</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<form action = "<?= site_url('request/get_search_availabity_rooms'); ?>" autocomplete="off" id="frm_search_rooms" name="frm_search_rooms" method="post">
				<div id="panel-booking" class="col s12" style="display: block; border-top:1px solid #00bcd4;  border-left:1px solid #00bcd4 ; border-bottom:1px solid #00bcd4 ; border-right:1px solid #00bcd4;">
				  <div class="row">
					<div class="col s3">
					  <h6 class="header">Waktu Rapat</h6>
					  <input placeholder="Tanggal" readonly="readonly" value="<?= $arr_params['dTime']; ?>" id="txt_schedule" type="text" isnull = "false" name="txt_schedule">
					</div>
					<div class="col s2">
					  <h6 class="header">Kapasitas</h6>
					  <?= form_dropdown('capacity', $arr_capacity, $arr_params['iCapacity'], 'class="form-control" id = "cb_capacity"'); ?>
					</div>
					<div class="input-field col s5" style="margin-top: 0px;">
					  <h6 class="header">Lokasi</h6>
					  <?= form_dropdown('building', $arr_building, $arr_params['iBuilding_Id'], 'class="form-control" id = "cb_building"'); ?>
					</div>
					<div class="col s2" style="text-align:center">
					<br>
					<a class="waves-effect waves-light btn" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="is_available_rooms('#frm_search_rooms',$(this));"><i class="mdi-action-search left"></i>Cari</a>
					</div>
					<!-- End Sisi Kanan !-->
					
				  </div>
				</div>
			</form>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<?php
		$iCount_Obj = count($obj_sql);
		if($iCount_Obj > 0)
		{
			for($i = 0; $i < $iCount_Obj; $i++)
			{
				?>
				<div class="row">
					<div class="col s3">
						<div class="product-card">
							<div class="card">
								<div class="card-image waves-effect waves-block waves-light">
									<img data-src="<?= base_url(); ?><?= $obj_sql[$i]['ROOM_PHOTO']; ?>" class="lazy-hidden">
								</div>
							</div>
						</div>
					</div>
					<div class="col s9">
						<ul class="collection" style="border:none;">
						  <li class="collection-item avatar">
							<i class="mdi-maps-pin-drop circle pink"></i>
							<span class="title">Ruang Rapat <?= $obj_sql[$i]['ROOM_NAME']; ?></span>
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
						  </li>
						  <li class="collection-item avatar">
							
							<?php
							if(ceil($obj_sql[$i]['PERCENT']) > 99)
							{
								?>
								<div class="row section">
									<div class="chip cyan white-text"> <i class="mdi-notification-disc-full"></i> Ruangan Penuh</div>
								</div>
								<?php
							}
							else{
								?>
								<div class="fixed-action-btn horizontal" style="position: absolute; display: inline-block; right: 19px;">
									<a class="btn-floating btn-large blue">
										<i class="mdi-action-stars"></i>
									</a>
									<ul>
										<li><a class="btn-floating green dark-1" href="<?= site_url('search/available/'.hashids_encrypt($obj_sql[$i]['ROOM_BUILDING_ID'], _HASHIDS_, 6) .'-' . hashids_encrypt($obj_sql[$i]['ROOM_ID'], _HASHIDS_, 6) . '/' . $arr_params['dTime']); ?>"><i class="large mdi-content-add-circle"></i></a></li>
									</ul>
								</div>
								<?php
							}
							?>

						  </li>
						</ul>
					</div>
				</div>
				<?php
			}
		}
	?>
</div>
<script type="text/javascript" src="<?= base_url(); ?>public/js/jquery.lazyload.js"></script>
<script>
	$(document).ready(function(){
		$('#txt_schedule').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id', minDate : new Date() });
		$("img.lazy").lazyload({
			effect : "fadeIn"
		});
	});
</script>