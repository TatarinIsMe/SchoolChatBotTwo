<?php

namespace app\models;
use yii\db\ActiveRecord;
class History extends ActiveRecord

{
    public static function tableName()
    {
        return 'history';
    }

    public function addHistory(){
        $item =new History();
        $item->history = "История сообщении";
        $item->save(false);
    }

    public function saveHistory($text){
        $text .= '-';
        $count = History::find()
            ->count();
        $post = History::find()->where(['id' =>$count])->all();
        $history = $post[0]->history;
        $history .= $text;
        $post[0]->history = $history;
        $post[0]->save();
    }

}