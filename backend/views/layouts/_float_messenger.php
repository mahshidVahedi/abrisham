<?php
use backend\models\Comment;
?>
<style>
    #float-messenger #chat-exit{
        display: none;
    }
    #float-messenger{
        z-index:10;
        position: fixed;
        height: calc(100% - 60px);
        margin-top: 60px;
        max-width: 400px;
        width: calc(100vw - 50px);
        left: 0;
        transform: translateX(calc(-100% - 15px));
        transition: all 0.5s;
        box-shadow: 1px 0px 10px 1px #797979;
        animation: 3s firstShow;
        background: #19b5ce;
        top: 0;
    }
    @keyframes firstShow {
        0% {transform: translateX(-100%);}
        80% {transform: translateX(-100%);}
    }
    #float-messenger:hover, #float-messenger.receive-new-message:not(.show){
        transform: translateX(-100%);
    }
    #float-messenger.show{
        transform: translateX(0);
    }
    .show #toggle-messenger span{
        transform: rotate(-180deg);
    }
    #toggle-messenger span{
        transition: all .5s;
        animation: 3s firstShowIcon;
    }
    @keyframes firstShowIcon {
        0% {transform: rotate(-30deg);}
        80% {transform: rotate(-30deg);}
    }
    #toggle-messenger{
        width: 35px;
        height: 70px;
        position: absolute;
        top: calc(50% - 30px);
        right: 0;
        transform: translate(100% , -50%);
        text-align: right;
        background: #19b5ce;
        color: white;
        padding-top: 24px;
        font-size: 21px;
        filter: opacity(0.4);
        margin: 0;
        padding-right: 10px;
        cursor: pointer;
        transition: all 1s;
        box-shadow: 1px 0px 10px 1px #797979;
        border-radius: 35px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        animation: 3s firstShowBtn;
    }
    @keyframes firstShowBtn {
        0% {filter: opacity(1)}
        80% {filter: opacity(1)}
    }

    #toggle-messenger:hover , .receive-new-message #toggle-messenger , .show #toggle-messenger{
        transition: all 0.3s;
        filter: opacity(1);
    }
    #toggle-messenger:hover span , .receive-new-message #toggle-messenger span{
        transform: rotate(-30deg);
    }
    .show #toggle-messenger:hover span , .show.receive-new-message #toggle-messenger span{
        transform: rotate(-150deg);
    }
    #toggle-messenger label{
        font-size: 12px;
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(25%,-25%);
        border-radius: 50%
    }
    #float-messenger iframe{
        border: solid 0px;
        height: 100%;
        width: 100%;
        z-index: 1;
        position: absolute;
    }
    #frame-messenger{
        animation: 2s fadeShow;
        background: #19b5ce;
    }
    @keyframes fadeShow {
        0% {filter: opacity(0)}
        100% {filter: opacity(1)}
    }

</style>
<script>
    function floatMessenger(){
        document.domain = window.location.host.split('new.').join('').trim();
        var floatMessenger = $('#float-messenger');
        if(!floatMessenger.find('iframe').length){
            floatMessenger.children().append('<iframe allow="microphone; camera" id="frame-messenger" src="/new/backend/web/users/chat"></iframe>');
        }
        $('#frame-messenger').load(function(){
            var iframe = this;
            $(this).contents().find('#chat-exit').remove();
            var messengerInterval = setInterval(function () {
                var iframeDocument = iframe.contentWindow.document;
                if(!iframeDocument.chatCodeTab){
                    $('#float-messenger').removeClass('show');
                    $('#frame-messenger').remove();
                    clearInterval(messengerInterval);
                }
                if(document.totalCount != iframeDocument.totalCount){
                    $('#toggle-messenger label').remove();
                    if(iframeDocument.totalCount){
                        $('#toggle-messenger').prepend('<label class="label label-danger">'+farsiNumber(iframeDocument.totalCount)+'</label>');
                        if(document.totalCount < iframeDocument.totalCount){
                            $('#float-messenger').addClass('receive-new-message');
                            setTimeout(function (){
                                $('#float-messenger').removeClass('receive-new-message');
                            },1000);
                        }
                        document.totalCount = iframeDocument.totalCount;
                    }
                }
                return true;
            },500)
        });
        setTimeout(function (){
            $('#float-messenger').toggleClass('show');
        },100)
    }

</script>
<?php
$newMessages = Comment::getNewMessage();
?>
<div id="float-messenger" style="">
    <div style="position: relative; width: 100%; height: 100%;">
        <div style="top: 0px; right: 0px; position: fixed; width: 100%; height: 100%; background: linear-gradient(45deg, rgba(34,21,74,1) 0%, var(--start-background-1-color) 57%, var(--start-background-2-color) 100%); font-size: 50px; color: white; display: none;" class="content-middle text-center">
            <div style="background-image: url(<?=  yii::getAlias('@yii2Url') ?>'/backend/web/nadiya_assets/images/chat-background.png'); width: 100%;height: 100%;position: fixed;opacity: 0.1;"></div>
        </div>
        <div id="toggle-messenger" onclick="floatMessenger()">
            <?= !empty($newMessages['count']) ? '<label class="label label-danger">'.Yii::$app->fstring->translateDigits($newMessages['count']).'</label>' : '' ?>
            <span class="md-send"></span>
        </div>
    </div>
</div>
