<?php

namespace app\models;
use yii\db\ActiveRecord;
class LastOrder extends ActiveRecord
{
    public static function tableName()
    {
        return 'application';
    }
    public function getLastOrder(){
        $count = LastOrder::find()
            ->count();
        $lastItem = LastOrder::find()
            ->where(['id' => $count])
            ->one();
        return $lastItem->text;
    }
    public function updateLastOrder($text){
        $count = LastOrder::find()
            ->count();
        $post = LastOrder::find()->where(['id' =>$count])->all();
        $post[0]->text = $text;
        $post[0]->save();
    }

}