<?php 

use backend\models\Hit;

use backend\models\Comment;

use backend\models\Follow;

use backend\models\Contents;

use backend\models\ContentUserAccess;

use yii\helpers\ArrayHelper;

use yii\data\ActiveDataProvider;

use yii\data\ArrayDataProvider;

use yii\widgets\ListView;
$urlPublicYii2	=	Yii::getAlias('@yii2Url');



		$userId						=	Yii::$app->user->id;

		$listContetHitted			=	ArrayHelper::map(Hit::find()->where(array('user_id'=> $userId , "is_hit" => 1 , "type" => 1  ))->all(),"return_id","return_id");

        $listCommentHitted			=	ArrayHelper::map(Hit::find()->where(array('user_id'=> $userId , "is_hit" => 1 , "type" => 2  ))->all(),"return_id","return_id");

		$listCommentMy				=	ArrayHelper::map(Comment::find()->where(array('user_id'=> $userId ))->all(),"id","id");

		$listCommentHitted			=	$listCommentHitted	+	$listCommentMy;

		$listMyContent				=	ArrayHelper::map(Contents::find()->where(array('create_user_id'=> $userId ))->all(),"id","id");

		

		// generate comment for my content	

		$dataProviderCommentForMyContent = new ActiveDataProvider([

			'query' => Comment::find()->alias('t')->joinWith(['content' => function($q){$q->alias('c');}])

				->where(['in','t.content_id',$listMyContent])

				->andWhere(['not in' , 't.id',$listCommentHitted])
				->andWhere(['<>' , 'c.cat_id',7])
				->andWhere(['<>' , 'c.cat_id',17])

				->andWhere(['t.is_disable'=>0,'c.is_publish'=>1])

				->orderBy(['t.create_date'=>'desc'])

				,

			'pagination' =>false

		]);

		$listComment    	=	ArrayHelper::map(	Comment::find()->alias('t')->joinWith(['content' => function($q){$q->alias('c');}])

													->where(['in','t.content_id',$listMyContent])

													->andWhere(['not in' , 't.id',$listCommentHitted])
													->andWhere(['<>' , 'c.cat_id',7])
													->andWhere(['<>' , 'c.cat_id',17])

													->andWhere(['t.is_disable'=>0,'c.is_publish'=>1])

													->orderBy(['t.create_date'=>'desc'])->all(),"id","id");

		

		// generate comment for follow content

		$listContentWithMyFollow    =	ArrayHelper::map(Follow::find()->where(array('user_id'=> $userId , 'type' => 1 ))->all(),"return_id","return_id");

		$dataProviderCommentForMyFollowContent = new ActiveDataProvider([

			'query' => Comment::find()->alias('t')->joinWith(['content' => function($q){$q->alias('c');}])

				->where(['in','t.content_id',$listContentWithMyFollow])

				->andWhere(['not in' , 't.id',$listCommentHitted])
				->andWhere(['<>' , 'c.cat_id',7])
				->andWhere(['<>' , 'c.cat_id',17])

				->andWhere(['t.is_disable'=>0,'c.is_publish'=>1])

				->orderBy(['t.create_date'=>'desc'])

				,

			'pagination' =>false

		]);

		

		

		// generate comment for my comment



		$listCommentHitted					=	array_merge( $listCommentHitted , $listComment);

		$dataProviderCommentForMyComment	=	new ActiveDataProvider([

			'query' => Comment::find()->alias('t')->joinWith(['content' => function($q){$q->alias('c');}])

				->where(['in','t.comment_id',$listCommentMy])

				->andWhere(['not in' , 't.id',$listCommentHitted])
				->andWhere(['<>' , 'c.cat_id',7])
				->andWhere(['<>' , 'c.cat_id',17])

				->andWhere(['t.is_disable'	=>	0		,	'c.is_publish'	=>	1])

				->orderBy(['t.create_date'	=>	'desc'])

				,

			'pagination' =>false

		]);

		

		

		// generate content by  follow firend

		$listUsersWithMyFollow		=	ArrayHelper::map(Follow::find()->where(array('user_id'=> $userId	,	'type' => 2))->all(),"return_id","return_id");

		$listContentHitted			=	ArrayHelper::map(Hit::find()->where(array('user_id'=> $userId, "is_hit" => 1 , "type" => 1))->all(),"return_id","return_id");



		$dataProviderContentByMyFriends	=	new ActiveDataProvider([

			'query' => Contents::find()

				->where(['in','create_user_id',$listUsersWithMyFollow ])

				->andWhere(['not in' , 'id',$listContentHitted])


				->andWhere(['is_publish'	=>	1])

				->orderBy(['create_date'	=>	'desc'])

				,

			'pagination' =>false

		]);

		// generate my invite

		$listInviteMyContent  	=	ArrayHelper::map(ContentUserAccess::find()->where(array('user_id'=> $userId	))->all(),"content_id","content_id");

		$listInviteMyContent	=	array_diff( $listInviteMyContent , $listContentHitted);

		$dataProviderContentMyInvite	=	new ActiveDataProvider([

			'query' => Contents::find()

				->where(['in','id',$listInviteMyContent ])

				->andWhere(['is_publish'	=>	1])

				,

			'pagination' =>false

		]);

		

        

		

		$records = array();

		$rows = $dataProviderCommentForMyContent->getModels();

		if(!empty($rows))

			foreach($rows as $row){

				$row->recordType	=	'comment';

				$row->recordTitle	=	'دیدگاه جدید';

				$row->recordContent	=	$row->content->title;

				array_push($records, $row);

			}

		



		$rows = $dataProviderCommentForMyFollowContent->getModels();

		if(!empty($rows))

			foreach($rows as $row){

				$row->recordType	=	'comment';

				$row->recordTitle	=	'دیدگاه جدید';

				$row->recordContent	=	$row->content->title;

				array_push($records, $row);

			}



		$rows = $dataProviderCommentForMyComment->getModels();

		if(!empty($rows))

			foreach($rows as $row){

				$row->recordType	=	'comment';

				$row->recordTitle	=	'پاسخ به دیدگاه من';

				$row->recordContent	=	$row->content->title;

				array_push($records, $row);

			}



		$rows = $dataProviderContentByMyFriends->getModels();

		if(!empty($rows))

			foreach($rows as $row){

				$row->recordType	=	'content';

				$row->recordTitle	=	'مطلب جدید';

				$row->recordContent	=	$row->title;

				array_push($records, $row);

			}



		/*$rows = $dataProviderContentMyInvite->getModels();

		if(!empty($rows))

			foreach($rows as $row){

				$row->recordType	=	'content';

				$row->recordTitle	=	'<i class="glyphicon glyphicon-group"></i> '.'دعوت به گفتگوی خصوصی';

				$row->recordContent	=	$row->title;

				array_push($records, $row);

			}	*/

		//print_r($records);

		//$records	=	ArrayHelper::multisort($records, ['create_date'], [ SORT_DESC]);

		

		$dataEventAll = new ArrayDataProvider([

			'allModels' => $records,			

			'pagination' => [

				'pageSize' => 3,

			],

		]);

		// print_r($dataEventAll);

		//echo $dataEventAll->getCount() ;

		if($dataEventAll->getCount() > 0){

		echo '<li class="dropdown top-menu-item-xs">

                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">

                                        <i class="icon-bell"></i> <span class="badge badge-xs badge-danger">'.$dataEventAll->getCount().'</span>

                                    </a>

									

                                    <ul class="dropdown-menu dropdown-menu-lg">

                                        <li class="notifi-title"><span class="label label-default pull-left">جدید '.$dataEventAll->getCount().'</span>رخدادها</li>

                                        <li class="list-group slimscroll-noti notification-list">';

		



		

											echo ListView::widget([

												'dataProvider'	=> $dataEventAll,

												'itemView'		=>	'//layouts/_event_detail.php',

												'layout'		=>	'{items}'

												

												

												

											]);

									echo '

									 </li>

                                        <li>

                                            <a href="'.'/users/events'.'" class="list-group-item text-left">

                                                <small class="font-600">مشاهده تمام رخدادها</small>

                                            </a>

                                        </li>

                                    </ul>

                                </li>';

		}

		

		//'.Yii::->createUrl('users/events').'

?>





                          