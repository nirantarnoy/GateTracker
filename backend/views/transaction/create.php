<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Transaction */

$this->title = 'สร้างรายการรับสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
