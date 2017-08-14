<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\web\UrlManager;
use yii\bootstrap\Modal;

$this->title = "แจ้งเตือนรถเข้า - ออก";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'แจ้งเตือน'), 'url' => ['index']];

date_default_timezone_set('Asia/Bangkok');
$img_logo = Yii::$app->getUrlManager()->getBaseUrl().'/img/blue.png';
//echo Yii::$app->request->BaseUrl;
//if(file_exists(yii\helpers\Url::to('@backend/uploads').'/photo4.jpg')){echo "OK";}else{echo 'NOO';}
//$xx = yii\helpers\Url::to('@backend/uploads').'/photo4.jpg';
//$xx2 = yii\helpers\Url::to('@backend/views/notification');
//echo $xx;
$js =<<<JS
  $(function(){
      $(".btn-approve").on('click',function(e){
        $("#modal").modal("show");
      });
  });
JS;
$this->registerJs($js,static::POS_END);
?>

<div class="panel panel-body">
<div class="table-responsive">
  <?php echo Html::beginForm(['/notification/showlist'],'post', ['id'=>'print-form', 'name'=>'print_form']);?>
  <div class="row">
    <div class="col-lg-4">
        <input type="text" class="form-control" placeholder="Search ..." value="<?=$textsearch;?>" name="noti-search" style="width: 100%" />
</div>
<div class="col-lg-6">
      <button type="submit" class="btn btn-outline btn-primary">Search</button>
</div>
</div>
<?php echo Html::endForm();?>
<br />
<table class="table table-hover issue-tracker">
    <tbody>
      <?php if(count($model)>0):?>
        <?php foreach($model as $value):?>
    <tr>
        <td style="width: 5%">
            <?php if($value->reftype == 1):?>
              <i class="fa fa-bell-o fa-3x text-primary"></i>
            <?php else:?>
              <i class="fa fa-bell-o fa-3x text-danger"></i>
            <?php endif;?>
        </td>
        <td class="issue-info">
            <a href="">
                <?= $value->title ?>
            </a>

            <small>
                <?php echo $value->description;?>
            </small>
            <span class=""><i class="fa fa-calendar fa-x2"></i> <?php echo date('d-m-Y',$value->created_at);?></span>
            <span class=""><i class="fa fa-clock-o fa-x2"></i> <?php echo date('H:i',$value->created_at);?></span>
            <?php if($value->reftype == 1):?>
                <?php if($value->journalinfo->status == 1):?>
                <span class="approve-result-yes lable text-success"><i class="fa fa-check-circle text-success"></i> อนุมัติ </span>
                <span><i class="fa fa-pen"></i> #<?=$value->journalinfo->status_reason?></span>
              <?php elseif($value->journalinfo->status == 2):?>
                <span class="approve-result-no lable text-danger"><i class="fa fa-ban text-danger"></i> ไม่อนุมัติ </span>
                <span><i class="fa fa-pen"></i> #<?=$value->journalinfo->status_reason?></span>
              <?php endif;?>
           <?php else:?>
               <?php if($value->journaltransinfo->status == 1):?>
                <span class="approve-result-yes lable text-success"><i class="fa fa-check-circle text-success"></i> อนุมัติรถออก </span>
                <span><i class="fa fa-pen"></i> #<?=$value->title?></span>
              <?php elseif($value->journaltransinfo->status == 0):?>
                <span class="approve-result-no lable text-danger"><i class="fa fa-ban text-danger"></i> รอการอนุมัติรถออก </span>
                <span><i class="fa fa-pen"></i> #<?=$value->journaltransinfo->title?></span>
              <?php endif;?>
           <?php endif;?>
        </td>
        <td>

        </td>
        <td>

        </td>
        <td>

        </td>
        <td class="text-right">
          <?php if($value->reftype == 1):?>
              <?php if($value->journalinfo->status == 1):?>
                 <div class="btn btn-success btn-approve"> ปล่อยรถเข้า </div>
              <?php endif;?>
            <?php else:?>
                <div class="btn btn-danger btn-approve"> ปล่อยรถออก </div>
            <?php endif;?>
        </td>
    </tr>
  <?php endforeach;?>
  <?php endif;?>

    </tbody>
</table>
<?php
  echo LinkPager::widget(['pagination' => $pages,]);
?>
</div>
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
             'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">ตกลง</a><a href="#" class="btn btn-default" data-dismiss="modal">ยกเลิก</a>',
]);
echo  "<div id='showmodal'>
  <h3 class='text-info'>คุณต้องการอนุมัติใบแจ้งเข้า - ออก นี้ใช่หรือไม่ ?</h3>
</div>";
?>
<?php Modal::end()?>
