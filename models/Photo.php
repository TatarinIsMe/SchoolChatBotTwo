<?php

namespace app\models;

use yii\db\ActiveRecord;

class Photo extends ActiveRecord
{
  //  public $file;
    public static function tableName()
    {
        return 'photo';
    }
    public function rules()
    {
        return [
            //...
            [['file'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }


}