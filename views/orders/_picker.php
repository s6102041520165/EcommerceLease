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

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'dateStart')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'placeholder' => 'ปี-เดือน-วัน']
            ]) ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'dateEnd')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'placeholder' => 'ปี-เดือน-วัน']
            ]) ?>
        </div>


        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton(FA::icon('search') . ' ค้นหา', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>