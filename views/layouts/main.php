<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Profile;
use app\widgets\Alert;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;
use yii\bootstrap4\Dropdown;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use yii\web\View;

\app\assets\AppAsset::register($this);

if (!Yii::$app->user->isGuest) {
    $profile = Profile::findOne(['user_id' => Yii::$app->user->id]);
    if (!isset($profile->id) && Yii::$app->controller->id !== "profile") {
        Yii::$app->response->redirect(['profile/create']);
    }
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <div class="heading-content bg-warning">
            <div class="container">

                <div class="row justify-content-end">

                    <?php
                    echo Nav::widget([
                        'items' => [
                            [
                                'label' => 'ข้อมูลส่วนตัว',
                                'visible' => !Yii::$app->user->isGuest,
                                'linkOptions' => ['class' => 'text-white'],
                                'items' => [
                                    ['label' => 'ตะกร้าสินค้า', 'url' => ['cart/index'],],
                                    ['label' => 'ประวัติการสั่งซื้อ', 'url' => ['orders/index'],],
                                    ['label' => 'ประวัติการเช่าสินค้า', 'url' => ['lease/index'],],
                                    ['label' => 'แจ้งชำระเงิน', 'url' => ['payment/index'],],
                                    '<div class="dropdown-divider"></div>',
                                    '<div class="dropdown-header">ข้อมูลส่วนตัว</div>',
                                    [
                                        'label' => 'แก้ไขข้อมูลส่วนตัว',
                                        'url' => ['profile/update'],
                                    ],
                                    [
                                        'label' => 'เปลี่ยนรหัสผ่าน',
                                        'url' => ['site/request-password-reset'],
                                    ],
                                    [
                                        'label' => 'ออกจากระบบ',
                                        'url' => ['site/logout'],
                                        'linkOptions' => ['data-method' => 'post']
                                    ],

                                ],

                            ],
                            [
                                'label' => 'เข้าสู่ระบบ',
                                'url' => ['site/login'],
                                'linkOptions' => ['class' => 'text-white'],
                                'visible' => Yii::$app->user->isGuest
                            ],
                        ],
                        //'options' => ['class' => 'nav-pills'], // set this to nav-tab to get tab-styled navigation
                    ]);
                    ?>
                </div>

            </div>

        </div>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'options' => [
                'class' => 'navbar-expand-md navbar-light bg-light nav-shadow',
            ],
        ]);
        echo "<div class='my-2 my-lg-0'>";
        echo Nav::widget([
            'items' => [
                ['label' => 'หน้าแรก', 'url' => ['/site/index']],
                ['label' => 'สินค้า', 'url' => ['/product/index']],
                ['label' => 'ตะกร้าสินค้า', 'url' => ['/cart']],
                ['label' => 'ประวัติเช่ากล้อง', 'url' => ['/lease/index']],
                ['label' => 'ประวัติการสั่งซื้อ', 'url' => ['/orders/index']],
                ['label' => 'ติดต่อเรา', 'url' => ['/site/contact']],
            ],
            'dropdownClass' => Dropdown::classname(), // use the custom dropdown
            'options' => ['class' => 'navbar-nav mr-auto'],
        ]);
        echo "<div>";
        NavBar::end();
        /*NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();*/
        ?>


        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="float-left">&copy; My Company <?= date('Y') ?></p>

            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php
    $url = Url::toRoute(['/site/check-orders']);
    $verify = Url::toRoute(['/site/check-verify']);
    $js = '
    //Body function checkExpireOrder
    function checkExpireOrder(){
        $.ajax({
            method: "GET",
            url: "' . $url . '",
        })
        .done(function( msg ) {
            console.log(msg)
        });

        $.ajax({
            method: "GET",
            url: "' . $verify . '",
        })
        .done(function( msg ) {
            console.log(msg)
        });
    }
    setInterval(checkExpireOrder, 5000)

    ';

    $this->registerJs(
        $js,
        View::POS_READY,
        'my-realtime-handler'
    );
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>