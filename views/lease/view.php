<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lease */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lease-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            'description:ntext',
            [
                'attribute' => 'grand_total',
                'value' => function ($data) {
                    return number_format($data->grand_total);
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

</div>