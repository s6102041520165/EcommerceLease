<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผู้ใช้';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="panel panel-default">
        <div class="panel-body">

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'username',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    //'email:email',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return ($data->status == 9) ? "ไม่ได้ใช้งาน" : "ใช้งาน";
                        }
                    ],
                    'created_at:relativeTime',
                    'updated_at:relativeTime',
                    //'verification_token',

                    ['class' => 'app\components\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>