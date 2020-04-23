<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($imageModel, 'imageFiles[]')->fileInput(['multiple' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'purchase_price')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'price_for_lease')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'price_for_lease')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'stock')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>
        </div>
        <?php $categories = ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name') ?>
        <div class="col-lg-12">
            <?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => '===== กรุณาเลือกประเภทสินค้า =====']) ?>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>