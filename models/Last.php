<?php

namespace app\models;
use yii\db\ActiveRecord;
class Last extends ActiveRecord
{
    public static function tableName()
    {
        return 'current_row';
    }


}