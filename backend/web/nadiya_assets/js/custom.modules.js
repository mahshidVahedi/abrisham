$(document).on('focus','.input-update',function(){
    oldValue = $(this).val();
});

$(document).on('paste change','.input-update',function(){
    var newValue = $(this).val();
    if(oldValue != newValue)  // textbox value is changed and must be update
    {
        $("#waiting-list").fadeIn();
        var csrfToken   = $('meta[name="csrf-token"]').attr('content');
        var name        = $(this).attr('name');
        var id          = $(this).attr('alt');
        var column      = $(this).attr('primary-key');
        if($(this).attr('aria-required') && newValue.length == 0)
        {
            $.Notification.notify('error','bottom right','لطفا مقدار این فیلد را وارد کنید!');
            $("#waiting-list").fadeOut(); 
        }
        else
        {
            $.post('/new/backend/web/inputupdate/index?error',{
                name   : name,
                value  : newValue,
                id     : id,
                column : column,
                _csrf  : csrfToken
                },function(data){
                    $.Notification.notify('success','bottom right',data);
            }).always(function(){
                $("#waiting-list").fadeOut();  
            }).fail(function(){
                $.Notification.notify('error','bottom right','مشکلی در ارسال اطلاعات بوجود آمده است!'); 
            })
        }
    }
    oldValue = $(this).val();
})