<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\NotificationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

     <div class="input-group">
    <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
             <?= $form->field($model, 'globalSearch')->textInput(['placeholder'=>'Search','class'=>'form-control','aria-describedby'=>'basic-addon1'])->label(false) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
