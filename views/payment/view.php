<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'แจ้งชำระเงิน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'receipt_id',
            'name',
            'location',
            'source_bank',
            [
                'attribute' => 'destination_bank',
                'value' => function($data){
                    return $data->bank['account_number']. " - ". $data->bank['account_name'] . " - ".$data->bank['bank'];
                }
            ],
            [
                'attribute' => 'slip',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<img src='" . Yii::getAlias('@web/image/') . $data->slip . "' style='width:150px;height:auto'/>";
                }
            ],
        ],
    ]) ?>

</div>