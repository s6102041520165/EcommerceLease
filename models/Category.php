<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int|null $sub_category
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sub_category'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['sub_category'], 'exist', 'skipOnError' => true, 'targetClass' => $this::className(), 'targetAttribute' => ['sub_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสอ้างอิง'),
            'name' => Yii::t('app', 'ประเภทสินค้า'),
            'sub_category' => Yii::t('app', 'ประเภทสินค้าหลัก'),
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public function getSubCategory()
    {
        return $this->hasOne($this::className(), ['id' => 'sub_category']);
    }

    
}
