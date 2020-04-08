<?php

namespace app\models;

class DatePicker extends \yii\base\Model
{
    public $dateInput;

    public function rules()
    {
        return [
            [['dateInput'], 'required'],
            [['dateInput'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'dateInput' => 'รายงานประจำวัน'
        ];
    }
}
