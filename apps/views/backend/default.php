<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	&nbsp;
</div>
<div class="row">
	<div class="col s12">
		<div class="section-title blue-border">
			<h2>Agenda</h2>
			<small>Rapat Hari ini</small>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<?php
		$iCount_schedule = count($arr_schedule);
		if($iCount_schedule > 0)
		{
			?>
			<div class="cp-featured-news-slider">
				<div class="featured-slider">
					<?php
					for($i = 0; $i < $iCount_schedule; $i++)
					{
						?>
						<div class="item">
							<div class="cp-post-content">
								<div class="catname"><a class="btn waves-effect waves-button <?= $arr_schedule[$i]['BOOKED_EVENT_TYPE'] == 0 ? 'indigo' : 'yellow darken-4'; ?>" href="javascript:void(0);"><?= $arr_schedule[$i]['BOOKED_EVENT_TYPE_NAME']; ?></a> </div>
								<h1><a href="javascript:void(0);"><?= $arr_schedule[$i]['BOOKED_EVENT_NAME']; ?></a></h1>
								<ul class="cp-post-tools">
									<li><i class="mdi-action-room"></i> <?= $arr_schedule[$i]['ROOM_NAME']; ?></li>
									<li><i class="mdi-action-schedule"></i> <?= $arr_schedule[$i]['BOOKED_EVENT_START']; ?> - <?= $arr_schedule[$i]['BOOKED_EVENT_FINISH']; ?></li>
								</ul>
							</div>
							<div class="cp-post-thumb"><img style="height:450px;" data-src="<?= base_url(); ?><?= $arr_schedule[$i]['ROOM_PHOTO']; ?>" alt="" class="lazy-hidden"></div>
						</div>
						<?php
					}
					?>
				</div>
			</div>	
			<?php
		}
		?>
	</div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="row">
	<div class="col s8">
		<div class="section-title blue-border">
			<h2>Smart Finder</h2>
			<small>Meeting</small>
		</div>
		<ul id="issues-collection" class="collection">
			<li class="collection-item">
				<div id="running-scheduler"></div>
			</li>
		</ul>
	</div>
	<!-- Start Kanan !-->
	<div class="col s4">
		<h4 class="header"><i class="mdi-maps-place"></i> Cari ruangan dengan mudah disini !</h4>
		<div id="profile-card" class="card" style="overflow: visible;">
			<form action = "<?= site_url('request/get_search_availabity_rooms'); ?>" autocomplete="off" id="frm_search_rooms" name="frm_search_rooms" method="post">
				<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="<?= base_url(); ?>public/images/rooms/no-pict.jpg" alt="user bg">
				</div>
				<div class="card-content">
					<a class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="is_available_rooms('#frm_search_rooms',$(this));"><i class="mdi-content-send"></i></a>
					<p>Waktu Rapat</p>
					<p><input placeholder="Tanggal" readonly="readonly" value="<?= date("d-m-Y"); ?>" id="txt_schedule" type="text" isnull = "false" name="txt_schedule"></p>
					<p>Kapasitas Ruangan</p>
					<p><?= form_dropdown('capacity', $arr_capacity, '', 'class="form-control" id = "cb_capacity"'); ?></p>
					<p>Lokasi Ruangan</p>
					<p><?= form_dropdown('building', $arr_building, '', 'class="form-control" id = "cb_building"'); ?></p>
				</div>
			</form>
		</div>
	</div>
	<!-- End Kanan !-->
</<div>
<script type="text/javascript" src="<?= base_url(); ?>public/js/jquery.lazyload.js"></script>
<script>
	$(document).ready(function(){
		if ($(".featured-slider").length) {
			$(".featured-slider").owlCarousel({
				autoPlay: 5000,
				items: 2,
				pagination: false,
				itemsMobile: [768, 1],
				itemsDesktop: [1199, 2],
				itemsDesktopSmall: [979, 1]
			});
			$("img.lazy").lazyload({
				effect : "fadeIn"
			});
		}
		$('#txt_schedule').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id', minDate : new Date() });
		$('#running-scheduler').fullCalendar({
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			lang: 'id',
			defaultDate: '<?= date("Y-m-d"); ?>',
			eventLimit: true,
			viewRender: function(currentView){
				var minDate = moment().add(-1, 'days'), maxDate = moment();
				if (minDate >= currentView.start && minDate <= currentView.end) {
					$(".fc-prev-button").prop('disabled', true); 
					$(".fc-prev-button").addClass('fc-state-disabled'); 
				}
				else {
					$(".fc-prev-button").removeClass('fc-state-disabled'); 
					$(".fc-prev-button").prop('disabled', false); 
				}
			},
			events: function(start, end, timezone, callback) {
				$.ajax({
					type: "POST",
					url: '<?= site_url('request/get_quick_finder_events'); ?>',
					dataType: 'json',
					data: {
						start: start.unix(),
						end: end.unix()
					},
					success: function(eventstring){
						var buildingEvents = $.map(eventstring, function (item){
							return {
								id: item.Id,
								title: item.Title,
								start: item.StartDate,
								color: item.Color
							};
						});
						callback(buildingEvents);
					}
				});
			},
			eventRender: function( event, element, view ) {
				element.find('.fc-title').prepend('<i class="mdi-action-assignment"></i> '); 
			},
			eventClick: function(calEvent, jsEvent, view) {
				var sdata = moment(calEvent.id).unix();
				location.href = '<?= base_url('events/post'); ?>' + '/' + sdata + '.html';
			},
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			displayEventTime: true,
			height: 475
		});
	})
</script>