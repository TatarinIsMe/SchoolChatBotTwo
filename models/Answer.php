<?php

namespace app\models;
use yii\db\ActiveRecord;

class Answer extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'name' => 'Ответ',
            'question_id' => 'Код вопроса',
            'next_question_id' => 'Код следующего вопроса'
        ];

    }
    public function rules()
    {
        return [
            [['name'], 'required']
        ];
    }
    public static function tableName()
    {
        return 'answer';
    }
//    public function getQuestion(){
//        return $this->hasOne(Questions::className(),['id' => 'question_id']);
//    }

}