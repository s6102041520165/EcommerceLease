<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>สวัสดีคุณ <?= Html::encode($user->username) ?>,</p>

    <p>กรุณากดลิงค์ด้านล่างเพื่อเปลี่ยนรหัสผ่าน:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
