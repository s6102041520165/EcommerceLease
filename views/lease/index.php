<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LeaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Leases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lease-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Lease'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',

            ['class' => 'app\components\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>