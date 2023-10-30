<?php

namespace app\models;
use yii\db\ActiveRecord;
class Questions extends ActiveRecord

{
    public static function tableName()
    {
        return 'question';
    }
    public function getAnswer(){
        return $this->hasMany(Answer::className(),['question_id' => 'id']);
    }

}