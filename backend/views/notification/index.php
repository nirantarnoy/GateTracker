<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\assets\ICheckAsset;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;

ICheckAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการแจ้งเตือน';
$this->params['breadcrumbs'][] = $this->title;

$approve_url = Yii::$app->getUrlManager()->createUrl('notification/approvenoti');

$js =<<<JS
  $(function(){ 

     var approveList = [];
     var approveStatus = 0;

     $(".btn-approve,.btn-none-approve").attr('disabled','disabled');

     $(".btn-approve").on('click',function(e){
        approveStatus = 1;
        $("#modal").modal("show");
      });
      $(".btn-none-approve").on('click',function(e){
        approveStatus = 0;
        $("#modal").modal("show");
      });

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
                    $(".btn-approve,.btn-none-approve").attr('disabled',false);
                }else{
                    $(".btn-approve,.btn-none-approve").attr('disabled',true);
                    // console.log("un check"+$(e1).children().val());
                    $(e1).children().prop("checked", false);
                    $(document).find("input[name='selection_all']").prop("checked", false);
                    $(document).find("input[name='selection_all']").parent().removeClass("checked");

                }
                  approveList = [];
                  $(".icheckbox_square-green input[name='selection[]']:checked").each(function(i,e){
                      approveList.push(e.value);
                  });

            }else{
                approveList = [];
                if($(e1).children().prop("checked")){
                    // console.log("check all");
                    $(".btn-approve,.btn-none-approve").attr('disabled',false);
                    $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                        // console.log(e.value);
                        $(e).prop("checked", true);
                        $(e).parent().addClass("checked");
                        approveList.push(e.value);
                    });
                }else{
                    // console.log("un check all");
                    $(".btn-approve,.btn-none-approve").attr('disabled','disabled');
                    $(".icheckbox_square-green input[name='selection[]']").each(function(i,e){
                        // console.log(e.value);
                        $(e).prop("checked", false);
                        $(e).parent().removeClass("checked");
                        approveList = [];
                    });
                }

                // console.log(orderList);
            }
            // console.log(orderList);
            //alert(approveList);
        });
    });

    $('.btn-approve-submit').click(function(){
        if(approveList.lenght <= 0)return;
        var approveText = $(".approve-text").val();
        var Url = '$approve_url';
        $.ajax({
            type: 'post',
            dataType: 'html',
            url: Url,
            data: {approvelist: approveList,approvetext: approveText,approvestatus: approveStatus},
            success: function(data){
                alert(data);
            },
            error:function(){

            }
        });
        
    });
    
    $(".alert").show().fadeOut(5000);

  });
JS;
$this->registerJs($js,static::POS_END);

?>
<div class="notification-index">

    <?php $session = Yii::$app->session;
      if ($session->getFlash('msg')): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php echo $session->getFlash('msg'); ?>
      </div>
  <?php endif; ?>

    <?php Pjax::begin(); ?>

<div class="panel panel-default">
    <div class="panel-heading">
         <div class="btn-group">
             <?php echo $this->render('_search', ['model' => $searchModel]); ?>
         </div>
        
         <div class="btn-group">
             <div class="btn btn-primary btn-approve" style="bottom:-5px">อนุมัติ</div>
         </div>
         <div class="btn-group">  
             <div class="btn btn-warning btn-none-approve" style="bottom:-5px">ไม่อนุมัติ</div>
         </div>
   <!--  <p>
        <?php // Html::a('Create Notification', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

        
    </div>
    <div class="panel-body">
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckBoxColumn'],
            //'id',
            'title',
            'description',
            'files',
            'url:url',
            // 'status',
            // 'created_at',
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('d-m-Y H:i',$model->created_at);
                }
            ],
            // 'updated_at',
            // 'created_by',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>

    <?php Pjax::end(); ?>
</div>
<?php    Modal::begin([
            'header' => '<h4><i class="fa fa-file-text-o"></i> อนุมัติใบแจ้งเข้า  - ออก</h4>',
            'id' => 'modal',
            // 'data-backdrop'=>static,

            'size' => '',
            'options' => ['data-backdrop' => 'false',
                           'tabindex' => -1
             ],
            // 'closeButton'=>['label'=>'Close'],
             'footer' => '<a href="#" class="btn btn-primary btn-approve-submit" data-dismiss="modal">ตกลง</a><a href="#" class="btn btn-default" data-dismiss="modal">ยกเลิก</a>',
]);
echo  "<div id='showmodal'>
        <textarea class='form-control approve-text' name='' cols='10' rows='4'></textarea>
      </div>";
?>
<?php Modal::end()?>
