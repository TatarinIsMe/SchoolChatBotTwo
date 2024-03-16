<?php

namespace app\models;
use yii\db\ActiveRecord;
class Last extends ActiveRecord
{
    public static function tableName()
    {
        return 'current_row';
    }

    public function saveIdItem($id){
        $post = Last::find()->where(['id' =>'1'])->all();
        $post[0]->current_row = $id;
        $post[0]->save();
//        $item =new Last();
//        $item->current_row = $id;
//        $item->save(false);
    }


}