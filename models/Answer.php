<?php

namespace app\models;
use yii\db\ActiveRecord;

class Answer extends ActiveRecord
{
    public static function tableName()
    {
        return 'answer';
    }
//    public function getQuestion(){
//        return $this->hasOne(Questions::className(),['id' => 'question_id']);
//    }

}