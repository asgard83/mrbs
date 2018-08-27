<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col s4">
		<h4 class="header">Detil Jadwal Ruangan Rapat</h4>
		<blockquote>
			<p><?= $sDay; ?>, <?= $sDate; ?></p>
		</blockquote>

		<div class="row">
			<div class="col s12">
				<h4 class="header">Pemakaian ruangan</h4>
				<ul class="collection">
					<li class="collection-item dismissable">
						<p class="collections-title"><strong>#<?= $arr_info[0]['Dipesan']; ?></strong> Dipesan <span style="float: right;"><i class="mdi-action-assignment"></i></span></p>
					</li>
					<li class="collection-item dismissable">
						<p class="collections-title"><strong>#<?= $arr_info[0]['Diverifikasi']; ?></strong> Diverifikasi <span style="float: right;"><i class="mdi-action-speaker-notes"></i></span></p>
					</li>
					<li class="collection-item dismissable">
						<p class="collections-title"><strong>#<?= $arr_info[0]['Disetujui']; ?></strong> Disetujui <span style="float: right;"><i class="mdi-action-assignment-turned-in"></i></span></p>
					</li>
					<li class="collection-item dismissable">
						<p class="collections-title"><strong>#<?= $arr_info[0]['Dibatalkan']; ?></strong> Dibatalkan <span style="float: right;"><i class="mdi-communication-no-sim"></i></span></p>
					</li>
				</ul>
			</div>
		</div>

		<div class="card">
			<div class="card-image waves-effect waves-block waves-light">
				<img class="activator" src="<?= base_url(); ?><?= $obj_sql['ROOM_PHOTO']; ?>" alt="user bg">
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
		<div>
			<blockquote>Tarik atau <i>drag</i> secara vertikal pada <i>timeline schedule</i> untuk memilih jam rapat yang akan dipesan
			<br> 
			<br> <a class="btn waves-effect waves-light light-blue darken-4" onclick="javascript:window.history.back();"><i class="mdi-navigation-arrow-back left"></i>Kembali Ke Pencarian</a>
			</blockquote>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#txt_schedule').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id', minDate : new Date() });
		$('#calendar-available').fullCalendar({
			now: '<?= $sHeader_Date; ?>',
			header: {
			  left: '',
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
			events: <?= $arr_events; ?>,
			height: 600
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