<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\Form */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ลงทะเบียน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-ลงทะเบียน">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>กรุณากรอกข้อมูลทุกฟิลด์เพื่อลงทะเบียน</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('ลงทะเบียน', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
