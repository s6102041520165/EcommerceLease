<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ตะกร้าสินค้า');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

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

            ['class' => 'yii\grid\ActionColumn'],
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
                        <?= Html::a(FA::icon('trash'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm ',
                            'data' => [
                                'confirm' => Yii::t('app', 'คุณต้องการลบรายการนี้ใช่หรือไม่'),
                                'method' => 'post',
                            ],
                        ]) ?>
                        <h5 class="mb-1"><?= $model->product['name'] ?></h5>

                    </div>


                    <small class="text-right">

                        <span class="text-right">ราคาสั่งซื้อ : <?= number_format($model->product['price_for_order']) ?> <br /></span>
                        <span class="text-right">ราคาเช่า : <?= number_format($model->product['price_for_lease']) ?> <br /></span>
                        X
                        <?= Html::a(FA::icon('minus'), ['cart/minus', 'id' => $model->id], $options = ['class' => "btn btn-primary btn-sm $isMinus", 'data-method' => 'post']) ?>
                        <span style="margin: 5px"><?= $model->quantity ?></span>
                        <?= Html::a(FA::icon('plus'), ['cart/plus', 'id' => $model->id], $options = ['class' => "btn btn-primary btn-sm $isPlus", 'data-method' => 'post']) ?>
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

    <div class="text-right">
        <?php if ($grandTotalOrder > 0 || $grandTotalLease > 0) : ?>
            <?= Html::a(FA::icon('chevron-circle-right') . ' ขั้นตอนถัดไป', ['cart/checkout'], $options = ['class' => 'btn btn-warning btn-lg']) ?>
        <?php endif; ?>
    </div>



</div>