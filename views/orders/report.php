<?php

use app\models\OrderDetail;
use app\models\Product;
use app\models\Orders;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->title = 'รายงานยอดขาย';


// var_dump($model);

$round = count($model);


// $order_detail = OrderDetail::findAll([
//     'order_id' => $model->id,
// ]);


// $round = count($order_detail);

?>

<div style="font-family: thsarabun;">
    <h3 style="text-align:center;font-weight:bold">รายงานยอดขายตั้งแต่วันที่ <?php echo Yii::$app->formatter->asDate($reportDate[0]);?> ถึง <?php echo Yii::$app->formatter->asDate($reportDate[1]);?></h3>
    <table style="font-family: thsarabun;font-size:16pt;font-family:thsarabun;width:100%;" border="1">
        <tr>
            <th style="text-align: center">#</th>
            <th style="text-align: center">รายการสั่งซื้อที่</th>
            <th style="text-align:center;">วันที่/เวลา</th>
            <th style="text-align: center">ราคา</th>
        </tr>

        <?php
        $total=0;
        for ($i = 0; $i < $round; $i++) {
            $total+=$model[$i]->grand_total;
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $i + 1; ?></td>
                <td><?php echo $model[$i]->id; ?></td>
                <td><?php echo Yii::$app->formatter->asDatetime($model[$i]->created_at); ?></td>
                <td style="text-align: right;"><?php echo number_format($model[$i]->grand_total,2); ?></td>
            </tr>
        <?php
        }
        ?>

        <tr>
            <td colspan="3" style="text-align: right;font-weight:bold;">ยอดเงินที่ขายได้</td>
            <td style="text-align: right;font-weight:bold;">
                <?php echo number_format($total,2); ?>
            </td>
        </tr>
    </table>

</div>