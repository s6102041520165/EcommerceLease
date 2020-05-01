<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="lease-check-return">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'product_status')->dropDownList([0 => 'ใช้งานได้', 1 => 'อุปกรณ์ชำรุด'], ['prompt' => '===== เลือกสถานะอุปกรณ์ =====']) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>