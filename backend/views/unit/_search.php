<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'name') ?>

    <?php // $form->field($model, 'description') ?>

    <?php // $form->field($model, 'status') ?>

    <?php // $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <!-- <div class="form-group">
        <?php // Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php // Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div> -->
    <div class="input-group">
    <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
             <?= $form->field($model, 'globalSearch')->textInput(['placeholder'=>'Search','class'=>'form-control','aria-describedby'=>'basic-addon1'])->label(false) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
