<?php

use app\models\OrderDetail;
use app\models\Payment;
use app\models\Profile;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->title = 'ใบกำกับภาษี';
?>

<div class="orders-receipt">
    <div class="level1">
        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <header>
                    <div style="text-align: center;font-family:thsarabun;">
                        <h1 style="font-weight: bold">ใบกำกับภาษี</h1>
                    </div>
                    <div class="row">

                        <div>
                            <h1 class="name" style="font-family:thsarabun;">

                                <?= Yii::$app->name ?>

                            </h1>
                            <div style="font-family:thsarabun; font-size:14pt; ">เลขที่ 98/33 ถนน โรงเหล้าสาย ก ตำบล สะบารัง อำเภอเมืองปัตตานี ปัตตานี 94000</div>
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
                            <div class="address" style="font-family:thsarabun; font-size:14pt; "><?= $model->profile['address'] ?> ตำบล <?= $model->profile['subdistrict'] ?> อำเภอ <?= $model->profile['district'] ?> จังหวัด <?= $model->profile['province'] ?> รหัสไปรษณีย์ <?= $model->profile['zipcode'] ?></div>
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
                                $sumTotal = $data->product['price_for_order'] * $data->qty;
                            ?>
                                <tr>
                                    <td class="no" style="font-family:thsarabun; font-size:14pt; border:0.5px solid black"><?= $num; ?></td>
                                    <td class="text-left" style="font-family:thsarabun; font-size:14pt; border:0.5px solid black">
                                        <?= $data->product['name']; ?>
                                    </td>
                                    <td style="font-family:thsarabun; font-size:14pt; border:0.5px solid black;text-align:right"><?= number_format($data->product['price_for_order']); ?> x <?= $data->qty; ?></td>
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
    </div>
    <pagebreak>
        <div style="text-align: center;font-family:thsarabun;">
            <h1 style="font-weight: bold">หลักฐานการชำระเงิน</h1>
        </div>
        <?php
        $paymentProvider = new ActiveDataProvider([
            'query' => Payment::find()->where(['receipt_id' => $model->id]),
        ]);

        foreach ($paymentProvider->getModels() as $getdata) :
        ?>
            <table class="table" style="font-family:thsarabun; font-size:16pt">
                <thead>
                    <tr>
                        <th>ชื่อบัญชี</th>
                        <th>สาขาที่โอน</th>
                        <th>ธนาคารที่โอน</th>
                        <th>สลิป</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?= $getdata->name ?></td>
                        <td><?= $getdata->location ?></td>
                        <td><?= $getdata->source_bank ?></td>
                        <td><img src="<?= Yii::getAlias('@web/image/') . $getdata->slip ?>" style=" width:100px;height:auto" class="thumbnail" />
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php
        endforeach;
        ?>


</div>