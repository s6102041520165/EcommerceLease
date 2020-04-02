<?php

use app\models\OrderDetail;
use app\models\Orders;
use app\models\Payment;
use rmrevin\yii\fontawesome\FA;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียดใบสั่งซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">
    <h1>รายละเอียดใบสั่งซื้อ <?= str_pad($model->id, 6, 0, STR_PAD_LEFT); ?></h1>
    <?php echo Html::a(FA::icon('print') . ' พิมพ์ใบกำกับภาษี', ['receipt', 'id' => $model->id], [
        'class' => 'btn btn-primary',
        'target' => '_blank',
    ]) ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'grand_total',
            [
                'attribute' => 'created_by',
                'value' => function ($data) {
                    return $data->creator['username'];
                }
            ],
            'created_at:relativeTime',
            'updated_at:relativeTime',
            //'created_by',
            //'updated_by',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->status === 9) {
                        return "<span class=\"badge badge-danger\" >ยังไม่ได้ยืนยัน</span>";
                    } else {
                        return "<span class=\"badge badge-success\" >ยืนยันแล้ว</span>";
                    }
                }
            ],
        ],
    ]) ?>

    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => OrderDetail::find()->where(['order_id' => $model->id]),
    ]);

    $total = Orders::findOne(['id' => $model->id]);
    echo "<h1>รายการสินค้าที่สั่งซื้อ</h1>";
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => TRUE,
        'footerRowOptions' => ['style' => 'font-weight:bold;text-align:right'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'product_id',
                'value' => function ($data) {
                    return $data->product['name'];
                }
            ],
            [
                'attribute' => 'product.price_for_order',
                'value' => function ($data) {
                    return number_format($data->product['price_for_order']) . " x " . $data->qty;
                },
            ],
            [
                //'attribute' => 'product.price_for_order',
                'label' => 'ราคารวม',
                'contentOptions' => ['style' => 'width: 10%;text-align:right'],
                'value' => function ($data) {

                    // show the amount in money format => 50,000.00
                    return number_format($data->product['price_for_order'] * $data->qty, 2);
                },
                'filter' => false, //disable the filter for this field
                // I create the summary function in my Invoice model
                'footer' => number_format($total->grand_total, 2),
            ],
        ],
        /**/

    ]);

    $paymentProvider = new ActiveDataProvider([
        'query' => Payment::find()->where(['receipt_id' => $model->id]),
    ]);

    echo "<h1>หลักฐานชำระเงิน</h1>";

    echo GridView::widget([
        'dataProvider' => $paymentProvider,
        'columns' => [

            //'id',
            'receipt_id',
            'name',
            'location',
            'source_bank',
            [
                'attribute' => 'slip',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<a target='_blank' href='" . Yii::getAlias('@web/image/') . $data->image . "'><img src='" . Yii::getAlias('@web/image/') . $data->image . "' style='width:250px;height:auto' class='thumbnail' /></a>";
                }
            ],

        ],

    ]);
    ?>


</div>