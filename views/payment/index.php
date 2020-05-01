<?php

use app\models\Bank;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'แจ้งชำระเงิน');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'แจ้งชำระเงิน'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <h3>คุณสามารถแจ้งชำระเงินมาที่บัญชีดังนี้</h3>
    <?php
    $bankProvider = new ActiveDataProvider([
        'query' => Bank::find(),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);
    echo GridView::widget([
        'dataProvider' => $bankProvider,
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'ค้นหา',
            ],

            'id',
            'receipt_id',
            'name',
            'location',
            'source_bank',
            //'destination_bank',
            //'slip',

            ['class' => 'app\components\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>