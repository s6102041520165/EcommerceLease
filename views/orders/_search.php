<?php

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

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
            <?= $form->field($model, 'status')->dropDownList([9 => 'กำลังดำเนินการ', 10 => 'ดำเนินการเรียบร้อย'], ['prompt' => '===== ค้นหาด้วยสถานะ =====']) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'created_by')->dropDownList($dropdown, ['prompt' => '===== ค้นหาด้วยผู้ใช้ =====']) ?>
        </div>

        <?php // echo $form->field($model, 'created_by') 
        ?>

        <?php // echo $form->field($model, 'updated_by') 
        ?>
        <div class="col-lg-12">

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>