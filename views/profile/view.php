<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = 'ข้อมูลส่วนตัว';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'f_name',
            'l_name',
            [
                'attribute' => 'picture',
                'format' => 'raw',
                'value' => function($data){
                    return "<img src='".Yii::getAlias('@web/image/').$data->picture."' style='max-width:400px;'/>";
                }
            ],
            'dob',
            'address:ntext',
            'subdistrict',
            'district',
            'province',
            'zipcode',
        ],
    ]) ?>

</div>