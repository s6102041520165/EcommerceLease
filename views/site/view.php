<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'สินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$imageList = explode(',', $model->picture);
?>
<div class="product-view">

    <div class="row">
        <div class="col-lg-4">
            <img src="<?= Yii::getAlias('@web/image/') . $imageList[0]; ?>" alt="<?= $imageList[0] ?>" class="img-thumbnail" id="product-profile">
            <div class="row" style="margin: 5px 0px">
                <?php for ($i = 0; $i < sizeof($imageList); $i++) : ?>
                    <div class="col-lg-4 col-md-4 col-sm-4">

                        <a href="<?= Yii::getAlias('@web/image/') . $imageList[$i]; ?>" class="product-thumbnail">
                            <img src="<?= Yii::getAlias('@web/image/') . $imageList[$i]; ?>" alt="<?= $imageList[$i] ?>" class="img-thumbnail">
                        </a>

                    </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="col-lg-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'description',
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
            <?php $isBuy = ($model->stock > 0) ? "btn btn-primary" : "btn btn-primary disabled"; ?>
            <?= Html::a(FA::icon('shopping-cart') . ' หยิบใส่ตะกร้า', ['product/cart', 'id' => $model->id], ['data-method' => 'post', 'class' => $isBuy]) ?>


        </div>
    </div>

    <?php
    $script = "
        $('.product-thumbnail').on('click', function() { 
            $('#product-profile').attr('src',$(this).attr('href'));
            //console.log($(this).attr('href'))
            //alert('Button clicked!'); 
            return false; 
        });
    ";
    $css = "
        .product-thumbnail:hover{
            filter: grayscale(100%);
        }
    ";

    $this->registerCss($css);
    $this->registerJs(
        $script,
        View::POS_READY,
        'view-product-button-handler'
    );
    ?>

</div>