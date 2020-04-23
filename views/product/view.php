<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

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
            'name',
            [
                'attribute' => 'picture',
                'format' => 'raw',
                'value' => function ($data) {
                    $imageList = explode(",", $data->picture);
                    $result = '<div class="col-lg-12>"<img src="' . Yii::getAlias('@web/../../image/') . $imageList[0] . '"
                    style="width:150px;height:auto" class="img-thumbnail" /></div>';
                    for ($i = 0; $i < sizeof($imageList); $i++) {
                        $result .= '<div class="col-lg-4 col-md-4 col-sm-4">';

                        $result .= '<a href="' . Yii::getAlias('@web/image/') . $imageList[$i] . '" class="product-thumbnail">';
                        $result .= '<img src="' . Yii::getAlias('@web/image/') . $imageList[$i] . '" alt="' . $imageList[$i] . '" class="img-thumbnail" style="width:50px height:auto">';
                        $result .= '</a>';

                        $result .= '</div>';
                    }
                    return $result;
                }
            ],
            'description',
            'purchase_price',
            'price_for_order',
            'price_for_lease',
            'stock',
            [
                'attribute' => 'created_by',
                'value' => function ($data) {
                    return $data->creator['username'];
                }
            ],
            'created_at:relativeTime',
            [
                'attribute' => 'updated_by',
                'value' => function ($data) {
                    return $data->creator['username'];
                }
            ],
            'updated_at:relativeTime',
            [
                'attribute' => 'category_id',
                'value' => function ($data) {
                    return $data->category['name'];
                }
            ]
        ],
    ]) ?>

</div>