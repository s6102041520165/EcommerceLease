<?php

use app\models\Profile;
use app\models\Lease;
use app\models\LeaseDetail;

$profile = Profile::findOne(['user_id' => $model->created_by]);
$lesae = LeaseDetail::findAll(['lease_id' => $model->id]);


$age = date("Y") - ((int) Yii::$app->formatter->asDate($profile->dob, 'yyyy'));
$address = str_replace(" ", "..........", $profile->address) . "<dottab/><br/>" . "ต." . $profile->subdistrict . "................" . "อ." . $profile->district . ".............." . "จ." . $profile->province . "........" . $profile->zipcode . "<dottab/>";

$arr = [];
foreach ($lesae as $data) {
    array_push($arr, $data->product['name']);
}

$dataString = implode(",", $arr);


?>
<div class="container" style="font-family:thsarabun;">
    <h4 style="text-align: center;font-weight:bold;font-size:16pt;font-family:thsarabun;"><strong>สัญญาค้ำประกันเช่าอุปกรณ์ถ่ายภาพ<br>ร้านเช่ากล้อง ปัตตานี</strong></h4>
    <p style="display:block;text-align: right;font-size:16pt;margin-top:30px;">
        เขียนที่.....................................<br>
        วันที่.....<?php echo Yii::$app->formatter->asDate(time(), 'php:d F Y') ?>...........................................
    </p>
    <p style="text-indent: 30px;text-align:justify;font-size:16pt;margin:0px;margin-top:20px">ข้าพเจ้า.....<?php echo "คุณ" . $profile->f_name . " " . $profile->l_name; ?>...........อายุ.......<?php echo $age . " " ?>ปี
        <dottab /><br />
        สัญชาติ
        .........ไทย
        .....ที่อยู่
        <?= $address ?>
        <br />
        โทรศัพท์ที่บ้าน.............................โทรศัพท์มือถือ................<?= $profile->telephone ?>
        <dottab /><br />
        ที่อยู่ที่ทำงาน/โรงเรียน..........................................................Facebook
        <dottab /><br />
        ขอทำสัญญานี้เพื่อค้ำประกันการเช่าอุปกรณ์ถ่ายภาพของ
        <dottab />(ผู้เช่า)
        ต่อร้าน เช่ากล้อง ปัตตานี<br>
        เวลาเช่า....<?php echo $model->lease_date ?>..<?= $model->lease_time ?>.............เวลาคืน....<?php echo $model->due_date ?>..<?= $model->due_time; ?>
        <dottab /><br />
        อุปกรณ์ที่เช่า.....<?php echo $dataString; ?>
        <dottab />
    </p>
    <h3 style="margin-top:0px;text-indent:30px;text-align: justify;font-weight:bold;font-size:16pt">ในกรณีที่ผู้เช่าไม่สามารถนำของมาคืนตามกำหนดได้หรือทำของชำรุดเสียหายรวมทั้งผิดสัญญาเช่าข้าพเจ้ายินดีรับผิดชอบชำระหนี้แทนให้เสร็จสิ้นภายใน 10 วัน</h3>
    <h3 style="text-indent:30px;font-weight:bold;font-size:16pt">หากส่งอุปกรณ์ไม่ตรงตามเวลาที่กำหนด จะต้องจ่ายค่าปรับชั่วโมงละ 50 บาท</h3>
    <div>
        <br /><br />
        <table align="center" style="width: 100%">
            <tr>
                <td width="50%">
                    <div style="text-align: center;font-size:16pt;font-family:thsarabun;">
                        ลงชื่อ................................................ ผู้เช่า<br />
                        (.......................................................................)
                    </div>
                </td>
                <td width="50%">
                    <div style="text-align: center;font-size:16pt;font-family:thsarabun;">
                        ลงชื่อ................................................ ผู้ให้เช่า<br />
                        (........................................................................)
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>