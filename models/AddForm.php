<?php

namespace app\models;
use yii\base\Model;
use yii\widgets\ActiveForm;

class AddForm extends Model
{
    public $id;
    public $question;
    public $answer;

    public  function rules()
    {
        return [
            // name, email, subject and body are required
            [['id', 'question', 'answer'], 'required'],
            // email has to be a valid email address

        ];
    }


}