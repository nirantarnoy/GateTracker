<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use toxor88\switchery\Switchery;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Journal */
/* @var $form yii\widgets\ActiveForm */
$acttype = \backend\models\Contacttype::find()->all();
$cartype = \backend\models\Cartype::find()->all();
?>

<div class="journal-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><?= $this->title?></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-6">
                  <?= $form->field($model, 'journal_no')->textInput(['maxlength' => true,'readonly'=>'readonly','value'=>$model->isNewRecord?$runno:$model->journal_no]) ?>
                  <?php
                      $date_val = date('dd-mm-yyyy');
                      if(!$model->isNewRecord){
                        $date_vale = date('dd-mm-yyyy',$model->trans_date);
                      }
                  ?>
                  <?php $model->isNewRecord?$model->trans_date = date('d-m-Y'):$model->trans_date ?>
                  <?= $form->field($model, 'trans_date')->widget(DatePicker::className(), [ 'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'value' => date('dd-mm-yyyy'),
                        'autoclose' => true,
                        'todayHighlight' => true
                    ], 'options' => ['style' => 'width: 100%']])
                ?>

                <?= $form->field($model, 'activity_id')->widget(Select2::className(),[
                     'data' => ArrayHelper::map($acttype,'id','name'),
                     'options' => ['placeholder'=> 'เลือกประเภทการติดต่อ']
                  ]) ?>

                <?= $form->field($model, 'car_type')->widget(Select2::className(),[
                     'data' => ArrayHelper::map($cartype,'id','name'),
                     'options' => ['placeholder'=> 'เลือกประเภทรถ']
                  ]) ?>

                  <?= $form->field($model, 'car_license_no')->textInput(['maxlength' => true]) ?>

                  <?= $form->field($model, 'status')->textInput() ?>

                  <?= $form->field($model, 'status_reason')->textarea(['rows' => 6]) ?>

                  <?php //echo $form->field($model, 'created_at')->textInput() ?>

                  <?php //echo $form->field($model, 'updated_at')->textInput() ?>

                  <?php //echo $form->field($model, 'created_by')->textInput() ?>

                  <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
    <?php ActiveForm::end(); ?>

</div>
