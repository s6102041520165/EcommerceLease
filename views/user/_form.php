<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->dropDownList(['customer' => 'ลูกค้า', 'employee' => 'พนักงาน', 'admin' => 'ผู้ดูแลระบบ'],[
        'prompt' => 'กรุณาเลือกสิทธิผู้ใช้',
        'value'=> array_keys(Yii::$app->authManager->getRolesByUser($model->id))[0]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>