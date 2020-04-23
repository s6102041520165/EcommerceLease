<?php

use app\models\OrderDetail;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
?>
<div class="card card-default product-thumbnail" style="margin: 10px 0px;padding:5px;">
    <?php $image = explode(",", $model->picture); ?>
    <div class="card-body text-center">
        <img class="img-thumbnail rounded" src="<?= Yii::getAlias('@web/image/') . $image[0]; ?>" alt="">

       
        <h3><?= $model->name; ?></h3>
        <p class="text-danger">ราคาสั่งซื้อ <?= number_format($model->price_for_order) ?> บาท<br />ราคาเช่า <?= number_format($model->price_for_lease) ?> บาท</p>
        <?php
        $isBuy = ($model->stock > 0) ? "btn btn-warning" : "btn disabled btn-danger";
        ?>
        <footer class="blockquote-footer">คงเหลือ : <cite title="Source Title"><?= $model->stock ?> <?= $model->unit_name ?></cite></footer>


    </div>

    <div class="card-footer text-center bg-white">
        <div style="margin:5px">
            <?= Html::a(FA::icon('shopping-cart') . ' หยิบใส่ตะกร้า', ['product/cart', 'id' => $model->id], ['data-method' => 'post', 'class' => $isBuy, ]) ?>
        </div>

        <div style="margin:5px">
            <?= Html::a(FA::icon('eye') . ' รายละเอียด', ['view', 'id' => $model->id], ['class' => 'btn btn-warning',]) ?>
        </div>
    </div>
</div>