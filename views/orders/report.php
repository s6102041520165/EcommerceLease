<?php

use app\models\OrderDetail;
use app\models\Product;
use app\models\Orders;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->title = 'รายงานยอดขาย';
$order_detail = OrderDetail::findAll(['order_id' => $model->id]);


$round = count($order_detail);

?>

<div style="font-family: thsarabun;">
    <h3 style="text-align:center;font-weight:bold">รายงานยอดขาดวันที่ <?php echo date("d-M-Y", $model->created_at) ?></h3>
    <table style="font-family: thsarabun;font-size:16pt;font-family:thsarabun;width:100%;" border="1">
        <tr>
            <th style="text-align: center">#</th>
            <th style="text-align: center">รายการ</th>
            <th style="text-align: center">จำนวนที่สั่งซื้อ</th>
            <th style="text-align: center">ราคา</th>
            <th style="text-align: center">ราคารวม</th>
        </tr>
        <?php
        $total=0;
        for ($i = 0; $i < $round; $i++) {
            $product = Product :: findOne(['id' => $order_detail[$i]->product_id]);
            $total += $product->price_for_order * $order_detail[$i]->qty;
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i+1; ?></td>
                <td><?php echo $product->name; ?></td>
                <td style="text-align: right;"><?php echo number_format($product->price_for_order,2); ?></td>
                <td style="text-align: right;"><?php echo number_format($order_detail[$i]->qty,2); ?></td>
                <td style="text-align: right;"><?php echo number_format($product->price_for_order * $order_detail[$i]->qty,2); ?></td>
            </tr>
            <?php
        }   
        ?>
        <tr>
            <td colspan="4" style="text-align: right;">ยอดเงินที่ขายได้</td>
            <td style="text-align: right;">
                <?php echo number_format($total,2); ?>
            </td>
        </tr>
    </table>

</div>