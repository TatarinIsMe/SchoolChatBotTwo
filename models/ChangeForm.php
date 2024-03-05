<?php

namespace app\models;
use yii\base\Model;
use yii\widgets\ActiveForm;

class ChangeForm extends Model
{
    public $id;
    public $question;
    public $answerYes;
    public $answerNo;
    public $answerStrict;
//    public function __construct($id,$question, $answerYes, $answerNo, $answerStrict)
//    {
//        $this->id = $id;
//        $this->question = $question;
//        $this->answerYes = $answerYes;
//        $this->answerNo = $answerNo;
//        $this->answerStrict = $answerStrict;
//    }

    public function addQuestions(){
        if ($this->question != '-'){
            $post = Questions::find()->where(['id' =>$this->id])->all();
            $post[0]->text = $this->question;
            $post[0]->save();
        } else return;
    }

    public function addAnswers(){
        if ($this->answerNo != '-' ){
            $post = Answer::find()->where(['question_id' =>$this->id])->all();
            $post[1]->name = $this->answerNo;
            $post[1]->save();
        } else if($this->answerYes != '-'){
            $post = Answer::find()->where(['question_id' =>$this->id])->all();
            $post[0]->name = $this->answerYes;
            $post[0]->save();
        } else if ($this->answerStrict != '-'){
            $post = Answer::find()->where(['question_id' =>$this->id])->all();
            $post[0]->name = $this->answerStrict;
            $post[0]->save();
        } else return;
    }



    public  function rules()
    {
        return [
            // name, email, subject and body are required
            [['id', 'question', 'answerYes', 'answerNo', 'answerStrict'], 'required'],
            // email has to be a valid email address

        ];
    }


}