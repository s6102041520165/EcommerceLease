<?php

use app\models\CartSearch;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lease */

$this->title = Yii::t('app', 'เลือกข้อมูลเช่า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ตะกร้าสินค้า'), 'url' => ['cart/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ยืนยันการสั่งซื้อ'), 'url' => ['cart/checkout']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lease-create">
<h1><?= Html::encode($this->title) ?></h1>

    <ul class="list-group">
        <?php
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $grandTotalOrder = 0;
        $grandTotalLease = 0;
        foreach ($dataProvider->getModels() as $cart) : ?>
            <?php
            $totalOrder = $cart->product['price_for_order'] * $cart->quantity;
            $totalLease = $cart->product['price_for_lease'] * $cart->quantity;
            $image = explode(',', $cart->product['picture']);
            $isMinus = ($cart->quantity > 1) ? "" : "disabled";
            $isPlus = ($cart->quantity >= $cart->product['stock']) ? "disabled" : "";
            ?>
            <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <div>

                        <h5 class="mb-1"><?= $cart->product['name'] ?></h5>

                    </div>


                    <small class="text-right">
                        <span class="text-right">ราคาเช่า : <?= number_format($cart->product['price_for_lease']) ?> / วัน<br /></span>
                        X
                        <?= $cart->quantity ?></span>
                    </small>
                </div>

                <div class="d-flex w-100 justify-content-between">

                    <div class="mb-1">
                        <img style="width: 84px;height:auto" src="<?= Yii::getAlias('@web/image/'); ?><?= $image[0] ?>" class="mr-3">
                    </div>
                    <small class="text-right">
                        <span class="font-weight-bold">
                            ราคาเช่ารวม : <?= number_format($totalLease) ?> / วัน
                        </span>
                    </small>
                </div>


            </li>

        <?php
            $grandTotalLease += $totalLease;
        endforeach; ?>
        <?php if ($grandTotalLease > 0) : ?>
            <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">

                    <div class="mb-1">
                        <h4>ราคารวม</h4>
                    </div>

                    <small class="text-right">
                        
                        <span class="font-weight-bold">
                            ราคาเช่ารวม : <?= number_format($grandTotalLease) ?> บาท / วัน
                        </span>
                    </small>
                </div>
            </li>

        <?php endif ?>


    </ul>
    <br>

    <?php if ($grandTotalLease > 0) : ?>
    

    <?= $this->render('_form', [
        'model' => $model,
        'grandTotal' => $grandTotalLease,
    ]) ?>
    <?php endif; ?>

</div>