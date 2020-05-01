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
    public $product_status;
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
            [['grand_total', 'lease_date', 'due_date', 'lease_time', 'due_time'], 'required'],
            [['lease_date', 'due_date', 'lease_time', 'due_time'], 'safe'],
            [['description'], 'string'],
            [['grand_total'], 'number'],
            [['status','product_status'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'à¸£à¸«à¸±à¸ªà¸?à¸²à¸£à¹€à¸?à¹?à¸²'),
            'lease_date' => Yii::t('app', 'à¸§à¸±à¸?à¸—à¸µà¹?à¸£à¸±à¸?à¸ªà¸´à¸?à¸?à¹?à¸²'),
            'lease_time' => Yii::t('app', 'à¹€à¸§à¸¥à¸²à¸—à¸µà¹?à¸£à¸±à¸?à¸ªà¸´à¸?à¸?à¹?à¸²'),
            'due_date' => Yii::t('app', 'à¸§à¸±à¸?à¸—à¸µà¹?à¸?à¸·à¸?à¸ªà¸´à¸?à¸?à¹?à¸²'),
            'due_time' => Yii::t('app', 'à¹€à¸§à¸¥à¸²à¸—à¸µà¹?à¸?à¸·à¸?à¸ªà¸´à¸?à¸?à¹?à¸²'),
            'description' => Yii::t('app', 'à¸£à¸²à¸¢à¸¥à¸°à¹€à¸­à¸µà¸¢à¸”'),
            'grand_total' => Yii::t('app', 'à¸£à¸²à¸?à¸²à¸£à¸§à¸¡'),
            'status' => Yii::t('app','à¸ªà¸–à¸²à¸?à¸°'),
            'created_at' => Yii::t('app', 'à¹€à¸?à¹?à¸²à¹€à¸¡à¸·à¹?à¸­'),
            'created_by' => Yii::t('app', 'à¹€à¸?à¹?à¸²à¹?à¸”à¸¢'),
            'updated_at' => Yii::t('app', 'à¹?à¸?à¹?à¹?à¸?à¹€à¸¡à¸·à¹?à¸­'),
            'updated_by' => Yii::t('app', 'à¹?à¸?à¹?à¹?à¸?à¹?à¸”à¸¢'),
            'product_status' => Yii::t('app', 'à¸ªà¸–à¸²à¸?à¸°à¸­à¸¸à¸?à¸?à¸£à¸“à¹?'),
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

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'created_by']);
    }
}
