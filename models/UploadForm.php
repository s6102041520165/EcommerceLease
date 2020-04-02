<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'png, jpg, gif', 'maxFiles' => 4],
        ];
    }

    public function upload(String $folder)
    {
        if ($this->validate()) {
            $arrs = [];
            foreach ($this->imageFiles as $file) {
                $path = $folder.'/' . time() . '_' . rand(0, 9999999999) . '.' . $file->extension;
                $file->saveAs(Yii::getAlias('@webroot/image/') . $path);
                array_push($arrs, $path);
            }
            //var_dump($this->imageFiles);die();
            return $arrs;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'imageFiles' => 'รูปภาพ'
        ];
    }
}
