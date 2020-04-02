<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LeaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'เช่าอุปกรณ์');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lease-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <div class="card card-default">
        <div class="card-body">
            <?php echo $this->render('_search', ['model' => $searchModel]);
            ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'lease_date',
            'due_date',
            'description:ntext',
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
                    $badge = ($data->status === 8) ? "badge-warning" : "badge-success";
                    return "<span class='badge $badge'>" . (($data->status === 8) ? "กำลังดำเนินการ" : "ได้รับการยืนยันแล้ว") . "</span>";
                }
            ],
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',

            ['class' => 'app\components\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>