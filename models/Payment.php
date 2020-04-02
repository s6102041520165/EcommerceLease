<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property int $receipt_id
 * @property string $name
 * @property string|null $location
 * @property string $source_bank
 * @property int $destination_bank
 * @property string $slip
 *
 * @property Bank $destinationBank
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_id', 'name', 'source_bank', 'destination_bank', 'slip'], 'required'],
            [['receipt_id', 'destination_bank','created_by','updated_by'], 'integer'],
            [['name', 'location', 'source_bank', 'slip'], 'string', 'max' => 255],
            [['destination_bank'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['destination_bank' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสอ้างอิง'),
            'receipt_id' => Yii::t('app', 'เลขที่ใบเสร็จ'),
            'name' => Yii::t('app', 'ชื่อบัญชี'),
            'location' => Yii::t('app', 'สาขาที่โอน'),
            'source_bank' => Yii::t('app', 'ธนาคารที่โอน'),
            'destination_bank' => Yii::t('app', 'โอนไปยังธนาคาร'),
            'slip' => Yii::t('app', 'สลิป'),
            'created_by' => Yii::t('app', 'เพิ่มโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย')
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className()
        ];
    }

    /**
     * Gets query for [[DestinationBank]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['id' => 'destination_bank']);
    }
}
