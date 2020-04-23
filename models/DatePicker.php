<?php

namespace app\models;

class DatePicker extends \yii\base\Model
{
    public $dateStart;
    public $dateEnd;

    public function rules()
    {
        return [
            [['dateStart','dateEnd'], 'required'],
            [['dateStart','dateEnd'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'dateStart' => 'วันที่เริ่มต้น',
            'dateEnd' => 'วันที่สิ้นสุด'
        ];
    }
}
