/**
 * app.js
 * Created : Syafrizal
 */
var lasturl = "";
preloader = new $.materialPreloader({
            position: 'top',
            height: '4px',
            col_1: '#159756',
            col_2: '#da4733',
            col_3: '#3b78e7',
            col_4: '#fdba2c',
            fadeIn: 200,
            fadeOut: 200
        });

$(document).ready(function() {
    checkURL();
    $('a.relhash').click(function(e) {
        checkURL(this.hash);
    });
    setInterval("checkURL()", 250);
    console.log('Item Name       : Meeting Booking Room System  \nVersion         : Alpha 1 \nAuthor          : ACN \nDevelop By      : Syafrizal');
});


var form = $("#frm_booking_new");
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    labels: {
        cancel: "<i class=\"mdi-navigation-cancel\"></i> Batalkan",
        current: "current step:",
        pagination: "Pagination",
        finish: "<i class=\"mdi-navigation-check\"></i> Selesai",
        next: " Selanjutnya <i class=\"mdi-navigation-chevron-right\"></i>",
        previous: "<i class=\"mdi-navigation-chevron-left\"></i> Sebelumnya",
        loading: "Memuat ..."
    },
    onStepChanging: function (event, currentIndex, newIndex)
    {
        return true;
    },
    onFinishing: function (event, currentIndex)
    {
        return true;
    },
    onFinished: function (event, currentIndex)
    {
        post(form, $(this));
    }
});

function checkURL(a){
    if (!a)
        a = window.location.hash;
    if (a != lasturl) {
        lasturl = a;
        loadPage(a);
    }
}

function loadPage(b) {
    e = e.replace('#/', '');
    $('#content-ojan').html('').css("min-height", 300);
    $("#content-ojan").addClass("block-page");
    $.get(base_url + b, function(cnt) {
        $("#progress").width("101%").delay(200).fadeOut(400, function() {
            $(this).remove();
            $("#content-ojan").removeClass("block-page");
            $('#content-ojan').html(cnt);
        });
    });
    return false;
}


function auth(b, obj){
    var $this = $(b);
    var $obj = $(obj); 
    var $isnull = 0;
    var $msg = "";
    $.each($("input:visible, input:hidden,select:visible, textarea:visible"), function(){
        if($(this).attr('isnull')){
            if($(this).attr('isnull')=="false" && ($(this).val()=="" || $(this).val()==null)){
                $isnull++;
            }
        }
    });
    if($isnull > 0){
        alertify.alert("Maaf, " + $isnull + " kolom yang harus diisi <br> Silahkan periksa kembali isian form anda");
        return false;
    }else{
        $.ajax({
            type: "POST",
            url: $(b).attr('action') + '/ajax',
            data: $(b).serializeArray(),
            dataType: "json",
            beforeSend: function()
            {
                preloader.on();
                $obj.html('Mohon Tunggu ... ');
                $obj.prop('disabled', true);
            },
            complete: function()
            {
                preloader.off();
                $obj.html('Login');
                $obj.removeAttr('disabled');
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
                    alertify.success(data.message);
                    setTimeout(function()
                    {
                        location.href = data.returnurl;
                    },2000);
                }
            },
            error: function (data, status, e){
                alertify.alert(data);
            }
        });
    }
    return false;
}


function is_available_rooms(c, obj)
{
    var $this = $(c);
    var $obj = $(obj); 
    var $isnull = 0;
    var $msg = "";
    $.each($("input:visible, input:hidden,select:visible, textarea:visible"), function(){
        if($(this).attr('isnull')){
            if($(this).attr('isnull')=="false" && ($(this).val()=="" || $(this).val()==null)){
                $isnull++;
            }
        }
    });
    if($isnull > 0){
        alertify.alert("Perhatikan kembali formulir pencarian. <br> Masih terdapat beberapa kolom yang harus diisi");
        return false;
    }else{
        $.ajax({
            type: "POST",
            url: $(c).attr('action'),
            data: $(c).serializeArray(),
            dataType: "json",
            beforeSend: function()
            {
                preloader.on();
                $obj.html('Mohon Tunggu ... ');
                $obj.prop('disabled', true);
            },
            complete: function()
            {
                preloader.off();
                $obj.html('Cari');
                $obj.removeAttr('disabled');
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
                alertify.alert(data);
            }
        });
    }
}

function post(d, obj){ 
    var $this = $(d);
    var $obj = $(obj); 
    var $isnull = 0;
    var $msg = "";
    $.each($("input:visible, input:hidden,select:visible, textarea:visible"), function(){
        if($(this).attr('isnull')){
            if($(this).attr('isnull')=="false" && ($(this).val()=="" || $(this).val()==null)){
                $isnull++;
            }
        }
    });
    if($isnull > 0){
        alertify.alert("Maaf, ada beberapa kolom yang harus diisi / dipilih <br> Mohon periksa kembali isian Anda pada kolom bertanda *)");
        return false;
    }else{
        alertify.okBtn("Ya").cancelBtn("Tidak").confirm("Apakah anda yakin dengan data yang Anda isikan ?", function (ev){
            $.ajax({
                type: "POST",
                url: $(d).attr('action'),
                data: $(d).serializeArray(),
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
                    alertify.success(data.message);
                    if(data.refreshing)
                    {
                        setTimeout(function()
                        {
                            location.reload(true);
                        },2000);
                    }
                    else
                    {
                        setTimeout(function()
                        {
                            location.href = data.returnurl;
                        },2000);
                    }   
                },
                error: function (data, status, e){
                    alertify.alert(data);
                }
            });
        },
        function(ev){
            ev.preventDefault();
            return false;
        });
    }
    return false;
}

function canceled(e)
{
    var $this = $(e);   
    alertify.okBtn("Ya").cancelBtn("Tidak").confirm("Apakah anda yakin akan membatalkan "+ $this.attr("data-title") +" ?", function (ev){
        setTimeout(function()
        {
            location.href = $this.attr("data-url")
        },1000);
    },
    function(ev){
        ev.preventDefault();
        return false;
    });
}

function proccess (f, obj) {
    var $this = $(f);
    var $obj = $(obj); 
    var $isnull = 0;
    var $msg = "";
    $.each($("input:visible, input:hidden,select:visible, textarea:visible"), function(){
        if($(this).attr('isnull')){
            if($(this).attr('isnull')=="false" && ($(this).val()=="" || $(this).val()==null)){
                $isnull++;
            }
        }
    });
    if($isnull > 0){
        alertify.alert("Maaf, ada beberapa kolom yang harus diisi / dipilih <br> Mohon periksa kembali isian Anda pada kolom bertanda *)");
        return false;
    }else{
        alertify.okBtn("Ya").cancelBtn("Tidak").confirm("Apakah anda yakin dengan data yang Anda isikan ?", function (ev){
            //var ParseData = $(f).serializeArray();
            var ParseData = new FormData(document.getElementById('fpreview'));
                //ParseData.push({name: "SESUDAH", value: $obj.attr("data-status") });
                ParseData.append("SESUDAH",$obj.attr("data-status"));
            $.ajax({
                type: "POST",
                url: $(f).attr('action'),
                data: ParseData,
                processData: false,
                contentType: false,
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
                    alertify.success(data.message);
                    if(data.refreshing)
                    {
                        setTimeout(function()
                        {
                            location.reload(true);
                        },2000);
                    }
                    else
                    {
                        setTimeout(function()
                        {
                            location.href = data.returnurl;
                        },2000);
                    }   
                },
                error: function (data, status, e){
                    alertify.alert(data);
                }
            });
        },
        function(ev){
            ev.preventDefault();
            return false;
        });
    }
    return false;
}

function set_cb_autofill(cb_start, cb_distance, options_keys)
{
    options_keys = typeof options_keys !== 'undefined' ? options_keys : false;
    var $this = $(cb_start);
    var $target = $(cb_distance);
    if($this.attr("data-url"))
    {
        $target.html('');
        var dataString = 'params='+ $this.val();
        if(options_keys)
        {
            var $keys = $(options_keys);
            dataString = 'params='+ $this.val() + '&keys=' + $keys.val();
        }
        $.ajax({
            type:"POST",
            url: $this.attr("data-url"),
            data: dataString,
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
                    var length = data.message.length;

                    for(var j = 0; j < length; j++)
                    {
                        if($this.attr("is_materialize"))
                        {
                            $target.append($("<option></option>")
                                            .attr("value",data.message[j].value)
                                            .text(data.message[j].option)
                            );

                        }
                        else
                        {
                            var nuoption = $('<option/>');
                            nuoption.attr('value', data.message[j].value);
                            nuoption.text(data.message[j].option);
                            $target.append(nuoption);    
                        }
                        if($this.attr("is_materialize")) $target.material_select();
                    }
                }
            },
            error: function (data, status, e){
                alertify.alert(e);
            }
        });
    }
    else
    {
        return false;
    }
    return false;
}