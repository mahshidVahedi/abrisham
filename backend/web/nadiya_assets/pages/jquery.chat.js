if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw3.js');
    console.log("service work");
}



// Opera 8.0+
var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

// Firefox 1.0+
var isFirefox = typeof InstallTrigger !== 'undefined';

// Safari 3.0+ "[object HTMLElementConstructor]"
var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);

// Internet Explorer 6-11
var isIE = /*@cc_on!@*/false || !!document.documentMode;

// Edge 20+
var isEdge = !isIE && !!window.StyleMedia;

// Chrome 1 - 71
var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);

// Blink engine detection
var isBlink = (isChrome || isOpera) && !!window.CSS;

var ua = navigator.userAgent.toLowerCase();
var isAndroid = ua.indexOf("android") > -1;

(function($) {
    $.fn.hasScrollBar = function() {
        // if(this[0].scrollHeight > this.outerHeight())
        //     return true;
        // else
        //     alert();
    }
})(window.jQuery);


// function getVideoInfo(){
//     var canvas = document.getElementById('canvas');
//     var video = document.getElementById('video');
//     canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
//     video.duration;
// }

function isAllEimoji(text){
    if(!text.replace(/(?:[\u2700-\u27bf]|(?:\ud83c[\udde6-\uddff]){2}|[\ud800-\udbff][\udc00-\udfff]|[\u0023-\u0039]\ufe0f?\u20e3|\u3299|\u3297|\u303d|\u3030|\u24c2|\ud83c[\udd70-\udd71]|\ud83c[\udd7e-\udd7f]|\ud83c\udd8e|\ud83c[\udd91-\udd9a]|\ud83c[\udde6-\uddff]|[\ud83c[\ude01\uddff]|\ud83c[\ude01-\ude02]|\ud83c\ude1a|\ud83c\ude2f|[\ud83c[\ude32\ude02]|\ud83c\ude1a|\ud83c\ude2f|\ud83c[\ude32-\ude3a]|[\ud83c[\ude50\ude3a]|\ud83c[\ude50-\ude51]|\u203c|\u2049|[\u25aa-\u25ab]|\u25b6|\u25c0|[\u25fb-\u25fe]|\u00a9|\u00ae|\u2122|\u2139|\ud83c\udc04|[\u2600-\u26FF]|\u2b05|\u2b06|\u2b07|\u2b1b|\u2b1c|\u2b50|\u2b55|\u231a|\u231b|\u2328|\u23cf|[\u23e9-\u23f3]|[\u23f8-\u23fa]|\ud83c\udccf|\u2934|\u2935|[\u2190-\u21ff])/g , ''))
        return true;
}
function secToTime(time){
    time = parseInt(time);
    if(time){
        var h = parseInt(time/3600).toString();
        var m = parseInt(time/60).toString();
        var s = parseInt(time%60).toString();
        if(h.length == 1 && h != '0'){
            h = '0'+h+':';
        }
        else
            h = '';
        if(m.length == 1){
            m = '0'+m;
        }
        if(s.length == 1){
            s = '0'+s;
        }
        return h+m+':'+s;
    }
    return '00:00:00';
}
function getVideoInfo(file){
    var allFile = [];
    let filePromise = new Promise(resolve => {

        var video=document.createElement('video');
    var array=[];
    var canvas=document.createElement('canvas');
    var ctx=canvas.getContext('2d');
    var info = {};
    function initCanvas(e) {
        canvas.width=this.videoWidth;
        canvas.height=this.videoHeight;
        info = {
            width   : this.videoWidth,
            height  : this.videoHeight,
            duration  : this.duration,
        };
        this.currentTime=this.duration / 2;
    }

    function drawFrame(e) {

        // this.pause();
        ctx.drawImage(this, 0, 0);

        canvas.toBlob(saveFrame, 'image/jpeg');
        // pro.innerHTML = ((this.currentTime / this.duration) * 100).toFixed(2) + ' %';
        // if (this.currentTime < this.duration) {
        //     this.play();
        // }
    }

    function saveFrame(blob) {
        img=new Image();
        img.onload=revokeURL;
        img.src=URL.createObjectURL(blob);
        // pro.attr('src', URL.createObjectURL(blob));
        // console.log(blob);
        // alert(22);
        resolve({
            'file' : file,
            'info' :{
                thumb       : URL.createObjectURL(blob),
                thumbFile   : blob,
                width       : info.width,
                height      : info.height,
                duration    : info.duration,
            }
        })
    }

    function revokeURL(e) {
        URL.revokeObjectURL(this.src);
    }

    function onend(e) {
        var img;
        for (var i=0; i < array.length; i++) {
            img=new Image();
            img.onload=revokeURL;
            img.src=URL.createObjectURL(array[i]);
            pro.attr('src', URL.createObjectURL(array[i]));
        }
        URL.revokeObjectURL(this.src);
    }

    video.muted=true;
    video.addEventListener('loadedmetadata', initCanvas, false);
    video.addEventListener('timeupdate', drawFrame, false);
    video.src=URL.createObjectURL(file);
});

    allFile.push(filePromise);
    return Promise.all(allFile);

}

function randColor() {

    var colors = [
        '#672f6a',
        '#2f6a68',
        '#2f556a',
        '#2f6a62',
        '#306a2f',
        '#656a2f',
        '#6a4c2f',
        '#6a332f',
        '#ad1d69',
        '#ad1d1d',
        '#711dad',
        '#341dad',
        '#1d7aad',
        '#1da8ad',
        '#1dad56',
        '#35ad1d',
        '#aaad1d',
        '#ad781d',
        '#aaad1d',
    ];
    return colors[Math.floor(Math.random() * colors.length)];
}
function elementSort(el , attr) {
    var lis = [];
    new_ul = [];
    // if(!el)
    return false;
    for(var i = $(el).children('.conversation-list-item').length; i--;){
        // if(el.childNodes[i].nodeName === 'LI')
        lis.push($(el).children('.conversation-list-item')[i]);
    }

    // Sort the lis in descending order
    lis.sort(function(a, b){
        return $(b).attr(attr) <= $(a).attr(attr);
    });
    $(el).children('.conversation-list-item').remove();
    // Add them into the ul in order
    for(var i = 0; i < lis.length; i++)
        $(el).append(lis[i]);
}
function getRightTime(time) {
    if(!time)
        return;
    var date = time.split(' ');
    var d = [0,0,0];
    var t = [0,0,0];
    if(date[0]){
        d = date[0].split('-');
    }
    if(date[1]){
        t = date[1].split(':');
    }
    d[1] = parseInt(d[1])-1;
    return moment({
        year :parseInt(d[0]),
        month :parseInt(d[1]),
        day :parseInt(d[2]),
        hour :parseInt(t[0]),
        minute :parseInt(t[1]),
        second :parseInt(t[2])
    });

}
function chatTimeDiff(time) {
    var a = moment();
    if(isFirefox && isAndroid)
        a.set('hour' , parseInt(a.get('hour'))+1);
    var b = getRightTime(time);
    var year = a.diff(b,'years');
    var month = a.diff(b,'months');
    var days = a.diff(b,'days');
    var secends = a.diff(b,'secends');
    var minutes = a.diff(b,'minutes');
    var hours = a.diff(b,'hours');
    var seenTitle;
    var isOnline = '';
    if(year){
        if(year == 1)
            seenTitle = 'پارسال';
        else
            seenTitle = 'خیلی وقت پیش';
    }
    else if(month){
        seenTitle = numbersToPersian(month) + ' ماه پیش';
    }
    else if(days){
        if(days == 1){
            seenTitle = 'دیروز ' + numbersToPersian(b.format("HH:mm"));
        }
        else if(days == 2){
            seenTitle = 'پریروز ' + numbersToPersian(b.format("HH:mm"));
        }
        else if(days < 7){
            seenTitle = numbersToPersian(days) + ' روز پیش';
        }
        else{
            seenTitle = numbersToPersian(parseInt(days/7)) + ' هفته پیش';
        }
    }
    else if(hours){
        seenTitle = numbersToPersian(b.format("HH:mm"));
    }
    else if(minutes){
        seenTitle = numbersToPersian(minutes) + ' دقیقه پیش';
    }
    else{
        if(secends < 30000){
            seenTitle = 'آنلاین';
            isOnline = 'online';
        }
        else
            seenTitle = 'چند لحظه پیش';
    }
    var r = [];
    r['diff'] = seenTitle;
    r['is_online'] = isOnline;
    return r;
}
function notifyMe(message , title , icon = '' , image = '') {
    var options = {
        body: message.text,
        tag: message.tag,
        badage: '20',
        dir: 'rtl',
        icon: icon,
        image: image,
        vibrate: [200, 100, 200, 100, 200, 100, 200]
    }
    if ('serviceWorker' in navigator) {
        if (("Notification" in window))
        Notification.requestPermission(function (result) {
            if (result === 'granted') {
                navigator.serviceWorker.ready.then(function (registration) {
                    registration.getNotifications({tag: message.tag}).then(function(notifications) {
                        console.log(notifications);
                        if(notifications.length)
                        options.body = notifications[0].body + '\n' + message.text;
                        var notification = registration.showNotification(title, options);
                        notification.onclick = function(event) {
                            window.focus();
                        }
                    })
                });
            }
            else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(function (permission) {
                    if (permission === "granted") {
                        navigator.serviceWorker.ready.then(function (registration) {
                            var notification = registration.showNotification(title, options);
                            notification.onclick = function(event) {
                                window.focus();
                            }
                        });
                    }
                });
            }

        });
    }
    else
    if (("Notification" in window)) {
        if (Notification.permission === "granted") {
            var notification = new Notification(title,options);
            notification.onclick = function(event) {
                window.focus();
            }
        }
        else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
                if (permission === "granted") {
                    var notification = new Notification(title,options);
                    notification.onclick = function(event) {
                        window.focus();
                    }
                }
            });

        }
    }
}


self.onnotificationclick = function(event) {
    console.log('On notification click: ', event.notification.tag);
    event.notification.close();

    // This looks to see if the current is already open and
    // focuses if it is
    event.waitUntil(clients.matchAll({
        type: "window"
    }).then(function(clientList) {
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url == '/' && 'focus' in client)
                return client.focus();
        }
        if (clients.openWindow)
            return clients.openWindow('/');
    }));
};


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


function base64ToBlob (b64Data, contentType='', sliceSize=512) {
    const byteCharacters = atob(b64Data);
    const byteArrays = [];

    for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        const slice = byteCharacters.slice(offset, offset + sliceSize);

        const byteNumbers = new Array(slice.length);
        for (let i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        const byteArray = new Uint8Array(byteNumbers);
        byteArrays.push(byteArray);
    }

    const blob = new Blob(byteArrays, {type: contentType});
    return blob;
}

function imageWidthHeight (imageData) {
    return new Promise(resolve => {
        var i = new Image();
    var image = [];
    i.onload = () => resolve({width: i.width, height: i.height});
    i.src = imageData;
});
}

function selectText(node , type = 'copy') {
    var message = [];
    node.contents().each(function () {
        message.push($(this).text());
    });
    var textArea = document.createElement("textarea");

    //
    // *** This styling is an extra step which is likely not required. ***
    //
    // Why is it here? To ensure:
    // 1. the element is able to have focus and selection.
    // 2. if element was to flash render it has minimal visual impact.
    // 3. less flakyness with selection and copying which **might** occur if
    //    the textarea element is not visible.
    //
    // The likelihood is the element won't even render, not even a
    // flash, so some of these are just precautions. However in
    // Internet Explorer the element is visible whilst the popup
    // box asking the user for permission for the web page to
    // copy to the clipboard.
    //

    // Place in top-left corner of screen regardless of scroll position.
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;

    // Ensure it has a small width and height. Setting to 1px / 1em
    // doesn't work as this gives a negative w/h on some browsers.
    textArea.style.width = '2em';
    textArea.style.height = '2em';

    // We don't need padding, reducing the size if it does flash render.
    textArea.style.padding = 0;

    // Clean up any borders.
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';

    // Avoid flash of white box if rendered for any reason.
    textArea.style.background = 'transparent';


    textArea.value = message.join('\n').trim();

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
    } catch (err) {
        console.log('Oops, unable to copy');
    }

    document.body.removeChild(textArea);    return false;
    if (document.body.createTextRange) {
        const range = document.body.createTextRange();
        range.moveToElementText(node);
        range.select();
        if(type == 'copy') {
            document.execCommand("copy");
            document.getSelection().removeAllRanges();
        }
    } else if (window.getSelection) {
        const selection = window.getSelection();
        const range = document.createRange();
        range.selectNodeContents(node);
        selection.removeAllRanges();
        selection.addRange(range);
        if(type == 'copy') {
            document.execCommand("copy");
            document.getSelection().removeAllRanges();
        }
    } else {
        // console.warn("Could not select text in node: Unsupported browser.");
    }
}


/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Chat application
 */




!function($) {
    "use strict";

    var ChatApp = function() {
        this.$body = $("body"),
            this.$timeDateChecked = '',
            this.$conversationDiv = $('.conversation-card-box'),
            this.$sendAttachText = $(".div-description-for-attach > div"),
            this.$conversationListUl = $(".conversation-list-box .conversation-list-ul"),
            this.$conversationListItem = $(".conversation-list-item"),
            this.$sendAttachBtn = $(".send-attach-btn"),
            this.$sendAttachFileBtn = $(".send-attach-file-btn"),
            this.$attachPreview = $(".chat-attach-preview"),
            this.$attachImgPreview = $(".attach-image-preview"),
            this.$attachVideoPreview = $(".attach-video-preview"),
            this.$attachInput = $(".chat-attach-files"),
            this.$attachInputSelected = null,
            this.$attachInputType = null,
            this.$imageAttach = $(".image-attach"),
            this.$fileAttach = $(".file-attach"),
            this.$attachBtn = $(".chat-attach"),
            this.$attachDiv = $(".chat-attach-buttons"),
            this.$chatGallery = $(".chat-show-gallery"),
            this.$chatInput = $('.chat-input'),
            this.$chatList = $('.conversation-list'),
            this.$chatDiv = $('.conversation-chat-box'),
            this.$chatId = $('.conversation-chat-box').data('chat-id'),
            this.$latestMessageId =  $('ul.conversation-list li[data-message-id]:last').data('message-id'),
            this.$chatSendBtn = $('.chat-send button');
        this.$scrolToEndBtn = $('.scroll-to-end');
        this.$startDates = new Array();
        this.$ajax = new Array();
        var messageIds = new Array();
        $('ul.conversation-list li[data-message-id]').each(function () {
            messageIds.push(parseInt($(this).data('message-id')));
        });
        this.$messageIds = messageIds;
        this.$messageInfo = [];
        this.$replyMessageId = 0;
        this.$editMessageId = 0;
        this.$beginingReply = 0;
        this.$isLoadHistory = false;
        this.ctrlPress = false;
        this.chatInputHeight = this.$chatInput.innerHeight();
        this.$fileAttachs = null;
        this.$replyInfo = {};
        this.$usersPush = [];
        this.$usersPush[0] = false;
        this.urlLevelInfo = [];
        this.$imgGalleryId = 0;
        this.$searchAjax = null;
        this.readyToshow = 0;
        var $messageIdForShow = 0;
        var $this = this;
        $.ajax({
            url : '/new/backend/web/users/ajax',
            type : 'post',
            data : {
                command : 'getUserInfo'
            },
            success:function (value) {
                if(value){
                    value = JSON.parse(value);
                    $this.$userInfo = {
                        image   : value.image,
                        name    : value.name,
                        lname   : value.lname,
                        userId   : value.user_id,
                        colorTheme   : value.color_theme,
                    }
                    $this.readyToshow++;
                    if($this.readyToshow == 2)
                        $('#chat-start-waiting').fadeOut();
                }
            },
            error:function(a,b,c){
                // if(b == 'timeout' || a.status == 0){
                var $ajax = this;
                setTimeout(function(){
                    $.ajax($ajax);
                }, 1000)
                // }
            }
        });
        $this.isEndHistory = false;
    };


    ChatApp.prototype.contactSearcherCreate = function() {
        var $this = this;
        var loader = '<div id="message-content-search-loader">' +
            '<div style="position: absolute;top: 50%;right: 50%;"><svg class="fa-spin svg-loader" style=" "><circle cy="22" cx="22" r="20" class="circle-loader" style="stroke: grey !important;"></circle></svg></div>\n' +
            '</div>';
        $('body').on('change' , '.contract_academic_year_id' , function(){
            var $academic = $(this);
            $academic.parent().nextAll().remove();
            $academic.closest('ul').after(loader);
            $.ajax({
                url : '/new/backend/web/users/ajax',
                type : 'post',
                data : {
                    command : 'getChatUsersInput',
                    academicYearId : $(this).val(),
                },
                complete:function(){
                    $academic.closest('ul').nextAll('#message-content-search-loader').remove();
                },
                success:function (value) {
                    $academic.nextAll().remove();
                    if(value){
                        value = JSON.parse(value);
                        var orgs = [];
                        var bases = [];
                        var classes = [];
                        var statusS = [];
                        var educationCourses = [];
                        var orgS = '';
                        var baseS = '';
                        var organization,base,status,sts,selected;
                        var style = 'style="border-radius: 0px;border-color: rgba(0,0,0,0.2);padding: 0;padding-right: 5px;"';
                        var contact = '<div class="select"><label>نوع</label><select name="contact_type" class="form-control input-lg contact_type" '+style+'>';
                        for(var data of value){
                            contact += '<option value="'+data.value+'">'+data.title+'</option>';
                            if(data.organization){
                                orgS = '<div class="select"><label>سازمان</label><select name="organization_id" class="form-control input-lg organization_contact" id="organization_id_'+data.value+'" '+style+'>';
                                for(var organizationId in data.organization.options){
                                    organization = data.organization.options[organizationId];
                                    orgS += '<option value="'+organization.id+'">'+organization.title+'</option>';
                                }
                                orgS += '</select></div>';
                                orgs.push(orgS);

                                if(data.organization.base){
                                    for(var organizationId in data.organization.base.options){
                                        baseS = '<div class="select"><label>پایه</label><select name="base_id" class="form-control input-lg base_contact" id="base_id_'+data.value+'_'+organizationId+'" '+style+'>';
                                        for(var baseId in data.organization.base.options[organizationId]){
                                            base = data.organization.base.options[organizationId][baseId];
                                            if(base){
                                                baseS += '<option value="'+baseId+'">'+base.title+'</option>';
                                                if(data.organization.base.status){
                                                    status = '<div class="select"><label>وضعیت</label><select name="status_id" class="form-control input-lg status_contact" id="status_id_'+data.value+'_'+organizationId+'_'+baseId+'" '+style+'>';
                                                    for(var statusId in data.organization.base.status.options){
                                                        sts = data.organization.base.status.options[statusId];
                                                        selected = '';
                                                        if(sts.id == 1){
                                                            selected = 'selected="true"';
                                                        }
                                                        status += '<option '+selected+' value="'+sts.id+'">'+sts.title+'</option>';
                                                    }
                                                    status += '</select></div>';

                                                    statusS.push(status);
                                                }

                                                if(data.organization.base.classes){
                                                        let classeS = '<div class="select"><label>کلاس</label><select name="class_id" class="form-control input-lg class_contact" id="class_id_'+data.value+'_'+organizationId+'_'+baseId+'" '+style+'>';
                                                        for(var classId in data.organization.base.classes.options[organizationId][baseId]){
                                                            let classData = data.organization.base.classes.options[organizationId][baseId][classId];
                                                            classeS += '<option value="'+classId+'">'+classData.title+'</option>';
                                                        }
                                                        classeS += '</select></div>';
                                                        classes.push(classeS);
                                                }
                                            }


                                        }
                                        baseS += '</select></div>';
                                        bases.push(baseS);
                                    }
                                }
                                if(data.organization.educationCourses){
                                    for(var organizationId in data.organization.educationCourses.options){
                                        baseS = '<div class="select"><label>'+data.organization.educationCourses.title+'</label><select name="educationCourses_id" class="form-control input-lg educationCourses_contact" id="educationCourses_id_'+data.value+'_'+organizationId+'" '+style+'>';
                                        for(var baseId in data.organization.educationCourses.options[organizationId]){
                                            base = data.organization.educationCourses.options[organizationId][baseId];
                                            baseS += '<option value="'+baseId+'">'+base.title+'</option>';
                                        }
                                        baseS += '</select></div>';
                                        educationCourses.push(baseS);
                                    }
                                }
                            }
                        }
                        contact += '</select></div>';
                        var html = contact + orgs.join('') + bases.join('') + educationCourses.join('') + classes.join('');
                        if(statusS)
                            html += statusS.join('');
                        $academic.parent().nextAll().remove();
                        $academic.parent().after(html);
                        $academic.closest('li').find('.contact_type').trigger('change');
                    }
                },
                error:function(a,b,c){
                    // if(b == 'timeout' || a.status == 0){
                    var $ajax = this;
                    setTimeout(function(){
                        $.ajax($ajax);
                    }, 1000)
                    // }
                }
            });
        });
        $('body').on('change' , '.contact_type' , function(){
            var $start = $(this).closest('.contact-start');
            $start.find('.organization_contact , .base_contact , .status_contact , .class_contact , .educationCourses_contact').each(function(){
                $(this).parent().hide();
            });
            $start.find('#organization_id_'+$(this).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#base_id_'+$(this).val()+'_'+ $start.find('#organization_id_'+$(this).val()).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#class_id_'+$(this).val()+'_'+ $start.find('#organization_id_'+$(this).val()).val()+'_'+$('#base_id_'+$(this).val()+'_'+ $start.find('#organization_id_'+$(this).val()).val()).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#educationCourses_id_'+$(this).val()+'_'+ $start.find('#organization_id_'+$(this).val()).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#status_id_'+$(this).val()+'_'+ $start.find('#organization_id_'+$(this).val()).val()+'_'+$('#base_id_'+$(this).val()+'_'+ $start.find('#organization_id_'+$(this).val()).val()).val()).each(function(){
                $(this).parent().show();
            });
        });

        $('body').on('change' , '.organization_contact' , function(){
            var $start = $(this).closest('.contact-start');
            $start.find('.base_contact , .status_contact , .class_contact , .educationCourses_contact').each(function(){
                $(this).parent().hide();
            });

            $start.find('#base_id_'+$start.find('.contact_type').val()+'_'+ $(this).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#class_id_'+$start.find('.contact_type').val()+'_'+$(this).val()+'_'+$start.find('#base_id_'+$start.find('.contact_type').val()+'_'+ $start.find('#organization_id_'+$start.find('.contact_type').val()).val()).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#educationCourses_id_'+$start.find('.contact_type').val()+'_'+ $(this).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#status_id_'+$start.find('.contact_type').val()+'_'+$(this).val()+'_'+$start.find('#base_id_'+$start.find('.contact_type').val()+'_'+ $start.find('#organization_id_'+$start.find('.contact_type').val()).val()).val()).each(function(){
                $(this).parent().show();
            });
        });

        $('body').on('change' , '.base_contact' , function(){
            var $start = $(this).closest('.contact-start');
            $start.find('.status_contact , .class_contact').each(function(){
                $(this).parent().hide();
            });
            $start.find('#class_id_'+$start.find('.contact_type').val()+'_'+$start.find('#organization_id_'+$start.find('.contact_type').val()).val()+'_'+ $(this).val()).each(function(){
                $(this).parent().show();
            });
            $start.find('#status_id_'+$start.find('.contact_type').val()+'_'+$start.find('#organization_id_'+$start.find('.contact_type').val()).val()+'_'+ $(this).val()).each(function(){
                $(this).parent().show().val(1);
            });
        });

        $('body').on('click' , '.select label' , function(){
            $(this).next('select').focus();
        });

        $('body').on('change' , '.contact-start select:not(#forward-type-list):visible' , function(){
            if($(this).hasClass('contract_academic_year_id'))
                return false;
            if(!$(this).closest('.select:visible').length)
                return false;
            var $start = $(this).closest('.contact-start');
            var $ul = $start.closest('ul');
            var data = {command:'getchatContact'};
            $start.find('select:visible').each(function(){
                data[$(this).attr('name')] = $(this).val();
            });
            $start.nextAll().remove();
            $ul.after(loader);
            $.ajax({
                url: '/new/backend/web/users/ajax',
                type: 'post',
                data: data,
                complete:function(){
                    $ul.nextAll('#message-content-search-loader').remove();
                },
                success:function(value){
                    value = JSON.parse(value);
                    var users = [];
                    if($ul.closest('#conversation-profile-info').length){
                        users = $ul.data('users');
                    }
                    var liClass = '';
                    for(var user of value){
                        liClass = $ul.data('li-class');
                        if(users[user.user_id])
                            liClass += ' disabled checked';
                        $this.contactInsert(user , '' , $start , liClass);
                    }
                }
            });
        });
        $('.contract_academic_year_id').trigger('change');
    }
    ChatApp.prototype.checkCreateMessageValidate = function($class = '.create-conversation-form') {
        var validate = false;
        var $form = $($class);
        if($form.find('.title').val().trim() || $class == '#chat-setting'){
            validate = true;
        }
        else {
            validate = false;
        }
        var letters = /^[0-9a-zA-Z_]+$/;
        if(letters.test($form.find('#conversation-id-input').val()) || !$form.find('#conversation-id-input').val().trim()){
            $form.find('#conversation-id-input').css('color' , '');
            $form.find('#conversation-id-input').css('border-color' , '');
            $form.find('#conversation-id-input').prev().css('color' , '');
        }
        else {
            $form.find('#conversation-id-input').css('color' , 'red');
            $form.find('#conversation-id-input').css('border-color' , 'red');
            $form.find('#conversation-id-input').prev().css('color' , 'red');
            validate = false;
        }
        if(validate){
            $form.find('.submit-ch-g , .update-ch-g').addClass('fadeIn-zoom').removeClass('fadeOut-zoom');
        }
        else {
            $form.find('.submit-ch-g , .update-ch-g').addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
        }
        return validate;
    }
    ChatApp.prototype.messageSearch = function(text , contentId = 0 , offset = 0) {
        var $this = this;
        let chatListSearchHasValue = false;
        if($this.$searchAjax)
            $this.$searchAjax.abort();
        if(!offset){
            $('#message-content-search-result .conversation-list-ul').data('offset' , 'ended');
            $('#message-content-search-result .conversation-list-ul').html('');
            if (text.trim()){
                $('.conversation-list-box .chat-message-summery > b').each(function(){
                    if($(this).text().search(new RegExp(text, "i")) > -1){
                        chatListSearchHasValue = true;
                        let textParent = $(this).closest('.conversation-list-item');
                        $('#message-content-search-result .conversation-list-ul').append($this.createChatList({
                            id : textParent.data('id'),
                            chat_type : textParent.data('search_type'),
                            title : $(this).html(),
                            color_theme : textParent.find('.img-not-exist').css('background-color'),
                            src : textParent.find('img').attr('src'),
                            new_message : 0,
                            last_message : {
                                id : true,
                                name : '',
                                text : textParent.find('.chat-message-summery > span').html()
                            }
                        } , 'chatListSearchResult'));
                    }
                });
            }
        }
        if(text.length > 2){
            if(!offset)
                $('#message-content-search-loader').show();
            $this.$searchAjax = $.ajax({
                url : '/new/backend/web/users/ajax',
                type : 'post',
                data: {
                    command : 'searchMessage',
                    text    : text,
                    offset  : offset,
                },
                success : function (value) {
                    if(offset < $('#message-content-search-result .conversation-list-ul').data('offset') && $('#message-content-search-result .conversation-list-ul').data('text') == text)
                        return false;
                    $('#message-content-search-loader').hide();
                    if(value){
                        value = JSON.parse(value);
                        $('#message-content-search-result .conversation-list-ul').data('offset' , offset+1);
                        $('#message-content-search-result .conversation-list-ul').data('text' , text);
                        if(value.global.length){
                            for(var search of value.global){
                                $('#message-content-search-result .conversation-list-ul').append($this.createChatList(search , 'globalSearchResult'));
                            }
                        }
                        if(value.message.length){
                            for(var search of value.message){
                                $('#message-content-search-result .conversation-list-ul').append($this.createChatList(search , 'searchResult'));
                            }
                        }
                        if(!value.global.length && !value.message.length && !chatListSearchHasValue) {
                            if(!offset){
                                $('#message-content-search-result .conversation-list-ul').html('<div style="text-align:center;position: absolute;top: 50%;right: 50%;transform: translate(50% , -50%);"><i style="font-size: 100px;display: block;" class="fa fa-frown"></i><span>نتیجه‌ای یافت نشد!</span></div>');
                            }
                            $('#message-content-search-result .conversation-list-ul').data('offset' , 'ended');
                        }
                    }
                    else if(!offset) {
                        $('#message-content-search-result .conversation-list-ul').html('<div style="text-align:center;position: absolute;top: 50%;right: 50%;transform: translate(50% , -50%);"><i style="font-size: 100px;display: block;" class="fa fa-frown"></i><span>نتیجه‌ای یافت نشد!</span></div>');
                    }
                },
                error:function(a,b,c){
                    if((b == 'timeout' || a.status == 0) && b != 'abort'){
                        var $ajax = this;
                        setTimeout(function(){
                            $this.$searchAjax = $.ajax($ajax);
                        }, 1000)
                    }
                    else if(b != 'abort'){
                        $('#message-content-search-loader').hide();
                        $.Notification.notify('error','bottom right','خطا!');
                    }
                }
            });
        }

    }
    ChatApp.prototype.messageSeen = function(messages) {
        for(var message of messages){
            $('.chat-message-box[data-message-id="'+message+'"]').removeClass('me-not-sink');
        }
        $.ajax({
            'url' : '/new/backend/web/users/ajax',
            'type' : 'post',
            'data' : {
                command     : 'messageSink',
                messages    : messages,
            },
            'success' : function (value) {
                if(value){
                    value = JSON.parse(value);
                    for(var message of value){
                        $('.chat-message-box[data-message-id="'+message+'"]').removeClass('me-not-sink');
                    }
                }
            },
            'error' : function(a,b,c){
                if(b == 'timeout' || a.status == 0){
                    var $ajax = this;
                    setTimeout(function(){
                        $.ajax($ajax);
                    }, 1000)
                }
            }
        });
    }


    ChatApp.prototype.checkMessageSeen = function() {
        // var scrollSize = this.$chatList[0].scrollHeight;
        var scrollTop  = this.$chatList[0].scrollTop;
        var height     = $('.conversation-list-div').innerHeight();
        var $this = this;
        $($this.$chatList.find('.chat-message-box.me-not-sink:not([data-message-id=""])').get().reverse()).each(function () {
            if(this.offsetTop < scrollTop+height){
                var messageSeened = [];
                messageSeened.push($(this).data('message-id'));
                $(this).prevAll('.me-not-sink').each(function () {
                    messageSeened.push($(this).data('message-id'));
                });
                $this.messageSeen(messageSeened);
                return false;
            }
        });
    }
    ChatApp.prototype.showStartDate = function() {
        // var scrollSize = this.$chatList[0].scrollHeight;
        var scrollTop  = this.$chatList[0].scrollTop;
        var $this = this;
        $($this.$chatList.find('.chat-start-date:not(.chat-start-date-fixed)').get().reverse()).each(function () {
            if(this.offsetTop-10 < scrollTop){
                var tempId = (Math.floor(Math.random() * 100000000)).toString();
                $('.chat-start-date-fixed span').html($(this).children().html()).parent().fadeIn()
                    .attr('data-temp-id' , tempId);
                setTimeout(function (){
                    $('.chat-start-date-fixed[data-temp-id="'+tempId+'"]').fadeOut();
                }, 700)
                return false;
            }
        });
    }
    ChatApp.prototype.resize = function() {
        var height = $('.conversation-card-box').innerHeight();
        var childHeight = 0;
        var afterHeight = 0;
        // $('.chat-conversation > :not(.conversation-list-div)')..each(function () {
        //     childHeight+=$(this).outerHeight(true);
        // });
        $('.chat-conversation .conversation-list-div').nextAll(':visible').each(function () {
            afterHeight += $(this).outerHeight(true);
        });
        var marginHeight = $('.conversation-list-div').outerHeight(true) - $('.conversation-list-div').outerHeight();
        // $('.conversation-list-div').css('height' , (height-childHeight-marginHeight).toString()+'px');
        $('#conversation-profile-info').css('height' , ( $('.conversation-list-div').outerHeight(true)+afterHeight).toString()+'px');
        // if($('.conversation-list-div ul').hasScrollBar())
        //     $('.conversation-list-div').addClass('has-scroll-bar');
        // else
        //     $('.conversation-list-div').removeClass('has-scroll-bar');
    }
    ChatApp.prototype.selectElementContents = function(el , type) {
        if(type == 'end'){

        }
        var range = document.createRange();
        range.selectNodeContents(el);
        range.setStart(el.childNodes[el.childNodes.length-1], el.childNodes[el.childNodes.length-1].length);
        range.collapse(true);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }
    ChatApp.prototype.attachFilePreviwe = async function(el , type) {
        var $this = this;
        var allFile = [];
        var i = 0;
        $this.$fileAttachs = el.files;
        var totalWidth = 0;
        var totalHeight = 0;
        var width = [];
        var height = [];
        var widthTmp=0;
        var heightTmp=0;
        var fontSize=0;
        if(el.files.length > 12){
            totalWidth = '25';
            fontSize = '5';
            totalHeight = '16.66%';
        }
        else if(el.files.length > 8){
            totalWidth = '25';
            fontSize = '5';
            totalHeight = '33.33%';
        }
        else if(el.files.length > 4){
            totalHeight = '50%';
            totalWidth = '25';
            fontSize = '5';
        }
        else{
            totalHeight = '100%';
            totalWidth = 100/el.files.length;
            fontSize = (20/el.files.length).toString();
        }
        i = 0;
        $this.$attachImgPreview.html('');
        if(type == 'image'){
            try{
                for(var file of el.files){
                    i++;
                    if(i>12)
                        break;
                    await imageQuality(file , 50).then(function (value) {
                        allFile.push({src:value[0],size:value[0].length*3/4});
                    });

                };
                $this.$attachImgPreview.html('');
                Promise.all(allFile).then(function (value) {
                    for(var image of value){
                        $('<div />').addClass('content-middle').append($('<img />').attr('src', image.src))
                            .append($('<div />').addClass('file-attach-size').html($this.fileSize(image.size)).addClass('ltr')).css('width' , totalWidth+'%').css({
                            'height' : totalHeight
                        }).appendTo($this.$attachImgPreview);
                        $('.chat-attach-preview').addClass('in-zoomIn-fade').removeClass('out-zoomIn-fade');
                    }

                });
            }
            catch {
                alert('خطا!');
                window.history.back();
            }
        }
        else if(type == 'video'){
            try{
                if(el.files[0]){
                    await getVideoInfo(el.files[0]).then(function(value){
                        $('<div />').data('patch', value[0]).addClass('video-file').addClass('content-middle').append($('<img />').addClass('video-file-thumb').attr('src', value[0].info.thumb))
                            .append($('<div />').addClass('file-attach-size').html(value[0].file.name).addClass('ltr').css('top','90%'))
                            .append($('<div />').addClass('file-attach-size').html(numbersToPersian($this.fileSize(value[0].file.size))+'<br>'+numbersToPersian(secToTime(value[0].info.duration))).addClass('ltr').addClass('text-center')).css('width' , totalWidth+'%').css({
                            'height' : totalHeight
                        }).appendTo($this.$attachImgPreview);
                        $('.chat-attach-preview').addClass('in-zoomIn-fade').removeClass('out-zoomIn-fade');
                    });
                }
            }
            catch(a) {
                alert('خطا!');
                window.history.back();
            }
        }
        else {
            $this.$attachImgPreview.html('');
            var typeTitle = '';
            for(var file of el.files){
                i++;
                if(i>12)
                    break;
                typeTitle = /(?:\.([^.]+))?$/.exec(file.name)[1];
                $('<div />').data('patch', file).append(
                    $('<div />')
                        .append($('<div />').addClass('file-attach-size').html(file.name).addClass('ltr').css('top','90%'))
                        .append($('<div />').html(typeTitle).addClass('ltr').attr('style' , 'top: auto; bottom: 10%; color: white;font-size: '+fontSize+'vw;display: table-cell;vertical-align: middle;text-align: center;'))
                        .append($('<div />').addClass('ltr').addClass('file-attach-size').html($this.fileSize(file.size)).css('top','10%'))
                        .css({
                            'background-color'  : 'darkcyan',
                            'border-radius'     : '5px',
                            'display'           : 'table',
                            'width'             : '100%',
                            'height'            : '100%'
                        })
                ).css('width' , totalWidth+'%').css({
                    'height'   : totalHeight,
                    'padding'  : '5px'
                }).addClass('attach-file-preview').appendTo($this.$attachImgPreview);
                $('.chat-attach-preview').addClass('in-zoomIn-fade').removeClass('out-zoomIn-fade');
            }
        }
    }
    ChatApp.prototype.b64Export = function(data , name) {
        var data2 = data.split(',');
        var type = data2[0].split(':')[1].split(';')[0];
        saveAs(this.base64ToBlob(data2[1] , type), name);
    }
    ChatApp.prototype.export = function(data , name) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', data, true);
        xhr.responseType = 'blob';
        xhr.onload = function(e) {
            if (this.status == 200) {
                saveAs(this.response, name);
            }
        };
        xhr.send();
    }
    ChatApp.prototype.fileSize = function($size) {
        if($size >= 1000000000)
            $size = ((parseInt($size/100000000))/10).toString() + ' GB';
        else if($size >= 1000000)
            $size = ((parseInt($size/100000))/10).toString() + ' MB';
        else if($size >= 1000)
            $size = ((parseInt($size/100))/10).toString() + ' KB';
        else
            $size = ((parseInt($size*10))/10).toString() + ' B';
        return $size;
    }
    ChatApp.prototype.base64ToBlob = function (b64Data, contentType='', sliceSize=512) {
        const byteCharacters = atob(b64Data);
        const byteArrays = [];

        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);

            const byteNumbers = new Array(slice.length);
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            const byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }

        const blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }
    ChatApp.prototype.download = function(el , type = 'image') {
        var loaded = 0;
        var $this = this;
        var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     // if(this.readyState == 2 && this.status == 200) {
        //     //     // Download is being started
        //     // }
        //     // else if(this.readyState == 3) {
        //     //
        //     // }
        //     if (this.readyState == XMLHttpRequest.DONE) {
        //         $(el).find('img').get(0).src = this.responseText;
        //     }
        // };
        $(el).find('.download-img-div .download-icon *').remove();
        $(el).find('.download-img-div svg').show();
        $(el).find('.message-attach-file-source svg').show();
        $(el).find('.percent-download').show();
        $(el).find('.message-attach-file-source i').remove();
        xhttp.addEventListener('readystatechange', function(e) {
            if(xhttp.readyState == 2) {

            }
            else if(xhttp.readyState == 3) {
                // Download is under progress
            }
            else if(xhttp.readyState == 4 && xhttp.status == 200) {
                if(type == 'image'){
                    $(el).find('.download-img-div').hide();
                    $(el).find('img').removeClass('message-img-loading')[0].src = URL.createObjectURL(xhttp.response);
                    if($this.$chatGallery.find('.img-full-show').attr('data-file-id') == $(el).find('img').data('file-id')){
                        $this.$chatGallery.find('.img-full-show')[0].src = URL.createObjectURL(xhttp.response);
                    }
                }
                else{
                    $(el).find('.message-attach-file-source svg').hide();
                    $(el).find('.percent-download').hide();
                    $(el).find('.message-attach-file-source').append('<i class="fa fa-file" style="font-size: 20px;"></i>');
                    $(el).data('patch' , URL.createObjectURL(xhttp.response)).addClass('file-attach-download-to-click');
                }
            }
            else if(xhttp.readyState == 4){
                $(el).find('.download-img-div .download-icon').html('<i class="md-arrow-back"></i>');
                $(el).find('.download-img-div svg').hide();
                $(el).find('.message-attach-file-source svg').hide();
                $(el).find('.percent-download').hide();
                $(el).find('.message-attach-file-source').append('<i class="md-arrow-back"></i>');
            }
        });
        if(type == 'image'){
            var fileSize = $(el).find('img').data('file-size');
            xhttp.addEventListener('progress', function(e) {
                var percent_complete = (e.loaded / fileSize)*100;
                $(el).find('.download-img-div .download-icon').html(numbersToPersian(parseInt(percent_complete).toString())+'%');
                if(percent_complete == 0)
                    percent_complete = 2;
                $(el).find('svg circle').css('stroke-dasharray' , ((percent_complete/100)*100.48).toString()+' 999');
            });
            var fileSrc = $(el).find('img').data('file-src');
            if (fileSrc) {
                xhttp.open("GET", fileSrc, true);
                xhttp.responseType = 'blob';
                xhttp.send();
            } else {
                $(el).find('.message-img').get(0).src = "";
            }
        }
        if(type == 'file'){
            var fileSize = $(el).data('file-size');
            xhttp.addEventListener('progress', function(e) {
                var percent_complete = (e.loaded / fileSize)*100;
                $(el).find('.percent-download').html(numbersToPersian(parseInt(percent_complete).toString())+'%');
                if(percent_complete == 0)
                    percent_complete = 2;
                $(el).find('svg circle').css('stroke-dasharray' , ((percent_complete/100)*100.48).toString()+' 999');
            });
            var fileSrc = $(el).data('file-src');
            if (fileSrc) {
                xhttp.open("GET", fileSrc, true);
                xhttp.responseType = 'blob';
                xhttp.send();
            }
        }

        // $.ajax({
        //     url : '/backend/web/users/getfile',
        //     type : 'get',
        //     data : {fileId:fileId},
        //     success : function (value) {
        //         $(el).find('img').removeClass('message-img-loading')[0].src = value;
        //     }
        // });
        //
    }

    ChatApp.prototype.showGallery = function(el) {
        if(el){
            this.$chatGallery.find('.img-full-show').attr('src' , el.src).attr('data-name' , $(el).data('name')).attr('data-file-id',$(el).attr('data-file-id'));
            this.$chatGallery.addClass('in-zoomIn-fade').removeClass('out-zoomIn-fade');
        }
    }

    ChatApp.prototype.hideGallery = function() {
        this.$chatGallery.addClass('out-zoomIn-fade').removeClass('in-zoomIn-fade');
    }

    ChatApp.prototype.dataURLtoFile = function(dataurl, filename) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
    }

    ChatApp.prototype.like = function($messageId,$type = 'like') {
        var $addType,$removeType;
        if ($type == 'like') {
            $addType = 'fa-heart-o';
            $removeType = 'fa-heart';
        }
        if ($type == 'dislike') {
            $addType = 'fa-heart';
            $removeType = 'fa-heart-o';
        }
        $('.chat-message-box[data-message-id="' + $messageId + '"] .like-chat-message').addClass($removeType).removeClass($addType);
        var $this = this;
        $.ajax({
            'url': '/new/backend/web/users/ajax',
            'type': 'post',
            'data': {
                command: 'likeChatMessage',
                commentId: $messageId,
                type: $type,
            },
            'success': function (value) {
                if (value) {
                    value = JSON.parse(value);
                    if (!value.error) {

                    } else {
                        $('.chat-message-box[data-message-id="' + $messageId + '"] .like-chat-message').addClass($addType).removeClass($removeType);
                    }
                } else
                    $('.chat-message-box[data-message-id="' + $messageId + '"] .like-chat-message').addClass($addType).removeClass($removeType);
            },
            'error': function (a, b, c) {
                if(b == 'timeout' || a.status == 0){
                    var $ajax = this;
                    setTimeout(function(){
                        $.ajax($ajax);
                    }, 1000)
                }
                else
                    $('.chat-message-box[data-message-id="' + $messageId + '"] .like-chat-message').addClass($addType).removeClass($removeType);
            },
        });
    }


    ChatApp.prototype.getRealTextOfHtml = function(content) {
        var textArr = [];
        if(typeof content === 'string')
            content = $('<div />').html(content);

        content.contents().filter(function() {
            return (this.nodeType === 3 || (this.nodeType === 1 && this.nodeName !== 'DIV' && this.nodeName !== 'BR')) && $(this).text().trim();
        }).wrap( "<div></div>");

        var div = content.clone();
        var chatText = '';
        var oldNode = null;
        if(div.text().trim()){
            if(div.children().length){
                content.children().each(function () {
                    let text;
                    if(this.nodeName == "BR" && oldNode && oldNode.nodeType != 3)
                        textArr.push('\n');
                    else {
                        $(this).html($(this).html().replace(/<br>/gi,'\n'));
                        textArr.push($(this).text().trim()+'\n');
                    }
                    oldNode = this;
                });
                chatText = textArr.join('');
            }
            else {
                chatText = content.html(content.html().replace(/<br>/gi,'\n')).text();
            }
        }
        return chatText.trim();


    };

    ChatApp.prototype.getRealTextHtml = function(content , isHtmlSC = false , rtlLtr = false , isResultForInput = false) {
        var textArr = [];

        if(!isHtmlSC)
            content = CSRDecode(content);

        content = $('<div />').html(content);

        content.contents().filter(function() {
            return (this.nodeType === 3 || (this.nodeType === 1 && this.nodeName !== 'DIV' && this.nodeName !== 'BR')) && $(this).text().trim();
        }).wrap( "<div></div>");


        var div = content.clone();

        var chatText = '';
        var oldNode = null;
        var $this = this;
        if(div.text().trim()){
            if(div.children().length){
                content.children().each(function () {
                    if(this.nodeName == "BR") {
                        if (oldNode && oldNode.nodeName == 'BR') {
                            textArr.push('\n');
                        }
                    }
                    else {

                        $(this).html($(this).html()
                            .replace(/<br>/gi, '\n'));

                        if (($(this).is('a') || $(this).find('a').length) && isHtmlSC == true && !isResultForInput) {
                            var text = $(this).html().replace(/\n/g, '');
                        } else {
                            var text = $this.getRealTextOfHtml($(this).html()).trim();
                            if (isHtmlSC)
                                text = text.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
                        }
                        text = text.trim();
                        if(!text)
                            text = '\n';
                        textArr.push(text);
                    }
                    oldNode = this;
                });
                textArr = textArr.join('(!|__-|-__|!)').trim().split('(!|__-|-__|!)').filter(function(el) { return el; });
                textArr.forEach((text , index) => {
                    if (rtlLtr) {
                        var letters = /^[0-9a-zA-Z@#\\\/\-*=()]+$/;
                        if (letters.test($('<div />').html(text).text().split('').slice(0, 3).join(''))) {
                            text = '<div style="direction:ltr; text-align: left;">' + text + '</div>';
                        } else {
                            text = '<div style="direction:rtl; text-align: right;">' + text + '</div>';
                        }
                        textArr[index] = text;
                    }
                });
                if(!isHtmlSC)
                    chatText = textArr.join('\n');
                else
                    chatText = CSREncode(textArr.join(''));


                chatText = chatText.trim().replace(/\n/g, '<br>');
            }
            else {
                chatText = content.html();
                if (rtlLtr) {
                    var letters = /^[0-9a-zA-Z@#\\\/\-*=()]+$/;
                    if (letters.test($('<div />').html(chatText).text().split('').slice(0, 3).join(''))) {
                        chatText = '<div style="direction:ltr; text-align: left;">' + chatText + '</div>';
                    } else {
                        chatText = '<div style="direction:rtl; text-align: right;">' + chatText + '</div>';
                    }
                }

            }
        }
        return chatText;
    }


    ChatApp.prototype.getRealText = function(content , type = 'text' , mode = 'content' , isHtmlSC = false , rtlLtr = false) {
        var textArr = [];
        if(mode == 'text') {
            if(!isHtmlSC)
                content = CSRDecode(content);
            content = $('<div />').html(content);
        }else{
            content.contents().filter(function() {
                return this.nodeType === 3 || (this.nodeType === 1 && this.nodeName !== 'DIV' && this.nodeName !== 'BR');
            }).wrap( "<div></div>");
        }
        var div = content.clone();
        div.find('br').remove();
        var chatText = '';
        if(div.text().trim()){
            if(div.children().length){
                var isBr = 0;
                content.children().each(function () {
                    if(type == 'text')
                        $(this).html($(this).html().replace(/<br>/gi,'\n'));
                    else if(type == 'html')
                        $(this).html($(this).html().replace(/<br>/gi,'_______br_______'));
                    if(($(this).is('a') || $(this).find('a').length) && type == 'text' && mode == 'content' && isHtmlSC == true){
                        var text = $(this).html();
                        isBr = 0;
                    }
                    else{
                        var text = $(this).text().trim();
                        if(type == 'html')
                            text = text.replace(/_______br_______/gi,'<br>');
                        if(isHtmlSC)
                            text = text.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
                        if(text.trim())
                            isBr = 0;
                        else if(!isBr)
                            isBr = 1;
                    }
                    if(isBr == 1){
                        isBr = 2;
                    }
                    else{
                        if(rtlLtr){
                            var letters = /^[0-9a-zA-Z@#\\\/\-*=()]+$/;
                            if(letters.test(text.split('').slice(0,3).join(''))){
                                text = '<div style="direction:ltr; text-align: left;">'+text+'</div>';
                            }
                            else{
                                text = '<div style="direction:rtl; text-align: right;">'+text+'</div>';
                            }
                        }
                        textArr.push(text);
                    }
                });
                if(!isHtmlSC)
                    chatText = textArr.join('<br>');
                else
                    chatText = CSREncode(textArr.join(''));
            }
            else {
                chatText = content.html(content.html().replace('<br>','\n')).text();
            }
        }
        return chatText;
    }

    ChatApp.prototype.save = function(chatText = '' , filesId = '' , randId = 0) {
        var $this = this;
        if(!chatText && !filesId)
            chatText = $this.getRealTextOfHtml($this.$chatInput);
        var chatTime = moment().format("H:mm");
        if (chatText == "" && !filesId) {
            $.Notification.notify('error','bottom right','خطا!','ابتدا متن خود را وارد نمایید.');
            this.$chatInput.focus();
        } else {
            $this.$chatInput.html('');
            var edit = $this.$editMessageId;
            var $replyTemp = $this.$replyMessageId;
            $this.$replyMessageId = 0;
            $this.$editMessageId = 0;
            $('.chat-editor .reply-box , .chat-editor .edit-box').remove();
            if (edit){
                $('.chat-message-box[data-message-id="' + edit + '"]').addClass('message-send-loading');
            }

            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'sendChatMessage',
                    text : chatText,
                    files : filesId,
                    chatId : $this.$chatId,
                    commentId : $replyTemp,
                    editId : edit,
                    tempId : randId,
                },
                'success' : function (value) {
                    if(value){
                        value = JSON.parse(value);
                        if(value.error){
                            for(var a of value.error){
                                for(var errorMessage of a){
                                    $.Notification.notify('error','bottom right','خطا!',errorMessage);
                                }
                            }
                            if (edit){
                                $('.chat-message-box[data-message-id="' + edit + '"]').removeClass('message-send-loading');
                            }
                        }
                        else {
                            $('.chat-editor .reply-box').remove();
                            $this.resize();
                            if (edit){
                                $('.chat-message-box[data-message-id="' + edit + '"]').addClass('edited-chat-message').removeClass('message-send-loading');
                                $('.chat-message-box[data-message-id="' + edit + '"]').find('.edited-title .edited-date').html(value.update.date);
                                if(isAllEimoji(value.message_text) && value.message_text.length < 20){
                                    value.message_text = '<span class="only-emoji" style="font-size: 30px">'+value.message_text+'</span>';
                                }
                                $('.chat-message-box[data-message-id="' + edit + '"] .chat-message-text').html($this.getRealTextHtml(value.message_text , true , true));
                                $this.resize();
                            }
                            else{
                                $this.$messageIds.push(parseInt(value.message_id));
                                $('.chat-message-box[data-temp-id="'+randId+'"]').attr('data-message-id',value.message_id).addClass('message-not-sink').removeClass('message-send-loading').removeAttr('data-temp-id');
                            }
                        }
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                },
                error : function (a,b,c) {
                    if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                }
            });
        }
    },

        ChatApp.prototype.getChat = function(type) {
            var $this = this;
            var randId = (Math.floor(Math.random() * 100000000)).toString();
            $this.$ajax['getChat'] = randId;
            $this.$chatDiv.find('.chat-message-box , .chat-start-date:not(.chat-start-date-fixed)').remove();
            $this.$chatDiv.find('.header-title .chat-name-title-2').html('');
            $this.$chatDiv.find('.header-title .chat-message-profile').removeClass('online');
            $this.$chatDiv.attr('data-type-id' , '');
            $this.$chatDiv.attr('data-user-id' , '');
            $this.$chatInput.html('');
            $this.$attachInput.val('');
            if(type == 1){
                $this.$chatDiv.find('.header-title img').attr('src' , $('.conversation-list-item[data-id="'+$this.$chatId+'"] img').eq(0).attr('src'));
                $this.$chatDiv.find('.header-title .img-not-exist').html($('.conversation-list-item[data-id="'+$this.$chatId+'"] .img-not-exist').eq(0).html())
                    .css('background-color' , $('.conversation-list-item[data-id="'+$this.$chatId+'"] .img-not-exist').eq(0).css('background-color'));
                var chatTitle;
                if($('.conversation-list-item[data-id="'+$this.$chatId+'"] b').eq(0).html())
                    chatTitle = '<span>'+$('.conversation-list-item[data-id="'+$this.$chatId+'"] b').eq(0).text()+'</span>';
                $this.$chatDiv.find('.header-title .chat-name-title-1').html(chatTitle);
                $this.$chatDiv.find('.header-title .chat-name-title-2').html('');
                if($('.cancel-reply-message').length){
                    $('.cancel-reply-message').trigger('click');
                }
                if($('.cancel-edit-message').length){
                    $('.cancel-edit-message').trigger('click');
                }
            }
            else {
                $this.$chatDiv.find('.header-title img').attr('src' , '');
                $this.$chatDiv.find('.header-title .img-not-exist').html('')
                    .css('background-color' , '');
                $this.$chatDiv.find('.header-title .chat-name-title-1').html('');
                $this.$chatDiv.find('.header-title .chat-name-title-2').html('');
            }
            $this.$chatDiv.attr('data-chat-id' , $this.$chatId);
            $('#conversation-profile-member').parent().hide();
            $('#conversation-profile-add-member').remove();
            $('#conversation-profile-edit-info').remove();
            $('#conversation-forbidden-comment').remove();
            $('#conversation-profile-info .conversation-list-ul .list-group-item').remove();
            $this.$messageIds = [];
            $this.$replyMessageId = 0;
            $this.$editMessageId = 0;
            $this.$beginingReply = 0;
            $this.ctrlPress = false;
            $this.$fileAttachs = null;
            $this.$isLoadHistory = false;
            $this.$messageInfo = [];
            $this.$replyInfo = {};
            $('.chat-editor').hide();
            $('.channel-footer').hide();
            if($this.$chatId)
                $.ajax({
                    'url' : '/new/backend/web/users/ajax',
                    'type' : 'post',
                    'data' : {
                        command : 'getChat',
                        chatId : $this.$chatId,
                    },
                    'success' : function (value) {
                        if($this.$ajax['getChat'] != randId)
                            return false;
                        if(value){
                            value = JSON.parse(value);
                            if(!value.access){
                                window.history.back();
                                $.Notification.notify('error','bottom right','خطا!','شما به این گفت‌وگو دسترسی ندارید!');
                            }
                            $this.$messageInfo = value;
                            $this.$chatDiv.find('.header-title .chat-message-profile img').attr('src' , value.avatar);
                            if(value.access.send_message){
                                $('.chat-editor').show();
                            }
                            else {
                                if(value.type == 1){
                                    if(!value.access.is_joined)
                                        $('.channel-footer').css('display' , 'flex');
                                }
                            }
                            $this.$chatDiv.attr('data-type-id' , value.type);
                            $this.$chatDiv.attr('data-user-id' , value.chat_user_id);
                            $this.$chatDiv.find('.header-title .img-not-exist').html(value.title.split('')[0]).css('background-color' , value.color_theme);
                            $this.$chatDiv.find('.header-title .chat-name-title-1').html(value.title);
                            $this.$chatDiv.find('#conversation-profile-name').html(value.title);
                            if(!value.summery)
                                value.summery = '';
                            $this.$chatDiv.find('#conversation-profile-summery').html(value.summery.replace(/\n/gi,'<br>'));
                            $this.$chatDiv.find('#conversation-profile-id').html(value.unique_code);
                            if(value.type == 0){
                                var diff = chatTimeDiff(value.activity_date);
                                if(diff['is_online'])
                                    $this.$chatDiv.find('.header-title .chat-message-profile').addClass('online');
                                $this.$chatDiv.find('.header-title .chat-name .chat-name-title-2').html(diff['diff']);
                            }
                            else if(value.type == 1 || value.type == 2){
                                $this.$chatDiv.find('.header-title .chat-name-title-2').html(numbersToPersian(value.members) + ' نفر');
                                $this.$chatDiv.find('#conversation-profile-member').html(numbersToPersian(value.members));
                                $('#conversation-profile-member').parent().show();
                                var menu;
                                if(value.access.is_admin){
                                    $('#conversation-profile-member').parent().append('<a id="conversation-profile-add-member" class="btn btn-info m-r-10">افزودن عضو</a>');
                                }
                                if(value.access.is_super_admin){
                                    $('#conversation-profile-member').parent().append('<a id="conversation-profile-edit-info" class="btn btn-warning m-r-10">ویرایش</a>');
                                }
                                if(value.type == 2){
                                    if(value.access.is_admin){
                                        $('#conversation-profile-member').parent().append('<a id="conversation-forbidden-comment" class="btn btn-danger btn-block m-t-10">بستن ارسال پیام</a>');
                                    }
                                }
                                for(var member of value.memberData){
                                    $this.memberInsert(member , value);
                                }
                                imgWhenLoadShow('#conversation-profile-info img');
                            }
                            if(value.comment_type == 3){
                                if(!$this.$messageInfo.access.is_admin){
                                    if(!$('.chat-editor .forbidden-comment').length){
                                        $('.chat-editor').prepend(`
                                            <div class="forbidden-comment"><i class="fa fa-ban"></i> دسترسی ارسال پیام در این گروه بسته شده است!</div>
                                        `);
                                    }
                                }
                                else
                                    $('#conversation-forbidden-comment').html('ارسال پیام <span class="red">بسته </span> است! برای باز گردن اینجا کلیک نمایید.').addClass('btn-success').removeClass('btn-danger');
                            }
                            else{
                                $('.chat-editor .forbidden-comment').remove();
                                $('#conversation-forbidden-comment').html('بستن ارسال پیام').addClass('btn-danger').removeClass('btn-success');
                            }
                            // $this.$chatDiv.find('.header-title b').html(value.title);
                            $this.init('');
                        }
                        else
                            $.Notification.notify('error','bottom right','خطا!');
                    },
                    error : function (a,b,c) {
                        if(b == 'abort'){
                            alert();
                            return false
                        }
                        // if(b == 'timeout' || a.status == 0){
                            var $ajax = this;
                            setTimeout(function(){
                                $.ajax($ajax);
                            }, 1000)
                        // }
                        // else
                        //     $.Notification.notify('error','bottom right','خطا!');
                    }
                });
        },

        ChatApp.prototype.contactInsert = function(user , type = '' , el = '' , liClass= 'conversation-start-chat') {
            if(!type)
                type = user.type;
            var diff = chatTimeDiff(user.activity_date);
            // if(!$.inArray(user.user_id, this.$usersPush))
            this.$usersPush.push(user.user_id);
            if(!el)
                el = $('.conversation-manage-body > .conversation-list-ul .contact-start');
            el.after(
                '<li class="list-group-item conversation-list-item '+liClass+'" data-search-type="'+type+'" data-user-id="'+user.user_id+'">' +
                '<div class="disabled-select"></div>' +
                '    <div class="chat-message-profile fadeIn-zoom '+diff['is_online']+'">' +
                '        <img src="'+user.avatar+'">' +
                '        <div class="img-not-exist" style="background-color: '+user.color_theme+';">'+user.lname.split('')[0]+'</div>' +
                '    </div>' +
                '    <div class="chat-message-summery w-100">' +
                '        <b style="display: block;margin-bottom: 5px;overflow: hidden;height: 20px;">'+user.name+' '+user.lname+'</b>' +
                '        <span style="font-size: 10px;display: block;overflow: hidden;height: 13px;" class="text-muted pull-right user-activity-time">'+diff['diff']+'</span>' +
                '        <span style="font-size: 10px;display: block;overflow: hidden;height: 13px;" class="text-muted pull-left">'+user.discription+'</span>' +
                '    </div>' +
                '<div class="item-selected"><i class="fa fa-check"></i></div>'+
                '</li>'
            );
        }
        ChatApp.prototype.memberInsert = function(member , value) {
            var $this = this;
            var menu = '';
            var adminIcon = '';
            if(
                member.user_id != $this.$userInfo.userId &&
                value.access.is_admin &&
                !member.is_owner &&
                (value.access.is_owner || !member.is_super_admin)
            ){
                menu =  '<div class="message-option-menu">' +
                    '<ul class="list-group" style="text-align: center;margin: 0;">';
                if(value.access.is_super_admin){
                    if(!member.is_admin || member.is_super_admin) {
                        menu += '<li class="list-group-item add-admin-conversation"><i class="fa fa-user"></i> ' + (member.is_super_admin ? 'تنزل به ' : '') + 'ادمین</li>';
                    }else {
                        menu += '<li class="list-group-item remove-admin-conversation"><i class="fa fa-trash"></i> حذف ادمین</li>';
                    }
                }
                if(value.access.is_owner){
                    if(!member.is_super_admin) {
                        menu += '<li class="list-group-item add-super-admin-conversation"><i class="fa fa-user"></i> ' + (member.is_admin ? 'ارتقا به ' : '') + 'سوپر ادمین</li>';
                    }else {
                        menu += '<li class="list-group-item remove-super-admin-conversation"><i class="fa fa-trash"></i> حذف سوپر ادمین</li>';
                    }
                }
                if(value.access.is_admin){
                    if(!member.is_admin || value.access.is_owner || (!member.is_super_admin && value.access.is_super_admin))
                        menu += '<li class="list-group-item remove-member-conversation"><i class="fa fa-trash"></i> حذف</li>';
                }
                menu += '</ul>' +
                    '</div>';
            }
            if(member.is_owner){
                adminIcon = `<div class="pull-left member-access-type" style="display: flex;justify-content: center;flex-direction: column; font-size:20px">
                                      <i class="fa fa-star"></i>
                                    </div>`;
            }
            else if(member.is_super_admin){
                adminIcon = `<div class="pull-left member-access-type" style="display: flex;justify-content: center;flex-direction: column; font-size:20px">
                                      <i class="fa fa-star-o"></i>
                                    </div>`;
            }
            else if(member.is_admin){
                adminIcon = `<div class="pull-left member-access-type" style="display: flex;justify-content: center;flex-direction: column; font-size:20px">
                                      <i class="gl gl-user-key"></i>
                                    </div>`;
            }

            var diff = chatTimeDiff(member.activity_date);
            // if(!$.inArray(member.user_id, this.$usersPush))
            this.$usersPush.push(member.user_id);
            $('#conversation-profile-info .conversation-list-ul').append(
                '<li style="display: flex" class="list-group-item conversation-list-item" data-member-type="'+''+'" data-user-id="'+member.user_id+'">\n' +
                '    <div class="chat-message-profile fadeIn-zoom '+diff['is_online']+'">' +
                '        <img src="'+member.avatar+'">' +
                '        <div class="img-not-exist" style="background-color: '+member.color_theme+';">'+member.lname.split('')[0]+'</div>\n' +
                '    </div>' +
                '    <div class="chat-message-summery w-100">' +
                '        <b style="display: block;margin-bottom: 5px;overflow: hidden;height: 20px;">'+member.name+' '+member.lname+'</b>\n' +
                '        <span style="font-size: 10px;display: block;overflow: hidden;height: 13px;" class="text-muted user-activity-time">'+numbersToPersian(diff['diff'])+'</span>\n' +
                '    </div>' +
                adminIcon +
                menu +
                '</li>'
            );
        }
        ChatApp.prototype.getContact = function() {
            var $this = this;
            $('.contact-search-item:not([data-search-type="all"]):not([data-search-type="star"])').hide();
            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'getChatUsers',
                },
                'success' : function (value) {
                    if(value){
                        value = JSON.parse(value);
                        if(value.partners.length){
                            $('.contact-search-item[data-search-type="2"]').show();
                            for(var user of value.partners){
                                $this.contactInsert(user , 2);
                            }
                        }
                        if(value.teachers.length){
                            $('.contact-search-item[data-search-type="3"]').show();
                            for(var user of value.teachers){
                                $this.contactInsert(user , 3);
                            }
                        }
                        if(value.family.length){
                            $('.contact-search-item[data-search-type="4"]').show();
                            for(var user of value.family){
                                $this.contactInsert(user , 4);
                            }
                        }
                        if(value.classmate.length){
                            $('.contact-search-item[data-search-type="0"]').show();
                            for(var user of value.classmate){
                                $this.contactInsert(user , 0);
                            }
                        }
                        if(value.students.length){
                            $('.contact-search-item[data-search-type="1"]').show();
                            for(var user of value.students){
                                $this.contactInsert(user , 1);
                            }
                        }
                        if(value.parents.length){
                            $('.contact-search-item[data-search-type="5"]').show();
                            for(var user of value.parents){
                                $this.contactInsert(user , 5);
                            }
                        }
                        $('.conversation-manage-body > .create-conversation > .conversation-list-ul').html($('.conversation-manage-body > .conversation-list-ul .contact-start').clone());
                        $('.conversation-manage-body > .conversation-list-ul .contact-start').nextAll().each(function(){
                            $('.conversation-manage-body > .create-conversation > .conversation-list-ul').append($(this).clone().addClass('user-add-to-ch-g').removeClass('conversation-start-chat'));
                        });
                        imgWhenLoadShow('.conversation-list-item img');
                        $this.readyToshow++;
                        if($this.readyToshow == 2)
                            $('#chat-start-waiting').fadeOut();
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                },
                error : function (a,b,c) {
                    // if(b == 'abort'){
                    //     alert();
                    //     return false
                    // }
                    // if(b == 'timeout' || a.status == 0){
                    var $ajax = this;
                    setTimeout(function(){
                        $.ajax($ajax);
                    }, 1000)
                    // }
                    // else
                    //     $.Notification.notify('error','bottom right','خطا!');
                }
            });
        },

        ChatApp.prototype.createChat = function(data , HL) {
            var $this = this;
            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'craeteChat',
                    data    : data
                },
                'success' : function (value) {
                    $('.submit-ch-g , .update-ch-g').removeClass('loading');
                    if(value){
                        value = JSON.parse(value);
                        if(!value.error){
                            if(!value.is_chat){
                                $this.$chatDiv.find('.header-title .img-not-exist').css('background-color' , value.color_theme);
                                $this.$chatDiv.find('.header-title img').attr('src' , value.chat_avatar);
                                $this.$chatDiv.find('.header-title .chat-name-title-1').html(value.title);
                                $this.$chatDiv.find('#conversation-profile-name').html(value.title);
                                if(!value.summery)
                                    value.summery = '';
                                $this.$chatDiv.find('#conversation-profile-summery').html(value.summery.replace(/\n/gi,'<br>'));
                                $this.$chatDiv.find('#conversation-profile-id').html(value.unique_code);
                            }
                            if(!value.is_update){
                                if(HL < 0)
                                    window.history.go(HL);
                                // if(HL == -1)
                                //     window.history.back();
                                // else if(HL == -2){
                                //     window.history.back();
                                //     window.history.back();
                                // }
                                setTimeout(function(){
                                    window.location.hash = value.id;
                                }, 100)
                            }
                            else{
                                $('#conversation-profile-add-member-cancel').trigger('click');
                                if($this.$messageInfo.id == value.id){
                                    $this.$messageInfo = value;
                                    $('.header-title .chat-message-profile img').attr('src' , value.avatar);
                                }
                            }
                        }
                        else{
                            for(var a in value.error){
                                for(var b of value.error[a]){
                                    $.Notification.notify('error','bottom right','خطا!' , b);
                                }
                            }
                        }
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                },
                error : function (a,b,c) {
                    if(b == 'abort'){
                        $('.submit-ch-g').removeClass('loading');
                        return false
                    }
                    if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    }
                    else{
                        $('.submit-ch-g').removeClass('loading');
                        $.Notification.notify('error','bottom right','خطا!');
                    }
                }
            });
        },

        ChatApp.prototype.removeChat = function(id) {
            var $this = this;
            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'removeChat',
                    id    : id
                },
                'success' : function (value) {
                    if(value){
                        value = JSON.parse(value);
                        if(!value.error){
                            $('.conversation-list-item[data-id='+id+']').remove();
                        }
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                },
                error : function (a,b,c) {
                    if(b == 'abort'){
                        alert();
                        return false
                    }
                    if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                }
            });
        },

        ChatApp.prototype.getUserActivity = function() {
            var $this = this;
            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'getUserActivity',
                    users    : $this.$usersPush
                },
                'success' : function (value) {
                    if(!document.chatCodeTab)
                        return false;
                    if(value){
                        value = JSON.parse(value);
                        var diff;
                        var el;
                        if(!value.error){
                            for(var item of value.data){
                                diff = chatTimeDiff(item.date);
                                var userchat = 'none';
                                if($this.$messageInfo.chat_user_id == item.user_id)
                                    userchat = item.user_id;
                                el =  $('.conversation-list-item[data-user-id="'+item.user_id+'"] , .conversation-chat-box .header-title [data-user-id="'+userchat+'"]');
                                if(diff['is_online']){
                                    el.find('.chat-message-profile').addClass('online');
                                }
                                else{
                                    el.find('.chat-message-profile').removeClass('online');
                                }
                                el.find('.user-activity-time , .chat-name-title-2').html(diff['diff']);
                                el.attr('data-last-seen' , item.date)
                            }
                        }
                        elementSort($('.conversation-profile-detail')[0] , 'data-user-id');
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                    setTimeout(function(){
                        $this.getUserActivity();
                    },1000)
                },
                error : function (a,b,c) {
                    if(b == 'abort'){
                        alert();
                        return false
                    }
                    // if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    // }
                    // else
                    //     $.Notification.notify('error','bottom right','خطا!');
                }
            });
        },

        ChatApp.prototype.removeAddMember = function(id , type='remove') {
            var $this = this;
            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'removeAddMember',
                    id    : id,
                    type    : type,
                    chatId    : $this.$chatId
                },
                'success' : function (value) {
                    $('#conversation-profile-add-member-check').removeClass('loading');
                    if(value){
                        value = JSON.parse(value);
                        if(!value.error){
                            $('#conversation-profile-info .create-conversation').remove();
                            if(type=='remove'){
                                $('#conversation-profile-info .conversation-list-item[data-user-id='+id+']').remove();
                            }
                            else if(type=='add'){
                                for(var member of value.data){
                                    $this.$messageInfo.memberData.push(member);
                                    $this.memberInsert(member , $this.$messageInfo);
                                }
                            }
                        }
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                },
                error : function (a,b,c) {
                    if(b == 'abort'){
                        alert();
                        return false
                    }
                    if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                }
            });
        },


        ChatApp.prototype.removeAddAdmin = function(id , type='remove') {
            var $this = this;
            var chatId = $this.$chatId;
            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'removeAddAdmin',
                    id    : id,
                    type    : type,
                    chatId    : chatId
                },
                'success' : function (value) {
                    if(value){
                        value = JSON.parse(value);
                        if(!value.error){
                            var el = $('.conversation-chat-box[data-chat-id='+chatId+'] .conversation-list-item[data-user-id='+id+']');
                            if(type == 'add'){
                                el.find('.add-admin-conversation').addClass('remove-admin-conversation').html('<i class="fa fa-trash"></i> حذف ادمین').removeClass('add-admin-conversation');
                                var adminIcon = `<div class="pull-left member-access-type" style="display: flex;justify-content: center;flex-direction: column; font-size:20px">
                                  <i class="gl gl-user-key"></i>
                                </div>`;
                                el.find('.member-access-type').remove();
                                el.append(adminIcon);
                            }
                            else if(type == 'remove'){
                                el.find('.remove-admin-conversation').addClass('add-admin-conversation').html('<i class="fa fa-user"></i> ادمین').removeClass('remove-admin-conversation');
                                el.find('.member-access-type').remove();
                            }
                        }
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                },
                error : function (a,b,c) {
                    if(b == 'abort'){
                        alert();
                        return false
                    }
                    if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                }
            });
        },

        ChatApp.prototype.removeAddSuperAdmin = function(id , type='remove') {
            var $this = this;
            var chatId = $this.$chatId;
            $.ajax({
                'url' : '/new/backend/web/users/ajax',
                'type' : 'post',
                'data' : {
                    command : 'removeAddSuperAdmin',
                    id    : id,
                    type    : type,
                    chatId    : chatId
                },
                'success' : function (value) {
                    if(value){
                        value = JSON.parse(value);
                        if(!value.error){
                            var el = $('.conversation-chat-box[data-chat-id='+chatId+'] .conversation-list-item[data-user-id='+id+']');
                            if(type == 'add'){
                                el.find('.add-super-admin-conversation').addClass('remove-super-admin-conversation').html('<i class="fa fa-trash"></i> حذف سوپر ادمین').removeClass('add-super-admin-conversation');
                                var adminIcon = `<div class="pull-left member-access-type" style="display: flex;justify-content: center;flex-direction: column; font-size:20px">
                                  <i class="fa fa-star-o"></i>
                                </div>`;
                                el.find('.member-access-type').remove();
                                el.append(adminIcon);
                            }
                            else if(type == 'remove'){
                                el.find('.remove-super-admin-conversation').addClass('add-super-admin-conversation').html('<i class="fa fa-user"></i> سوپر ادمین').removeClass('remove-super-admin-conversation');
                                el.find('.member-access-type').remove();
                            }
                        }
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                },
                error : function (a,b,c) {
                    if(b == 'abort'){
                        alert();
                        return false
                    }
                    if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    }
                    else
                        $.Notification.notify('error','bottom right','خطا!');
                }
            });
        },

        ChatApp.prototype.createChatList = function(item , type = 'chatList') {
            var $this = this;
            var dateInfo;
            var prevColor;
            var list = '';
            var summeryTilte;
            var title;
            var chatType = '';
            var deleteTitle = '';
            var titleForDelete = '';
            var messageDate;
            titleForDelete = '';
            title = item.title;
            summeryTilte = '!';
            if(item.chat_type == 1)
                title = '<i class="fa fa-bullhorn"></i> '+item.title;
            if(item.chat_type == 2)
                title = '<i class="fa fa-group"></i> '+item.title;

            if(item.title)
                summeryTilte = item.title.split('')[0];
            if(type == 'chatList'){
                if(item.access.is_owner)
                    titleForDelete = 'و حذف';
                if(item.chat_type == 1){
                    chatType = 'کانال';
                    deleteTitle = '<li class="list-group-item remove-chat-conversation"><i class="gl gl-person-running"></i> ترک '+titleForDelete+' کانال</li>';
                }
                if(item.chat_type == 2)
                {
                    chatType = 'گروه';
                    deleteTitle = '<li class="list-group-item remove-chat-conversation"><i class="gl gl-person-running"></i> ترک '+titleForDelete+' گروه</li>';
                }
                if(item.chat_type == 0)
                {
                    chatType = 'چت';
                    deleteTitle = '<li class="list-group-item remove-chat-conversation"><i class="fa fa-trash"></i> حذف گفت‌وگو</li>';
                }

            }

            list = '<li class="list-group-item conversation-list-item" data-id="'+item.id+'" data-search-type="'+item.chat_type+'" data-user-id="'+item.user_id+'" data-message-id="'+(type != 'chatListSearchResult' ? item.last_message.id : 0)+'">' +
                '<div class="chat-message-profile fadeIn-zoom">'+
                '<img src="'+item.src+'">' +
                '<div class="img-not-exist" style="background-color: '+item.color_theme+'">'+summeryTilte+'</div>' +
                '</div>'+
                '<div class="chat-message-summery">' +
                '<b style="display: block;margin-bottom: 5px;overflow: hidden;height: 20px;">'+title+'</b>';
            if(item.last_message.id){
                if(item.chat_type == 2 && type != 'globalSearchResult' && type != 'chatListSearchResult')
                    item.last_message.name = item.last_message.name + ' : ';
                if(item.last_message.hasFile){
                    if(item.last_message.hasFile.type == 0){
                        if(item.last_message.text){
                            item.last_message.text = '<i class="fa fa-image"></i> ' + item.last_message.text;
                        }
                        else{
                            item.last_message.text = '<i class="fa fa-image"></i> تصویر';
                        }
                    }
                    else if(item.last_message.hasFile.type == 1){
                        if(item.last_message.text){
                            item.last_message.text = '<i class="fa fa-file"></i> ' + item.last_message.text;
                        }
                        else{
                            item.last_message.text = '<i class="fa fa-file"></i> فایل';
                        }
                    }
                    else if(item.last_message.hasFile.type == 3){
                        if(item.last_message.text){
                            item.last_message.text = '<i class="fa fa-video-camera"></i> ' + item.last_message.text;
                        }
                        else{
                            item.last_message.text = '<i class="fa fa-video-camera"></i> ویدئو';
                        }
                    }
                    else if(item.last_message.hasFile.type == 2){
                        if(item.last_message.text){
                            item.last_message.text = '<i class="fa fa-music"></i> ' + item.last_message.text;
                        }
                        else{
                            item.last_message.text = '<i class="fa fa-music"></i> صدا';
                        }
                    }
                }
                list += '<span style="font-size: 10px;display: block;overflow: hidden;height: 13px;"><span>'+item.last_message.name+'</span><span class="text-muted">'+item.last_message.text+'</span>';
                messageDate = item.last_message.date;
            }
            else if (item.chat_type != 0) {
                list += '<span style="font-size: 10px;display: block;overflow: hidden;height: 13px;" class="text-muted">شما به این '+chatType+' پیوستید.</span>';
                messageDate = item.date;
            }
            if(!messageDate){
                dateInfo = '';
            }
            else if(moment().format("YYYY-MM-DD") == getRightTime(messageDate).format("YYYY-MM-DD")){
                dateInfo = numbersToPersian(moment(messageDate).format("HH:mm"));
            }
            else if(moment().add(-1, 'days').format("YYYY-MM-DD") == getRightTime(messageDate).format("YYYY-MM-DD")){
                dateInfo = 'دیروز ' + numbersToPersian(getRightTime(messageDate).format("HH:mm"));
            }
            // else {
            //     dateInfo = 'دیروز ' + numbersToPersian(moment(item.date).format("H:m"));
            // }
            else{
                dateInfo = numbersToPersian(dateTojalali(messageDate.split(' ')[0])) + ' ' + numbersToPersian(getRightTime(messageDate).format("HH:mm"))
            }

            if(!parseInt(item.new_message))
                item.new_message = '';
            else if(item.new_message > 99)
                item.new_message = numbersToPersian('+99');
            else
                item.new_message = numbersToPersian(item.new_message);
            list += '</div>' +
                '<div class="chat-new-message-count fadeIn-zoom ltr">'+numbersToPersian(item.new_message)+'</div>' +
                '<div class="chat-new-message-has-reply-to-me fadeIn-zoom ltr"></div>' +
                '<div class="chat-info">' +
                '<span>'+dateInfo+'</span>' +
                '</div>' +
                '<div class="message-option-menu">' +
                '<ul class="list-group" style="text-align: center;margin: 0;">'+
                deleteTitle+
                '</ul>'+
                '</div>'+
                '</li>';
            return list;
        }

    ChatApp.prototype.getChatList = function(dateTime = '') {
        var $this = this;
        $.ajax({
            'url' : '/new/backend/web/users/ajax',
            'type' : 'post',
            'data' : {
                command : 'getChatList',
                date : dateTime,
                chatCodeTab : document.chatCodeTab,
            },
            'success' : function (value) {
                var list;
                var prev;
                if(value == 'forceExit') {
                    document.chatCodeTab = false;
                    $('body *').remove();
                    $('body').append('<div class="alert alert-danger m-t-20" style="margin: 50px auto; max-width: 400px; text-align: center;">از صفحه‌ای دیگر وارد بیام‌رسان شدید!</div>')
                    return false;
                }
                if(value) {
                    var value=JSON.parse(value);
                    document.totalCount = value.totalCount;
                    $('body').attr('totalCount' , value.totalCount);
                    if(value.data.length)
                        $('#chat-list-loader').remove();
                    else{
                        $('#chat-list-loader').html(`<i style="font-size: 100px;display: block;" class="fa fa-comments"></i><span>برای شروع گفتگو بر روی دکمه زیر کلیک نمایید.</span>`);
                    }
                    $this.$conversationListUl.find('.conversation-list-item .chat-new-message-count').html('');
                    $this.$conversationListUl.find('.conversation-list-item .chat-new-message-has-reply-to-me').html('');
                    for(var item of value.data){
                        if(item.chat_type == 0) {
                            $this.$usersPush.push(item.user_id);
                        }
                        prev = $this.$conversationListUl.find('.conversation-list-item[data-id="'+item.id+'"]');
                        if(prev.filter('[data-message-id='+item.last_message.id+']').length)
                            continue;
                        list = $this.createChatList(item);
                        prev.remove();
                        if(!dateTime)
                            $this.$conversationListUl.append(list);
                        else {
                            $this.$conversationListUl.prepend(list);
                            if($this.$chatId != item.id && !item.last_message.is_me){
                                if(item.chat_type == 2)
                                    item.last_message.text = item.last_message.name + ' : ' + item.last_message.text;
                                notifyMe({'text':$this.getRealTextOfHtml(item.last_message.text),'tag':'new_message_'+item.id} , item.title , item.src);
                            }
                        }
                    }
                    var $replytitle = '';
                    for(var count of value.count){
                        // if(!parseInt(count.count))
                        //     count.count = '';
                        // else if(count.count > 99)
                        //     count.count = numbersToPersian('+99');
                        // else
                        //     count.count = numbersToPersian(count.count);
                        $replytitle = '';
                        if(parseInt(count.is_has_reply)){
                            $replytitle = '@';
                        }
                        $this.$conversationListUl.find('.conversation-list-item[data-id="'+count.id+'"] .chat-new-message-has-reply-to-me').html($replytitle);
                        $this.$conversationListUl.find('.conversation-list-item[data-id="'+count.id+'"] .chat-new-message-count').html(count.count ? numbersToPersian(count.count) : '');
                    }
                }
                imgWhenLoadShow('.conversation-list-item img');
                if(!dateTime)
                    $(window).trigger('hashchange');
                if(value){
                    dateTime = value.updateDate;
                }
                setTimeout(function(){
                    $this.getChatList(dateTime);
                }, 1000);
                $this.readyToshow++;
                if($this.readyToshow == 2)
                    $('#chat-start-waiting').fadeOut();
            },
            error : function (a,b,c) {
                if(b == 'abort'){
                    return false
                }
                // if(b == 'timeout' || a.status == 0){
                    var $ajax = this;
                    setTimeout(function(){
                        $.ajax($ajax);
                    }, 1000)
                // }
                // else
                //     $.Notification.notify('error','bottom right','خطا!');
            }
        });
    },
        ChatApp.prototype.appendMessage = async function (messages , mode = 'online' , index=0 , scroll = 'end' , isShowComment = false) {
        var $this = this;
        if(!Array.isArray(messages)){
            messages = [messages];
        }
        var isHasTemp = false;
        var message = messages[index];
        if(message.temp_id){
            if($('.chat-message-box[data-temp-id="'+message.temp_id+'"]').length){
                $('.chat-message-box[data-temp-id="'+message.temp_id+'"]').attr('data-message-id',message.message_id).addClass('message-not-sink').removeClass('message-send-loading').removeAttr('data-temp-id');
                isHasTemp = true;
                $this.$messageIds.push(parseInt(message.message_id));
            }
        }
        if(!isHasTemp){
            var odd = '';
            if($this.$messageIds.find(function (key) {
                    return key == parseInt(message.message_id);
                }))
                return false;
            if(parseInt(message.message_id))
                $this.$messageIds.push(parseInt(message.message_id));

            // if(!$this.$startDates.find(function (key) {
            //         return key == parseInt(message.message_date.split(' ')[0]);
            //     })){
            //     $this.$startDates.push(message.message_date.split(' ')[0]);
            // }


            var $messageStatus = ''
            var replyIcon = 'reply';
            if(message.is_me){
                if($this.$messageInfo.type != 1){
                    odd = 'odd';
                    replyIcon = 'forward';
                }
                if(message.is_sink){
                    $messageStatus = ' message-sink';
                }
                else if(message.is_loading){
                    $messageStatus = ' message-send-loading';
                }
                else{
                    $messageStatus = ' message-not-sink';
                }
                if(!message.is_me_sink){
                    $messageStatus += ' me-not-sink';
                }
            }
            else{
                if(!message.is_me_sink){
                    $messageStatus = ' me-not-sink';
                }
            }
            var $tempId = ''
            if(message.temp_id){
                $tempId = ' data-temp-id="'+message.temp_id+'" ';
            }
            var $reply = '';
            if(message.reply.id){
                $reply = '<div class="reply" data-reply-message-id="'+message.reply.id+'"><a><b>'+message.reply.full_name+'</b><span>'+message.reply.comment+'</span></a></div>';
            }
            var $forward = '';
            if(message.forward){
                if(message.forward.id){
                    $forward = '<div class="forward" data-reply-message-id="'+message.forward.id+'"><a><b>باز ارسال شده</b><b>از '+message.forward.title+'</b></a></div>';
                }
            }
            var $updateDate = '';
            var $updateClass = '';
            if(message.update.date){
                $updateDate = message.update.date;
                $updateClass = ' edited-chat-message';
            }
            var $firstImage = '';
            var imageGallery = '';
            var attachFiles = '';
            var attachAudio = '';
            var attachVideo = '';
            var $isNextGallery = '';
            var playIcon = '';
            if(message.file) {
                if (message.file.image) {
                    if (message.file.image.length) {
                        $isNextGallery=' message-has-gallery';
                        // var maxHeight;
                        // var maxWidth;
                        // if(message.file.image.length <= 4){
                        //     maxWidth = (100/message.file.image.length).toString()+'%';
                        // }
                        // else{
                        //     maxWidth = (100/4).toString()+'%';
                        // }
                        var $grid1, $grid2, imageSize, $imageGalleryClass='';
                        var $styleDiv=new Array();
                        var imgappend;
                        var $float2LineSet=[];
                        for (var $id in message.file.image) {
                            imgappend=await
                            imageWidthHeight('data:' + message.file.image[$id].type + ';base64,' + message.file.image[$id].srcThumb).then(function (imageSize) {
                                if (imageSize.height / imageSize.width >= 1) {
                                    $grid1='w';
                                    $grid2='h';
                                } else {
                                    $grid2='w';
                                    $grid1='h';
                                }
                                $styleDiv[$id]=new Array();
                                $styleDiv[$id]['height']=imageSize.height;
                                $styleDiv[$id]['width']=imageSize.width;
                                $styleDiv[$id]['image']=message.file.image[$id];
                                if (($id + 1) % 3 == 1) {
                                    if ($grid1 == 'w') {
                                        $styleDiv[$id][$grid2]=9;
                                        $styleDiv[$id][$grid1]=6;
                                    }
                                    else {
                                        $styleDiv[$id][$grid2]=6;
                                        $styleDiv[$id][$grid1]=4;
                                    }
                                    $styleDiv[$id]['s']=$grid1;
                                } else if (($id + 1) % 3 == 2) {
                                    if ($styleDiv[$id - 1]['s'] == $grid1) {
                                        $styleDiv[$id][$grid1]=3;
                                        $styleDiv[$id][$grid2]=6;
                                        $styleDiv[$id]['s']=$grid1;
                                        $styleDiv[$id - 1][$grid1]=3;
                                        $styleDiv[$id - 1][$grid2]=6;
                                    } else if ($styleDiv[$id - 1]['s'] == $grid2) {
                                        if ($grid1 == 'w') {
                                            $styleDiv[$id][$grid1]=2;
                                            $styleDiv[$id][$grid2]=4;
                                            $styleDiv[$id]['s']=$grid1;
                                            $styleDiv[$id - 1][$grid1]=4;
                                            $styleDiv[$id - 1][$grid2]=4;
                                        }
                                        else {
                                            $styleDiv[$id][$grid1]=2;
                                            $styleDiv[$id][$grid2]=6;
                                            $styleDiv[$id]['s']=$grid1;
                                            if ($styleDiv[$id - 1]['s'] == 'w') {
                                                $styleDiv[$id - 1][$grid2]=9;
                                                $styleDiv[$id - 1][$grid1]=6;
                                            }
                                            else {
                                                $styleDiv[$id - 1][$grid2]=6;
                                                $styleDiv[$id - 1][$grid1]=4;
                                            }
                                        }
                                    }
                                } else if (($id + 1) % 3 == 0) {
                                    if ($styleDiv[$id - 1]['s'] == $grid1) {
                                        if ($styleDiv[$id - 2]['s'] == $grid1) {
                                            $styleDiv[$id][$grid1]=2;
                                            $styleDiv[$id][$grid2]=6;
                                            $styleDiv[$id]['s']=$grid1;
                                            $styleDiv[$id - 1][$grid1]=2;
                                            $styleDiv[$id - 2][$grid1]=2;
                                            $styleDiv[$id - 1][$grid2]=6;
                                            $styleDiv[$id - 2][$grid2]=6;
                                        } else if ($styleDiv[$id - 2]['s'] == $grid2) {
                                            $styleDiv[$id][$grid1]=3;
                                            $styleDiv[$id][$grid2]=4;
                                            $styleDiv[$id]['s']=$grid1;
                                            $styleDiv[$id - 1][$grid1]=3;
                                            $styleDiv[$id - 1][$grid2]=4;
                                            $styleDiv[$id - 2][$grid1]=6;
                                            $styleDiv[$id - 2][$grid2]=2;
                                        }
                                    } else if ($styleDiv[$id - 1]['s'] == $grid2) {
                                        if ($styleDiv[$id - 2]['s'] == $grid1) {
                                            $styleDiv[$id][$grid1]=4;
                                            $styleDiv[$id][$grid2]=3;
                                            $styleDiv[$id]['s']=$grid1;
                                            $styleDiv[$id - 1][$grid1]=4;
                                            $styleDiv[$id - 2][$grid1]=2;
                                            $styleDiv[$id - 1][$grid2]=3;
                                            $styleDiv[$id - 2][$grid2]=6;
                                        } else if ($styleDiv[$id - 2]['s'] == $grid2) {
                                            $styleDiv[$id][$grid1]=2;
                                            $styleDiv[$id][$grid2]=6;
                                            $styleDiv[$id]['s']=$grid1;
                                            if ($grid1 == 'w') {
                                                $float2LineSet[parseInt($id / 3)]=true;
                                            }
                                            $styleDiv[$id - 1][$grid1]=4;
                                            $styleDiv[$id - 1][$grid2]=3;
                                            $styleDiv[$id - 2][$grid1]=4;
                                            $styleDiv[$id - 2][$grid2]=3;
                                        }
                                    }
                                }
                                return false;
                            });
                        }
                        var image;
                        var $style;

                        for (var $id in $styleDiv) {
                            $style='';
                            var $float2LineSetStart='';
                            var $float2LineSetEnd='';
                            if ($float2LineSet[parseInt($id / 3)]) {
                                if ($id % 3 == 0) {
                                    $float2LineSetStart='<div class="img-w-4" style="float: left">';
                                }
                                else if ($id % 3 == 1) {
                                    $float2LineSetEnd='</div>';
                                }
                            }
                            image=$styleDiv[$id]['image'];
                            if(!$firstImage)
                                $firstImage = 'data:' + image.type + ';base64,' + image.srcThumb;
                            $imageGalleryClass='image-gallery-d';
                            if ($styleDiv[$id]['w'] * $styleDiv[$id]['height'] > $styleDiv[$id]['h'] * $styleDiv[$id]['width']){
                                $style='width:100%;height:auto';
                            }
                            else{
                                $style='height:100%;width:auto;min-width:'+((100*$styleDiv[$id]['width']*$styleDiv[$id]['h'])/($styleDiv[$id]['height']*$styleDiv[$id]['w'])).toString()+'%';
                            }
                            $styleDiv[$id]['h']=' img-h-' + $styleDiv[$id]['h'];
                            $styleDiv[$id]['w']=' img-w-' + $styleDiv[$id]['w'];
                            var status='message-img-loading';
                            var imgIcon='<div class="download-img-div">' +
                                '<svg class="fa-spin svg-circle-percent">' +
                                '<circle class="circle-percent" r="20" cx="22" cy="22"></circle>' +
                                '</svg>' +
                                '<div class="download-icon text-center content-middle"><i class="md-arrow-back"></i></div>' +
                                '<div class="file-size">' + image.sizeFa + '</div></div>';
                            if (image.is_source) {
                                status='message-img-uploading';
                                imgIcon='<div class="upload-img-div">' +
                                    '<svg class="fa-spin svg-circle-percent" style="display: block">' +
                                    '<circle class="circle-percent" r="20" cx="22" cy="22"></circle>' +
                                    '</svg>' +
                                    '<div class="upload-icon text-center content-middle">۰%</div>' +
                                    '</div>';
                            }
                            imageGallery+=$float2LineSetStart + '<div class="message-img ' + $styleDiv[$id]['h'] + $styleDiv[$id]['w'] + '">' +
                                imgIcon +
                                '<img style="' + $style + '" class=" ' + status + '" data-file-size="' + image.size + '" data-file-id="' + image.id + '" src="data:' + image.type + ';base64,' + image.srcThumb + '" data-file-src="' + image.src + '" data-name="'+image.name+'">' +
                                '</div>' + $float2LineSetEnd;
                        }
                        imageGallery='<div class="message-gallery ' + $imageGalleryClass + '">' + imageGallery + '</div>';
                    }
                }
                if (message.file.audio) {
                    if (message.file.audio.length) {
                        // $isNextGallery=' message-has-gallery';
                        for(var attach of message.file.audio){
                            attachAudio +=
                                '<div class="message-attach-audio" data-file-size="'+attach.size+'" data-file-id="'+attach.id+'" data-file-src="'+attach.src+'">' +
                                '   <audio class="audio-waite-to-proccess" controls preload="metadata" download-url="'+attach.src+'">' +
                                '       <source src="'+attach.src+'" type="audio/mpeg">' +
                                '   </audio>' +
                                '</div>';
                        }
                    }
                }
                var videoStyle = '';
                if (message.file.video) {
                    if (message.file.video.length) {
                        // $isNextGallery=' message-has-gallery';
                        for(var attach of message.file.video){
                            download = '';
                            imgIcon = '';
                            playIcon = '';
                            if (attach.is_source) {
                                download = '<i class="md-arrow-back message-video-download" style="display: none"></i>';
                                imgIcon='<div class="upload-img-div">' +
                                    '<svg class="fa-spin svg-circle-percent" style="display: block">' +
                                    '<circle class="circle-percent" r="20" cx="22" cy="22"></circle>' +
                                    '</svg>' +
                                    '<div class="percent-upload upload-icon text-center content-middle">۰%</div>' +
                                    '</div>';
                                playIcon = '<div class="message-video-play content-middle text-center" style="display: none;"><i class="gl gl-play"></i></div>';

                            }else{
                                playIcon = '<div class="message-video-play content-middle text-center"><i class="gl gl-play"></i></div>';
                                download = '<i class="md-arrow-back message-video-download"></i>';
                            }
                            videoStyle = '';
                            // if(attach.info.other.width / attach.info.other.height > 0.5){
                            //     videoStyle = '';
                            // }
                            // else{
                            //     videoStyle = 'width:auto !important';
                            // }
                            attachVideo +=
                                '<div class="message-attach-video" data-file-size="'+attach.size+'" data-file-id="'+attach.id+'" data-file-src="'+attach.src+'">' +
                                download +
                                imgIcon +
                                playIcon+
                                '<div class="file-size ltr text-right" style="right: 5px;left: auto;">' +
                                '  <span>'+numbersToPersian(secToTime(attach.info.other.duration))+'</span><br>' +
                                '  <span>'+numbersToPersian($this.fileSize(attach.size))+'</span>' +
                                '</div>'+
                                // '<img class="message-img-uploading" src="data:' + attach.info.fileType + ';base64,' + attach.info.thumb + '">' +
                                '<img class="message-thumb-video-uploading" src="'+attach.info.thumb+'" height="'+attach.info.other.height+'" style="'+videoStyle+'">' +
                                // '   <video preload="metadata" controls style="padding-bottom:0px" download-url="/backend/web/users/getfile2?fileId='+attach.id+'&download=true">' +
                                // '       <source src="/backend/web/users/getfile3?fileId='+attach.id+'" type="'+attach.type+'">' +
                                // '   </video>' +
                                '</div>';

                            // '<div class="message-attach-video" data-file-size="'+attach.size+'" data-file-id="'+attach.id+'">' +
                            // '   <video data-plyr-config=\'{ "download": true }\' class="plyr__video-embed video-waite-to-proccess" controls crossorigin playsinline style="padding-bottom:0px" download-url="/backend/web/users/getfile2?fileId='+attach.id+'&download=true">' +
                            // '       <source src="/backend/web/users/getfile2?fileId='+attach.id+'" type="'+attach.type+'">' +
                            // '   </video>' +
                            // '</div>';
                        }
                    }
                }
                if (message.file.attach) {
                    if (message.file.attach.length) {
                        var dStatus = '';
                        var download = '';
                        for(var attach of message.file.attach){
                            dStatus = '';
                            download = '<i class="md-arrow-back"></i>';
                            if (attach.is_source) {
                                dStatus =
                                    '<div class="message-attach-file-uploading">' +
                                    '<svg class="fa-spin svg-circle-percent"><circle class="circle-percent" cx="22" cy="22" r="18"></circle></svg>'+
                                    '<span class="percent-upload"></span>' +
                                    '</div>';
                                download = '<i class="fa fa-file" style="font-size: 20px;margin-right: 2px"></i>';
                            }else{

                            }
                            attachFiles +=
                                '<div class="message-attach-file" data-file-size="'+attach.size+'" data-file-id="'+attach.id+'" data-file-src="'+attach.src+'">' +
                                '<div class="message-attach-file-box">' +
                                dStatus +
                                '<div class="message-attach-file-source">' +
                                '<svg class="fa-spin svg-circle-percent"><circle class="circle-percent" cx="22" cy="22" r="18"></circle></svg>'+
                                '<span class="percent-download"></span>'+
                                download +
                                '</div>' +
                                '</div>' +
                                '<div class="message-attach-file-name content-middle">' +
                                '<span>'+attach.name+'</span>' +
                                '</div>' +
                                '</div>';
                        }
                    }
                }
            }
            var hideWait = '';

            if(mode == 'history'){
                hideWait = ' hide';
            }
            var menu = '';
            if(
                ($this.$messageInfo.type == 0 && message.is_me) ||
                ($this.$messageInfo.type != 0 && $this.$messageInfo.access.is_super_admin)
            ){
                if(jQuery.isEmptyObject(message.forward))
                    menu += '<li class="list-group-item edit-chat-message" style="padding: 5px;"><i class="fa fa-pencil"></i> ویرایش</li>';
                menu += '<li class="list-group-item delete-chat-message" style="padding: 5px;"><i class="fa fa-trash-o"></i> حذف</li>';
            }
            if($this.$messageInfo.access.send_message)
                menu += '<li class="list-group-item chat-message-reply" style="padding: 5px;"><i class="fa fa-mail-'+replyIcon+'"></i> پاسخ</li>';
            menu += '<li class="list-group-item forward-chat-message" style="padding: 5px;"><i class="fa fa-share-alt"></i> بازارسال</li>' +
                '<li class="list-group-item copy-chat-message" style="padding: 5px;"><i class="fa fa-copy"></i> رونوشت</li>'+
                '<li class="list-group-item" style="padding: 5px;"><i class="fa fa-warning"></i> گزارش</li>';
            var $messageAvatar = '';
            var $fullName = '';
            var $replyBtn = '';
            var $viewCount = '';
            if($this.$messageInfo.type == 2){
                $messageAvatar = `
            <div class="chat-avatar">
                <div class="chat-message-profile fadeIn-zoom">
                    <div class="img-not-exist" style="background-color: `+message.color_theme+`;position: absolute;">`+message.lname.split('')[0]+`</div>
                    <img src="`+message.avatar_dir+`" style="position: absolute;">
                </div>
                <i>` + message.message_time_fa + `</i>
            </div>`;
                // $messageAvatar = '<div class="chat-avatar"><img src="' + message.avatar_dir + '" alt="' + message.full_name + '"><i>' + message.message_time_fa + '</i></div>';
                $fullName = '<i class="chat-message-user-name">' + message.full_name + '</i>';
            }
            else if($this.$messageInfo.type == 1){
                if(!message.view_count)
                    message.view_count = 0;
                $viewCount = '<div class="view-count m-r-5">' +
                    '<span class="view-count-number" style="font-size: 10px;margin-left: 2px;">'+farsiNumber(message.view_count)+'</span>' +
                    '<span class="fa fa-eye"></span>' +
                    '</div>';

            }
            if($this.$messageInfo.access.send_message){
                $replyBtn = '<i class="fa fa-mail-'+replyIcon+' chat-message-reply" data-toggle="tooltip" data-placement="top" data-original-title="پاسخ"></i>';
            }
            var likeStatus = 'fa-heart-o';
            var $messageCount = '';
            if(message.like_count){
                if(parseInt(message.like_count))
                    $messageCount = farsiNumber(message.like_count);
            }
            if(message.is_like){
                likeStatus = 'fa-heart';
            }
            if(isAllEimoji(message.message_text) && !attachFiles && !attachAudio && !imageGallery && !attachVideo && message.message_text.length < 20){
                message.message_text = '<span class="only-emoji" style="font-size: 30px">'+message.message_text+'</span>';
            }
            else{
                message.message_text = $this.getRealTextHtml(message.message_text , true , true);
            }
            message.message_text = message.message_text.replace(/(#[\u0041-\u005A\u0061-\u007A\u00AA\u00B5\u00BA\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05D0-\u05EA\u05F0-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u08A0\u08A2-\u08AC\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097F\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C33\u0C35-\u0C39\u0C3D\u0C58\u0C59\u0C60\u0C61\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D60\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F4\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u1700-\u170C\u170E-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1877\u1880-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191C\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19C1-\u19C7\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4B\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1CE9-\u1CEC\u1CEE-\u1CF1\u1CF5\u1CF6\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2183\u2184\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005\u3006\u3031-\u3035\u303B\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FCC\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA697\uA6A0-\uA6E5\uA717-\uA71F\uA722-\uA788\uA78B-\uA78E\uA790-\uA793\uA7A0-\uA7AA\uA7F8-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA80-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uABC0-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC_]+)/ig, "<span class='blue'>$1</span>");
            var messageData = $('<li class="clearfix chat-message-box '+odd+$updateClass+$messageStatus+$isNextGallery+hideWait+'" '+$tempId+' data-message-id="' + message.message_id +'">'+
                $messageAvatar +
                '<div class="conversation-text">'+
                '<div class="message-option-menu">' +
                '<ul class="list-group" style="text-align: center;margin: 0;">'+
                menu +
                '</ul>'+
                '</div>'+
                '<div class="ctext-wrap">'+
                $fullName+
                $reply+
                $forward+
                '<div class="chat-message-text">' + message.message_text + '</div>'+
                attachFiles+
                attachAudio+
                imageGallery+
                attachVideo+
                '<div class="message-detail" style="display: flex; flex-direction: row-reverse">'+
                '<div class="message-status"><span></span><div class="message-loading" style="position: relative; margin-top: -4px"><svg class="fa-spin svg-loader mini"><circle cy="8" cx="8" r="6" class="circle-loader"></circle></svg><div></div></div></div>'+
                '<div class="edited-title content-middle m-r-5"><span class=" md-mode-edit"></span></div>'+
                $viewCount+
                '<div class="message-time content-middle"><span>'+message.message_time_fa+'</span></div>'+
                // '<div class="edited-title"><span>ویرایش شده در </span><span class="edited-date">'+$updateDate+'</span></div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="chat-message-options text-center">' +
                $replyBtn+
                '<i class="fa '+likeStatus+' like-chat-message" data-toggle="tooltip" data-placement="top" data-original-title="علاقه‌مندی"></i>' +
                '<div class="message-like-count" style="margin-top: -7px; margin-bottom: -7px">'+$messageCount+'</div>' +
                '</div>'+
                '</li>');


            if(mode == 'history'){
                if($('.conversation-list').find('.chat-start-date[data-date="'+message.message_date.split(' ')[0]+'"]').length)
                    $('.conversation-list').find('.chat-start-date[data-date="'+message.message_date.split(' ')[0]+'"]').remove();
                messageData.insertAfter('.conversation-list .chat-start-date-fixed');
                $('<li class="chat-start-date hide" data-date="'+message.message_date.split(' ')[0]+'"><span>'+numbersToPersian(dateTojalali(message.message_date.split(' ')[0]))+'</span></li>').insertAfter('.conversation-list .chat-start-date-fixed');
            }
            else if(mode == 'online'){
                if(!$('.conversation-list').find('.chat-start-date[data-date="'+message.message_date.split(' ')[0]+'"]').length)
                    $('<li class="chat-start-date" data-date="'+message.message_date.split(' ')[0]+'"><span>'+numbersToPersian(dateTojalali(message.message_date.split(' ')[0]))+'</span></li>').appendTo('.conversation-list');
                messageData.appendTo('.conversation-list');
            }

            // const players = Plyr.setup('.audio-waite-to-proccess , .video-waite-to-proccess');
            // for(var pl of players){
            //     if(pl[0].active){
            //         alert();
            //     }
            // }
            const player = Array.from(document.querySelectorAll('.video-waite-to-proccess , .audio-waite-to-proccess')).map(p => new Plyr(p , {controls: function(e){
                var controls = [
                    'play-large', // The large play button in the center
                    // 'restart', // Restart playback
                    // 'rewind', // Rewind by the seek time (default 10 seconds)
                    'play', // Play/pause playback
                    // 'fast-forward', // Fast forward by the seek time (default 10 seconds)
                    'progress', // The progress bar and scrubber for playback and buffering
                    'current-time', // The current time of playback
                    // 'duration', // The full duration of the media
                    // 'mute', // Toggle mute
                    // 'volume', // Volume control
                    'captions', // Toggle captions
                    'settings',
                    // 'settings', // Settings menu
                    'pip', // Picture-in-picture (currently Safari only)
                    'airplay', // Airplay (currently Safari only)
                    // 'volume', // Show a download button with a link to either the current source or a custom URL you specify in your options
                    'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
                    'fullscreen', // Toggle fullscreen
                ];
                // if($(p).hasClass('audio-waite-to-proccess'))
                //     controls.push('volume');
                return controls;
            },
                urls: {
                    download: $(p).attr('download-url'),
                },
                settings : ['speed'],
                i18n: {
                    restart: 'شروع مجدد',
                    rewind: 'پخش سریع در جهت معکوس {seektime}s',
                    play: 'پخش',
                    pause: 'توقف',
                    fastForward: 'پخش سریع {seektime}s',
                    seek: 'پیمایش',
                    seekLabel: '{currentTime} از {duration}',
                    played: 'پخش شده',
                    buffered: 'بافر شده',
                    currentTime: 'زمان کنونی',
                    duration: 'مدت زمان',
                    volume: 'میزان صدا',
                    mute: 'سکوت',
                    unmute: 'پخش صدا',
                    enableCaptions: 'فعال کردن زیرنویس',
                    disableCaptions: 'غیر فعال کردن زیرنویس',
                    enterFullscreen: 'ورود به حال تمام‌صفحه',
                    exitFullscreen: 'خروج از حالت تمام‌صفحه',
                    frameTitle: 'پخش برای {title}',
                    captions: 'زیرنویس‌ها',
                    settings: 'تنظیمات',
                    menuBack: 'بازگشت به منوی قبل',
                    speed: 'سرعت',
                    normal: 'معمولی',
                    quality: 'کیفیت',
                    loop: 'حلقه تکرار',
                    start: 'شروع',
                    end: 'پایان',
                    all: 'همه',
                    reset: 'بازنشانی',
                    disabled: 'غیرفعال شده',
                    enabled: 'فعال شده',
                    advertisement: 'تبلیغ',
                    qualityBadge: {
                        2160: '4K',
                        1440: 'HD',
                        1080: 'HD',
                        720: 'HD',
                        576: 'SD',
                        480: 'SD'
                    }
                }
            }));
            // player.on('canplaythrough', function(event) {
            //     player.off('canplaythrough');
            //     alert();
            // })
            $('.video-waite-to-proccess').removeClass('video-waite-to-proccess');
            // const player = new Plyr('.audio-waite-to-proccess');
            $('.audio-waite-to-proccess').removeClass('audio-waite-to-proccess');

            $this.$chatInput.val('');
        }
        if(mode == 'online'){
            // $this.$chatInput.focus();
            var scrollSize = $this.$chatList[0].scrollHeight;
            var scrolled = $this.$chatList[0].scrollTop;
            var height = $this.$chatList.outerHeight();
            if(scrollSize < scrolled+height+400 || message.is_me){
                if(scrollSize <= height){
                    $this.checkMessageSeen();
                }
                else{
                    if(scrollSize - scrolled <= height*2){
                        $this.$chatList.scrollTo('2000%', '2000%', {
                            easing: 'swing'
                        });
                    }
                    else{
                        $this.$chatList.scrollTo('2000%');
                    }
                }
            }
            else{
                var count = $this.$chatDiv.find('.chat-message-box.me-not-sink').length;
                if(count)
                    count = numbersToPersian(count);
                else
                    count = '';
                $this.$scrolToEndBtn.find('.chat-new-message-count').html(count);
                $this.$scrolToEndBtn.addClass('fadeIn-zoom').removeClass('fadeOut-zoom');
            }
            if(!message.is_me)
                if(document.visibilityState == 'hidden')
                    notifyMe({'text':$this.getRealTextOfHtml(message.message_text),'tag':'new_message_'+$this.$chatId} , message.full_name , message.avatar_dir , $firstImage);
        }
        index++;
        if(messages[index])
            $this.appendMessage(messages , mode , index , scroll , isShowComment);
        else{
            if(mode == 'history'){
                // $this.$chatList.ready(function(){
                setTimeout(function(){
                    var scrollTo = 0;
                    var lastEl = 0;
                    var scrollTo1;
                    var ii = 0;
                    var isNew;
                    if(!$this.$chatList[0].scrollTop)
                        $this.$chatList.scrollTo(1);
                    $('.chat-message-box.hide , .chat-start-date.hide:not(.chat-start-date-fixed)').each(function () {
                        $(this).removeClass('hide');
                        lastEl = $(this).outerHeight();
                        if(!isNew)
                            scrollTo += lastEl;
                        if(scroll == 'end') {
                            if(!$(this).hasClass('me-not-sink') || $(this).hasClass('odd') || $(this).hasClass('chat-start-date')){
                                scrollTo1 = scrollTo;
                            }
                            else
                                isNew = true;
                        }
                        $this.$chatList.scrollTop(scrollTo1);
                    });
                    if(isShowComment){
                        var messageBox = $('.conversation-list li[data-message-id="'+isShowComment+'"]');
                        var offsetTop = 0;
                        messageBox.prevAll(':not(.chat-start-date-fixed):not(#chat-loading-history)').each(function () {
                            offsetTop += $(this).outerHeight(true);
                        });
                        $this.$chatList.scrollTo(offsetTop);
                        messageBox.addClass('reply-show');
                        setTimeout(function(){
                            messageBox.removeClass('reply-show');
                        }, 2500);
                    }
                    var scrollSize = $this.$chatList[0].scrollHeight;
                    var height = $this.$chatList.outerHeight();
                    if(scrollSize <= height){
                        $this.checkMessageSeen();
                    }
                },10);
                // });
            }
            imgWhenLoadShow('.chat-message-profile img');
        }
    },

    ChatApp.prototype.getMessage = function (mode = 'online' , scroll='end' , commentId = 0) {
        var $this = this;
        var chatId = $this.$chatId;
        if(mode == 'history'){
            $('#chat-loading-history').show();
        }
        var randId = (Math.floor(Math.random() * 100000000)).toString();
        $this.$ajax[mode+'-'+scroll] = randId;
        if('history-end' == mode+'-'+scroll){
            $this.$ajax['online-end'] = '';
        }
        else if(!$this.$isLoadHistory)
            return false;

        // if(!$this.$messageIds.length && mode == 'online')
        //     return false;
        return $.ajax({
            'url' : '/new/backend/web/users/ajax',
            'type' : 'post',
            'data' : {
                command    : 'getChatMessage',
                chatId     : $this.$chatId,
                maxId      : $this.$messageIds.length ? Math.max.apply(null , $this.$messageIds) : null,
                minId      : $this.$messageIds.length ? Math.min.apply(null , $this.$messageIds) : null,
                mode       : mode,
                commentId  : commentId,
                dateTime   : $this.$timeDateChecked
            },
            'success' : function (value) {
                if(!document.chatCodeTab)
                    return false;
                if($this.$ajax[mode+'-'+scroll] != randId || chatId != $this.$chatId)
                    return false;
                if('history-end' == mode+'-'+scroll){
                    $this.$isLoadHistory = true;
                }
                else{
                    if(!$this.$isLoadHistory)
                        return false;
                }
                if(mode == 'history'){
                    $('#chat-loading-history').hide();
                }
                else if(mode == 'online'){
                    $this.$timeDateChecked = moment().format("YYYY-MM-DD H:m:s");
                }
                if(value){
                    value = JSON.parse(value);
                    if(mode == 'history'){
                        if(!value.message){
                            $this.isEndHistory = true;
                        }
                    }
                    if(value.message){
                        $this.appendMessage(value.message , mode , 0 , scroll , commentId);
                    }
                    if(mode == 'online'){
                        var $messageBox;
                        for(var like of value.like){
                            $messageBox = $('.chat-message-box[data-message-id="'+like.comment_id+'"]');
                            if(!parseInt(like.count))
                                like.count = '';
                            if($messageBox.length)
                                $messageBox.find('.message-like-count').html(farsiNumber(like.count));
                        }
                        for(var remove of value.removed){
                            $messageBox = $('.chat-message-box[data-message-id="'+remove+'"]');
                            if(!$messageBox.next('.chat-message-box').length)
                                $messageBox.prev('.chat-start-date').remove();
                            $messageBox.remove();
                        }
                        for(var edited of value.edited){
                            $messageBox = $('.chat-message-box[data-message-id="'+edited.id+'"]');
                            if(isAllEimoji(edited.text) && edited.text.length < 20)
                                edited.text = '<span class="only-emoji" style="font-size: 30px">'+edited.text+'</span>';
                            else
                                edited.text = $this.getRealTextHtml(edited.text ,true , true);
                            $messageBox.addClass('edited-chat-message').find('.chat-message-text').html(edited.text);
                            $messageBox.find('.edited-date').html(numbersToPersian(dateTojalali(edited.date)));
                        }
                        for(var sinked of value.sinked){
                            $messageBox = $('.chat-message-box[data-message-id="'+sinked+'"]').addClass('message-sink').removeClass('message-not-sink');
                        }
                        for(var view of value.view){
                            $messageBox = $('.chat-message-box[data-message-id="'+view.comment_id+'"]');
                            if($messageBox.length)
                                $messageBox.find('.view-count .view-count-number').html(farsiNumber(view.count));
                        }
                    }
                    if(value.chatOption.comment_type == 3){
                        if(!$this.$messageInfo.access.is_admin){
                            if(!$('.chat-editor .forbidden-comment').length)
                                $('.chat-editor').prepend(`
                                    <div class="forbidden-comment"><i class="fa fa-ban"></i> دسترسی ارسال پیام در این گروه بسته شده است!</div>
                                `);
                        }
                        else
                            $('#conversation-forbidden-comment').html('ارسال پیام <b class="red">بسته </b> است! برای باز کردن اینجا کلیک نمایید.').addClass('btn-success').removeClass('btn-danger');
                    }
                    else{
                        $('.chat-editor .forbidden-comment').remove();
                        $('#conversation-forbidden-comment').html('بستن ارسال پیام').addClass('btn-danger').removeClass('btn-success');
                    }
                }
                if(mode == 'online' || (mode == 'history' && scroll=='end')){
                    setTimeout(function(){
                        $this.getMessage();
                    },1000)
                }
            },
            error : function (a,b,c) {
                if(b == 'abort'){
                    return false;
                }
                if(b == 'timeout' || a.status == 0){
                    var $ajax = this;
                    setTimeout(function(){
                        $.ajax($ajax);
                    }, 1000)
                }
                else {
                    if(mode == 'history'){
                        $('#chat-loading-history').hide();
                    }
                    else if(mode == 'online'){
                        $this.getMessage();
                    }

                }
                // $.Notification.notify('error','bottom right','خطا!');
            }
        });

    }
    ChatApp.prototype.init = function (type = 'withEvent') {
        var $this = this;
        $this.isEndHistory = false;
        $('.div-fixed').show();
        $('#conversation-profile-add-member-cancel').trigger('click');
        $this.resize();
        $('.conversation-list').show();
        var finshed = [];
        $this.$ajax['getMessage'] = '';
        finshed.push($this.getMessage('history' , 'end' , $this.$messageIdForShow));
        // Promise.all(finshed).then(function(){
        //     $this.getMessage('online');
        // });
        // setInterval(function () {
        //     if($this.$messageIds.length)
        //         $this.getMessage('online')
        // }, 1000);
        //binding keypress event on chat input box - on enter we are adding the chat into chat list -
        if(type != 'withEvent'){
            return true;
        }
        $this.$chatInput.keypress(function (ev) {
            var p = ev.which;
            if (p == 13 && $this.ctrlPress) {
                ev.preventDefault();
                $this.$chatSendBtn.trigger('click');
                return false;
            }
        });

        $this.$chatInput.on('keyup change' , function (ev) {

            if($(this).text().trim()) {
                $this.$attachBtn.addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
                $('.v-r').hide();
                $('.chat-send').show();
            }
            else {
                $this.$attachBtn.addClass('fadeIn-zoom').removeClass('fadeOut-zoom');
                $('.v-r').show();
                $('.chat-send').hide();
                if(!$(this).text()){
                    $(this).html('');
                }
            }
            if(!$(this).children().length){
                var letters = /^[0-9a-zA-Z@#\\\/\-*=()]+$/;
                if(letters.test($(this).text().trim().replace(/ /g , '').split('').slice(0,3).join(''))){
                    $(this).attr('style' , "direction:ltr; text-align: left;");
                }
                else{
                    $(this).attr('style' , "direction:rtl; text-align: right;");
                }
            }
            else
                $(this).attr('style' , '');
            $(this).children().each(function(){
                var letters = /^[0-9a-zA-Z@#\\\/\-*=()]+$/;
                if(letters.test($(this).text().trim().replace(/ /g , '').split('').slice(0,3).join(''))){
                    $(this).attr('style' , "direction:ltr; text-align: left;");
                }
                else{
                    $(this).attr('style' , "direction:rtl; text-align: right;");
                }
            })
        });
        $this.$chatInput.on('paste' , function (ev) {
            var $this4 = $(this);
            setTimeout(function(){
                $this4.trigger('keyup');
            },10)
        });
        $this.$chatInput.keydown(function (ev) {
            if($this.chatInputHeight != $(this).innerHeight()) {
                $this.chatInputHeight = $(this).innerHeight();
                $this.resize();
            }
            if (ev.keyCode == 16) {
                $this.shiftPress = true;
            }
            else if (ev.keyCode == 17) {
                $this.ctrlPress = true;
            }
        }).keyup(function (ev) {
            if($this.chatInputHeight != $(this).innerHeight()) {
                $this.chatInputHeight = $(this).innerHeight();
                $this.resize();
            }
            if (ev.keyCode == 16) {
                $this.shiftPress = false;
            }
            else if (ev.keyCode == 17) {
                $this.ctrlPress = false;
            }

        });


        //binding send button click
        $this.$chatSendBtn.click(function (ev) {
            var randId = (Math.floor(Math.random() * 100000000)).toString();
            var text = $this.getRealTextHtml($this.$chatInput.html() , true , true);
            var textForSave = $this.getRealTextOfHtml($this.$chatInput);
            if(!$this.$editMessageId && text){
                $this.appendMessage({
                    message_id : '',
                    temp_id : randId,
                    is_me : true,
                    is_loading : true,
                    avatar_dir : $this.$userInfo.image,
                    full_name  : $this.$userInfo.name + ' ' + $this.$userInfo.lname,
                    lname      : $this.$userInfo.lname,
                    message_time_fa:farsiNumber(moment().format("H:mm")),
                    message_text:text,
                    message_date:moment().format("YYYY-MM-DD"),
                    file :{},
                    reply:$this.$replyInfo,
                    color_theme:$this.$userInfo.colorTheme,
                    update:false
                });
            }
            $this.$replyInfo = {};
            $this.save(textForSave , '' , randId);
            $this.$chatInput.trigger('keyup');
            return false;
        });


        //binding send button click
        $this.$chatList.on('click' , '.reply' , function () {
            var messageId = $(this).data('reply-message-id');
            var messageBox = $('.conversation-list li[data-message-id="'+messageId+'"]');
            var offsetTop = 0;
            var scrolled = $this.$chatList[0].scrollTop;
            var height = $this.$chatList.outerHeight();

            messageBox.prevAll(':not(.chat-start-date-fixed):not(#chat-loading-history)').each(function () {
                offsetTop += $(this).outerHeight(true);
            });
            if(Math.abs(scrolled-offsetTop) <= 2*height)
                $this.$chatList.scrollTo(offsetTop, '0%', {
                    easing: 'swing'
                });
            else
                $this.$chatList.scrollTo(offsetTop);
            messageBox.addClass('reply-show');
            setTimeout(function(){
                messageBox.removeClass('reply-show');
            }, 2500);
            $this.$beginingReply = $this.$chatList.get(0).scrollTop;
        });

        //$this.$chatDiv.off('click');
        //binding send button click
        $this.$chatDiv.on('click' , '.chat-message-reply' , function () {
            var $messageBox = $(this).closest('li.chat-message-box');
            var $messageId = $messageBox.data('message-id');
            $this.$replyMessageId = $messageId;
            $this.$editMessageId = 0;
            var $userName = $messageBox.find('.chat-message-user-name').text();
            if(!$userName)
                $userName = '&nbsp';
            var $messageText = $('<div/>').html($messageBox.find('.chat-message-text').html().replace('<br>','\n')).text().replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
            var $messageTextArr = $messageText.split(' ');
            if(!$userName)
                $userName = '&nbsp';
            $messageText = $messageTextArr.slice(0,5).join(' ')+' ...';
            $this.$replyInfo = {
                id : $messageId,
                comment:$messageText,
                full_name:$userName
            };
            var $reply = '<div class="reply-box" data-reply-message-id="'+$messageId+'"><div><i class="fa fa-mail-reply pull-right"></i></div><a class="cancel-reply-message pull-left"><i class="gl gl-remove"></i></a><div class="summery-text"><b>'+$userName+'</b><span>'+$messageText+'</span></div></div>';
            $('.chat-editor .reply-box , .chat-editor .edit-box').remove();
            $('.chat-editor').prepend($reply);
            $this.$chatInput.focus();
            $this.resize();
        });

        //binding send button click
        $this.$chatDiv.on('click' , '.message-option-menu .edit-chat-message' , function () {
            var $messageBox = $(this).closest('li.chat-message-box');
            var $messageId = $messageBox.data('message-id');
            $this.$editMessageId = $messageId;
            $this.$replyMessageId = 0;
            $this.$replyInfo = {};
            var $userName = $messageBox.find('.chat-message-user-name').text();
            if(!$userName)
                $userName = '&nbsp';
            var $messageTextArr = [];
            $('<div/>').html($messageBox.find('.chat-message-text').html().replace('<br>','\n')).children().each(function(){
                $messageTextArr.push($(this).text().replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;"));
            });
            var $messageText = $messageTextArr.slice(0,5).join(' ')+' ...';
            var $reply = '<div class="edit-box" data-reply-message-id="'+$messageId+'"><div><i class="fa fa-pencil pull-right"></i></div><a class="cancel-edit-message pull-left"><i class="gl gl-remove"></i></a><div class="summery-text"><b>'+$userName+'</b><span>'+$messageText+'</span></div></div>';
            $('.chat-editor .reply-box , .chat-editor .edit-box').remove();
            $('.chat-editor').prepend($reply);
            var clone = $messageBox.clone();
            // clone.find('.chat-message-text').contents().filter(function() {
            //     return this.nodeType === 3 || (this.nodeType === 1 && this.nodeName !== 'DIV');
            // }).wrap( "<div></div>");
            clone.find('.only-emoji').replaceWith(clone.find('.only-emoji').text());



            //CSR DECODE
            clone.find('.csr-preview').each(function () {
                var CSTitle = $(this).text();
                var splited = $(this).find('a').attr('href').split('/')
                var CSId = splited[splited.length-1];
                var CSRTemplate = `#CSR{{${CSId},${CSTitle}}}CSR`;
                $(this).replaceWith(`<div>${CSRTemplate}</div>`);
            });


            $this.selectElementContents($this.$chatInput.html(clone.find('.chat-message-text').html()).focus().get(0) , 'end');
            $this.resize();
            $this.$chatInput.trigger('keyup');
        });

        //binding send button click
        $this.$chatDiv.on('click' , '.message-option-menu .copy-chat-message' , function () {
            var $message = $(this).closest('li.chat-message-box').find('.chat-message-text');
            selectText($message);
        });

        $this.$chatDiv.on('click' , '.message-option-menu .delete-chat-message' , function () {
            var $messageBox = $(this).closest('li.chat-message-box').addClass('waite-to-delete');
            var $messageId = $messageBox.data('message-id');
            $.ajax({
                url : '/new/backend/web/users/ajax',
                type : 'post',
                data : {
                    command : 'deleteChatMessage',
                    id      : $messageId,
                },
                success:function (value) {
                    if(value){
                        value = JSON.parse(value);
                        if(value.error){

                        }
                        else{
                            if(!$messageBox.next('.chat-message-box').length)
                                $messageBox.prev('.chat-start-date').remove();
                            $messageBox.remove();
                        }
                    }
                },
                error:function(a,b,c){
                    if(b == 'timeout' || a.status == 0){
                        var $ajax = this;
                        setTimeout(function(){
                            $.ajax($ajax);
                        }, 1000)
                    }
                }
            });
        });

        //binding send button click
        $this.$chatDiv.on('click' , '.cancel-reply-message , .cancel-edit-message' , function () {
            $('.chat-editor .reply-box , .chat-editor .edit-box').remove();
            $this.$replyMessageId = 0;
            $this.$replyInfo = {};
            $this.$editMessageId = 0;
            $this.resize();
            if($(this).hasClass('cancel-edit-message'))
                $this.$chatInput.html('');
            $this.$chatInput.focusout();
        });


        //binding send button click
        $this.$chatDiv.on('click' , '.chat-message-options .like-chat-message' , function () {
            var messageBox = $(this).closest('li.chat-message-box');
            var messageId = messageBox.attr('data-message-id');
            var $type = '';
            if(messageBox.find('.like-chat-message').hasClass('fa-heart'))
                $type = 'dislike';
            else
                $type = 'like';
            $this.like(messageId,$type);
        });


        if(isSafari){
            var timeout;
            $this.$conversationDiv.on('touchstart', function( e ) {
                timeout = setTimeout(function () {
                    var $parent = '';
                    var $list;
                    var $thisMessage;
                    if($(e.target).filter('.ctext-wrap').length || $(e.target).closest('.ctext-wrap').length){
                        if($(e.target).hasClass('.ctext-wrap'))
                            $thisMessage = e.target;
                        else
                            $thisMessage = $(e.target).closest('.ctext-wrap');
                        $parent =  $($thisMessage).closest('.conversation-text');
                        $list = $this.$chatList;
                    }
                    if($(e.target).filter('.conversation-list-item').length || $(e.target).closest('.conversation-list-item').length){
                        $thisMessage = e.target;
                        $parent =  $($thisMessage).closest('.conversation-list-item');
                        if(!$parent.length)
                            $parent =  $($thisMessage);
                        $list = $parent.closest('.conversation-list-ul');
                    }
                    if($parent.length){
                        if (
                            !$(e.target).filter('.reply').length && !$(e.target).closest('.reply').length
                            // &&
                            // !$(e.target).filter('.message-gallery').length && !$(e.target).closest('.message-gallery').length
                        ) {
                            var height = $($thisMessage).outerHeight();
                            var width = $($thisMessage).outerWidth();
                            var pWidth = $list.outerWidth();
                            var offsetTop = $parent[0].offsetTop;
                            var offsetLeft = $parent[0].offsetLeft;
                            var scrollHeight = $list[0].scrollHeight;
                            var offsetY = e.offsetY;
                            var offsetX = e.offsetX;
                            var menu = $parent.find('.message-option-menu');
                            if(offsetTop+offsetY+menu.outerHeight() > scrollHeight){
                                offsetY = scrollHeight-(offsetTop+menu.outerHeight()+20);
                            }
                            if(offsetLeft+offsetX+menu.outerWidth()>pWidth){
                                offsetX = pWidth-(offsetLeft+menu.outerWidth())-5;
                            }
                            menu.css({
                                top: offsetY,
                                left: offsetX
                            }).show();
                        }
                    }
                },500);
            }).on( 'touchend', function( e ) {
                clearTimeout(timeout);
            });
        }


        $this.$conversationDiv.on('contextmenu , click , touch' , function (e) {
            $('.message-option-menu').hide();
            if(!$(e.target).closest('#conversation-profile-info').length && !$(e.target).filter('#conversation-profile-info').length && !$(e.target).hasClass('chat-more-info')){
                $('#conversation-profile-info').addClass('slide-reverse-left').removeClass('slide-reverse-right');
            }
            if(!$(e.target).closest('#chat-option-btn').length && !$(e.target).filter('#chat-option-btn').length && !$(e.target).filter('[id="chat-option-btn"]').length){
                $('#chat-option-menu').hide();
            }
            if(!$(e.target).closest('#forward-message-contact-selector').length && !$(e.target).filter('#forward-message-contact-selector').length && $('#forward-message-contact-selector').length){
                $('#forward-message-contact-selector').addClass('slide-down').removeClass('slide-up');
                setTimeout(function() {
                        $('#forward-message-contact-selector').remove();
                    },500
                )
            }
            if(!$(e.target).closest('.chat-attach').length && !$(e.target).hasClass('.chat-attach')){
                var sec = 0;
                $($this.$attachDiv.children().get().reverse()).each(function(){
                    var thisA = this;
                    setTimeout(function(){
                        $(thisA).addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
                    } , sec);
                    sec += 50;
                });
                setTimeout(function(){
                    $this.$attachDiv.hide();
                } , sec+500);

            }
            var $thisMessage;
            if(e.type == 'click')
                return true;
            else if(!$(e.target).closest('.chat-input').length && !$(e.target).hasClass('.chat-input'))
                e.preventDefault();
            var $parent = '';
            var $list;
            if($(e.target).filter('.ctext-wrap').length || $(e.target).closest('.ctext-wrap').length){
                if($(e.target).hasClass('.ctext-wrap'))
                    $thisMessage = e.target;
                else
                    $thisMessage = $(e.target).closest('.ctext-wrap');
                $parent =  $($thisMessage).closest('.conversation-text');
                $list = $this.$chatList;
            }
            if($(e.target).filter('.conversation-list-item').length || $(e.target).closest('.conversation-list-item').length){
                $thisMessage = e.target;
                $parent =  $($thisMessage).closest('.conversation-list-item');
                if(!$parent.length)
                    $parent =  $($thisMessage);
                $list = $parent.closest('.conversation-list-ul');
            }
            if($parent.length){
                if (
                    !$(e.target).filter('.reply').length && !$(e.target).closest('.reply').length
                // &&
                // !$(e.target).filter('.message-gallery').length && !$(e.target).closest('.message-gallery').length
                ) {
                    var height = $($thisMessage).outerHeight();
                    var width = $($thisMessage).outerWidth();
                    var pWidth = $list.outerWidth();
                    var offsetTop = $parent[0].offsetTop;
                    var offsetLeft = $parent[0].offsetLeft;
                    var scrollHeight = $list[0].scrollHeight;
                    var offsetY = e.offsetY;
                    var offsetX = e.offsetX;
                    var menu = $parent.find('.message-option-menu');
                    if(offsetTop+offsetY+menu.outerHeight() > scrollHeight){
                        offsetY = scrollHeight-(offsetTop+menu.outerHeight()+20);
                    }
                    if(offsetLeft+offsetX+menu.outerWidth()>pWidth){
                        offsetX = pWidth-(offsetLeft+menu.outerWidth())-5;
                    }
                    menu.css({
                        top: offsetY,
                        left: offsetX
                    }).show();
                }
            }
        });

        $this.$scrolToEndBtn.click(function () {
            var scrollSize = $this.$chatList[0].scrollHeight;
            var scrolled = $this.$chatList[0].scrollTop;
            var height = $this.$chatList.outerHeight();
            if(!$this.$beginingReply){
                if(scrollSize - scrolled <= height*3)
                    $this.$chatList.scrollTo('100%', '100%', {
                        easing: 'swing'
                    });
                else
                    $this.$chatList.scrollTo('100%');
            }
            else {
                if(scrollSize - $this.$beginingReply <= height*3)
                    $this.$chatList.scrollTo($this.$beginingReply+'px', '0%', {
                        easing: 'swing'
                    });
                else
                    $this.$chatList.scrollTo($this.$beginingReply+'px');
            }
        });

        $this.$chatList.on('scroll', function (e) {
            if(!$this.$chatList.hasScrollBar){
                $this.checkMessageSeen();
                return false;
            }
            var scrollSize = this.scrollHeight;
            var scrolled = this.scrollTop;
            var divHeight = $(this).innerHeight();
            if(document.visibilityState != 'hidden')
                $this.checkMessageSeen();
            $this.showStartDate();
            if(scrolled == 0){
                if(!$this.isEndHistory)
                    $this.getMessage('history' , 'no');
            }
            var count = $this.$chatDiv.find('.chat-message-box.me-not-sink').length;
            if(count)
                count = numbersToPersian(count);
            else
                count = '';
            $this.$scrolToEndBtn.find('.chat-new-message-count').html(count);
            if(scrollSize - scrolled > divHeight*2){
                var tempId = (Math.floor(Math.random() * 100000000)).toString();
                $this.$scrolToEndBtn.attr('data-temp-id' , tempId).addClass('fadeIn-zoom').removeClass('fadeOut-zoom');
                setTimeout(function (){
                    if(!$this.$scrolToEndBtn.find('.chat-new-message-count').html())
                        $this.$scrolToEndBtn.filter('[data-temp-id="'+tempId+'"]').addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
                }, 2000)

            }
            else
                $this.$scrolToEndBtn.addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
            if($this.$beginingReply <= scrolled){
                $this.$beginingReply = 0;
            }
        });

        document.addEventListener("visibilitychange", function() {
            $this.checkMessageSeen();;
        });

        $this.$chatList.on('click' , '.message-gallery .message-img-loading , .message-gallery .download-img-div .download-icon' , function (el) {
            console.log(111111111)
            $this.download($(this).closest('.message-img'));
        });

        $this.$chatList.on('click' , '.message-attach-file-source' , function (el) {
            if($(this).find('.md-arrow-back').length)
                $this.download($(this).closest('.message-attach-file') , 'file');
        });

        $this.$chatList.on('click' , '.message-img > img:not(.message-img-loading)' , function (el) {
            window.location.hash = '#'+$this.$chatId+'?show-gallery?data-message-id='+$(this).closest('.chat-message-box').data('message-id')+'&data-file-id='+$(this).data('file-id');
        });

        $this.$chatGallery.on('click' , '.close-show-gallery' , function (el) {
            // window.location.hash = '#'+$this.$chatId;
        });

        $this.$attachPreview.on('click' , '.close-show-attachs' , function (el) {
            // window.location.hash = '#'+$this.$chatId;
        });

        $this.$chatGallery.on('click' , '.download-gallery-img' , function (el) {
            $this.export($this.$chatGallery.find('.img-full-show').attr('src') , $this.$chatGallery.find('.img-full-show').data('name'));
        });

        $this.$chatList.on('click' , '.file-attach-download-to-click' , function (el) {
            $this.export($(this).data('patch') , $(this).find('.message-attach-file-name').text());
        });


        $this.$attachBtn.on('click', function (el) {
            var sec = 0;
            $this.$attachDiv.show().removeClass('hide');
            $this.$attachDiv.children().hide();
            $this.$attachDiv.children().each(function(){
                var thisA = this;
                setTimeout(function(){
                    $(thisA).addClass('fadeIn-zoom').removeClass('fadeOut-zoom');
                    $(thisA).show();
                } , sec);
                sec += 50;
            });
            // $this.$attachDiv.css('display' , 'flex');
            // // alert(1)
        });


        $this.$sendAttachBtn.on('click', function (el) {
                        // alert('ارسال ضمیمه غیر فعال است!'); return false;

            var images=[];
            var attach=[];
            var video=[];
            var i=2
            var fileUploadId=[];
            var messageText = $this.getRealTextHtml($this.$sendAttachText.html() ,true , true);
            var messageTextForSave = $this.getRealTextOfHtml($this.$sendAttachText);
            var imageEl=$('.attach-image-preview img:not(.video-file-thumb)').each(function (index, el) {
                fileUploadId.push(Math.floor(Math.random() * 100000000));
                images.push({
                    sizeFa: '',
                    size: '',
                    id: fileUploadId[index],
                    type: 'image/jpg',
                    srcThumb: this.src.split(',')[1],
                    name : $(this).data('name'),
                    is_source: true,
                    src: this.src
                });

            });

            var videoEl=$('.attach-image-preview .video-file').each(function (index, el) {
                fileUploadId.push(Math.floor(Math.random() * 100000000));
                var data=$(this).data('patch');
                video.push({
                    sizeFa: '',
                    size: data.file.size,
                    id: fileUploadId[index],
                    type: data.file.type,
                    name: data.file.name,
                    is_source: true,
                    patch: data,
                    info : {
                        other : {
                            width : data.info.width,
                            height: data.info.height,
                            duration: data.info.duration,
                        },
                        thumb : data.info.thumb,
                    },
                });
            });

            var fileEl=$('.attach-file-preview').each(function (index, el) {
                fileUploadId.push(Math.floor(Math.random() * 100000000));
                var data=$(this).data('patch');
                attach.push({
                    sizeFa: '',
                    size: data.size,
                    id: fileUploadId[index],
                    type: data.type,
                    name: data.name,
                    is_source: true,
                    patch: data,
                });

            });

            var randId=(Math.floor(Math.random() * 100000000)).toString();

            $this.appendMessage({
                message_id: '',
                temp_id: randId,
                is_me: true,
                is_loading: true,
                avatar_dir: $this.$userInfo.image,
                full_name: $this.$userInfo.name + ' ' + $this.$userInfo.lname,
                lname   : $this.$userInfo.lname,
                message_time_fa: farsiNumber(moment().format("H:mm")),
                message_text: messageText,
                message_date: moment().format("YYYY-MM-DD"),
                file: {
                    image   : images,
                    attach  : attach,
                    video   : video,
                },
                reply: $this.$replyInfo,
                color_theme:$this.$userInfo.colorTheme,
                update: false
            });

            if(attach.length){
                var index=0;
                var isFile = $this.$attachInputType == 'file' ? 1 :( $this.$attachInputType == 'audio' ? 2 : ( $this.$attachInputType == 'video' ? 3 : 4));
                var formData=new FormData();
                formData.append("file", attach[index].patch);
                formData.append("command", 'chat_attach_upload');
                formData.append("content_id", $this.$chatId);
                formData.append("is_file_view",  isFile);
                var fileIds=[];
                $.ajax({
                    xhr: function () {
                        var xhr=new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete=evt.loaded / evt.total;
                                percentComplete=parseInt(percentComplete * 100);

                                $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
                                    .find('.percent-upload')
                                    .html(numbersToPersian(percentComplete) + '%');
                                if (percentComplete == 0)
                                    percentComplete=2;
                                $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
                                    .find('svg circle').css('stroke-dasharray', ((percentComplete / 100) * 100.48).toString() + ' 999');

                                if (percentComplete === 100) {
                                    $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading').remove();
                                }
                            }
                        }, false);

                        return xhr;
                    },
                    url: '/new/backend/web/users/ajax',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    async: true,
                    success: function (value) {
                        if (value) {
                            fileIds.push(value);
                        }
                        else {
                            alert('error');
                            return false;
                        }
                        // $('.message-attach-file-box[data-file-id="' + fileUploadId[index].toString() + '"] message-attach-file-uploading')
                        //     .removeClass('message-img-uploading')
                        //     .prev('.upload-img-div')
                        //     .hide();
                        $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
                            .removeClass('message-img-uploading')
                            .prev('.upload-img-div')
                            .hide();
                        $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"]').attr('data-file-id',value);
                        if(isFile == 2){
                            const player = Array.from(
                                $('.message-attach-file[data-file-id="' + value + '"]')
                                    .addClass('message-attach-audio')
                                    .removeClass('message-attach-file-box')
                                    .html(
                                        '   <audio class="audio-waite-to-proccess" controls preload="metadata" download-url="'+URL.createObjectURL(attach[index].patch)+'">' +
                                        '       <source src="'+URL.createObjectURL(attach[index].patch)+'" type="audio/mpeg">' +
                                        '   </audio>'

                                    ).find('audio')
                            ).map(p => new Plyr(p , {controls: function(e){
                                var controls = [
                                    'play', // Play/pause playback
                                    'progress', // The progress bar and scrubber for playback and buffering
                                    'current-time', // The current time of playback
                                    'captions', // Toggle captions
                                    'pip', // Picture-in-picture (currently Safari only)
                                    'speed', // Picture-in-picture (currently Safari only)
                                    'airplay', // Airplay (currently Safari only)
                                    'volume', // Show a download button with a link to either the current source or a custom URL you specify in your options
                                    'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
                                    'fullscreen', // Toggle fullscreen
                                ];
                                if($(p).hasClass('audio-waite-to-proccess'))
                                    controls.push('volume');
                                return controls;
                            },
                                urls: {
                                    download: $(p).attr('download-url'),
                                },
                            }));

                        }

                        index++;
                        if (!attach[index]) {
                            $this.save(messageTextForSave, fileIds, randId);
                            return false;
                        }
                        var data=this;
                        var formData=new FormData();
                        formData.append("file", attach[index].patch);
                        formData.append("command", 'chat_attach_upload');
                        formData.append("content_id", $this.$chatId);
                        formData.append("is_file_view", isFile);
                        data.data=formData;
                        $.ajax(data);
                    },
                    error: function (a, b, c) {
                        if (b == 'timeout' || a.status == 0) {
                            var $ajax=this;
                            setTimeout(function () {
                                $.ajax($ajax);
                            }, 1000)
                        }
                    }
                });

                $this.$attachPreview.find('.close-show-attachs').trigger('click');
            }

            if(images.length){
                var index=0;
                var formData=new FormData();
                formData.append("file", $this.dataURLtoFile(images[index].src, 'sdfsdf.jpg'));
                formData.append("command", 'chat_attach_upload');
                formData.append("content_id", $this.$chatId);
                var fileIds=[];
                $.ajax({
                    xhr: function () {
                        var xhr=new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete=evt.loaded / evt.total;
                                percentComplete=parseInt(percentComplete * 100);

                                $('img.message-img-uploading[data-file-id="' + fileUploadId[index].toString() + '"]')
                                    .prev('.upload-img-div')
                                    .find('.upload-icon')
                                    .html(numbersToPersian(percentComplete) + '%');
                                if (percentComplete == 0)
                                    percentComplete=2;
                                $('img.message-img-uploading[data-file-id="' + fileUploadId[index].toString() + '"]')
                                    .prev('.upload-img-div').find('svg circle').css('stroke-dasharray', ((percentComplete / 100) * 100.48).toString() + ' 999');

                                if (percentComplete === 100) {
                                    $('img.message-img-uploading[data-file-id="' + fileUploadId[index].toString() + '"]')
                                        .removeClass('message-img-uploading')
                                        .prev('.upload-img-div')
                                        .hide();
                                }
                            }
                        }, false);

                        return xhr;
                    },
                    url: '/new/backend/web/users/ajax',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    async: true,
                    success: function (value) {
                        if (value) {
                            fileIds.push(value);
                        }
                        else {
                            alert('error');
                            return false;
                        }
                        $('img.message-img-uploading[data-file-id="' + fileUploadId[index].toString() + '"]')
                            .removeClass('message-img-uploading')
                            .prev('.upload-img-div')
                            .hide();
                        index++;
                        if (!images[index]) {
                            $this.save(messageTextForSave, fileIds, randId);
                            return false;
                        }
                        var data=this;
                        var formData=new FormData();
                        formData.append("file", $this.dataURLtoFile(images[index].src, 'sdfsdf.jpg'));
                        formData.append("command", 'chat_attach_upload');
                        formData.append("content_id", $this.$chatId);
                        data.data=formData;
                        $.ajax(data);
                    },
                    error: function (a, b, c) {
                        if (b == 'timeout' || a.status == 0) {
                            var $ajax=this;
                            setTimeout(function () {
                                $.ajax($ajax);
                            }, 1000)
                        }
                    }
                });

                $this.$attachPreview.find('.close-show-attachs').trigger('click');
            };

            if(video.length){
                var index=0;
                var formData=new FormData();
                formData.append("file", video[index].patch.file);
                formData.append("thumb", video[index].patch.info.thumbFile);
                formData.append("duration", video[index].patch.info.duration);
                formData.append("height", video[index].patch.info.height);
                formData.append("width", video[index].patch.info.width);
                // formData.append("info", video[index].patch.info);
                formData.append("command", 'chat_attach_upload');
                formData.append("content_id", $this.$chatId);
                formData.append("is_file_view",  3);
                var fileIds=[];
                $.ajax({
                    xhr: function () {
                        var xhr=new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete=evt.loaded / evt.total;
                                percentComplete=parseInt(percentComplete * 100);

                                $('.message-attach-video[data-file-id="' + fileUploadId[index].toString() + '"] .upload-img-div')
                                    .find('.upload-icon')
                                    .html(numbersToPersian(percentComplete) + '%');
                                if (percentComplete == 0)
                                    percentComplete=2;
                                $('.message-attach-video[data-file-id="' + fileUploadId[index].toString() + '"] .upload-img-div')
                                    .find('svg circle').css('stroke-dasharray', ((percentComplete / 100) * 100.48).toString() + ' 999');

                                if (percentComplete === 100) {
                                    $('.message-attach-video[data-file-id="' + fileUploadId[index].toString() + '"] .upload-img-div')
                                        .remove();
                                }
                            }
                        }, false);

                        return xhr;
                    },
                    url: '/new/backend/web/users/ajax',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    async: true,
                    success: function (value) {
                        if (value) {
                            fileIds.push(value);
                        }
                        else {
                            alert('error');
                            return false;
                        }
                        $('.message-attach-video[data-file-id="' + fileUploadId[index].toString() + '"] .upload-img-div')
                            .remove();
                        $('.message-attach-video[data-file-id="' + fileUploadId[index].toString() + '"] .message-video-download').show();
                        $('.message-attach-video[data-file-id="' + fileUploadId[index].toString() + '"] .message-video-play').show();
                        $('.message-attach-video').attr('data-file-src' , URL.createObjectURL(video[index].patch.file));
                        index++;
                        if (!images[index]) {
                            $this.save(messageTextForSave , fileIds, randId);
                            return false;
                        }
                    },
                    error: function (a, b, c) {
                        if (b == 'timeout' || a.status == 0) {
                            var $ajax=this;
                            setTimeout(function () {
                                $.ajax($ajax);
                            }, 1000)
                        }
                    }
                });

                $this.$attachPreview.find('.close-show-attachs').trigger('click');
            };

            $('.div-description-for-attach > div[contenteditable]').html('');
        });


        // $this.$attachDiv.children().on('click', function (el) {
        //     if($(this).hasClass('image-attach')){
        //         $this.$attachInput.data('type','image').attr('accept','image/jpg,image/jpeg,image/png,image/gif,image/tif,image/tiff');
        //     }
        //     else if($(this).hasClass('file-attach')){
        //         $this.$attachInput.data('type','file').attr('accept','pdf,psx,ppt,pptx,docx,xlsx,txt,rar');
        //     }
        //     else if($(this).hasClass('video-attach')){
        //         $this.$attachInput.data('type','video').attr('accept','video/mp4');
        //     }
        //     else if($(this).hasClass('audio-attach')){
        //         $this.$attachInput.data('type','audio').attr('accept','audio/WAV,audio/ogg,audio/mp3');
        //     }
        //     else if($(this).hasClass('content-reference')){
        //         return false;
        //     }
        //     $this.$attachInput.trigger('click');
        // });

        $this.$attachInput.on('change', function (e) {
            $this.$attachInputType = $(this).data('type');
            $this.$attachInputSelected = $(this);
            window.location.hash = '#'+$this.$chatId+'?attach-file';
        });

        $this.$chatInput.on('paste', function (el) {
            var thisEl = this;
            setTimeout(function () {
                $(thisEl).html($this.getRealTextHtml($(thisEl).html(), true , true , true));
            } , 1);
        });

        $this.$sendAttachText.on('paste', function (el) {
            var thisEl = this;
            setTimeout(function () {
                $(thisEl).html($this.getRealTextHtml($(thisEl).html(), true , true , true));
            } , 1);
        });

        // $this.$body.on('hover', function (el) {
        //     if($attachBtn.filter(':selected').length)
        //         $this.$attachDiv.hide();
        // });

        // $this.$body.on('click' , ':not(.attach-file)' , function (el) {
        //     $this.$attachDiv.hide();
        // });

        $(window).resize(function () {
            $this.resize();
        });

        $(document).on('click' , '.channel-footer' , function(){
            const _chatId = $this.$chatId;
            $(this).hide();
            $.ajax({
                url: '/new/backend/web/users/ajax',
                type: 'post',
                data: {
                    command: 'joinChannelOrGroup',
                    chatId: _chatId
                },
                success: function (result) {
                    obj = JSON.parse(result);
                    if(!obj.error){
                    }
                    else{
                        if(_chatId == $this.$chatId)
                            $(this).css('display' , 'flex');
                        $.Notification.notify('error','bottom right','خطا!',obj.error);
                    }
                },
                error: function (a, b, c) {
                    if (b == 'timeout' || a.status == 0) {
                        var $ajax = this;
                        setTimeout(function () {
                            $.ajax($ajax);
                        }, 1000)
                    }
                }
            });
        });
        $(document).on('click' , '.chat-go-back' , function(){
            window.history.back();
        });
        $('.manage-chat-list').on('click' , function(){
            window.location.hash = '#?manage-list';
        });
        $('.close-manage-chat-list').on('click' , function(){
            window.history.back();
        });
        $(window).on('hashchange' , function () {
            var $recorder =  $('.v-r');
            var recorderObject = $recorder.data('recorderObject');
            if(recorderObject){
                recorderObject.stop();
                $recorder.addClass('vr-start').removeClass('vr-stop');
            }


            var hash = location.hash;
            var result = [];
            var data = hash.split('?');
            result['chatId'] = data[0].replace('#','').split('&')[0];
            result['action'] = data[1];
            result['data']   = [];
            $this.$messageIdForShow = 0;
            $('.contact-filter-input input').val('').trigger('change');
            $('#conversation-forward-cancel').trigger('click');
            $this.$attachDiv.children().addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
            if(data[2]){
                var datas = data[2].split('&');
                for(var value of datas){
                    value = value.split('=');
                    result['data'][value[0]] = value[1];
                }
            }
            if($this.urlLevelInfo['data']){
                if(result['data']['add-avatar'] && $this.urlLevelInfo['data']['add-avatar']){
                    window.history.back();
                    // return false;
                }
            }
            else{

            }
            $this.urlLevelInfo = result;
            if($this.$chatId != result['chatId']){
                $this.$chatId = result['chatId'];
                if(result['action'] === 'messageShow' && result['data']['messageId']) {
                    $this.$messageIdForShow = result['data']['messageId'];
                }
                $this.getChat(1);
                if(!$this.$chatId){
                    $('.header-title .chat-message-profile img').attr('src' , '');
                }
            }
            if(result['action'] === 'show-gallery' && result['data']['data-file-id']){
                $this.$imgGalleryId = result['data']['data-file-id'];
                $this.showGallery($('.chat-message-box[data-message-id="'+result['data']['data-message-id']+'"] .message-img > [data-file-id="'+result['data']['data-file-id']+'"]')[0]);
            }
            else if(result['action'] === 'attach-file'){
                if($this.$attachInputSelected)
                    $this.attachFilePreviwe($this.$attachInputSelected[0] , $this.$attachInputType);
            }
            else if(result['action'] === 'manage-list'){
                $('.contact-filter-input input').attr('type' , 'chat');
                //$('.conversation-manage-body .conversation-start-chat').show();
                $('.conversation-manage-list-box').addClass('slide-up').removeClass('slide-down');
            }
            else if(result['action'] === 'chat-setting'){
                $('#chat-setting').addClass('slide-reverse-right').removeClass('slide-reverse-left');
            }
            else if(result['action'] === 'create-conversation'){
                if(result['data']['channel']){
                    $('.create-conversation-title').html('ساخت کانال');
                    $('.submit-ch-g').attr('type' , 'channel');
                }
                else if(result['data']['group']){
                    $('.create-conversation-title').html('ساخت گروه');
                    $('.submit-ch-g').attr('type' , 'group');
                }
                $('.contact-filter-input input').attr('type' , 'ch-g');
                $('.conversation-manage-body .user-add-to-ch-g').show();
                $('.conversation-manage-list-box').addClass('slide-up').removeClass('slide-down');
                $('.conversation-manage-body > .conversation-list-ul').addClass('slide-right').removeClass('slide-left');
                $('.conversation-manage-body > .create-conversation').addClass('slide-reverse-right').removeClass('slide-reverse-left');
                if(result['data']['add-avatar']){
                    //$('#add-chat-avatar-input').trigger('click');
                }
                else if(!result['data']['update-add-avatar']){
                    $('.add-chat-avatar-preview').css('visibility' , 'hidden');
                }
            }
            if(result['data']['update-add-avatar']){
                //$('#update-add-chat-avatar-input').trigger('click');
            }
            else if(!result['data']['add-avatar']){
                $('.add-chat-avatar-preview').css('visibility' , 'hidden');
            }

            if(result['action'] != 'create-conversation'){
                $('.conversation-manage-body > .conversation-list-ul').addClass('slide-left').removeClass('slide-right');
                $('.conversation-manage-body > .create-conversation').addClass('slide-reverse-left').removeClass('slide-reverse-right');
                $('.create-conversation-form input:not([type="checkbox"])').val('');
                // if(!result['data']['update-add-avatar']){
                //     if($('#public_or_private:checked').length){
                //         $('#public_or_private').trigger('click');
                //     }
                // }
                $('.create-conversation-form .add-chat-avatar img').attr('src' , '');
                if(result['action'] != 'manage-list'){
                    $('.conversation-manage-list-box').addClass('slide-down').removeClass('slide-up');
                }
            }
            if(result['action'] != 'attach-file'){
                if($this.$attachPreview.hasClass('in-zoomIn-fade'))
                    $this.$attachPreview.addClass('out-zoomIn-fade').removeClass('in-zoomIn-fade');
                $this.$fileAttachs = null;
                $this.$attachInput.val(null);
            }
            if(result['action'] != 'show-gallery'){
                if($this.$chatGallery.hasClass('in-zoomIn-fade'))
                    $this.$chatGallery.addClass('out-zoomIn-fade').removeClass('in-zoomIn-fade');
            }
            if(result['action'] != 'chat-setting'){
                $('#chat-setting').addClass('slide-reverse-left').removeClass('slide-reverse-right');
            }
        });

    },
        //init ChatApp
        $.ChatApp = new ChatApp, $.ChatApp.Constructor = ChatApp

}(window.jQuery),

//initializing main application module
    function($) {
        "use strict";
        // $(document).ready(function () {
        //     if($('.conversation-chat-box').length) {
                var chat = $.ChatApp;
                chat.getChatList();
                chat.contactSearcherCreate();
                chat.getUserActivity();
                $(document).on('click' , '.conversation-list-box .conversation-list-item' , function (e) {
                    if(!$(e.target).closest('.message-option-menu').length)
                        window.location.hash = '#'+$(this).data('id');
                });
                $(document).on('click' , '.conversation-search-box .conversation-list-item' , function (e) {
                    if(!$(e.target).closest('.message-option-menu').length) {
                        if(parseInt($(this).data('id'))) {
                            var href = '#' + $(this).data('id')
                            if(parseInt($(this).data('message-id'))){
                                href += '?messageShow?messageId=' + $(this).data('message-id');
                            }
                            window.location.hash=href;
                        }
                        else
                            chat.createChat({user_id:[$(this).data('user-id')] ,color_theme:randColor(), chat_type : 'chat'} , 0);
                    }
                });
                $(document).on('click' , '.conversation-list-type-search:not(.active)' , function () {
                    $('.conversation-list-box .conversation-list-ul').attr('data-search-type' , $(this).attr('data-search-type'));
                    $('.conversation-list-type-search').removeClass('active');
                    $(this).addClass('active');
                });
                $(document).on('click' , '.contact-search-item:not(.active)' , function () {
                    // $(this).closest('ul').attr('style' , '');
                    $(this).closest('ul').attr('data-search-type' , $(this).attr('data-search-type'));
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');
                });
                $(document).on('click' , '#create-channel , #create-group' , function () {
                    var hash = '';
                    if($(this).attr('id') == 'create-channel')
                        hash = '?channel=true';
                    if($(this).attr('id') == 'create-group')
                        hash = '?group=true';
                    window.location.hash = '#?create-conversation'+hash;
                });
                $(document).on('click' , '.message-video-download' , function () {
                    var id = $(this).closest('.message-attach-video').attr('data-file-id');
                    var url = $(this).closest('.message-attach-video').attr('data-file-src'); //'/backend/web/users/getfile2?fileId='+id+'&download=true';
                    window.open(
                        url,
                        '_blank' // <- This is what makes it open in a new window.
                    );

                });
                $(document).on('click' , '.attach-image-preview > div img:not(.video-file-thumb)' , function () {
                    var canvas = document.createElement('canvas');
                    // var thisImg = $(this).find('img')[0];
                    var thisImg = this;
                    $("<img/>").attr("src", thisImg.src).load(
                        function () {
                            // canvas.width = this.width;
                            // canvas.height = this.height;
                            // var x = canvas.width / 2;
                            // var y = canvas.height / 2;
                            // var width = this.width;
                            // var height = this.height;
                            // var context = canvas.getContext("2d");
                            // context.translate(x, y);
                            // context.rotate(90 * Math.PI / 180);
                            // context.drawImage(this, -width / 2, -height / 2, width, height);
                            // context.rotate(-90 * Math.PI / 180);
                            // context.translate(-x, -y);

                            var context = canvas.getContext("2d");
                            canvas.width = this.height;
                            canvas.height = this.width;
                            context.rotate(90*Math.PI/180);
                            context.translate(0, -this.height);
                            context.drawImage(this, 0, 0, this.width, this.height);
                            thisImg.src = canvas.toDataURL("image/jpeg");
                        }
                    );

                });
                $(document).on('click' , '.conversation-start-chat' , function () {

                    chat.createChat({user_id:[$(this).data('user-id')] ,color_theme:randColor(), chat_type : 'chat'} , -1);
                });
                $(document).on('click' , '.remove-chat-conversation' , function () {
                    chat.removeChat($(this).closest('.conversation-list-item').data('id'));
                });
                $(document).on('click' , '.remove-member-conversation' , function () {
                    chat.removeAddMember($(this).closest('.conversation-list-item').data('user-id'));
                });
                $(document).on('click' , '.add-admin-conversation' , function () {
                    chat.removeAddAdmin($(this).closest('.conversation-list-item').data('user-id') , 'add');
                });
                $(document).on('click' , '.remove-admin-conversation' , function () {
                    chat.removeAddAdmin($(this).closest('.conversation-list-item').data('user-id'));
                });
                $(document).on('click' , '.add-super-admin-conversation' , function () {
                    chat.removeAddSuperAdmin($(this).closest('.conversation-list-item').data('user-id') , 'add');
                });
                $(document).on('click' , '.remove-super-admin-conversation' , function () {
                    chat.removeAddSuperAdmin($(this).closest('.conversation-list-item').data('user-id'));
                });
                $(document).on('click' , '.create-conversation-form  .add-chat-avatar' , function () {
                    $('#add-chat-avatar-input').trigger('click');
                    // window.location.hash = window.location.hash+'&add-avatar=true';
                });
                $(document).on('click' , '#chat-setting  .add-chat-avatar' , function () {
                    $('#add-chat-avatar-profile').trigger('click');
                });
                $(document).on('click' , '.update-conversation-form  .add-chat-avatar' , function () {
                    $('#update-add-chat-avatar-input').trigger('click');
                    // window.location.hash = chat.$chatId+'?update-form?update-add-avatar=true';
                });
                $(document).on('change' , '#add-chat-avatar-input , #update-add-chat-avatar-input , #add-chat-avatar-profile' , function () {
                    if($(this).attr('id') == 'add-chat-avatar-input'){
                        window.location.hash = window.location.hash+'&add-avatar=true';
                    }
                    else if($(this).attr('id') == 'update-add-chat-avatar-input'){
                        window.location.hash = chat.$chatId+'?update-form?update-add-avatar=true';
                    }
                    else{
                        window.location.hash = window.location.hash+'?add-avatar=true';
                    }
                    $('.add-chat-avatar-preview').css('visibility' , 'visible');
                    var $uploadCrop;
                    var file = this;
                    var thisDiv = $(this).attr('id');
                    if (file.files && file.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#avatar-img-adding').attr('src' ,  e.target.result);
                            if($('.add-chat-avatar-preview').find('.croppie-container').length){
                                var img =  $('#avatar-img-adding').clone();
                                $('.add-chat-avatar-preview').find('.croppie-container').remove();
                                $('.add-chat-avatar-preview').append(img);
                            }
                            $uploadCrop = new Croppie($('#avatar-img-adding')[0] , {
                                viewport: {
                                    width: 300,
                                    height: 300,
                                    type: 'circle'
                                },
                                boundary: { width: 300, height: 300 },
                                enableExif: true,
                                enableOrientation: true
                            });
                        }
                        reader.readAsDataURL(file.files[0]);
                    }
                    $('#upload-chat-avatar').one('click' , function () {
                        $uploadCrop.result({format : 'jpeg' , quality : 0.5 , circle : false}).then(function(file) {
                            if(thisDiv == 'add-chat-avatar-input')
                                $(".create-conversation-form .add-chat-avatar img").attr("src" , file).show();
                            else if(thisDiv == 'update-add-chat-avatar-input')
                                $(".update-conversation-form .add-chat-avatar img").removeClass('old-avatar').attr("src" , file).show();
                            else if(thisDiv == 'add-chat-avatar-profile'){
                                $.ajax({
                                    type : 'post',
                                    url : '/new/backend/web/users/ajax',
                                    data : {
                                        command : 'setImageProfile',
                                        content : file,
                                        isDefualt : 1,
                                    },
                                    success:function (value) {
                                        if(value != 'nok'){
                                            value = JSON.parse(value);
                                            var html = `
                                            <div class="item active" data-id="`+value.id+`">
                                                <div style="position: absolute;top: 5px;right: 50%;transform: translateX(50%);opacity: .7;">
                                                    <a class="avatar-delete btn btn-danger circle-btn content-middle btn-custom"><i class="gl gl-bin"></i></a>
                                                    <a class="avatar-default btn btn-info circle-btn content-middle"><i class="gl gl-ok"></i></a>
                                                </div>
                                                <img style="width: 100%" src="`+value.src+`">
                                            </div>
                                            `;
                                            $("#chat-setting .carousel-inner .active").removeClass('active');
                                            $("#chat-setting .carousel-inner .avatar-default:not(.btn-custom)").addClass('btn-custom');
                                            $("#chat-setting .carousel-inner").prepend(html);
                                        }

                                    }
                                });
                            }
                                // $("#chat-setting .add-chat-avatar img").removeClass('old-avatar').attr("src" , file).show();
                            window.history.back();
                        });
                    });
                    $('.orientation-chat-avatar').on('click' , function () {
                        if($(this).data('deg'))
                            $uploadCrop.rotate($(this).data('deg'));
                        else{
                            var orientation = $(this).data('orientation');
                            $(this).data('orientation' , $(this).data('orientation-reverse'));
                            $(this).data('orientation-reverse' , orientation);
                            $uploadCrop.bind({
                                orientation: orientation
                            });
                        }
                    });
                });
                $(document).on('click' , '.user-add-to-ch-g:not(.disabled) , .user-add-to-forward:not(.disabled)' , function () {
                    $(this).toggleClass('checked');
                });
                $(document).on('click' , '#conversation-profile-add-member' , function () {
                    var clone = $('.create-conversation').clone()
                    clone.attr('style' , '');
                    clone.find('li').css('display' , 'flex');
                    clone.addClass('slide-reverse-right').removeClass('slide-reverse-left');
                    clone.find('.create-conversation-form').remove();
                    clone.find('.create-conversation-title').remove();
                    clone.find('.conversation-list-ul').attr('style' , 'overflow-y:auto; height:100%');
                    clone.append('<a class="btn circle-btn content-middle fadeOut-zoom" id="conversation-profile-add-member-check" style=" position: absolute; bottom: 10px; left: 5px; background-color: var(--btn-color); color:white; padding: 14px"><i class="fa fa-check"></i><i class="fa fa-circle-o-notch fa-spin"></i></a>');
                    clone.append('<a class="btn circle-btn content-middle" id="conversation-profile-add-member-cancel" style=" position: absolute; bottom: 10px; right: 5px; background-color: #ba4840; color:white"><i class="fa fa-remove"></i></a>');
                    var users = [];
                    $('#conversation-profile-detail .conversation-list-item').each(function () {
                        users[$(this).data('user-id')] = true;
                    });
                    clone.find('.conversation-list-ul').data('users' , users);
                    console.log(clone.find('.conversation-list-ul').data('users'));
                    clone.find('.conversation-list-item').attr('style' , '');
                    clone.find('.conversation-list-item').each(function () {
                        if(users[$(this).data('user-id')]){
                            $(this).addClass('disabled').addClass('checked');
                        }
                    });
                    clone.insertAfter('#conversation-profile-info > div');
                    imgWhenLoadShow('.conversation-list-item img');
                });
                $(document).on('change' , '#forward-type-list' , function () {
                    $('#forward-message-contact-selector .user-add-to-forward').remove();
                    if(this.value == 'chatList'){
                        $('#forward-message-contact-selector .select:not(.ftl-select)').hide();
                        let clone = $('.conversation-list-box .conversation-list-ul').clone();
                        clone
                            .find('.chat-info , .message-option-menu , .chat-new-message-has-reply-to-me , .chat-new-message-count , .chat-message-summery > span')
                            .remove();
                        clone
                            .find('.conversation-list-item')
                            .addClass('user-add-to-forward');
                        $('#forward-message-contact-selector .conversation-list-ul').append(
                            clone.html()
                        );
                        $('#forward-message-contact-selector #message-content-search-loader').remove();
                    }
                    else{
                        $('#forward-message-contact-selector .select').show();
                        $('#forward-message-contact-selector .academic-year-id').trigger('click');
                    }
                });
                $(document).on('click' , '.forward-chat-message' , function () {
                    chat.$forwardMessageId = $(this).closest('.chat-message-box').data('message-id');
                    var clone = $('.create-conversation').clone()
                    clone.find('.user-add-to-ch-g').css('display' , 'flex').addClass('user-add-to-forward').removeClass('user-add-to-ch-g');
                    clone.attr('id' , 'forward-message-contact-selector').addClass('slide-down').removeClass('slide-reverse-left');
                    clone.find('.create-conversation-form').remove();
                    clone.find('.create-conversation-title').remove();
                    clone.find('.conversation-list-ul').css('overflow-y' , 'auto').css('height' , '100%').data('li-class' , 'user-add-to-forward');
                    clone.append('<a class="btn circle-btn content-middle fadeOut-zoom" id="conversation-forward-send" style="visibility: hidden"><i class="fa fa-circle-o-notch fa-spin"></i><i class="fa fa-send"></i></a>');
                    clone.append('<a class="btn circle-btn content-middle" id="conversation-forward-cancel"><i class="fa fa-remove"></i></a>');
                    clone.find('.conversation-list-item').attr('style' , '');
                    clone.find('.contact-start').prepend(`
                    <div class="select ftl-select">
                      <label for="forward-type-list">انتخاب از</label>
                      <select
                        id="forward-type-list"
                        class="form-control input-lg"
                        style="border-radius: 0px;border-color: rgba(0,0,0,0.2);padding: 0px; padding-right: 5px;"
                        >
                            <option value="contacts">مخاطبین</option>
                            <option value="chatList">لیست چت</option>
                        </select>  
                    </div>
                    `);

                    clone.insertAfter('.channel-footer');
                    setTimeout(function() {
                            $('#forward-message-contact-selector').addClass('slide-up').removeClass('slide-down')
                        },10
                    )
                    imgWhenLoadShow('.conversation-list-item img');
                });
                $(document).on('click' , '#conversation-profile-edit-info' , function () {
                    var checked = '';
                    var disable = '';
                    if(chat.$messageInfo.is_private == 1){
                        checked = 'checked';
                        disable = 'disabled';
                    }
                    var $form = `
                    <div class="create-conversation slide-reverse-right p-10">
                        <div class="update-conversation-form clearfix">
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="label-mini">نام</label>
                                    <input class="form-control title" value="`+chat.$messageInfo.title+`" contenteditable>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="add-chat-avatar">
                                    <img src="`+chat.$messageInfo.avatar+`" class="old-avatar">
                                    <i class="fa fa-picture-o"></i>
                                </div>
                                <input type="file" id="update-add-chat-avatar-input" class="hide" accept="image/jpg,image/jpeg,image/png,image/gif" contenteditable>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="label-mini">توضیحات</label>
                                    <textarea class="form-control description" contenteditable>`+chat.$messageInfo.summery+`</textarea>
                                </div>
                            </div>
                            <div class="col-xs-4 m-t-10">
                                <div class="form-group">
                                    <input `+checked+` id="public_or_private" type="checkbox" data-size="small" data-plugin="switchery" data-color="#ED5565" data-secondary-color="#1AB394" data-switchery="true">
                                    <label for="public_or_private">عمومی</label>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label class="label-mini">لینک</label>
                                    <input `+disable+` class="form-control" id="conversation-id-input" value="`+chat.$messageInfo.unique_code+`" contenteditable>
                                </div>
                            </div>
                            <a class="btn circle-btn content-middle update-ch-g" id="conversation-profile-add-member-check" style=" position: absolute; bottom: 10px; left: 5px; background-color: var(--btn-color); color:white; padding: 14px">
                                <i class="fa fa-check"></i>
                                <i class="fa fa-circle-o-notch fa-spin" style="font-size: 20px;"></i>
                            </a>
                            <a class="btn circle-btn content-middle" id="conversation-profile-add-member-cancel" style=" position: absolute; bottom: 10px; right: 5px; background-color: #ba4840; color:white"><i class="fa fa-remove"></i></a>
                        </div>
                    </div>
                    `;
                    $('#conversation-profile-info > div').after($form);
                    new Switchery($('#conversation-profile-info #public_or_private')[0], $('#conversation-profile-info #public_or_private').data());
                });
                $(document).on('click' , '.chat-more-info' , function () {
                    $('#conversation-profile-info').toggleClass('slide-reverse-right').toggleClass('slide-reverse-left');
                    $('#conversation-profile-info').find('.create-conversation').remove();

                });
                $('.create-conversation-form .title , .create-conversation-form #conversation-id-input').on('keyup , change , paste'  , function () {
                    chat.checkCreateMessageValidate();
                });
                $(document).on('keyup , change , paste' , '.update-conversation-form .title , .update-conversation-form #conversation-id-input' , function () {
                    chat.checkCreateMessageValidate('.update-conversation-form');
                });
                $(document).on('keyup , change , paste' , '#chat-setting .title , #chat-setting #conversation-id-input , #chat-setting .description' , function () {
                    chat.checkCreateMessageValidate('#chat-setting');
                });
                // $(document).on('click' , '.switchery-small' , function () {
                //     $('#public_or_private')[0].checked = !$('#public_or_private')[0].checked ;
                //     console.log($('#public_or_private'));
                // });
                $(document).on('change' , '#public_or_private' , function () {
                    if($(this).filter(':checked').length){
                        $(this).closest('.clearfix').find('label[for="public_or_private"]').html('خصوصی');
                        $(this).closest('.clearfix').find('#conversation-id-input').data('value' , $(this).closest('.clearfix').find('#conversation-id-input').val());
                        $(this).closest('.clearfix').find('#conversation-id-input').attr('disabled' , 'true').val('');
                    }
                    else{
                        $(this).closest('.clearfix').find('label[for="public_or_private"]').html('عمومی');
                        $(this).closest('.clearfix').find('#conversation-id-input').removeAttr('disabled').val($(this).closest('.clearfix').find('#conversation-id-input').data('value'));
                    }
                });
                $(document).on('click' , '#conversation-profile-info .create-conversation .user-add-to-ch-g' , function () {
                    if($('#conversation-profile-info .create-conversation .user-add-to-ch-g.checked:not(.disabled)').length){
                        $('#conversation-profile-add-member-check').addClass('fadeIn-zoom').removeClass('fadeOut-zoom');
                    }
                    else {
                        $('#conversation-profile-add-member-check').addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
                    }
                });
                $(document).on('click' , '.user-add-to-forward' , function () {
                    if($('.user-add-to-forward.checked:not(.disabled)').length){
                        $('#conversation-forward-send').addClass('fadeIn-zoom').removeClass('fadeOut-zoom');
                    }
                    else {
                        $('#conversation-forward-send').addClass('fadeOut-zoom').removeClass('fadeIn-zoom');
                    }
                    $('#conversation-forward-send').attr('style' , '');
                });
                $(document).on('play' , 'video , audio' , function () {
                    alert();
                    $('video , audio').pause();
                    $(this).play();
                });
                $(document).on('click' , '#conversation-profile-add-member-check:not(.loading)' , function () {
                    var users = [];
                    $('#conversation-profile-info .create-conversation .user-add-to-ch-g.checked:not(.disabled)').each(function () {
                        users.push($(this).data('user-id'));
                    });
                    if(users.length){
                        $(this).addClass('loading');
                        chat.removeAddMember(users , 'add');
                    }
                });
                $(document).on('click' , '.message-attach-video .message-video-play' , function () {
                    var src = $(this).closest('.message-attach-video').attr('data-file-src');
                    var thisIcon = $(this);
                    var thisVideoDiv = $(this).closest('.message-attach-video');
                    var style = thisVideoDiv.find('img').attr('style');
                    $(this).html(`<svg class="fa-spin svg-loader"><circle cy="22" cx="22" r="20" class="circle-loader"></circle></svg>`);
                    thisVideoDiv.find('video').remove();
                    thisVideoDiv.append(`
                        <video class="video-message-chat" autoplay controls style="margin-bottom:-5px; padding:0px !important;display: none; `+style+`" download-url="`+src+`">
                            <source src="`+src+`">
                        </video>
                    `).find('video').one('loadedmetadata' , function () {
                        $(this).show();
                        $(this).prevAll().remove();
                    });
                    thisVideoDiv.find('video').on('abort emptied error' , function () {
                        thisIcon.html('<i class="fa fa-warning"></i>');
                    });
                    thisVideoDiv.find('video').on('play' , function () {
                        $('video , audio').not(this).each(function () {
                            this.pause();
                        })
                    });
                });
                $(document).on('click' , '#conversation-profile-add-member-cancel , #conversation-forward-cancel' , function () {
                    chat.$forwardMessageId = 0;
                    $('#conversation-profile-info .create-conversation').remove();
                    $('#forward-message-contact-selector').addClass('slide-down').removeClass('slide-up');

                    setTimeout(function() {
                            $('#forward-message-contact-selector').remove();
                        },500
                    )
                });
                $(document).on('click' , '#conversation-forward-send:not(.loading)' , function () {
                    $(this).addClass('loading');
                    var contact = $('#forward-message-contact-selector .user-add-to-forward.checked');
                    var users = [];
                    if(contact.length){
                        contact.each(function () {
                            users.push({
                                'id': $(this).data('id') ? $(this).data('id') : $(this).attr('data-user-id'),
                                'type': $(this).data('id') ? 'chat' : 'user',
                            });
                        });
                        $.ajax({
                            url : '/new/backend/web/users/ajax',
                            type : 'post',
                            data: {
                                command : 'forwardMessageSend',
                                data : users,
                                messageId : chat.$forwardMessageId,
                            },
                            success : function (value) {
                                if(value == 'OK'){
                                    $('#conversation-forward-cancel').trigger('click');
                                }
                                else{
                                    $('#conversation-forward-send').removeClass('loading');
                                    $.Notification.notify('error','bottom right','خطا!','ارسال نشد!');
                                }
                            },
                            error:function(a,b,c){
                                if(b == 'timeout' || a.status == 0){
                                    var $ajax = this;
                                    setTimeout(function(){
                                        $.ajax($ajax);
                                    }, 1000)
                                }
                                else{
                                    $.Notification.notify('error','bottom right','خطا!','ارسال نشد!');
                                    $('#conversation-forward-send').removeClass('loading');
                                }
                            }
                        });
                        // $('#conversation-forward-cancel').trigger('click');
                        // $.Notification.notify('error','bottom right','خطا!','این بخش در حال بروزرسانی می‌باشد!');
                    }
                });
                $('body').on('click' , '#conversation-forbidden-comment' , function () {
                    swal({
                        title: 'آیا مطمئن هستید؟',
                        text: $(this).hasClass('btn-danger') ? "در صورت بستن ارسال پیام تنها ادمین های گروه قادر به ارسال پیام می باشند!" : "در صورت باز کردن ارسال پیام تمامی اعضا قادر به ارسال پیام در گروه می باشند!",
                        icon: "warning",
                        buttons: {'cancel':'خیر','confirm':{text:'بله',className:'btn-danger'}},
                    })
                        .then((confirm) => {
                        if (confirm) {
                            $.ajax({
                                url : '/new/backend/web/users/ajax',
                                type : 'post',
                                data: {
                                    command : 'changeCommentType',
                                    chatId : chat.$chatId,
                                },
                                success : function (value) {
                                    if(value){
                                        if(value == 3){
                                            $('#conversation-forbidden-comment').html('ارسال پیام <b class="red">بسته </b> است! برای باز کردن اینجا کلیک نمایید.').addClass('btn-success').removeClass('btn-danger');
                                        }
                                        else{
                                            $('#conversation-forbidden-comment').html('بستن ارسال پیام').addClass('btn-danger').removeClass('btn-success');
                                        }
                                        // $this.$chatDiv.find('.header-title b').html(value.title);
                                    }
                                    else{
                                        $.Notification.notify('error','bottom right','خطا!');
                                    }
                                },
                                error:function(a,b,c) {
                                    setTimeout(function () {
                                        $.ajax($ajax);
                                    }, 1000)
                                }
                            });
                        }
                    });

                });
                $(document).on('click' , '.next-image , .prev-image' , function () {
                    var el;
                    var el1 = chat.$chatDiv.find('.conversation-text .message-gallery [data-file-id='+chat.$chatGallery.find('img.img-full-show').attr('data-file-id')+']').parent();
                    if($(this).hasClass('next-image')){
                        el = el1.next('.message-img');
                        if(!el.length){
                            el = el1.next();
                            if(el.find('.message-img').length){
                                el = el.find('.message-img').first();
                            }
                            else{
                                el = el1.parent().next('.message-img');
                                if(!el.length){
                                    el = el1.next();
                                    if(el.find('.message-img').length){
                                        el = el.find('.message-img').first();
                                    }
                                    else
                                        el = el1.prevAll().last();
                                }
                            }
                        }
                    }
                    if($(this).hasClass('prev-image')){
                        el = el1.prev('.message-img');
                        if(!el.length){
                            el = el1.prev();
                            if(el.find('.message-img').length){
                                el = el.find('.message-img').last();
                            }
                            else{
                                el = el1.parent().prev('.message-img');
                                if(!el.length){
                                    el = el1.prev();
                                    if(el.find('.message-img').length){
                                        el = el.find('.message-img').last();
                                    }
                                    else
                                        el = el1.nextAll().last();
                                }
                            }
                        }
                    }
                    if(el.length){
                        chat.showGallery(el.find('img')[0]);
                        if(el.find('.message-img-loading').length){
                            el.find('.download-icon').trigger('click');
                        }
                    }
                });
                $(document).on('click' , '.submit-ch-g:not(.loading):not(.chat-setting-submit) , .update-ch-g:not(.loading)' , function () {
                    var $form;
                    var $randColor;
                    var $chatId;
                    if($(this).hasClass('submit-ch-g')){
                        $form       = $('.create-conversation-form');
                        $randColor  = randColor();
                    }
                    else{
                        $form = $('.update-conversation-form');
                        $chatId = chat.$chatId;
                    }
                    if($form.find('.title').val().trim()){
                        var users = [];
                        $(this).addClass('loading');
                        $('.create-conversation .user-add-to-ch-g.checked').each(function () {
                            users.push($(this).data('user-id'));
                        });
                        chat.createChat({
                            user_id     :  users ,
                            chat_id     :  $chatId,
                            chat_type   :  $(this).attr('type') ,
                            title       :  $form.find('.title').val().trim() ,
                            summery     :  $form.find('.description').val().trim() ,
                            is_private  :  $form.find('#public_or_private').filter(':checked').length ? 1 : 0 ,
                            unique_code :  $form.find('#conversation-id-input').val(),
                            avatar      :  $form.find('.add-chat-avatar img').not('.old-avatar').attr('src'),
                            color_theme :  $randColor
                        } , -2);
                        if(!$chatId)
                            $('.create-conversation .user-add-to-ch-g.checked').removeClass('checked');
                    }
                });
                $(document).on('click' , '.chat-setting-submit:not(.loading)' , function () {
                    $(this).addClass('loading');
                    var thisBtn = this;
                    var $form = $(this).closest('#chat-setting');
                    $.ajax({
                        type:'post',
                        url:'/new/backend/web/users/ajax',
                        data:{
                            command        :   'setChatSetting',
                            aliasName :   $form.find('.title').val().trim(),
                            description :   $form.find('.description').val().trim(),
                            userName    :   $form.find('#conversation-id-input').val().trim(),
                        },
                        success:function(value){
                            if(value == 'OK'){
                                $.Notification.notify('success','bottom right','ثبت شد');
                            }
                            else{
                                value = JSON.parse(value);
                                for(var a in value){
                                    for(var b of value[a]){
                                        $.Notification.notify('error','bottom right','خطا!' , b);
                                    }
                                }
                            }
                        },
                        complete:function () {
                            $(thisBtn).removeClass('loading');
                        }
                    });
                });
                $('.contact-filter-input input').on('keyup , change' , function(){
                    var filter = this.value.trim();
                    if($(this).attr('type') == 'chat'){
                        $('.conversation-manage-body .conversation-start-chat').each(function () {
                            if($(this).text().search(filter) == -1)
                                $(this).addClass('hide');
                            else
                                $(this).removeClass('hide');
                        });
                    }
                    else if($(this).attr('type') == 'ch-g'){
                        $('.conversation-manage-body .user-add-to-ch-g').each(function () {
                            if($(this).text().search(filter) == -1)
                                $(this).addClass('hide');
                            else
                                $(this).removeClass('hide');
                        });
                    }
                });
                $('#chat-exit').click(function () {
                    swal({
                        title: 'آیا مطمئن هستید؟',
                        text: "آیا برای خروج از پیام‌رسان اطمینان دارید؟",
                        icon: "warning",
                        buttons: {'cancel':'خیر','confirm':{text:'بله',className:'btn-danger'}},
                    })
                        .then((confirm) => {
                        if (confirm) {
                            window.location.href = '/new/backend/web/users/dashboard';
                        }
                    });
                });
                $('#message-content-search').on('keyup' , function () {
                    chat.messageSearch($(this).val().trim());
                });
                $('#message-content-search-result').on('scroll' , function () {
                    if($('#message-content-search-result .conversation-list-ul li').length < 20)
                        return false;
                    var scrollTop  = $('#message-content-search-result')[0].scrollTop;
                    var height     = $('#message-content-search-result .conversation-list-ul').innerHeight();
                    var scrollHeight     = $('#message-content-search-result').innerHeight();
                    if(scrollTop+scrollHeight >= height){
                        if($('#message-content-search-result .conversation-list-ul').data('offset') != 'ended'){
                            chat.messageSearch($('#message-content-search-result .conversation-list-ul').data('text') , 0 , $('#message-content-search-result .conversation-list-ul').data('offset'));
                        }
                    }
                });
                $('#search-box-show').on('click' , function () {
                    $('.chat-search-box').show();
                });
                $('#search-box-cancel').on('click' , function () {
                    $('.chat-search-box').hide();
                });
                $('#chat-option-btn').on('click' , function () {
                    $('#chat-option-menu').slideDown('fast');
                });





    var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
    var recorder;
    var recorderOptions;
    var questionVoiceRecorded;
    var questionId;
    var mediaObject;
    var mediaType;
    var mediaAlias;
    var timeRecordLimit;
    var isRecorderPause;
    var intervalTimeLimit , timeRecord , messageTitle;
    $.getScript(['/new/backend/web/nadiya_assets/plugins/RecordRTC/RecordRTC.js'], function()
    {
        recorderOptions = {
            numberOfAudioChannels: isEdge ? 1 : 2,
            checkForInactiveTracks: true,
            bufferSize: 16384,
            audioBitsPerSecond: 32000,
            videoBitsPerSecond: 500000,
            ondataavailable: function(blob) {
                $('#answer-voice-recorder-stop').trigger('click');
            }
        };

        if(isSafari || isEdge) {
            recorderOptions.recorderType = StereoAudioRecorder;
        }

        if(navigator.platform && navigator.platform.toString().toLowerCase().indexOf('win') === -1) {
            recorderOptions.sampleRate = 48000; // or 44100 or remove this line for default
        }

        // if(isSafari) {
        //     recorderOptions.sampleRate = 44100;
        //     recorderOptions.bufferSize = 4096;
        //     recorderOptions.numberOfAudioChannels = 2;
        // }


                $('#vr-btn').on('click', function (ev) {
            // alert('ارسال ضمیمه غیر فعال است!'); return false;
            $('.cancel-edit-message').trigger('click');
            var $this = $(this);
            if($this.hasClass('vr-start')){
                var audio_context;
                    mediaType = 'audio';

                    recorderOptions.type = mediaType;
                    if(mediaType == 'audio'){
                        timeRecordLimit = 600;
                        mediaObject = {audio: true};
                    }

                  questionVoiceRecorded = null;
                  timeRecord = 1;
                  isRecorderPause = false;
                  navigator.mediaDevices.getUserMedia(mediaObject).then(function(stream) {
                      $this.addClass('vr-stop').removeClass('vr-start');
                    if(recorder) {
                        recorder.destroy();
                        recorder = null;
                    }
                    recorder = RecordRTC(stream, recorderOptions);
                    intervalTimeLimit = setInterval(function() {
                        if(!isRecorderPause){
                              if(timeRecord < timeRecordLimit){
                                  timeRecord++;
                              }
                              else{
                                  $('#vr-btn').trigger('click');
                                  clearInterval(intervalTimeLimit);
                              }
                        }
                    },1000)
                    recorder.startRecording();
                }).catch(function(error) {
                    console.log(error)
                    $(this).toggleClass('record').toggleClass('stop');
                        var span = document.createElement("span");
                        if(mediaType == 'audio'){
                            messageTitle = 'میکروفون';
                        }
                        else if(mediaType == 'video'){
                            messageTitle = 'دوربین';
                        }
                        span.innerHTML = 'لطفا روی علامت <i class="fa fa-lock"></i> که در بالای صفحه در کنار آدرس سایت قرار دارد، کلیک نموده و اجازه دسترسی به '+messageTitle+' را بدهید.</p>';
                        swal({
                                icon : 'error',
                                title: 'خطای دسترسی به '+messageTitle+'!',
                                content : span,
                                buttons: {'confirm':{text:'متوجه شدم',className:'btn-warning'}},
                        });
                });




            }
            else{


            clearInterval(intervalTimeLimit);
          recorder.stopRecording(function() {
                questionVoiceRecorded = this.getBlob();
                                $this.addClass('vr-start').removeClass('vr-stop');
                swal({
                    title: 'آیا مطمئن هستید؟',
                    text: "آیا از ارسال این صوت اطمینان دارید؟",
                    icon: "warning",
                    buttons: {'cancel':'خیر','confirm':{text:'بله',className:'btn-success'}},
                }).then((confirm) => {
                    if(!confirm)
                        return false;
                        var file = new File([questionVoiceRecorded], 'voice-recording.ogg', {type:'audio/ogg'});

                        var images=[];
                        var attach=[];
                        var video=[];
                        var i=2
                        var fileUploadId=[];
                        var index=0;
                        var randId=(Math.floor(Math.random() * 100000000)).toString();


                        fileUploadId.push(Math.floor(Math.random() * 100000000));
                        attach.push({
                            sizeFa: '',
                            size: file.size,
                            id: fileUploadId[index],
                            type: file.type,
                            name: randId+'.ogg',
                            is_source: true,
                            patch: file,
                        });



                        chat.appendMessage({
                            message_id: '',
                            temp_id: randId,
                            is_me: true,
                            is_loading: true,
                            avatar_dir: chat.$userInfo.image,
                            full_name: chat.$userInfo.name + ' ' + chat.$userInfo.lname,
                            lname   : chat.$userInfo.lname,
                            message_time_fa: farsiNumber(moment().format("H:mm")),
                            message_text: '',
                            message_date: moment().format("YYYY-MM-DD"),
                            file: {
                                attach  : attach,
                            },
                            reply: chat.$replyInfo,
                            color_theme:chat.$userInfo.colorTheme,
                            update: false
                        });

                        if(attach.length){
                            var formData=new FormData();
                            formData.append("file", file);
                            formData.append("command", 'chat_attach_upload');
                            formData.append("content_id", chat.$chatId);
                            formData.append("is_file_view",  2);
                            var fileIds=[];
                            $.ajax({
                                xhr: function () {
                                    var xhr=new window.XMLHttpRequest();

                                    xhr.upload.addEventListener("progress", function (evt) {
                                        if (evt.lengthComputable) {
                                            var percentComplete=evt.loaded / evt.total;
                                            percentComplete=parseInt(percentComplete * 100);

                                            $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
                                                .find('.percent-upload')
                                                .html(numbersToPersian(percentComplete) + '%');
                                            if (percentComplete == 0)
                                                percentComplete=2;
                                            $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
                                                .find('svg circle').css('stroke-dasharray', ((percentComplete / 100) * 100.48).toString() + ' 999');

                                            if (percentComplete === 100) {
                                                $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading').remove();
                                            }
                                        }
                                    }, false);

                                    return xhr;
                                },
                                url: '/new/backend/web/users/ajax',
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                async: true,
                                success: function (value) {
                                    if (value) {
                                        fileIds.push(value);
                                    }
                                    else {
                                        alert('error');
                                        return false;
                                    }
                                    // $('.message-attach-file-box[data-file-id="' + fileUploadId[index].toString() + '"] message-attach-file-uploading')
                                    //     .removeClass('message-img-uploading')
                                    //     .prev('.upload-img-div')
                                    //     .hide();
                                    $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
                                        .removeClass('message-img-uploading')
                                        .prev('.upload-img-div')
                                        .hide();
                                    $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"]').attr('data-file-id',value);
                                    const player = Array.from(
                                        $('.message-attach-file[data-file-id="' + value + '"]')
                                            .addClass('message-attach-audio')
                                            .removeClass('message-attach-file-box')
                                            .html(
                                                '   <audio class="audio-waite-to-proccess" controls preload="metadata" download-url="'+URL.createObjectURL(file)+'">' +
                                                '       <source src="'+URL.createObjectURL(file)+'" type="audio/mpeg">' +
                                                '   </audio>'

                                            ).find('audio')
                                    ).map(p => new Plyr(p , {controls: function(e){
                                            var controls = [
                                                'play', // Play/pause playback
                                                'progress', // The progress bar and scrubber for playback and buffering
                                                'current-time', // The current time of playback
                                                'captions', // Toggle captions
                                                'pip', // Picture-in-picture (currently Safari only)
                                                'airplay', // Airplay (currently Safari only)
                                                'speed', // Picture-in-picture (currently Safari only)
                                                'volume', // Show a download button with a link to either the current source or a custom URL you specify in your options
                                                'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
                                                'fullscreen', // Toggle fullscreen
                                            ];
                                            if($(p).hasClass('audio-waite-to-proccess'))
                                                controls.push('volume');
                                            return controls;
                                        },
                                        urls: {
                                            download: $(p).attr('download-url'),
                                        },
                                    }));
                                    chat.save('', fileIds, randId);
                                },
                                error: function (a, b, c) {
                                    if (b == 'timeout' || a.status == 0) {
                                        var $ajax=this;
                                        setTimeout(function () {
                                            $.ajax($ajax);
                                        }, 1000)
                                    }
                                }
                            });
                        }
                });

            });




        //     }
         }







    });

});



        //binding send button click
        // $('#vr-btn').on('click', function (ev) {
        //     // alert('ارسال ضمیمه غیر فعال است!'); return false;
        //     $('.cancel-edit-message').trigger('click');
        //     var $this = $(this);
        //     if($this.hasClass('vr-start')){
        //         var audio_context;
        //         try {
        //             window.AudioContext = window.AudioContext || window.webkitAudioContext;
        //             navigator.getUserMedia = ( navigator.getUserMedia ||
        //                 navigator.webkitGetUserMedia ||
        //                 navigator.mozGetUserMedia ||
        //                 navigator.msGetUserMedia);
        //             window.URL = window.URL || window.webkitURL;

        //             var audio_context = new AudioContext;

        //             var $recorder = $this;
        //             $(this).addClass('vr-stop').removeClass('vr-start');
        //             navigator.getUserMedia({audio: true}, function(stream) {
        //                 console.log(audioRecorder);
        //                 audioRecorder.requestDevice(function(recorderObject){
        //                     $recorder.data('recorderObject', recorderObject);
        //                     recorderObject.record();
        //                 }, {recordAsOGG: false});

        //                 // var recorderObject = new MP3Recorder(audio_context, stream, { statusContainer: $recorder.find('.status'), statusMethod: 'replace' });
        //                 // var recorderObject = new MP3Recorder(audio_context, stream, { statusContainer: $recorder.find('.status'), statusMethod: 'replace' });
        //             }, function(e) {
        //                 $this.addClass('vr-start').removeClass('vr-stop');
        //                 var span = document.createElement("span");
        //                 span.innerHTML = 'لطفا روی علامت <i class="fa fa-lock"></i> که در بالای صفحه در کنار آدرس سایت قرار دارد، کلیک نموده و اجازه دسترسی به میکروفون را بدهید.</p>';
        //                 swal({
        //                         icon : 'error',
        //                         title: 'خطای دسترسی به میکروفون!',
        //                         content : span,
        //                         buttons: {'confirm':{text:'متوجه شدم',className:'btn-warning'}},
        //                 });
        //             });
        //         } catch (e) {
        //             swal({
        //                 icon : 'error',
        //                 title: 'خطا!',
        //                 content : 'مرورگر شما از این قابلیت پشتیبانی نمی کند!',
        //                 buttons: {'confirm':{text:'متوجه شدم',className:'btn-warning'}},
        //             });
        //         }
        //     }
        //     else{
        //         var $recorder =  $this;
        //         var recorderObject = $recorder.data('recorderObject');
        //         recorderObject.stop();
        //         $(this).addClass('vr-start').removeClass('vr-stop');
        //         swal({
        //             title: 'آیا مطمئن هستید؟',
        //             text: "آیا از ارسال این صوت اطمینان دارید؟",
        //             icon: "warning",
        //             buttons: {'cancel':'خیر','confirm':{text:'بله',className:'btn-success'}},
        //         }).then((confirm) => {
        //             if(!confirm)
        //                 return false;
        //             recorderObject.exportMP3(function(blob) {
        //                 console.log(blob);
        //                 var file = new File([blob], 'voice-recording.mp3', {type:'audio/mp3'});

        //                 var images=[];
        //                 var attach=[];
        //                 var video=[];
        //                 var i=2
        //                 var fileUploadId=[];
        //                 var index=0;
        //                 var randId=(Math.floor(Math.random() * 100000000)).toString();


        //                 fileUploadId.push(Math.floor(Math.random() * 100000000));
        //                 attach.push({
        //                     sizeFa: '',
        //                     size: file.size,
        //                     id: fileUploadId[index],
        //                     type: file.type,
        //                     name: randId+'.mp3',
        //                     is_source: true,
        //                     patch: file,
        //                 });



        //                 chat.appendMessage({
        //                     message_id: '',
        //                     temp_id: randId,
        //                     is_me: true,
        //                     is_loading: true,
        //                     avatar_dir: chat.$userInfo.image,
        //                     full_name: chat.$userInfo.name + ' ' + chat.$userInfo.lname,
        //                     lname   : chat.$userInfo.lname,
        //                     message_time_fa: farsiNumber(moment().format("H:mm")),
        //                     message_text: '',
        //                     message_date: moment().format("YYYY-MM-DD"),
        //                     file: {
        //                         attach  : attach,
        //                     },
        //                     reply: chat.$replyInfo,
        //                     update: false
        //                 });

        //                 if(attach.length){
        //                     var formData=new FormData();
        //                     formData.append("file", file);
        //                     formData.append("command", 'chat_attach_upload');
        //                     formData.append("content_id", chat.$chatId);
        //                     formData.append("is_file_view",  2);
        //                     var fileIds=[];
        //                     $.ajax({
        //                         xhr: function () {
        //                             var xhr=new window.XMLHttpRequest();

        //                             xhr.upload.addEventListener("progress", function (evt) {
        //                                 if (evt.lengthComputable) {
        //                                     var percentComplete=evt.loaded / evt.total;
        //                                     percentComplete=parseInt(percentComplete * 100);

        //                                     $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
        //                                         .find('.percent-upload')
        //                                         .html(numbersToPersian(percentComplete) + '%');
        //                                     if (percentComplete == 0)
        //                                         percentComplete=2;
        //                                     $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
        //                                         .find('svg circle').css('stroke-dasharray', ((percentComplete / 100) * 100.48).toString() + ' 999');

        //                                     if (percentComplete === 100) {
        //                                         $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading').remove();
        //                                     }
        //                                 }
        //                             }, false);

        //                             return xhr;
        //                         },
        //                         url: '/new/backend/web/users/ajax',
        //                         type: "POST",
        //                         data: formData,
        //                         processData: false,
        //                         contentType: false,
        //                         async: true,
        //                         success: function (value) {
        //                             if (value) {
        //                                 fileIds.push(value);
        //                             }
        //                             else {
        //                                 alert('error');
        //                                 return false;
        //                             }
        //                             // $('.message-attach-file-box[data-file-id="' + fileUploadId[index].toString() + '"] message-attach-file-uploading')
        //                             //     .removeClass('message-img-uploading')
        //                             //     .prev('.upload-img-div')
        //                             //     .hide();
        //                             $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"] .message-attach-file-uploading')
        //                                 .removeClass('message-img-uploading')
        //                                 .prev('.upload-img-div')
        //                                 .hide();
        //                             $('.message-attach-file[data-file-id="' + fileUploadId[index].toString() + '"]').attr('data-file-id',value);
        //                             const player = Array.from(
        //                                 $('.message-attach-file[data-file-id="' + value + '"]')
        //                                     .addClass('message-attach-audio')
        //                                     .removeClass('message-attach-file-box')
        //                                     .html(
        //                                         '   <audio class="audio-waite-to-proccess" controls preload="metadata" download-url="'+URL.createObjectURL(file)+'">' +
        //                                         '       <source src="'+URL.createObjectURL(file)+'" type="audio/mpeg">' +
        //                                         '   </audio>'

        //                                     ).find('audio')
        //                             ).map(p => new Plyr(p , {controls: function(e){
        //                                     var controls = [
        //                                         'play', // Play/pause playback
        //                                         'progress', // The progress bar and scrubber for playback and buffering
        //                                         'current-time', // The current time of playback
        //                                         'captions', // Toggle captions
        //                                         'pip', // Picture-in-picture (currently Safari only)
        //                                         'airplay', // Airplay (currently Safari only)
        //                                         'volume', // Show a download button with a link to either the current source or a custom URL you specify in your options
        //                                         'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
        //                                         'fullscreen', // Toggle fullscreen
        //                                     ];
        //                                     if($(p).hasClass('audio-waite-to-proccess'))
        //                                         controls.push('volume');
        //                                     return controls;
        //                                 },
        //                                 urls: {
        //                                     download: $(p).attr('download-url'),
        //                                 },
        //                             }));
        //                             chat.save('', fileIds, randId);
        //                         },
        //                         error: function (a, b, c) {
        //                             if (b == 'timeout' || a.status == 0) {
        //                                 var $ajax=this;
        //                                 setTimeout(function () {
        //                                     $.ajax($ajax);
        //                                 }, 1000)
        //                             }
        //                         }
        //                     });
        //                 }
        //             });
        //         });
        //     }
        // });

        if(isAndroid && isFirefox){
            // var span = document.createElement("span");
            // span.innerHTML = "<div>جهت استفاده از تمامی امکانات پیام‌رسان لطفا از مرورگر <b>گوگل کروم</b> استفاده نمایید!</div><br><a class='btn btn-info btn-lg btn-block' target='_blank' href='market://details?id=com.android.chrome&hl=en'>دانلود گوگل کروم</a>";
            // swal({
            //     title: 'هشدار',
            //     content: span,
            //     icon: "warning",
            //     buttons: {confirm:{text:'متوجه شدم',className:'btn-warning'}},
            // });
        }
        $(document).on('click' , '#show-chat-setting' , function (el) {
            window.location.hash = '#?chat-setting';
        });

        $(document).on('click' , '.avatar-delete' , function (el) {
            var thisBtn = this;
            $.ajax({
                type : 'post',
                url : '/new/backend/web/users/ajax',
                data : {
                    command : 'deleteImage',
                    id : $(this).closest('.item').data('id'),
                },
                success:function (value) {
                    if(value == 'ok'){
                        var div = $(thisBtn).closest('.carousel-inner');
                        $(thisBtn).closest('.item').remove();
                        div.find('.item').eq(0).addClass('active');
                    }

                }
            });
        });

        $(document).on('click' , '.avatar-default' , function (el) {
            var thisBtn = this;
            $.ajax({
                type : 'post',
                url : '/new/backend/web/users/ajax',
                data : {
                    command : 'setDefault',
                    id : $(this).closest('.item').data('id'),
                },
                success:function (value) {
                    if(value == 'ok'){
                        $(thisBtn).closest('.carousel-inner').find('.avatar-default').addClass('btn-custom');
                        $(thisBtn).removeClass('btn-custom');
                    }

                }
            });
        });


        chat.init();
            // }
            imgWhenLoadShow('.chat-message-profile img');

        // });
    }(window.jQuery);

function imgWhenLoadShow(selected) {
    $(selected).not('.image-loaded').on('load' , function () {
        if(this.src){
            $(this).show();
            $(this).addClass('image-loaded').off('load');
            $('[src="'+$(this).attr('src')+'"]').show();
        }
    }).each(function() {
        if(this.complete && this.src) $(this).not('[src=""]').trigger('load');
    })
}

