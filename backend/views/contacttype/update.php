<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Contacttype */

$this->title = 'แก้ไขประเภทการติดต่อ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'ประเภทติดต่อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contacttype-update">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
