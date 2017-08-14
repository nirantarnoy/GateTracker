<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\ICheckAsset;
use yii\helpers\Url;

ICheckAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รับสินค้า';
$this->params['breadcrumbs'][] = $this->title;

$js =<<<JS
  $(function(){ 
    $(".approve-out").attr("disabled",true);

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
                    $(".approve-out").attr("disabled",false);
                }else{

                    // console.log("un check"+$(e1).children().val());
                    $(e1).children().prop("checked", false);
                    $(document).find("input[name='selection_all']").prop("checked", false);
                    $(document).find("input[name='selection_all']").parent().removeClass("checked");
                    //$(".approve-out").attr("disabled",false);
                }
                $(".approve-out").attr("disabled",false);

            }else{
                $(".approve-out").attr("disabled",true);
                if($(e1).children().prop("checked")){
                    // console.log("check all");
                    $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                        // console.log(e.value);
                        $(e).prop("checked", true);
                        $(e).parent().addClass("checked");
                        $(".approve-out").attr("disabled",false);
                    });
                }else{
                    // console.log("un check all");
                    $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                        // console.log(e.value);
                        $(e).prop("checked", false);
                        $(e).parent().removeClass("checked");
                        $(".approve-out").attr("disabled",true);
                    });
                }

                // console.log(orderList);
            }
            // console.log(orderList);
        });
    });
    
    $(".approve-out").click(function(e){
        var keys = $("#grid-transaction").yiiGridView("getSelectedRows");
        if(keys.length > 0){
            $.ajax({
                    type: "post",
                    dataType: "html",
                    url: "/index.php?r=transaction%2Fapprovetrans",
                    data: {id: keys},
                    success: function(data){
                           // $("#carinfo").val(data);
                               //   alert(data);
                    },
                    error: function(){

                    }
            });
        }else{
            e.preventDefault();
        }
    });
    
    $(".alert").show().fadeOut(5000);

  });
JS;
$this->registerJs($js,static::POS_END);

?>
<div class="transaction-index">
    <?php $session = Yii::$app->session;
      if ($session->getFlash('msg')): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php echo $session->getFlash('msg'); ?>
      </div>
  <?php endif; ?>
    <?php Pjax::begin(); ?>

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
           <div>
            <div class="row">
                <div class="col-lg-1">
                    <div class="btn-group">
                        <?= Html::a('<i class="fa fa-plus-circle"></i> รับสินค้า', ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <div class="col-lg-1">
                    <n/><span><div class="btn btn-info approve-out">อนุมัติรถออก</div></span> 
                </div>
                <div class="pull-right">
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            </div>
            
            
                    
            </div>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'id'=> 'grid-transaction',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                             ['class' => 'yii\grid\CheckBoxColumn'],

                            //'id',
                            'trans_no',
                            //'journal_id',
                            [
                            'attribute' => 'journal_id',
                            'value' => function($data){
                                return $data->journal_id!=''?$data->journal->journal_no:'';
                            }
                            ],
                            'contact_name',
                            //'position',
                            'company',
                            'contact_emp',
                            //'contact_number',
                            // 'contact_detail:ntext',
                            // 'status',
                            [
                              'attribute'=>'status',
                              'format' => 'html',
                              'value'=>function($data){
                                if($data->status === 0){
                                  return '<div class="label label-info">รอตรวจสอบ</div>';
                                }else if($data->status === 1){
                                  return '<div class="label label-success">ตรวจสอบแล้ว</div>';
                                }

                              }
                            ],
                            // 'document_ref',
                            // 'created_at',
                             [
                            'attribute' => 'created_at',
                            'value' => function($data){
                                return $data->created_at!=''?date('d-m-Y',$data->created_at):'';
                            }
                            ],
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
                                        <li><a href="'.Url::toRoute(['/transaction/view', 'id'=>$model->id]).'">'.'View'.'</a></li>
                                        <li><a href="'.Url::toRoute(['/transaction/update', 'id'=>$model->id]).'">'.'Update'.'</a></li>
                                        <li><a onclick="return confirm(\'Confirm ?\')" href="'.Url::to(['/transaction/delete', 'id'=>$model->id],true).'">Delete</a></li>
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
