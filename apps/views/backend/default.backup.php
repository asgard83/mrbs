<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col s12 m12">
    <div id='calendar'></div>
  </div>
</div>

<script>
    $(function() {
      $('#calendar').fullCalendar({
        now: '2016-08-07',
        header: {
          left: 'today prev,next',
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
            var sData = 'dStart='+ start +'&dEnd='+ end +'&iRoom_id='+resourceId.id;
            $.ajax({
                type: "POST",
                url: '<?= site_url(); ?>booking/get_obj_booking_attempt',
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
                    console.log(data);
                },
                error: function (data, status, e){
                    alertify.alert(data);
                }
            });

            var sDiv = '<aside id="right-sidebar-nav"><ul id="chat-out" class="side-nav rightside-navigation right-aligned ps-container ps-active-y" style="width: 600px; right: 0px; height: 727px;"><li class="li-hover"><a href="javascript:void(0);" data-activates="chat-out" class="chat-close-collapse right"><i class="mdi-navigation-close right-closed"></i></a><div id="right-search" class="row"><form class="col s12"><div class="input-field"><i class="mdi-action-search prefix"></i><input id="icon_prefix" type="text" class="validate"><label for="icon_prefix">Search</label></div></form></div></li></ul></aside>';
            $(".wrapper").append(sDiv);
            $(".right-closed").click(function(event){
                alertify.confirm("Are you sure want to cancel it ?", function () {
                    $("#right-sidebar-nav").remove();
                }, function() {
                    return false;
                });
            });
        },
        editable: false,
        defaultView: 'timelineDay',
        minTime: '08:00:00',
        maxTime: '19:00:00',
        resourceLabelText: 'Timeline',
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        resources: [
          { id: 'a', title: 'Timeline A'},
          { id: 'b', title: 'Timeline B'}
        ],
        events: [
          { id: '1', resourceId: 'b', start: '2016-08-07 08:00:00', end: '2016-08-07 09:00:00', title: 'Timeline 1 Timeline progress terkait github', color: '#ff1744' },
          { id: '2', resourceId: 'b', start: '2016-08-07 13:30:00', end: '2016-08-07 15:00:00', title: 'Timeline 2', color: '#2196f3' }
        ]
      });
    });
</script>