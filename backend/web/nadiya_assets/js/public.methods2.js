$(document).on('keyup keydown paste','.seprate-number',function(event){
    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;

    // format number
    $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
    });
})

function isValidNationalCode(nationalCode) {
    nationalCode = persianToEnglish(nationalCode);
    if (!!nationalCode && nationalCode.length == 10) {
        if (nationalCode == '1111111111' ||
            nationalCode == '0000000000' ||
            nationalCode == '2222222222' ||
            nationalCode == '3333333333' ||
            nationalCode == '4444444444' ||
            nationalCode == '5555555555' ||
            nationalCode == '6666666666' ||
            nationalCode == '7777777777' ||
            nationalCode == '8888888888' ||
            nationalCode == '9999999999') {
            return false;
        }
        c = parseInt(nationalCode.charAt(9));
        n = parseInt(nationalCode.charAt(0)) * 10 +
            parseInt(nationalCode.charAt(1)) * 9 +
            parseInt(nationalCode.charAt(2)) * 8 +
            parseInt(nationalCode.charAt(3)) * 7 +
            parseInt(nationalCode.charAt(4)) * 6 +
            parseInt(nationalCode.charAt(5)) * 5 +
            parseInt(nationalCode.charAt(6)) * 4 +
            parseInt(nationalCode.charAt(7)) * 3 +
            parseInt(nationalCode.charAt(8)) * 2;
        r = n - parseInt(n / 11) * 11;
        if ((r == 0 && r == c) || (r == 1 && c == 1) || (r > 1 && c == 11 - r)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }
}
function isValidPostalCode(input){
    input = persianToEnglish(input);
    if (!/^\d{10}$/.test(input))
        return false;

    var i;
    for (i = 0; i < 9; ++i) {
        if ( parseInt(input[i]) ==2 )
            return false;
    }

    if(parseInt(input[0]) == parseInt(input[1]))
        if(parseInt(input[1]) == parseInt(input[2]))
            if(parseInt(input[2]) == parseInt(input[3]))
                return false;

    return true;
}

$(document).on('blur paste','.national-code ,.nationalCode ,.national-Code ,.NationalCode,.National-Code ,#national-code ,#nationalcode ,#nationalCode ,#NationalCode',function(){

    if(!isValidNationalCode($(this).val()) && $(this).val() !== '')
        $.Notification.notify('error','bottom right','کدملی معتبر نیست!');

})


$(document).on('blur paste','.email , .mail ',function(){

    if(!IsEmail($(this).val()))
        $.Notification.notify('error','bottom right','رایانامه/ایمیل معتبر نیست!');

})

$(document).on('blur paste','.postal-code ,.postalCode ,.postal-Code ,.PostalCode,.Postal-Code ,#postal-code ,#postalcode ,#postalCode ,#PostalCode',function(){
    if($(this).val() != '')
        if(!isValidPostalCode($(this).val()))
            $.Notification.notify('error','bottom right','کدپستی معتبر نیست!');

})

var csrfToken = $('meta[name="csrf-token"]').attr('content');

$('.summary').addClass('to-persian');

$('.to-persian').text(function(i, value) {
    return numbersToPersian(value);
})

$('.to-persian-comma').text(function(i, value) {
    return numbersToPersian(numberWithCommas(value));

})

function numberWithCommas(number) {
    if(number) {
        var parts = number.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }
    else return '';
}

function numberWithoutCommas(number) {
    return (number.replace(/,|،/gi, ''));
}

$(document).on('keyup paste','.to-english-txt-comma',function(){
    var pattern = /^[0-9]+$/;
    if(!this.value.match(pattern))
    {
        this.value = this.value.replace(/[^0-9\.\,]/g,'');
    }
    var number = persianToEnglish($(this).val().replace(/,|،/gi, ''));
    number = numberWithCommas(number);
    $(this).val(number);
})

$(document).on('keyup paste','.to-persian-txt-comma',function(){

    var number = persianToEnglish($(this).val().replace(/,|،/gi, ''));
    number = numberWithCommas(number)
    var lastVal = numbersToPersian(number);
    $(this).val(lastVal);
})

$(document).on('keyup paste','.to-persian-txt',function(){
    var number = persianToEnglish($(this).val().replace(/,|،/gi, ''));
    var lastVal = numbersToPersian(number);
    $(this).val(lastVal);
})

function GetUrlParameter(stringParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == stringParam)
        {
            return sParameterName[1];
        }
    }
    return false;
}

function numbersToPersian(digits)
{
    if(digits != undefined)
    {
        var digits = digits.toString()
        var persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        var chars = digits.split('');
        for (var i = 0; i < chars.length; i++) {
            if (/\d/.test(chars[i])) {
                chars[i] = persianNumbers[chars[i]];
            }
        }
        return chars.join('');
    }
    else return;
}

function persianToEnglish(input)
{
    if(input && input.length)
    {
        var input = input.replace(/\,/g, '');
        var inputstring = input;
        var persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        var english = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]
        for (var i = 0; i < 10; i++) {
            var regex = new RegExp(persian[i], 'g');
            inputstring = inputstring.toString().replace(regex, english[i]);
        }
        return inputstring;
    }
    else return;
}

function getSplit(text,indexWanted,delimiter)
{
    var spl = text.split(delimiter);
    return spl[indexWanted];
}

function checkIsNumeric(input)
{
    input = parseInt(input);
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    if(numberRegex.test(input)) {
        return true;
    }
    else return false;
}

$(document).on('keyup keydown keypress paste change','.only-digit',function () {
    var pattern = /^[0-9]+$/;
    if(!this.value.match(pattern))
    {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    }
});

$(document).on('keyup keydown keypress paste change','.only-digit-persian',function () {
    let pattern = /^[0-9\u06F0-\u06F9]+$/;
    if(!pattern.test(this.value))
    {
        this.value =  this.value.replace(/[^0-9\u06F0-\u06F9]/g,'');
    }
});




$(document).ajaxError(function(jqXHR, textStatus, errorThrown) {
    if(textStatus.status == 403){
        requiredLoginMain();
    }
});

$(document).on('keyup','.card-number',function(){
    var cardValue = $(this).val(),
    cardLength = cardValue.length;
    if(cardLength >= 19 || cardLength == 0)
        return;

    var forCompaire = cardValue.replace(/\-/g, '');
    if ( forCompaire.length % 4 == 0 ) {
        cardValue += "-";
        $(this).val(cardValue);
    }
});

$(document).on('click','#select-all-checkbox',function(){
    $('.check-boxes').prop('checked', this.checked);
});

$(document).ready(function(){
    if ($('.persian-datepicker').length){
        $('.persian-datepicker').attr('autocomplete','off')
        $('.persian-datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            isRTL: true,
            dateFormat: 'yy/mm/dd',
            yearRange: 'c-100:c+50',
        });
    }
});

$(document).on('click','.check-boxes',function(){
    if($(".check-boxes").length == $(".check-boxes:checked").length) {
        $("#select-all-checkbox").prop("checked", true);
    } else {
        $("#select-all-checkbox").prop("checked", false);
    }
});


function selectallCheckBox( var_id , var_class ){

    $(document).on('click','#'+var_id,function(){
        $('.'+var_class).prop('checked', this.checked);
    });

    $(document).on('click','.'+var_class,function(){
        if($("."+var_class).length == $("."+var_class+":checked").length) {
            $("#"+var_id).prop("checked", true);
        } else {
            $("#"+var_id).prop("checked", false);
        }
    });
}

function dateTojalali(gdate)
{
    gdate = persianToEnglish(gdate.replace(/\-/g, '/'));

    gy = parseInt(getSplit(gdate,0,'/'));
    gm = parseInt(getSplit(gdate,1,'/'));
    gd = parseInt(getSplit(gdate,2,'/'));

    var g_d_m,jy,jm,jd,gy2,days;
    g_d_m=[0,31,59,90,120,151,181,212,243,273,304,334];
    if(gy > 1600)
    {
        jy   =   979;
        gy  -=  1601;
    }
    else
    {
        jy   =   0;
        gy  -=  622;
    }
    gy2      =      /*(gm >= 2)?(gy+1):*/gy+1;
    days     =      (365*gy2) +(parseInt((gy2+3)/4)) -(parseInt((gy2+99)/100)) +(parseInt((gy2+399)/400)) -80 +gd +g_d_m[gm-1];
    jy      +=      33*(parseInt(days/12053));
    days    %=      12053;
    jy      +=      4*(parseInt(days/1461));
    days    %=      1461;
    if(days > 365){
        jy      +=  parseInt((days-1)/365);
        days     =   (days-1)%365;
    }
    jm          =   (days < 186)?1+parseInt(days/31):7+parseInt((days-186)/30);
    jd          =   1+((days < 186)?(days%31):((days-186)%30));
    return jy+'/'+jm+'/'+jd;
    //return [jy,jm,jd];
}


function dateToGregorian(pdate)
{
    pdate = persianToEnglish(pdate.replace(/\-/g, '/'));

    jy = parseInt(getSplit(pdate,0,'/'));
    jm = parseInt(getSplit(pdate,1,'/'));
    jd = parseInt(getSplit(pdate,2,'/'));


    var sal_a,gy,gm,gd,days,v;
    if(jy > 979){
        gy=1600;
        jy-=979;
    }else{
        gy=621;
    }
    days=(365*jy) +((parseInt(jy/33))*8) +(parseInt(((jy%33)+3)/4)) +78 +jd +((jm<7)?(jm-1)*31:((jm-7)*30)+186);
    gy+=400*(parseInt(days/146097));
    days%=146097;
    if(days > 36524){
        gy+=100*(parseInt(--days/36524));
        days%=36524;
        if(days >= 365)days++;
    }
    gy+=4*(parseInt(days/1461));
    days%=1461;
    if(days > 365){
        gy+=parseInt((days-1)/365);
        days=(days-1)%365;
    }
    gd=days+1;
    sal_a=[0,31,((gy%4===0 && gy%100!==0) || (gy%400===0))?29:28,31,30,31,30,31,31,30,31,30,31];
    for(gm=0;gm<13;gm++){
        v=sal_a[gm];
        if(gd <= v)break;
        gd-=v;
    }
    return gy+'/'+gm+'/'+gd;
    //return [gy,gm,gd];
}

function imageQuality (imageFile , percent = 70 , rotateDeg = 0) {
    var allFile = [];
    let filePromise = new Promise(resolve => {
        var max_width = 1000;
    var max_height = 1000;
    // alert(imageFile.size)
    if(imageFile.size < 80000)
        percent = 100;
    else{
        percent = (((70-89)/(8000000-80000))*imageFile.size)+89;
        // alert(percent);
    }
    return processfile(imageFile);
    function processfile(file , row) {
        if( !( /image/i ).test( file.type ) )
        {
            alert( "File "+ file.name +" is not an image." );
            return false;
        }
        var reader = new FileReader();
        // alert(556);
        try{
            reader.readAsDataURL(file);
            reader.onload = function (event) {
                // var blob = new Blob([event.target.result]); // create blob...
                // console.log(event.target.result);
                // // window.URL = window.URL || window.webkitURL;
                // var blobURL = URL.createObjectURL(blob); // and get it's URL
                // var image = new Image();
                // image.src = blobURL;
                // image.onload = () => resolve(resizeMe(image));
                $("<img/>").attr("src", event.target.result).load(
                    function () {
                        resolve(resizeMe(this))
                    }
                    //     function() {
                    //     context.scale(width/this.width,  height/this.height);
                    //     context.drawImage(this, 0, 0);
                    //     deferred.resolve($("<img/>").attr("src", canvas.toDataURL()));
                    // }
                );
            };
        }
        catch(error) {
            alert('error');
        }
    }
    // === RESIZE ====

    function resizeMe(img) {

        var canvas = document.createElement('canvas');

        var width = img.width;
        var height = img.height;
        if (width > height) {
            if (width > max_width) {
                height = Math.round(height *= max_width / width);
                width = max_width;
            }
        } else {
            if (height > max_height) {
                width = Math.round(width *= max_height / height);
                height = max_height;
            }
        }
        canvas.width = width;
        canvas.height = height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, width, height);
        ctx.rotate(rotateDeg * Math.PI / 180);
        return canvas.toDataURL("image/jpeg",percent/100);

    }
});
    allFile.push(filePromise);
    return Promise.all(allFile);
}

$(document).on('keyup paste' , 'input.input-time' , function(e){
    var thisInput = this;
    setTimeout(function () {
        var time = (Number.isInteger(parseInt(persianToEnglish($(thisInput).val().replace(/:/g , '')))) ? persianToEnglish($(thisInput).val()).replace(/:/g , '') : '').toString().split('');
        var hour = [time[0],time[1]].filter(Boolean).join('');
        var min = [time[2],time[3]].filter(Boolean).join('');
        $(thisInput).val(([hour,min].filter(Boolean).join(':')));
        var stringTime = [];
        if(parseInt(hour) >= 24){
            $(thisInput).val(23);
            hour = 23;
        }

        if(parseInt(hour))
            stringTime.push(numbersToPersian(parseInt(hour)) + ' ساعت');
        if(parseInt(min) >= 60){
            $(thisInput).val(hour);
        }
        else if(parseInt(min))
            stringTime.push(numbersToPersian(parseInt(min)) + ' دقیقه');
        $(thisInput).nextAll('.preview-time-type').remove();
        $(thisInput).after('<div class="text-success preview-time-type" style="font-weight:bolder; position:absolute; top:50%; left:20px;"></div>').next().html(stringTime.join(' و '));
        if(min.length == 2){
            $(thisInput).focus('out');
        }
    }, 1);
});

$(document).on('keypress' , 'input.input-time', function(e){
    if($(this).val().replace(/:/g , '').length == 4 || (!parseInt(persianToEnglish(e.key)) && e.key !== '0' && e.key !== numbersToPersian('0'))){
        e.preventDefault();
    }
    if(e.key == ':'){
        var time = $(this).val();
        if(time.split(':').length - 1){
            e.preventDefault();
        }
        else if(time.length == 0){
            $(this).val('00')
        }
        else if(time.length == 1){
            $(this).val('0'+time)
        }
    }
});



// if($('#sidebar-menu').length){
//     $('#sidebar-menu').append(`
// `);
//     $('#sidebar_menu_search').keyup(function () {
//         var _this = $(this);
//         var searchResult = [];
//         $('#sidebar_menu_search_results').remove();
//         if(_this.val().length < 1){
//             return false;
//         }
//         $('#side-menu a').each(function () {
//             if(!$(this).find('.menu-arrow').length){
//                 if(!$(this).next('.menu-arrow').length){
//                     var has_sub = $(this).closest('.has_sub');
//                     var parentTitle = '';
//                     if(has_sub.prev('a').length){
//                         parentTitle = has_sub.prev('a').children('span:not(.menu-arrow)').text();
//                     }
//                     if($(this).text().indexOf(_this.val()) >= 0){
//                         searchResult.push({
//                             href : $(this).attr('href'),
//                             title : (parentTitle ? parentTitle+' / ' : '') + $(this).text(),
//                             icon : $(this).find('.gl,.fa').attr('class')
//                         });
//                     }
//                 }
//             }
//         });
//         $('#sidebar_menu_search_box').prepend('<div id="sidebar_menu_search_results"></div>')
//         $('#sidebar_menu_search_results').html('');
//         searchResult.slice(0,10).forEach(function (item) {
//             console.log(item)
//             $('#sidebar_menu_search_results').append(`
//                     <a href="${item.href}">
//                         <span class="${item.icon} m-l-10"></span> ${item.title}
//                     </a>
//                 `);
//         })
//     });


// }


//ABALERT MH&RM

function abAlert(json) {
    if (!$(".sp_alert_box").length) {
        $("body").append($('<div />', {
            class: "sp_alert_box"
        }))
    }
    let danger = ""
    if (json.type == "danger") {
        danger = "shake"
        function vibrate(){
            setTimeout(function (){
                navigator.vibrate(300);
            },200)
        }
        vibrate();
    }

    const randId = 'ab_alert_' + Math.floor(Math.random() * 10000);
    let duration = json.duration ? json.duration : 5000;
    let alert = `<div class="sp_alert ${danger}" id="${randId}">
                                            <div class="sp_alert_icon sp_alert_${json.type}"></div>
                                            <span class="flex-1">${json.title}</span>
                                        </div>`
    let alertLength = $(".sp_alert_box").find(".sp_alert").length;
    if (alertLength >= 5) {
        $(".sp_alert_box").find(".sp_alert").last().remove();
    }

    $(".sp_alert_box").prepend(alert);
    let timeOut = setTimeout(function () {
        $('#' + randId).fadeOut("slow", function () {
            $(this).remove();
        });
    }, duration);
    $('#' + randId).hover(function () {
        clearTimeout(timeOut);
    }, function () {
        timeOut = setTimeout(function () {
            $('#' + randId).fadeOut("slow", function () {
                $(this).remove();
            });
        }, duration)
    });

}

$(document).on('click', ".sp_alert", function () {
    $(this).fadeOut("slow", function () {
        $(this).remove();
    });
});


function btnLoading(el){
    if($(el).hasClass('sp_btn_loader')){
        $(el).removeClass('sp_btn_loader')
            .html($(el).data('html'))
            .removeAttr('style');
    }
    else{
        elHtml = $(el).html();
        width = $(el).outerWidth();
        height = $(el).outerHeight();
        color = $(el).css('color');
        $(el).data('html' , elHtml).addClass('sp_btn_loader').html(`
                <div class="lds-ellipsis">
                    <div style="background: ${color}"></div>
                    <div style="background: ${color}"></div>
                    <div style="background: ${color}"></div>
                    <div style="background: ${color}"></div>
                </div>
            `).css({
            width : width,
            height: height
        });
    }
}



$(document).on('click' , '.history-go-back' , function () {
    if(history.length > 1) {
        window.location = document.referrer;
    }
    else window.close();
})


$(document).on('click' , 'a[href="/new/backend/web/"]' , function (e) {
    e.preventDefault();
})