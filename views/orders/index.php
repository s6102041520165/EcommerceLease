<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ประวัติการสั่งซื้อ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'created_by',
                'value' => function ($data) {
                    return $data->creator['username'];
                }
            ],
            [
                'attribute' => 'grand_total',
                'value' => function ($data) {
                    return number_format($data->grand_total);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {
                    $badge = ($data->status === 9) ? "badge-warning" : "badge-success";
                    return "<span class='badge $badge'>" . (($data->status === 9) ? "กำลังดำเนินการ" : "ได้รับการยืนยันแล้ว") . "</span>";
                }
            ],
            'created_at:relativeTime',
            //'created_by',
            //'updated_by',

            ['class' => 'app\components\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>