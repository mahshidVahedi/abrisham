<?php 
use yii\helpers\Html;
$urlPublic	=	yii::getAlias('@yii1Url');
?>
<li class="list-group-item">
	<a href="#">
		<div class="avatar">
			<?php
			//list($profile)	=	$model->profile;
			
			// if($model->profile[0]['image']!=''){
				// $image =  $urlPublic.'/server/php/files/'.$profile['user_id'].'/profile/'.$profile['image'];
			// }else{
				// $image =  $urlPublic.'/server/php/files/images/no_pic.jpg';
			// }						$image = 	yii::$app->fuser->getUserProfileImage($model->user_id);
			if(isset($model->user_n->unique_key))				$url =	$urlPublic.'/'.$model->user_n->unique_key;			else				$url =	'';									if(isset($model->user_n->unique_key))				$url =	$urlPublic.'/'.$model->user_n->unique_key;			else				$url =	'';						if(isset($model->profile->name))				$name =	$model->profile->name;			else				$name =	'';						if(isset($model->profile->lname))				$lname =	$model->profile->lname;			else				$lname =	'';
			echo  Html::a( Html::img($image) ,$url,array('width'=>32,'height'=>32,'class'=>'img-circle' ,"target"=>"_blank"));
			?>
			
		</div>
		<span class="name"><?php echo $name ." ".$lname;?></span>
		<i class="fa fa-circle <?php //echo Users::model()->statusUser($data->profile[0]['user_id']); ?>"></i>
	</a>
	<span class="clearfix"></span>
</li>