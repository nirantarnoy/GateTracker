<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'หน่วยนับ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index">
    <?php Pjax::begin(); ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
           <div>
                <?= Html::a('<i class="fa fa-plus-circle"></i> Create Unit', ['create'], ['class' => 'btn btn-success']) ?>

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
                    'name',
                    'description',
                    //'status',
                    [
                      'attribute'=>'status',
                      'format' => 'html',
                      'value'=>function($data){
                        return $data->status === 1 ? '<div class="label label-success">Active</div>':'<div class="label label-default">Inactive</div>';
                      }
                    ],
                    //'created_at',
                    // 'updated_at',
                    // 'created_by',
                    // 'updated_by',

                    //['class' => 'yii\grid\ActionColumn'],
                    [
                                'label' => 'Action',
                                'format' => 'raw',
                                'value' => function($model){
                                        return '
                                            <div class="btn-group" >
                                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu" style="right: 0; left: auto;">
                                                <li><a href="'.Url::toRoute(['/unit/view', 'id'=>$model->id]).'">'.'View'.'</a></li>
                                                <li><a href="'.Url::toRoute(['/unit/update', 'id'=>$model->id]).'">'.'Update'.'</a></li>
                                                <li><a onclick="return confirm(\'Confirm ?\')" href="'.Url::to(['/unit/delete', 'id'=>$model->id],true).'">Delete</a></li>
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
