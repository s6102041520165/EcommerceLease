<?php

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LeaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lease-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'grand_total') ?>
        </div>
        <?php
        $dropdown = ArrayHelper::map(User::find()->all(), 'id', 'username')
        ?>
        <div class="col-lg-4">
            <?= $form->field($model, 'status')->dropDownList([8 => 'กำลังดำเนินการ', 10 => 'ดำเนินการเรียบร้อย'], ['prompt' => '===== ค้นหาด้วยสถานะ =====']) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'created_by')->dropDownList($dropdown, ['prompt' => '===== ค้นหาด้วยผู้ใช้ =====']) ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'lease_date')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'placeholder' => 'วันที่เช่า Exam.1997/01/20']
            ])  ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'lease_time')->widget(\janisto\timepicker\TimePicker::classname(), [
                'mode' => 'time',
                'clientOptions' => [
                    'timeFormat' => 'HH:mm:ss',
                    'showSecond' => true,
                ],
                'options' => ['placeholder' => 'เวลาที่ต้องการรับสินค้า']
            ])  ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'due_date')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'placeholder' => 'วันที่คืน Exam.1997/01/20']
            ])  ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'due_time')->widget(\janisto\timepicker\TimePicker::classname(), [
                'mode' => 'time',
                'clientOptions' => [
                    'timeFormat' => 'HH:mm:ss',
                    'showSecond' => true,
                ],
                'options' => ['placeholder' => 'เวลาที่ต้องการคืนสินค้า']
            ])  ?>
        </div>

        <div class="col-lg-12">

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'ค้นหา'), ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton(Yii::t('app', 'ล้างข้อมูล'), ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>


    
    <?php ActiveForm::end(); ?>

</div>