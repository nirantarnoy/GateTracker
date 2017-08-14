<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Transaction */

$this->title = 'แก้ไขรายการรับเข้า: ' . $model->trans_no;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->trans_no, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaction-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelline' => $modelline,
    ]) ?>

</div>
