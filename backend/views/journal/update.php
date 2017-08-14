<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Journal */

$this->title = 'แก้ไขรายการเข้า-ออก: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'รายการเข้า-ออก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="journal-update">

    <h1><?php //echo  Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
