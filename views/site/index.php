<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <div class="container">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "<div class='col-lg-12 col-sm-12 col-md-12 col-xl-12 col-xs-12'>{summary}</div>{items}<div class='col-lg-12 col-sm-12 col-md-12 col-xl-12 col-xs-12'>{pager}</div>",
            'options' => ['class' => 'row', 'style' => 'display: flex;
                align-items: left;
                justify-content: left;
                flex-direction: row;
                flex-wrap: wrap;
                flex-flow: row wrap;
                align-content: flex-end;'],
            'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-xl-3 col-sm-6 col-xs-12', 'style' => 'display: flex;'],
            'itemView' => '_list_product',
        ]); ?>
    </div>
</p>