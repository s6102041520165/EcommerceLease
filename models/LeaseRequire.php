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
class LeaseRequire extends \yii\db\ActiveRecord
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
            [['grand_total', 'lease_date', 'due_date'], 'required'],
            [['lease_date', 'due_date'], 'safe'],
            [['description'], 'string'],
            [['grand_total'], 'number'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
}
