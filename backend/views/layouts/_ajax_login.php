<?php
    use yii\helpers\Url;
?>
<script>
    var user_id    ='<?php echo yii::$app->user->id;?>';
    function requiredLoginMain(error = '',href = '')
    {
        if(error)
            error = "\n("+error+')';
        swal({
            title    :    "نیاز به ورود مجدد",
            text    :    "لطفا رمز عبور خود را وارد کنید"+error,
            icon    :    error ? 'error' : 'warning',
            buttons    :    'ورود',
            content: {
                element: "input",
                attributes: {
                    type: "password",
                },
            }
        }).then(value=>{
                $.ajax({
                    url:'<?php echo Url::to(['site/ajaxpage']);?>',
                    type:'POST',
                    data:{password :`${value}`,type:'loginByPassword',user_id:user_id},
                    success:function(res){
                        if(res == 'OK'){
                            swal({
                                title : 'با موفقیت وارد شدید',
                                icon : 'success',
                                timer: 1000
                            });
                            if(href)
                                window.location.replace(href);
                        }    
                        else{
                            requiredLoginMain(res,href)
                        }
                    }
            });
    });
    }
    $(document).ready(function(){
        $('.check-login').click(function(e){
            e.preventDefault();
            var href    =    $(this).attr('href');
            $.ajax({
                url:'<?php echo  Url::to(['site/ajaxpage']);?>',
                type:'POST',
                data:{type:'checkLogin','_csrf': csrfToken},
                success:function(res){
                    if(res == 'guest'){
                        requiredLoginMain('',href);
                    }else{
                        window.location.replace(href);
                    }
                }
            }); 
        });

    });
</script>