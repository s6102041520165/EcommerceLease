<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */

$dataId = (isset($id)) ? $id : "";
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
    $categories = ArrayHelper::map(\app\models\Category::find()
        ->where(['<>', 'id', $dataId])
        ->all(), 'id', 'name') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <span class="text-danger">
        หากไม่เลือก หมายถึงให้ประเภทสินค้าเป็นเมนูหลัก
    </span>
    <?= $form->field($model, 'sub_category')->dropDownList($categories, ['prompt' => '=====ประเภทสินค้าหลัก=====']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>