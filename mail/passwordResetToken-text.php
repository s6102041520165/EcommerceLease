<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
สวัสดีคุณ <?= $user->username ?>,

กรุณากดลิงค์ด้านล่างเพื่อเปลี่ยนรหัสผ่าน:

<?= $resetLink ?>
