<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "lease".
 *
 * @property int $id
 * @property string $lease_date
 * @property string $due_date
 * @property string|null $description
 * @property float $grand_total
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property LeaseDetail[] $leaseDetails
 */
class Lease extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lease';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grand_total','lease_date','due_date'], 'required'],
            [['lease_date', 'due_date','lease_time', 'due_time'], 'safe'],
            [['description'], 'string'],
            [['grand_total'], 'number'],
            [['status'],'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสการเช่า'),
            'lease_date' => Yii::t('app', 'วันที่รับสินค้า'),
            'lease_time' => Yii::t('app', 'เวลาที่รับสินค้า'),
            'due_date' => Yii::t('app', 'วันที่คืนสินค้า'),
            'due_time' => Yii::t('app', 'เวลาที่คืนสินค้า'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'grand_total' => Yii::t('app', 'ราคารวม'),
            'created_at' => Yii::t('app', 'เช่าเมื่อ'),
            'created_by' => Yii::t('app', 'เช่าโดย'),
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
     * Gets query for [[LeaseDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeaseDetails()
    {
        return $this->hasMany(LeaseDetail::className(), ['lease_id' => 'id']);
    }

    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
