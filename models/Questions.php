<?php

namespace app\models;
use yii\db\ActiveRecord;
class Questions extends ActiveRecord

{
    public function attributeLabels()
    {
        return [
          'id' => 'Код',
          'text' => 'Вопрос'
        ];

    }
    public function rules()
    {
        return [
            [['text'], 'required']
        ];
    }
    public function isLast($id){
        //id - это вопрос  с пометкой Конец
        $type = '';
        $answers = Questions::find()->with('answer')->where(['id' => $id])->all();
        $type = $answers[0]->answer[0]->name;
        if ($type == 'Конец')
            return true; else
            return false;
    }
    public function getQuestion($id){
        $last = new Last();
        $qa = Questions::findOne($id);
        $last->saveIdItem($id);
        return $qa;
    }


    public static function tableName()
    {
        return 'question';
    }
    public function getAnswer(){
        return $this->hasMany(Answer::className(),['question_id' => 'id']);
    }


}