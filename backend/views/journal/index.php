<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\assets\ICheckAsset;
use kartik\date\DatePicker;
use backend\helpers\CarState;

ICheckAsset::register($this);
\YiiNodeSocket\Assets\NodeSocketAssets::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\JournalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการเข้า-ออก';
$this->params['breadcrumbs'][] = $this->title;
$filter_status = [['id'=>'','name'=>'ทั้งหมด'],['id'=>0,'name'=>'รออนุมัติ'],['id'=>1,'name'=>'อนุมัติ'],['id'=>2,'name'=>'ไม่อนุมัติ']];
$js =<<<JS
  $(function(){ 

    $("input").iCheck({
        checkboxClass: "icheckbox_square-green",
        radioClass: "iradio_square-green",
        increaseArea: "10%" // optional
    });

    $(".iCheck-helper").click(function(){

        $(this).parent().each(function(i1, e1){
            if($(e1).children().attr("name") == "selection[]"){
                if($(e1).children().prop("checked")){
                    // console.log($(e1).children().val());
                    $(e1).children().prop("checked", true);

                    // $(".all-print").show();
                }else{

                    // console.log("un check"+$(e1).children().val());
                    $(e1).children().prop("checked", false);
                    $(document).find("input[name='selection_all']").prop("checked", false);
                    $(document).find("input[name='selection_all']").parent().removeClass("checked");

                }

            }else{
                if($(e1).children().prop("checked")){
                    // console.log("check all");
                    $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                        // console.log(e.value);
                        $(e).prop("checked", true);
                        $(e).parent().addClass("checked");
                    });
                }else{
                    // console.log("un check all");
                    $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                        // console.log(e.value);
                        $(e).prop("checked", false);
                        $(e).parent().removeClass("checked");
                    });
                }

                // console.log(orderList);
            }
            // console.log(orderList);
        });
    });
  });
JS;
$this->registerJs($js,static::POS_END);

?>
<div class="journal-index">

    <h1><?php //echo Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <input type="hidden" class="count_noti" name="count_noti" value="<?=$count_noti?>">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
           <div>
             <?php echo Html::beginForm(['/journal/index'], 'get'); ?>
             <div class="btn-group">
                <?= Html::a('<i class="fa fa-arrow-right"></i> แจ้งรถเข้า', ['create'], ['class' => 'btn btn-success']) ?>
              </div>
              <div class="btn-group">
                 <?php //echo Html::a('<i class="fa fa-arrow-left"></i> แจ้งรถออก', ['create'], ['class' => 'btn btn-danger','disabled'=>'disabled']) ?>
               </div>

                 <div class="btn-group field-icon-wrapp">
                   <input type="text" name="search" value="<?=$search;?>" placeholder="ข้อความค้นหา" class="form-control">
                 </div>
              <div class="btn-group" style="width: 200px">
                <?php $today = date('d-m-Y');
                    //echo date('d-m-Y',$sdate);
                    if($sdate!=''){$today=date('d-m-Y',$sdate);}
                ?>
                <?php echo DatePicker::widget([
                    'name' => 's_date',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'value' => $today,
                    'removeButton'=>false,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-mm-yyyy'
                    ]
                ]);?>
              </div>
              <div class="btn-group" style="width: 200px">
                <?php $today = date('d-m-Y');
                    //echo date('d-m-Y',$sdate);
                    if($ndate!=''){$today=date('d-m-Y',$ndate);}
                ?>
                <?php echo DatePicker::widget([
                    'name' => 'n_date',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'value' => $today,
                    'removeButton'=>false,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-mm-yyyy'
                    ]
                ]);?>
              </div>
              <div class="btn-group">
                 <select name="approve_type" class="form-control">
                   <?php for($i=0;$i<=count($filter_status)-1;$i++):?>
                     <?php
                        $selected = '';

                        if($apptype == $filter_status[$i]['id']){
                          $selected = 'selected';
                        }
                        if($apptype == ''){
                          $selected = '';
                        }
                     ?>
                   <option value='<?=$filter_status[$i]['id']?>' <?=$selected?>><?=$filter_status[$i]['name']?></option>
                   <!-- <option value='0'>ไม่อนุมัติ</option>
                   <option value='1'>อนุมัติ</option> -->
                 <?php endfor;?>
                 </select>
               </div>
               <div class="btn-group">
                 <?php echo Html::submitButton('ค้นหา', ['class'=>'btn btn-primary']); ?>
               </div>
               <?php echo Html::endForm(); ?>
        <!-- <div class="pull-right">
        <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
      </div> -->
      </div>
      </div>
      <div class="panel-body">
        <div class="row">
        <div class="col-lg-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        //'tableOptions'=> ['table table-responsive'],
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          ['class' => 'yii\grid\CheckBoxColumn'],

            //'id',
            'journal_no',
          //  'trans_date',
            [
              'attribute'=> 'created_at',
              'label' => 'วันที่',
              'format' => 'html',
              'value' => function($data){
                return '<i class="fa fa-calendar text-success"></i> '.date('d-m-Y',$data->created_at).' <i class="fa fa-clock-o text-success"></i> '.date('H:i',$data->created_at);
              }

            ],

            //'activity_id',
            [
              'attribute'=> 'activity_id',
              'value' => function($data){
                return $data->contacttype->name;
              }

            ],
            //'car_type',
            [
              'attribute'=> 'car_type',
              'format' => 'html',
              'value' => function($data){
                $car_type = '';
                if($data->car_type == 1){
                  $car_type = '<i class="fa fa-truck text-success"></i> '.$data->cartype->name;
                }elseif($data->car_type == 2){
                  $car_type = '<i class="fa fa-car text-success"></i> '.$data->cartype->name;
                }elseif($data->car_type == 3){
                  $car_type = '<i class="fa fa-truck text-success"></i> '.$data->cartype->name;
                }elseif($data->car_type == 4){
                  $car_type = '<i class="fa fa-motorcycle text-success"></i> '.$data->cartype->name;
                }elseif($data->car_type == 5){
                  $car_type = '<i class="fa fa-bicycle text-success"></i> '.$data->cartype->name;
                }
                return $car_type;
              }

            ],
            'car_license_no',
            // 'status',
            [
              'attribute'=> 'in_date',
              'format' => 'html',
              'value' => function($data){
                return $data->in_date!=NULL?'<i class="fa fa-calendar text-success"></i> '.date('d-m-Y',$data->in_date).' <i class="fa fa-clock-o text-success"></i> '.date('H:i',$data->in_date):'';
              }

            ],
            [
              'attribute'=> 'out_date',
              'format' => 'html',
              'value' => function($data){
                return  $data->out_date!=NULL?'<i class="fa fa-calendar text-success"></i> '.date('d-m-Y',$data->out_date).' <i class="fa fa-clock-o text-success"></i> '.date('H:i',$data->in_date):'';
              }

            ],
            [
              'attribute'=>'status',
              'format' => 'html',
              'value'=>function($data){
                if($data->status === 0){
                  return '<div class="label label-info">รออนุมัติ</div>';
                }else if($data->status === 1){
                  return '<div class="label label-success">อนุมัติ</div>';
                }else if($data->status === 2){
                  return '<div class="label label-warning">ไม่อนุมัติ</div>';
                }

              }
            ],
            [
              'attribute'=>'car_state',
              'format' => 'html',
              'value'=>function($data){
                 if($data->car_state === 0){
                  return '<div class="label label-default">'.CarState::getTypeById($data->car_state).'</div>';
                }else if($data->car_state === 1){
                  return '<div class="label label-success">'.CarState::getTypeById($data->car_state).'</div>';
                }else if($data->car_state === 2){
                  return '<div class="label label-warnning">'.CarState::getTypeById($data->car_state).'</div>';
                }else if($data->car_state === 3){
                  return '<div class="label label-danger">'.CarState::getTypeById($data->car_state).'</div>';
                }
              }
            ],
            // 'status_reason:ntext',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

          //  ['class' => 'yii\grid\ActionColumn'],
          [
                      'label' => 'Action',
                      'format' => 'raw',
                      'value' => function($model){
                          if($model->status ==0){
                            return '
                                  <div class="btn-group" >
                                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                      <ul class="dropdown-menu" style="right: 0; left: auto;">
                                      <li><a href="'.Url::toRoute(['/journal/view', 'id'=>$model->id]).'">'.'View'.'</a></li>
                                      <li><a href="'.Url::toRoute(['/journal/update', 'id'=>$model->id]).'">'.'Update'.'</a></li>
                                      <li><a onclick="return confirm(\'Confirm ?\')" href="'.Url::to(['/journal/delete', 'id'=>$model->id],true).'">Delete</a></li>
                                      </ul>
                                  </div>
                              ';
                          }else{
                            return '
                                  <div class="btn-group" >
                                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                      <ul class="dropdown-menu" style="right: 0; left: auto;">
                                      <li><a href="'.Url::toRoute(['/journal/view', 'id'=>$model->id]).'">'.'View'.'</a></li>
                                      </ul>
                                  </div>
                              ';
                          }
                              
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
    </div>
    </div>
    <?php Pjax::end(); ?>
</div>
