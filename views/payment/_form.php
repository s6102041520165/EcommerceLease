<?php

use app\models\Orders;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $receipt = ArrayHelper::map(Orders::findAll(['created_by' => Yii::$app->user->id]), 'id', function ($data) {
        return $data->id . " - " . $data->creator['username'];
    }) ?>

    <?= $form->field($model, 'receipt_id')->dropDownList($receipt, ['prompt' => 'กรุณาเลือกเลขที่ใบเสร็จ']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'destination_bank')->textInput() ?>

    <?= $form->field($model, 'slip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>