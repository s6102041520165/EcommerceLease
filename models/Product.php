<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float|null $price_for_order
 * @property float|null $price_for_lease
 * @property int $stock
 * @property string $unit_name
 * @property int $category_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property LeaseDetail[] $leaseDetails
 * @property OrderDetail[] $orderDetails
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'stock', 'unit_name', 'category_id', 'purchase_price'], 'required'],
            [['description', 'picture'], 'string'],
            [['price_for_order', 'price_for_lease', 'purchase_price'], 'number'],
            [['stock', 'category_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'unit_name'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสสินค้า'),
            'name' => Yii::t('app', 'ชื่อสินค้า'),
            'picture' => Yii::t('app', 'รูปภาพสินค้า'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'price_for_order' => Yii::t('app', 'ราคาสำหรับซื้อ'),
            'price_for_lease' => Yii::t('app', 'ราคาสำหรับเช่า'),
            'purchase_price' => Yii::t('app', 'ราคารับซื้อ'),
            'stock' => Yii::t('app', 'สินค้าคงเหลือ'),
            'unit_name' => Yii::t('app', 'ชื่อหน่วยของสินค้า'),
            'category_id' => Yii::t('app', 'ประเภทสินค้า'),
            'created_by' => Yii::t('app', 'เพิ่มโดย'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
            'created_at' => Yii::t('app', 'เพิ่มเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไขเมื่อ'),
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
     * Gets query for [[LeaseDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeaseDetails()
    {
        return $this->hasMany(LeaseDetail::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }


    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
