<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผู้ใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?//php echo Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
           <div>
        <?= Html::a('<i class="fa fa-plus-circle"></i> Create User', ['create'], ['class' => 'btn btn-success']) ?>
        <div class="pull-right">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
      </div>
      </div>
      <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            'fname',
            'lname',
            //'group_id',
            //'role_id',
            [
              'attribute'=>'group_id',
              'format' => 'html',
              'value'=>function($data){
                return $data->usergroup->name;
              }
            ],
            [
              'attribute'=>'role_id',
              'format' => 'html',
              'value'=>function($data){
                return $data->userrole->name == 'อนุมัติใบผ่าน'?'<span class="label label-primary">A</span>'.' '.$data->userrole->name:'<span class="label label-success">R</span>'.' '.$data->userrole->name;
              }
            ],
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            // 'email:email',
            // 'status',
            [
              'attribute'=>'status',
              'format' => 'html',
              'value'=>function($data){
                return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-default">Inactive</div>';
              }
            ],
            // 'created_at',
            // 'updated_at',
            // 'group_id',
            // 'role_id',

          //  ['class' => 'yii\grid\ActionColumn'],
          [
                      'label' => 'Action',
                      'format' => 'raw',
                      'value' => function($model){
                              return '
                                  <div class="btn-group" >
                                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                      <ul class="dropdown-menu" style="right: 0; left: auto;">
                                      <li><a href="'.Url::toRoute(['/user/view', 'id'=>$model->id]).'">'.'View'.'</a></li>
                                      <li><a href="'.Url::toRoute(['/user/update', 'id'=>$model->id]).'">'.'Update'.'</a></li>
                                      <li><a onclick="return confirm(\'Confirm ?\')" href="'.Url::to(['/user/delete', 'id'=>$model->id],true).'">Delete</a></li>
                                      </ul>
                                  </div>
                              ';
                          // }
                      },
                      'headerOptions'=>['class'=>'text-center'],
                      'contentOptions' => ['class'=>'text-center','style'=>'vertical-align: middle','text-align: center'],

                  ],
      ],
    ]); ?>
    </div>
    </div>
    </div>
    </div>
    <?php Pjax::end(); ?>
</div>
