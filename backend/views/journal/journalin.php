<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = "แจ้งรถเข้า";

$acttype = \backend\models\Contacttype::find()->all();
$cartype = \backend\models\Cartype::find()->all();
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3> <i class="fa fa-truck"></i> แจ้งรถเข้า </h3>
  </div>
  <div class="panel-body">
    <?php $form = ActiveForm::begin(['action'=>['create'],'method'=>'post']); ?>

    <?= $form->field($model, 'activity_id')->widget(Select2::className(),[
         'data' => ArrayHelper::map($acttype,'id','name'),
         'options' => ['placeholder'=> 'เลือกประเภทการติดต่อ']
      ]) ?>

    <?= $form->field($model, 'car_type')->widget(Select2::className(),[
         'data' => ArrayHelper::map($cartype,'id','name'),
         'options' => ['placeholder'=> 'เลือกประเภทรถ']
      ]) ?>

      <?= $form->field($model, 'car_license_no')->textInput(['maxlength' => true]) ?>

      <div class="form-group">
          <?= Html::submitButton('แจ้งรถเข้า', ['class' => 'btn btn-success']) ?>
      </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>
