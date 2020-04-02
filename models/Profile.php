<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string $f_name
 * @property string $l_name
 * @property string|null $picture
 * @property string $dob
 * @property string|null $address
 * @property string $subdistrict
 * @property string $district
 * @property string $province
 * @property string $zipcode
 * @property int $user_id
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['f_name', 'l_name', 'dob', 'subdistrict', 'district', 'province', 'zipcode','user_id'], 'required'],
            [['dob'], 'safe'],
            [['address'], 'string'],
            [['user_id'], 'integer'],
            [['f_name', 'l_name', 'picture'], 'string', 'max' => 50],
            [['subdistrict', 'district', 'province'], 'string', 'max' => 255],
            [['zipcode'], 'string', 'max' => 6],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสอ้างอิง'),
            'f_name' => Yii::t('app', 'ชื่อ'),
            'l_name' => Yii::t('app', 'นามสกุล'),
            'picture' => Yii::t('app', 'รูปภาพ'),
            'dob' => Yii::t('app', 'วัน/เดือน/ปี เกิด'),
            'address' => Yii::t('app', 'ที่อยู่'),
            'subdistrict' => Yii::t('app', 'ตำบล'),
            'district' => Yii::t('app', 'อำเภอ'),
            'province' => Yii::t('app', 'จังหวัด'),
            'zipcode' => Yii::t('app', 'รหัสไปรษณีย์'),
            'user_id' => Yii::t('app', 'ผู้ใช้'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'user_id',
            ]
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
