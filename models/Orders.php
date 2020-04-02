<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property float $grand_total
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property OrderDetail[] $orderDetails
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grand_total'], 'required'],
            [['grand_total'], 'number'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'grand_total' => Yii::t('app', 'ราคารวม'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สั่งซื้อเมื่อ'),
            'created_by' => Yii::t('app', 'สั่งซื้อโดย'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }


    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);
    }

    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'created_by']);
    }

}
