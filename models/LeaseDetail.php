<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lease_detail".
 *
 * @property int $id
 * @property int $lease_id
 * @property int $product_id
 * @property int $qty
 *
 * @property Lease $lease
 * @property Product $product
 */
class LeaseDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lease_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lease_id', 'product_id', 'qty'], 'required'],
            [['lease_id', 'product_id', 'qty'], 'integer'],
            [['lease_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lease::className(), 'targetAttribute' => ['lease_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lease_id' => Yii::t('app', 'Lease ID'),
            'product_id' => Yii::t('app', 'สินค้า'),
            'qty' => Yii::t('app', 'Qty'),
        ];
    }

    /**
     * Gets query for [[Lease]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLease()
    {
        return $this->hasOne(Lease::className(), ['id' => 'lease_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
