<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'journal_id') ?>

    <?php // echo $form->field($model, 'contact_name') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'company') ?>

    <?php // echo $form->field($model, 'contact_emp') ?>

    <?php // echo $form->field($model, 'contact_number') ?>

    <?php // echo $form->field($model, 'contact_detail') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'document_ref') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

     <div class="input-group">
    <!--         <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>-->
             <?= $form->field($model, 'globalSearch')->textInput(['placeholder'=>'Search','class'=>'form-control','aria-describedby'=>'basic-addon1'])->label(false) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
