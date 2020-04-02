<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['orders/verify-order', 'token' => $user->verification_token, 'order_id' => $id]);
?>
<div class="verify-order">
    <p>สวัสดีคุณ <?= Html::encode($user->username) ?>,</p>
    <p>ขอบคุณ คุณ <?=Html::encode($user->profile['f_name']." ".$user->profile['l_name'])?> ที่สั่งซื้อสินค้ากับเรา</p>

    <p>กรุณาคลิกลิงก์ด้านล่างเพื่อยืนยันการสั่งซื้อ:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>