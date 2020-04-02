<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['orders/verify-order', 'token' => $user->verification_token, 'order_id' => $id]);
?>
สวัสดีคุณ <?= $user->username ?>,
ขอบคุณ คุณ <?=$user->profile['f_name']." ".$user->profile['l_name']?> ที่สั่งซื้อสินค้ากับเรา

กรุณากดลิงค์ด้านล่างเพื่อยืนยันการสั่งซื้อ:

<?= $verifyLink ?>
