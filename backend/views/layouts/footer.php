<script>
	var resizefunc = [];
</script>

<?php
use yii\helpers\Url;
//echo $this->registerJsFile('@web/nadiya_assets/js/jquery.min.js',[$this::POS_HEAD]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/bootstrap-rtl.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/detect.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/fastclick.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/jquery.slimscroll.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/jquery.blockUI.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/waves.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/wow.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/jquery.nicescroll.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/jquery.scrollTo.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/plugins/switchery/js/switchery.min.js" , [$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/jquery.core.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/custom.modules.js?v=0.002',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/bootstrap-tagsinput.min.js',[$this::POS_END]) ?>

<?=  $this->registerJsFile('@web/nadiya_assets/plugins/notifyjs/js/notify.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/notifications/notify-metro.js',[$this::POS_END]) ?>

<?=  $this->registerJsFile('@web/nadiya_assets/plugins/bootstrap-select/js/bootstrap-select.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/custombox/js/custombox.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/custombox/js/legacy.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/summernote/summernote.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/summernote/summernote-ext-rtl.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js',[$this::POS_END]) ?>

<?= $this->registerJsFile('@web/nadiya_assets/js/jquery.app.js',[$this::POS_END]); ?>
<?= $this->registerJsFile('@web/nadiya_assets/plugins/sweetalert/sweetalert.min.js',[$this::POS_END]); ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/public.methods2.js?113',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/sticky.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/sweetalert.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/sweetalert2.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/js/dataTable4/datatables.min.js',[$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/moment/moment.js' , [$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/plugins/sheetJs/Blob.js" , [$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/plugins/sheetJs/FileSaver.js" , [$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/plugins/croppie/croppie.js" , [$this::POS_END]) ?>
<?=  $this->registerJsFile('@web/nadiya_assets/plugins/plyr/plyr.js' , [$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/js/jquery.cookie.min.js" , [$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/js/csr.js" , [$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/plugins/emoji-picker/src/js/jquery.emojiarea.js?1.00016" , [$this::POS_END , 'type'=>'module']) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/js/bootstrap-datepicker.min.js" , [$this::POS_END]) ?>
<?=  $this->registerJsFile("@web/nadiya_assets/js/bootstrap-datepicker.fa.min.js" , [$this::POS_END]) ?>


<?=
    $this->registerJs('
    var notify;
var notifyClosed = [];
getNotify();
// setInterval(getNotify , 10000);

 function getNotify(){
     $.ajax({
            url:\'/new/backend/web/notifications/getnotifications\',
            type:\'post\',
            success : function(value){
                if(value.length){
                    if(value != notify){
                        notify = value;
                        flag = 0;
                        for(var id of value.keys()){
                            if(value[id]){
                                if(flag > 2)
                                    $(".notification-alert[alt=\'"+value[id].id+"\']").closest(".notifyjs-wrapper.notifyjs-hidable").remove();
                                else
                                    if(sendNotify(value , id)){
                                        flag++;
                                    }
                            }
                        }
                        if(value.length > 3){
                            el = \'<div id="notify-count" style="\'+
                                                            \'padding-top: 3px;\'+
                                                            \'border-radius: 50%;\'+
                                                            \'background-color: red;\'+
                                                            \'width: 25px;\'+
                                                            \'color: white;\'+
                                                            \'height: 25px;\'+
                                                            \'margin-bottom: -3px;\'+
                                                            \'transition: all 0.5s;\'+
                                                            \'margin-right: -12px;" alt2="\'+value.length+\'" class="text-center"><a href="../notifications/" target="_blank" style="color: white">\'+numbersToPersian(value.length)+\'</a></div>\';
                            if($(".notifyjs-corner #notify-count").length){
                                if($(".notifyjs-corner #notify-count").attr("alt2") != value.length){
                                    $(".notifyjs-corner #notify-count").remove();
                                    $(".notifyjs-corner").prepend(el).find("#notify-count").hide().fadeIn();
                                }
                            }
                            else
                                $(".notifyjs-corner").prepend(el).find("#notify-count").hide().fadeIn();
                        }
                        else
                            $(".notifyjs-corner #notify-count").remove();
                    }
                }
                else
                    $(".notification-alert").closest(".notifyjs-wrapper.notifyjs-hidable").remove();
            }
        })
 }
 $(document).on(\'click\', ".notifyjs-wrapper.notifyjs-hidable" , function(){
    id = $(this).find(".notification-alert").attr("alt");
    if(!id)
        return false;
    notifyClosed[id] = true;
    notifyDiv = $(this);
         $.ajax({
            url:\'/new/backend/web/notifications/seennotifications\',
            type:\'post\',
            data : {id : id},
            success : function(value){
                if(value == "OK"){
                   id2 = $(".notification-alert[alt=\'"+id+"\']").attr("alt2");
                   var count = parseInt($(".notifyjs-corner #notify-count").attr("alt2")) - 1;
                   $(".notification-alert[alt=\'"+id+"\']").closest(".notifyjs-wrapper.notifyjs-hidable").remove();
                   delete notify[id2];
                   for(var nId of notify.keys()){
                   if(id != notify[nId].id && !$(".notification-alert[alt=\'"+notify[nId].id+"\']").length)
                      if(sendNotify(notify , nId)){
                        if($(".notifyjs-corner #notify-count").length){
                            if(count > 2){
                                el = \'<div id="notify-count" style="\'+
                                \'padding-top: 3px;\'+
                                \'border-radius: 50%;\'+
                                \'background-color: red;\'+
                                \'width: 25px;\'+
                                \'color: white;\'+
                                \'height: 25px;\'+
                                \'margin-bottom: -3px;\'+
                                \'transition: all 0.5s;\'+
                                \'margin-right: -10px;" alt2="\'+(count)+\'" class="text-center"><a href="../notifications/" target="_blank" style="color: white">\'+numbersToPersian(count)+\'</a></div>\';
                                $(".notifyjs-corner #notify-count").remove();
                                $(".notifyjs-corner").prepend(el).find("#notify-count");
                            }
                            else
                                $(".notifyjs-corner #notify-count").remove();
                        }
                        break;
                      }
                   }
                }

            },
            error : function(xhr, ajaxOptions, thrownError){
                notifyClosed[id] = false;
            }
         });
 });


 function sendNotify(value , id){
    if(notifyClosed[value[id].id])
        return false;
    value[id].title = value[id].title + "<span class=\'notification-alert\' alt=\'"+value[id].id+"\' alt2=\'"+id+"\'></span>";
    if(!$(".notification-alert[alt=\'"+value[id].id+"\']").length){
        $.notify.defaults({autoHideDelay:9999999999});
        var btn = "";
        if(value[id].is_show_btn)
            btn = "<div class=\"btn btn-white btn-block\" style=\"margin-top: 15px;\">دیدم</div>";
        notifyMessage = value[id].message+"<p class=\'m-t-5\' style=\'margin-bottom: -8px; font-size: 10px;\'><span class=\'\'>"+value[id].sender+"</span> - <span class=\'ltr\'>"+value[id].date+"</span></p>"+btn;
        $.Notification.notify(notifyType(value[id].type),"bottom left",value[id].title,notifyMessage);
        $.notify.defaults({autoHideDelay:5000});
    }
    return true;
 }

 function notifyType(type){
     if(type == 1)
        type = "warning";
    else if(type == 2)
        type = "error";
    else if(type == 3)
        type = "info";
    else if(type == 4)
        type = "success";
    else if(type == 5)
        type = "black";
    else if(type == 6)
        type = "white";
    else if(type == 7)
        type = "default";
    else if(type == 8)
        type = "custom";
    return type;
 }


             //<---iphone responsive-table start--->//

				if(!!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)){
					$(\'.table-responsive\').css(\'direction\',\'ltr\');
					$(\'.table-responsive > table\').css(\'direction\',\'rtl\');
					$(document).ready(function(){
						setTimeout(function() {
							  $(\'.table-responsive\').each(function(){
								  width=$(this).width(),
									scrollWidth=$(this).get(0).scrollWidth;
								  $(this).scrollLeft(scrollWidth-width);
							  });
						},500);
					});
				}

            //<---iphone responsive-table end--->//
            
            
				$(document).ready(function(){
				    setTimeout(function () {
                        const menuItemActive = $(\'.side-menu a.active\').eq(0);
                        let scrollTop = 4;
                        menuItemActive.parent().prevAll().each(function () {
                            // $(\'.slimscrollleft\').slimScroll({ scrollTo : ($(this).outerHeight+$(\'.slimscrollleft\')[0].scrollTop)+\'px\' });
                            scrollTop += $(this).outerHeight() + 4;
                        });
                        $(\'.slimscrollleft\').slimScroll({ scrollTo : scrollTop+\'px\' , animate: true });
                    }, 200)
                });
            

    ');
?>
