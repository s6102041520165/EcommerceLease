<?php

use app\models\Lease;
use app\models\LeaseDetail;
use app\models\OrderDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lease */

$this->title = "รหัสใบเช่า : ".$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lease-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'สัญญาเช่า'), ['contract', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'ลบ'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'คุณต้องการลบรายการนี้ใช่หรือไม่'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'lease_date:date',
            'due_date:date',
            'lease_time:time',
            'due_time:time',
            'description:ntext',
            [
                'attribute' => 'grand_total',
                'value' => function ($data) {
                    return number_format($data->grand_total) . " บาท/1 วัน";
                }
            ],
            'created_at:relativeTime',
            [
                'attribute' => 'created_by',
                'value' => function ($data) {
                    return $data->creator['username'];
                }
            ],
            'updated_at:relativeTime',
        ],
    ]) ?>

    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => LeaseDetail::find()->where(['lease_id' => $model->id]),
    ]);

    $total = Lease::findOne(['id' => $model->id]);
    echo "<h1>รายการสินค้าที่เช่า</h1>";
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
                'attribute' => 'product.price_for_lease',
                'value' => function ($data) {
                    return number_format($data->product['price_for_lease']) . " x " . $data->qty;
                },
            ],
            [
                //'attribute' => 'product.price_for_lease',
                'label' => 'ราคารวม',
                'contentOptions' => ['style' => 'width: 10%;text-align:right'],
                'value' => function ($data) {

                    // show the amount in money format => 50,000.00
                    return number_format($data->product['price_for_lease'] * $data->qty, 2);
                },
                'filter' => false, //disable the filter for this field
                // I create the summary function in my Invoice model
                'footer' => number_format($total->grand_total, 2),
            ],
        ],
        /**/

    ]);

    ?>

</div>