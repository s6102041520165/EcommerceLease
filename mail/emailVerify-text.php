<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
สวัสดีคุณ <?= $user->username ?>,

กรุณากดลิงค์ด้านล่างเพื่อยืนยันอีเมล:

<?= $verifyLink ?>
