<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property int $id
 * @property string $account_number
 * @property string $account_name
 * @property string $bank
 *
 * @property Payment[] $payments
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account_number', 'account_name', 'bank'], 'required'],
            [['account_number', 'account_name', 'bank'], 'string', 'max' => 255],
            [['account_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสอ้างอิง'),
            'account_number' => Yii::t('app', 'เลขบัญชีธนาคร'),
            'account_name' => Yii::t('app', 'ชื่อบัญชีธนาคร'),
            'bank' => Yii::t('app', 'ธนาคาร'),
        ];
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['destination_bank' => 'id']);
    }
}
