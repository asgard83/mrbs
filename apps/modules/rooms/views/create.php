<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col s4">
		<h4 class="header">Hasil Pencarian</h4>
		<blockquote>
			<p><?= $sDay; ?>, <?= $sDate; ?><a class="btn-floating waves-effect waves-light indigo right" onClick="$('#obj_search_available').slideToggle(); return false;" title="Ganti pencarian"><i class="mdi-action-autorenew"></i></a></p>
		</blockquote>
		<br>
		<div class="row" style="display:none;" id="obj_search_available">
			<div class="col s12">
				<div class="card-panel">
					<h5 class="header2">Pencarian Jadwal Lain</h5>
					<div class="row">
						<form class="col s12" action = "<?= site_url('request/get_search_availabity_rooms'); ?>" autocomplete="off" id="frm_search_rooms" name="frm_search_rooms" method="post">
							<div class="row">
								<div class="col s12">
									<h6 class="header"> 1. Gedung </h6>
									<?= form_dropdown('building_id', $arr_building, '', 'class="initialized" isnull = "false" id = "cb_building" onchange="set_cb_autofill($(this), \'#cb_room\'); return false;" is_materialize = "true" data-url = "'.site_url('request/get_rooms').'"'); ?>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<h6 class="header"> 2. Ruang Rapat </h6>
									<?= form_dropdown('room_id', array('' => ''), '', 'class="form-control" isnull = "false" id = "cb_room"'); ?>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s11">
									<h6 class="header"> 3. Waktu Rapat </h6>
									<input placeholder="Tanggal" id="txt_schedule" type="text" isnull = "false" name="txt_schedule"><i class="mdi-action-schedule prefix"></i>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<a class="waves-effect waves-light btn cyn" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="is_available_rooms('#frm_search_rooms',$(this));"><i class="mdi-action-search left"></i>Cari</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-image waves-effect waves-block waves-light">
				<img class="activator" src="<?= base_url(); ?>public/images/Deputi_1.jpg" alt="user bg">
			</div>
			<div class="card-content">
				<a class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right">
					<i class="mdi-action-room"></i>
				</a>
				<span class="card-title activator grey-text text-darken-4"><?= $obj_sql['ROOM_NAME']; ?></span>
				<p><i class="mdi-action-perm-phone-msg"></i> <?= $obj_sql['ROOM_PABX']; ?></p>
				<p><i class="mdi-action-account-box"></i> <?= $obj_sql['ROOM_PIC']; ?></p>
				<p><i class="mdi-maps-store-mall-directory"></i> <?= $obj_sql['ROOM_FACILITIES']; ?></p>
			</div>
		</div>
	</div>
	<div class="col s8">
		<div style="padding-top:20px; padding-bottom:10px;" id="calendar-available"></div>
	</div>
</div>
  
<script>
	$(document).ready(function(){
		$('#txt_schedule').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id', minDate : new Date() });
		$('#calendar-available').fullCalendar({
			now: '<?= $sHeader_Date; ?>',
			header: {
			  left: 'prev,next',
			  center: 'title',
			  right: ''
			},
			lang: 'id',
			timeFormat: {
			  agenda: 'h:mm'
			},
			editable: true,
			eventOverlap:false,
			selectOverlap: function(event) {
			  return event.rendering === 'background';
			},
			selectHelper: true,
			selectable: true,
			select: function(start, end, allDay, event, resourceId){ 
				var dStart = moment(start).format('YYYY-MM-DD HH:mm:ss');
				var dEnd = moment(end).format('YYYY-MM-DD HH:mm:ss');
				var sRedirect = window.location.pathname;
				var sData = 'dStart='+ start +'&dEnd='+ end +'&iRoom_id='+ resourceId.id +'&sRedirect='+ sRedirect;
				$.ajax({
					type: "POST",
					url: '<?= site_url(); ?>request/get_booking_rooms',
					data: sData,
					dataType: "json",
					beforeSend: function()
					{
						preloader.on();
					},
					complete: function()
					{
						preloader.off();
					},
					success: function(data)
					{ 
						if(data.error != "")
						{
							alertify.error(data.error);
							return false;
						}
						else
						{
							if(data.code == "200")
							{
								location.href = data.redirect;
							}
						}
					},
					error: function (data, status, e){
						alertify.alert(e);
					}
				});
			},
			editable: false,
			defaultView: 'agendaDay',
			minTime: '08:00:00',
			maxTime: '19:00:00',
			resourceLabelText: 'Jadwal Rapat',
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			resources: [<?= $arr_resources; ?>],
			events: <?= $arr_events; ?>
		});
	});

	function materialize_customdialog($obj_div_modal, $obj_data)
	{
		var $obj_div_modal = $obj_div_modal;
		var $str_html = '<div id="'+ $obj_div_modal +'" class="modal modal-fixed-footer"><div class="modal-content">'+ $obj_data.replace(/\n/g, "") +'</div></div>';
		$("body").append($str_html);
		$("#" + $obj_div_modal).openModal({dismissible: true,
										   opacity: .5,
										   in_duration: 300,
										   out_duration: 200
		});
		return false;
	}
</script>