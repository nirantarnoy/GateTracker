<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
$cat = \backend\models\Category::find()->all();
$units = \backend\models\Unit::find()->all();
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><?= $this->title?></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-6">
                    <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'category_id')->widget(Select2::className(),[
                         'data' => ArrayHelper::map($cat,'id','name'),
                         'options' => ['placeholder'=> 'เลือกหมวดสินค้า']
                      ]) ?>

                    <?= $form->field($model, 'weight')->textInput() ?>

                    <?= $form->field($model, 'unit_id')->widget(Select2::className(),[
                         'data' => ArrayHelper::map($units,'id','name'),
                         'options' => ['placeholder'=> 'เลือกหน่วยนับ']
                      ]) ?>

                    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

                      <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status')->widget(Switchery::className(),['options'=>['label'=>'']]) ?>


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
