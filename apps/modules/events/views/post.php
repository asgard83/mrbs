<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	&nbsp;
</div>
<div class="container">
	<div class="row">
		<div class="col s12">
			<div class="section-title blue-border">
				<h2>Agenda Rapat</h2>
				<small><?= $sDay; ?> <?= $sDate; ?></small>
			</div>
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
									<img src="<?= base_url(); ?><?= $obj_sql[$i]['ROOM_PHOTO']; ?>" alt="product-img" class="lazy">
								</div>
							</div>
						</div>
					</div>
					<div class="col s9">
						<ul class="collection" style="border:none;">
						  <li class="collection-item avatar">
							<i class="mdi-maps-pin-drop circle pink"></i>
							<span class="title">Ruang Rapat <?= $obj_sql[$i]['ROOM_NAME']; ?></span>
							<p class="title"><b><?= $obj_sql[$i]['BOOKED_EVENT_NAME']; ?></b></p>
							<p><small class="extra-small">Pimpinan Rapat</small></p>
							<p><?= $obj_sql[$i]['BOOKED_EVENT_LEADER']; ?></p>
							<p><small class="extra-small">Waktu Rapat</small></p> 
							<p>Pukul <?= $obj_sql[$i]['BOOKED_EVENT_START']; ?> s.d <?= $obj_sql[$i]['BOOKED_EVENT_FINISH']; ?> WIB
							</p>
						  </li>
						  <li class="collection-item avatar">
							<i class="mdi-action-account-circle"></i> &nbsp; <?= $obj_sql[$i]['BOOKED_EVENT_PIC']; ?>
							<i class="mdi-action-perm-phone-msg"></i> &nbsp; <?= $obj_sql[$i]['BOOKED_EVENT_PIC_PHONE']; ?>
						  </li>
						</ul>
					</div>
				</div>
				<?php
			}
		}
	?>

	<div class="row">
		<div class="col s12">
			<a href="<?= base_url(); ?>" class="btn waves-effect waves-light light-blue darken-4"><i class="mdi-action-home left"></i>Ke Halaman Utama</a>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= base_url(); ?>public/js/jquery.lazyload.js"></script>
<script>
	$(document).ready(function(){
		$("img.lazy").lazyload({
			effect : "fadeIn"
		});
	});
</script>