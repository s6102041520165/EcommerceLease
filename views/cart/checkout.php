<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ยืนยันการสั่งซื้อ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ตะกร้าสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]);
    //var_dump($dataProvider->getModels()) 
    ?>

    <?php /* echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'created_by',
            'created_at',
            'updated_by',
            //'updated_at',
            //'quantity',

            ['class' => 'app\components\grid\ActionColumn'],
        ],
    ]); */ ?>
    <ul class="list-group">
        <?php
        $grandTotalOrder = 0;
        $grandTotalLease = 0;
        foreach ($dataProvider->getModels() as $model) : ?>
            <?php
            $totalOrder = $model->product['price_for_order'] * $model->quantity;
            $totalLease = $model->product['price_for_lease'] * $model->quantity;
            $image = explode(',', $model->product['picture']);
            $isMinus = ($model->quantity > 1) ? "" : "disabled";
            $isPlus = ($model->quantity >= $model->product['stock']) ? "disabled" : "";
            ?>
            <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <div>

                        <h5 class="mb-1"><?= $model->product['name'] ?></h5>

                    </div>


                    <small class="text-right">

                        <span class="text-right">ราคาสั่งซื้อ : <?= number_format($model->product['price_for_order']) ?> <br /></span>
                        <span class="text-right">ราคาเช่า : <?= number_format($model->product['price_for_lease']) ?> <br /></span>
                        X
                        <?= $model->quantity ?></span>
                    </small>
                </div>

                <div class="d-flex w-100 justify-content-between">

                    <div class="mb-1">
                        <img style="width: 84px;height:auto" src="<?= Yii::getAlias('@web/image/'); ?><?= $image[0] ?>" class="mr-3">
                    </div>
                    <small class="text-right">
                        <span class="font-weight-bold">
                            ราคาสั่งซื้อรวม : <?= number_format($totalOrder) ?>
                        </span><br />
                        <span class="font-weight-bold">
                            ราคาเช่ารวม : <?= number_format($totalLease) ?>
                        </span>
                    </small>
                </div>


            </li>

        <?php
            $grandTotalLease += $totalLease;
            $grandTotalOrder += $totalOrder;
        endforeach; ?>
        <?php if ($grandTotalOrder > 0 || $grandTotalLease > 0) : ?>
            <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">

                    <div class="mb-1">
                        <h4>ราคารวม</h4>
                    </div>

                    <small class="text-right">
                        <span class="font-weight-bold">
                            ราคาสั่งซื้อรวม : <?= number_format($grandTotalOrder) ?> บาท
                        </span><br />
                        <span class="font-weight-bold">
                            ราคาเช่ารวม : <?= number_format($grandTotalLease) ?> บาท
                        </span>
                    </small>
                </div>
            </li>

        <?php endif ?>


    </ul>
    <br>

    <div class="card card-primary">
        <div class="card-header">
            ข้อมูลลูกค้า
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($profile, 'f_name')->textInput(['maxlength' => true]) ?>

                </div>

                <div class="col-lg-6">
                    <?= $form->field($profile, 'l_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-12">
                    <?= $form->field($profile, 'address')->textarea() ?>
                </div>

                <div class="col-lg-12">
                    <?= $form->field($profile, 'telephone')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-3">
                    <?= $form->field($profile, 'subdistrict')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-3">
                    <?= $form->field($profile, 'district')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-3">
                    <?= $form->field($profile, 'province')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-3">
                    <?= $form->field($profile, 'zipcode')->textInput(['maxlength' => true]) ?>

                </div>

                <?php if ($grandTotalOrder > 0 || $grandTotalLease > 0) : ?>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="text-center">
                            <?= Html::submitButton(FA::icon('shopping-cart') . ' สั่งซื้อ '.number_format($grandTotalOrder)." บาท", ['class' => 'btn btn-primary','name' => 'typeButton','value' => 'order']) ?>
                            <?= Html::a(FA::icon('arrow-right') . ' เช่า '.number_format($grandTotalLease)." บาท", ['lease/create'], ['class' => 'btn btn-warning']) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php Pjax::end(); ?>

</div>