<?php

use kartik\widgets\DatePicker;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'รายงานยอดขายสินค้า';
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['target' => '_blank']]); ?>

    <?= $form->field($model, 'dateInput')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'th',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'placeholder' => 'ปี-เดือน-วัน']
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton(FA::icon('search') . ' ค้นหา', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>