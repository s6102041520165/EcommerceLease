<?php

use app\models\Bank;
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

    <?php $receipt = ArrayHelper::map(Orders::findAll(
        [
            'created_by' => Yii::$app->user->id,
            'status' => 9
        ],
    ), 'id', function ($data) {
        return $data->id . " - " . $data->creator['username'];
    }) ?>

    <?php $bank = ArrayHelper::map(Bank::find()->all(), 'id', function ($data) {
        return $data->account_number . " - " . $data->account_name . " - " . $data->bank;
    }) ?>

    <?= $form->field($model, 'receipt_id')->dropDownList($receipt, ['prompt' => 'กรุณาเลือกเลขที่ใบเสร็จ']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'destination_bank')->dropDownList($bank, ['prompt' => '===== กรุณาเลือกธนาคารที่โอน =====']) ?>

    <div class="col-lg-12">
        <?= $form->field($imageFile, 'imageFiles[]')->fileInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>