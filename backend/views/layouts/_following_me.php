<?php 
use backend\models\Follow;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
	$userId			=	Yii::$app->user->id;
	$dataProviderMyFollow = new ActiveDataProvider([
			'query' => Follow::find()
				->where(['return_id'=>$userId ,'type' => 2 ])
				->orderBy(['create_date'=>'desc'])
				,
			'pagination' =>false
		]);
?>
<div class="side-bar right-bar nicescroll">
	<h4 class="text-center">پیگیرهای من</h4>
	<div class="contact-list nicescroll">
		<ul class="list-group contacts-list">
			<?php 
				echo ListView::widget([
												'dataProvider'	=> $dataProviderMyFollow,
												'itemView'		=>	'//layouts/_following_detail',
												'layout'		=>	'{items}'
												
												
												
											]);
			?>
		</ul>  
	</div>
</div>