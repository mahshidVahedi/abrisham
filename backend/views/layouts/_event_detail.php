 <?php
 
 $urlPublic	=	yii::getAlias('@yii1Url');
 $class="";
 if($model-> recordType == 'content'){
	$class	='fa fa-file';	
	 
 }elseif($model-> recordType == 'comment'){
	$class	='fa fa-comment';	
	 
 }
 ?>
 <a href="<?php echo $urlPublic.'/users/saveVisit?id='.$model->id.'&type='.$model->recordType;?>" target="_blank" class="list-group-item">
  <div class="media">
	 <div class="pull-right p-l-10">
		<em class="<?php echo $class;?> noti-primary"></em>
	 </div>
	 <div class="media-body">
		<h5 class="media-heading"><?php echo $model->recordTitle;?></h5>
		<p class="m-0">
			<small><?php echo $model->recordContent;?></small>
		</p>
	 </div>
  </div>
</a>
