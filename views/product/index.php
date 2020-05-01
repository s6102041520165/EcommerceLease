<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'สินค้า');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'เพิ่มสินค้า'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'ค้นหา',
            ],
            'id',
            'name',
            //'description:ntext',
            'purchase_price',
            'price_for_order',
            'price_for_lease',
            [
                'attribute' => 'stock',
                'value' => function ($data) {
                    return $data->stock . " " . $data->unit_name;
                }
            ],
            //'unit_name',
            //'category_id',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

            ['class' => 'app\components\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>