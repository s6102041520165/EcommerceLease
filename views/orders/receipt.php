<?php

use app\models\OrderDetail;
use app\models\Payment;
use app\models\Profile;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->title = 'ใบกำกับภาษี';
?>

<div class="orders-receipt">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div style="text-align: center;font-family:thsarabun;"><h1 style="font-weight: bold">ใบกำกับภาษี</h1></div>
                <div class="row">

                    <div>
                        <h1 class="name" style="font-family:thsarabun;">

                            <?= Yii::$app->name ?>

                        </h1>
                        <div style="font-family:thsarabun; font-size:14pt; ">111/19 หมู่ที่ 4 ถนน ลพบุรีราเมศวร์ อำเภอหาดใหญ่ จังหวัดสงขลา 90110</div>
                    </div>
                </div>
            </header>
            <main>
                <?php
                $profile = Profile::findOne(['user_id' => $model->created_by]);
                $payment = Payment::findOne(['receipt_id' => $model->id]);
                ?>
                <div class="row contacts" style="text-align: right">
                    <div class="col invoice-to">
                        <div class="text-gray-light" style="font-family:thsarabun; font-size:14pt">ออกใบกำกับภาษีให้กับ:</div>
                        <h2 class="to" style="font-family:thsarabun; margin:1px"><?= $model->profile['f_name'] . " " . $model->profile['l_name'] ?></h2>
                        <div class="address" style="font-family:thsarabun; font-size:14pt; ">ตำบล <?= $model->profile['subdistrict'] ?> อำเภอ <?= $model->profile['district'] ?> จังหวัด <?= $model->profile['province'] ?> รหัสไปรษณีย์ <?= $model->profile['zipcode'] ?></div>
                        <div class="email" style="font-family:thsarabun; font-size:14pt; "><a href="mailto:john@example.com"><?= $profile->user['email'] ?></a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id" style="font-family:thsarabun; ">เลขที่ใบกับกำภาษี : <?= str_pad($model->id, 6, 0, STR_PAD_LEFT) ?></h1>
                        <div style="font-family:thsarabun; font-size:14pt; ">สถานะการชำระเงิน :
                            <?php if (isset($payment) || $model->status === 10) {
                                echo ($model->status === 9) ? "กำลังดำเนินการ" : "ชำระเงินแล้ว";
                            } else echo "ยังไม่ชำระเงิน" ?>
                        </div>
                        <div style="font-family:thsarabun; font-size:14pt; ">วันที่ออกใบเสร็จ : <?= Yii::$app->formatter->asDatetime($model->created_at) ?></div>
                    </div>
                </div>
                <?php
                $orderDetail = OrderDetail::find()->where(['order_id' => $model->id])->all();
                ?>
                <table border="0" cellspacing="0" cellpadding="5" style="width: 100%">
                    <thead>
                        <tr style="background-color:steelblue; color:whitesmoke">
                            <th style="font-family:thsarabun; font-size:16pt; border:0.5px solid black; color: white">#</th>
                            <th style="font-family:thsarabun; font-size:16pt; border:0.5px solid black; color: white" class="text-left">รายการสินค้า</th>
                            <th style="font-family:thsarabun; font-size:16pt; border:0.5px solid black; color: white" class="text-right">ราคาสินค้า</th>
                            <th style="font-family:thsarabun; font-size:16pt; border:0.5px solid black; color: white" class="text-right">ราคารวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $num = 1;
                        $grandTotal = 0;
                        $sumTotal = 0;
                        foreach ($orderDetail as $data) :
                            $sumTotal = $data->product['price_for_lease'] * $data->qty;
                        ?>
                            <tr>
                                <td class="no" style="font-family:thsarabun; font-size:14pt; border:0.5px solid black"><?= $num; ?></td>
                                <td class="text-left" style="font-family:thsarabun; font-size:14pt; border:0.5px solid black">
                                    <?= $data->product['name']; ?>
                                </td>
                                <td style="font-family:thsarabun; font-size:14pt; border:0.5px solid black;text-align:right"><?=number_format($data->product['price_for_lease']); ?> x <?= $data->qty; ?></td>
                                <td style="font-family:thsarabun; font-size:14pt;text-align:right; border:0.5px solid black"><?= number_format($sumTotal, 2); ?> บาท</td>
                            </tr>
                        <?php
                            $num++;
                            $grandTotal += $sumTotal;
                        endforeach; ?>


                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="font-family:thsarabun; font-size:16pt; text-align:right; border:0.5px solid black">ราคาสุทธิ</th>
                            <td style="font-family:thsarabun; font-size:16pt;text-align:right; border:0.5px solid black"><?= $grandTotal; ?></td>
                        </tr>

                    </tfoot>
                </table>
                <br><br>

            </main>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
    <?php

    /* $jsScript = <<< JS
        $('#printInvoice').click(function() {
            Popup($('.invoice')[0].outerHTML);
            
            function Popup(data) {
                window.print();
                return true;
            }
        })
    JS;
    $this->registerJs(
        $jsScript,
        View::POS_READY,
        'my-button-handler'
    ); */
    ?>

</div>