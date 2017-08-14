<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\Session;
use kartik\date\DatePicker;

$session = new Session();
$session->open();

//echo $session['roleaction'];
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
//$this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile('https://cdn.socket.io/socket.io-1.3.5.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$sdate = '';
$ndate = '';
?>
<div class="dashboard-index">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
             <?php echo Html::beginForm(['/journal/index'], 'get'); ?>

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
                 <?php echo Html::submitButton('ค้นหา', ['class'=>'btn btn-primary']); ?>
               </div>
               <?php echo Html::endForm(); ?>
        <!-- <div class="pull-right">
        <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
      </div> -->
      </div>
    </div>
  </div><br />
  <div class="row">
  	<div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-paper-plane-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">รถมาติดต่อ</span>
                <span class="info-box-number"><h2><b><?=$model1;?></b></h2><small></small></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-truck"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">รถส่งของ</span>
                <span class="info-box-number"><h2><b><?=$model2;?></b></h2></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
     <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-indent"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">รถส่งเหล็กม้วน</span>
                <span class="info-box-number"><h2><b><?=$model3;?></b></h2></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
     <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-cube"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">รถมารับสินค้า</span>
                <span class="info-box-number"><h2><b><?=$model4;?></b></h2></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
  </div>
  <div class="row">
  	<div class="col-lg-12">
  		<!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">สรุปรายการรถทั้งหมด (เข้า - ออก)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>รายการ</th>
                    <th>ทั้งหมด</th>
                    <th>เสร็จแล้ว</th>
                    <th>อยู่ในระบบ</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td><a href="pages/examples/invoice.html">รถมาติดต่อ</a></td>
                    <td>23</td>
                    <td>25</td>
                    <td>
                      25
                    </td>
                  </tr>
                  <tr>
                    <td><a href="pages/examples/invoice.html">รถส่งของ</a></td>
                    <td>34</td>
                    <td>25</td>
                    <td>
                      25
                    </td>
                  </tr>
                  <tr>
                    <td><a href="pages/examples/invoice.html">รถส่งเหล็กม้วน</a></td>
                    <td>45</td>
                    <td>25</td>
                    <td>
                      25
                    </td>
                  </tr>
                  <tr>
                    <td><a href="pages/examples/invoice.html">รถมารับสินค้า</a></td>
                    <td>54</td>
                    <td>25</td>
                    <td>
                     25
                    </td>
                  </tr>
                  
                  </tbody>
                  <tfoot>
                  	<tr>
                    <td><h5>รวมรายการทั้งหมด</h5></td>
                    <td><h5>300</h5></td>
                    
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">รายละเอียดเพิ่มเติม</a>
              <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a> -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
  	</div>
  	 
  </div>
</div>
