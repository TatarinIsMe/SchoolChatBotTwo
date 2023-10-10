<?php

namespace app\models;
use yii\db\ActiveRecord;
class Questions extends ActiveRecord

{
    public static function tableName()
    {
        return 'questions';
    }

}