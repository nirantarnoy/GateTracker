<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Usergroup */

$this->title = 'สร้างกลุ่มผู้ใช้';
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มผู้ใช้งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usergroup-create">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
