<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">



    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-lg-6">
            <?= $form->field($model, 'f_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'l_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-12">
            <?= $form->field($imageFile, 'imageFiles[]')->fileInput() ?>
        </div>

        <div class="col-lg-12">
            <?= $form->field($model, 'dob')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'placeholder' => '1997/01/20']
            ]) ?>
        </div>

        <div class="col-lg-12">
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'subdistrict')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6">

            <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6">

            <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6">
            <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>
        </div>


        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


</div>