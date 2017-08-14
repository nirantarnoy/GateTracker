<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Userrole */

$this->title = 'แก้ไขสิทธิ์การใช้งาน: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'สิทธิ์การใช้งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userrole-update">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
