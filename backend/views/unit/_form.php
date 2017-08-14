<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><?= $this->title?></div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'']]) ?>
          </div>
        </div>


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

    <?php ActiveForm::end(); ?>

</div>
