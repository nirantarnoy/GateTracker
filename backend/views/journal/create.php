<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Journal */

$this->title = 'สร้างรายการเข้า-ออก';
$this->params['breadcrumbs'][] = ['label' => 'รายการเข้า-ออก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-create">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'runno' => $runno,
    ]) ?>

</div>
