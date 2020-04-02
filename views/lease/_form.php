<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lease */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lease-form">

    <?php $grand = (isset($grandTotal)) ? $grandTotal : ""; ?>
    <?php $grandTotalVal = (isset($model->grand_total)) ? $model->grand_total : $grand; ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-lg-6">
            <?= $form->field($model, 'lease_date')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'placeholder' => 'วันที่เช่า Exam.1997/01/20']
            ])  ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'due_date')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'placeholder' => 'วันที่คืน Exam.1997/01/20']
            ])  ?>
        </div>

        <div class="col-lg-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-lg-12">
            <?= $form->field($model, 'grand_total')->textInput(['readonly' => true, 'value' => $grandTotalVal]) ?>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>