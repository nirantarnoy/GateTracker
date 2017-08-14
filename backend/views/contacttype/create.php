<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Contacttype */

$this->title = 'สร้างประเภทการติดต่อ';
$this->params['breadcrumbs'][] = ['label' => 'ประเภทการติดต่อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacttype-create">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
